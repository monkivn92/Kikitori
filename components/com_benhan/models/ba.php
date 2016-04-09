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
        $db->setQuery();
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
                if(!isAdmin($user->id))
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
        $cbUser =& CBuser::getInstance( $userid );
        return $cbUser;
    }

	function getCBfield()
	{
        global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;   
        $db = JFactory::getDbo();         
       
        $CBfields = array();    
        $return = new \stdClass(); 
        $userid = JRequest::getInt('userid');
        $user = JFactory::getUser();

        if(!$userid) 
        { 
            $this_user = $user->id;
        }
        $cbUser =& CBuser::getInstance( $this_user );

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
            $link = JUri::base();
            $app->enqueueMessage($msg,'Message');
            $app->redirect(JRoute::_($link, false));
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
            $CBfields[$name] = $cbUser->getField( $name, null, 'htmledit', 'div','register', 0, true);
        }		
		$return->page_info = $formfield;
        $return->CBfields = $CBfields;
        $return->total = $total;
        $return->cur_page = $ordering;
		return $return;

	}    
    

    function jRegValidator($user_info)
    {
        $error ='';
        global $_CB_database;

        //check username if it has already existed     
        $_CB_database->query('SELECT id FROM #__users WHERE username="'.$user_info->username.'"');
        $r_user = $_CB_database->loadResult();

        if($r_user)
        {
            $error .= "<p>The username has already existed.</p>";              
        }

        //*********check fields' format*****\\
        //Contact Information
        if(!$user_info->cb_registrantfirstname)
        {
        
            $error .= '<p>Firstname is required.</p>';
        }

        if(!$user_info->cb_registrantlastname)
        {
        
            $error .= '<p>Lastname is required.</p>';
        }       

        if($user_info->email)
        {
            preg_match('/^[a-z][a-z0-9_\.]{2,32}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$/', $user_info->email, $email_matches);
            if(!$email_matches)
            {
                $error .= '<p>Please enter a valid Email.</p>';
            }
            if($user_info->email != $user_info->confirmemail)
            {
                $error .= '<p>Please enter the same email again</p>';
            }
        }
        else
        {
            $error .= '<p>Email is required.</p>';
        }

        if($user_info->cb_altemail2)
        {
            preg_match('/^[a-z][a-z0-9_\.]{2,32}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$/', $user_info->email, $email_matches);
            if(!$email_matches)
            {
                $error .= '<p>Please enter a valid Professional email address.</p>';
            }           
        }        

        if(!$user_info->cb_city)
        {
        	$error .= '<p>City is required.</p>';
        }

        if(!$user_info->cb_postalcode)
        {
        	$error .= '<p>Postal/Zip Code is required.</p>';
        }

        if(!$user_info->cb_country)
        {
        	$error .= '<p>Country is required.</p>';
        }
        //Institutional/Organizational/Industry Contact Person
        if(!$user_info->cb_orgname)
        {
        	$error .= '<p>Institution/Organization Name is required.</p>';
        }

        if(!$user_info->cb_orgtype)
        {
        	$error .= '<p>Institution/Organization Type is required.</p>';
        }

         if(!$user_info->cb_orgaffiliation)
        {
        	$error .= '<p>Professional/Organizational/Industry Affiliation is required.</p>';
        }

         if(!$user_info->cb_orgspecialty)
        {
        	$error .= '<p>Research Area/Specialty is required.</p>';
        }
        //Name of Institution or Organization
    	if(!$user_info->cb_orgcontactname)
        {
        	$error .= '<p>Organization Contact Name is required.</p>';
        }

        if(!$user_info->cb_orgcontacttitle)
        {
        	$error .= '<p>Organization Contact Title is required.</p>';
        }

        if(!$user_info->cb_orgcontactemail)
        {
        	$error .= '<p>Organization Contact Email is required.</p>';
        }

        if(!$user_info->cb_orgcontactphone)
        {
        	$error .= '<p>Organization Contact Phone is required.</p>';
        }
        //Choose your DS-Connect Username and Password
        if($user_info->password)
        {
            preg_match('/^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,}$/', $user_info->password, $password_matches);
            if(!$password_matches)
            {
                $error .= '<p>Please enter a valid password.  No spaces, at least 8 characters and contain at least 1 lower-case letter, 1 upper-case letter, 1 number, and 1 symbol character.</p>';
            }
            if($user_info->password != $user_info->password__verify)
            {
                $error .= '<p>Please enter the same password again.</p>';
            }
        }
        else
        {
            $error .= '<p>Password is required.</p>';
        }
        //Terms of Use
        if($user_info->cb_agreeterms != 1)
        {
            $error .= "<p>You must agree to the Terms & Conditions and the Privacy Policy.</p>";             
        }

        if($user_info->cb_agreedatapolicy != 1)
        {
            $error .= "<p>You must agree to the Data Access and Publication Policy.</p>";             
        }

        return $error;    
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