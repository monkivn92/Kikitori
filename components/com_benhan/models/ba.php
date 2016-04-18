<?php
jimport( 'joomla.application.component.model' );

class BenhanModelBa extends JModel
{	
	function __construct()
	{		
		parent::__construct();
	}	

    function isAdmin($userid)
    {
        $db = JFactory::getDbo();     
        $sql = "SELECT group_id FROM #__user_usergroup_map WHERE user_id=$userid";
        $db->setQuery($sql);
        $r = $db->loadResult();
        if($r == 7 || $r == 8)
            return true;
        else
            return false;

    }
    function getUserInfo()
    {
        $userid = JRequest::getInt('userid');
        $user = JFactory::getUser();
        $this_user = 0;
        if(!$userid) 
        { 
            $this_user = $user->id;
        }
        else
        {
            if($userid==$user->id)
            {
                $this_user = $user->id;
            }
            else
            {
                if(!$this->isAdmin($user->id))
                {
                    die('You are not authorized !');
                }                    
                else
                {
                    $this_user = $userid;
                }
                    
            }
        }

        global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;
        $cbUser =& CBuser::getInstance( $this_user );
        return $cbUser;
    }

	function getCBfield()
	{
        global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;   
        $db = JFactory::getDbo();         
       
        $CBfields = array();    
        $return = new \stdClass(); 
      
        $cbUser = $this->getUserInfo();
        $this_user = $cbUser->_cbuser->id;

        $sql = 'SELECT COUNT(*) FROM #__com_benhan_form';
        $db->setQuery($sql);
        $total = $db->loadResult();       
        
        $db = JFactory::getDbo();
        $cur_page = JRequest::getInt('cur_page');
        if(!$cur_page)
        {
            $ordering = 1;
        }
        else
        {
            if( $_POST['ba_back'] )
            {
                $ordering = $cur_page-1;
            }
            if( $_POST['ba_next'])
            {
                $ordering = $cur_page+1;                
            }

            //Save changes
            $sql = "SELECT * FROM #__com_benhan_form WHERE published=1 AND ordering=$cur_page";        
            $db->setQuery($sql);
            $fs = $db->loadObject();  

            $sql ="SELECT name FROM #__comprofiler_fields WHERE fieldid IN($fs->fields)";

            $db->setQuery($sql);
            $ns = $db->loadResultArray();
            $set = '';
            $len = count($ns);
            for($i=0; $i< $len; $i++)
            {
                $var = $ns[$i];
                $val = JRequest::getVar($var);
                if(is_array($val))
                {
                    $val = implode('|*|', $val);
                }
                $val = $db->quote($val);
                if($i != $len-1)
                {
                    $set .= (" $var=$val, ");
                }
                else
                {
                     $set .= (" $var=$val ");
                }
            }  
            $sql = "UPDATE #__comprofiler SET $set WHERE user_id=$this_user";            
            $db->setQuery($sql);
            $db->query();

        }        
        
        if($_POST['ba_save'])
        {
            $app = JFactory::getApplication();
            $msg = 'Saved';
            $link = '/component/benhan/?view=user&task=showprofile&userid='.$this_user;
            $app->enqueueMessage($msg,'Message');
            $app->redirect($link);
        }
        //get Fields in Form to display next/previous page
        $sql = "SELECT * FROM #__com_benhan_form WHERE published=1 AND ordering=$ordering";        
        $db->setQuery($sql);
        $formfield = $db->loadObject();   

        $sql ="SELECT name FROM #__comprofiler_fields 
                WHERE fieldid IN($formfield->fields)
                ORDER BY FIELD(fieldid,$formfield->fields)";//http://stackoverflow.com/questions/8178530/mysql-in-operator-result-set-order
        
        $db->setQuery($sql);
        $names = $db->loadResultArray();

        foreach ($names as $name) 
        {
            $data = '{"userid":' . $this_user . ',"label":"' . $name . '"}';
            $html = '';
            $html .= '<div class="wrap_field">';    
            $html .= "<img data='$data' class='addnote' style='cursor:pointer' src='/components/com_benhan/img/plus_red.png' title='Add note for this field'>";        
            $html .= $cbUser->getField( $name, null, 'htmledit', 'div','register', 0, true);
           
            $html .= '</div>';
            $CBfields[$name] = $html;
        }		
		$return->page_info = $formfield;
        $return->CBfields = $CBfields;
        $return->total = $total;
        $return->cur_page = $ordering;
		return $return;

	}    
    function takeNote()
    {
        $app = JFactory::getApplication();
        $db = JFactory::getDbo();

        $uid = JRequest::getInt('u');
        $field = JRequest::getVar('f');
        $quote_f = $db->quote($field);
        $sql = "SELECT text FROM #__ba_note WHERE user_id=$uid AND field_name=$quote_f";
        $db->setQuery($sql);
        $fval = $db->loadResult();

        $sql = "SELECT title FROM #__comprofiler_fields WHERE name=$quote_f";
        $db->setQuery($sql);
        $fname = $db->loadResult();

        $html ='';
        $html .= "<form action='/components/com_benhan/?view=ba&task=savenote&u=$uid&f=$field'>";
        $html .= "<h4>$fname</h4>";
        $html .= "<textarea name='text' cols='100'rows='10'>$fval</textarea>";
        $html .= "<p><input type='submit' name='submit_note' value='Save' class='btn btn-primary'  /></p>";
        $html .= '</form>';
        return $html;
    }
    function saveNote()
    {
        $app = JFactory::getApplication();
        $db = JFactory::getDbo();

        $uid = JRequest::getInt('u');
        $field = $db->quote(JRequest::getVar('f'));
        $text = $db->quote(JRequest::getVar('text'));

        $sql = "SELECT id FROM #__ba_note WHERE user_id=$uid AND field_name=$field";
        $db->setQuery($sql);
        $id = $db->loadResult();

        if($id)
        {
            $sql = "UPDATE #__ba_note SET text=$text WHERE  user_id=$uid AND field_name=$field";
        }
        else
        {
            $sql = "INSERT INTO #__ba_note(user_id,field_name,text) VALUES ($uid,$field,$text)";
        }
        $db->setQuery($sql);
        $db->query();
       
    }


   
    function getAdminMail()
    {
        
        global $_CB_database;
        $email = JRequest::getVar('email');
        $_CB_database->query('SELECT u.email 
                            FROM #__users AS u,#__user_usergroup_map AS ugm 
                            WHERE u.id = ugm.user_id
                            AND ugm.group_id = 8 ');
        $r = $_CB_database->loadResultArray();
        return $r;       
    }
    function sendMailtoAdmin($user_info,$uid)
    {
        $app = JFactory::getApplication();
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();
        $sender = array( 
            $config->get( 'mailfrom' ),
            $config->get( 'fromname' ) 
        );                 
        $mailer->setSender($sender);
       
        $recipient = $this->getAdminMail();
        $mailer->addRecipient($recipient);  

        $subject = 'Have a new researcher registered'; 
        $body = "The new researcher user's information:\n\nUser's ID: $uid\n\nFistname: $user_info->cb_registrantfirstname\n\nLastname: $user_info->cb_registrantlastname\n\nUsername: $user_info->username\n\nEmail: $user_info->email";       
          
        $mailer->setSubject($subject);
        $mailer->setBody($body);
        $send = $mailer->Send();//send mail to admin to get approval
        if ( $send !== true ) {
            echo 'Error sending email: ' . $send->__toString();
        } else {
            echo 'Mail sent';
        }        


    }
	
}

?>