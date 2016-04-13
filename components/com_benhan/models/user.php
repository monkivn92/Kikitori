<?php
jimport( 'joomla.application.component.model' );

class BenhanModelUser extends JModel
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
        {
            return true;
        }
            
        else

            return false;

    }
    function getUserID()
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
            if($userid == $user->id)
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
        return $this_user;

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
            if($userid == $user->id)
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
    function getFormData()
    {
        $user_info = new \stdClass();
        $db = JFactory::getDbo();
        $sql = 'SELECT name FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $fields = $db->loadResultArray();

        foreach ($fields as $value)
        {
            $user_info->$value = JRequest::getVar($value);
        }

        return $user_info;

    }

    function getCBfield()
    {
        global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;   
        $db = JFactory::getDbo();         
        $cbUser =& CBuser::getInstance( null );
        $CBfields = array();    
        $return = new \stdClass(); 
        $this_user = $cbUser->_cbuser->id;

        $sql = 'SELECT name FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $names = $db->loadResultArray();  

        foreach ($names as $name) 
        {
            $CBfields[$name] = $cbUser->getField( $name, null, 'htmledit', 'div','register', 0, true);
        }      
        
        return $CBfields;

    }
    function getCBfieldEdit()
    {
        global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;   
        $db = JFactory::getDbo();         
       
        $CBfields = array();    
        $return = new \stdClass();        

        $cbUser = $this->getUserInfo();
        $this_user = $cbUser->_cbuser->id;

        $sql = 'SELECT name FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $names = $db->loadResultArray();  

        foreach ($names as $name) 
        {
            if($name === 'password')
            {
                $CBfields[$name] = $cbUser->getField( $name, null, 'htmledit', 'div','register', 0, true);
                $CBfields[$name] = str_replace('required', '', $CBfields[$name]);
            }
            else
            {
                $CBfields[$name] = $cbUser->getField( $name, null, 'htmledit', 'div','register', 0, true);
            }
            
        }      
        
        return $CBfields;

    }

    function saveuser()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $name = '';
        $username = '';
        $email = '';
        $password = '';
        $registerDate = '';
        $params = '""';
        $uid = null;

        $user_info = $this->getFormData();

        $name = $db->quote($user_info->name);
       
        $email = $db->quote($user_info->email);
      
        $registerDate = $db->quote(date( 'Y-m-d H:i:s'));
        $params = '""';
        $uid = null;

        $sql = 'INSERT INTO #__users (name, email, block, sendEmail,registerDate,params)'
                .' VALUES ('
                            .$name.','                           
                            .$email.','                           
                            .'0,'
                            .'0,'
                            .$registerDate.','
                            .$params.
                          ')';
        
        $db->setQuery($sql);
        $r_u =  $db->execute();     
        $uid = $db->insertid();
        $r_group = false;
        $r_com = false;
        if($r_u)
        {

            // add new user to group user
            $sql = 'INSERT INTO #__user_usergroup_map(user_id, group_id)'
                    .' VALUES ("'.$uid.'","2")';       
            $db->setQuery($sql);
            $r_group = $db->execute(); 


            // add new user to comprofiler
            $id = $uid;
            $user_id = $uid;
            $values = array();
            $fields = array();
               
            include_once( JPATH_ADMINISTRATOR . '/components/com_comprofiler/comprofiler.class.php' );              
            $registeripaddr = $db->quote(cbGetIPlist()); 
            //$degrees = implode('|*|', $user_info->cb_degrees);

            foreach ($user_info as $key => $value) 
            {
                if($key !== 'email'&& $key !== 'name')
                {
                    $fields[] = $key;
                    $values[] = $db->quote($value);
                }
                
            }
            $fields[] = 'id';
            $fields[] = 'user_id';
            $fields[] = 'registeripaddr';
            $values[] = $id;
            $values[] = $user_id;
            $values[] = $db->quote($registeripaddr);
            $f = implode(',', $fields);
            $v = implode(',', $values);


            $sql = "INSERT INTO #__comprofiler($f) VALUES($v)";   
            $db->setQuery($sql);
            $r_com = $db->execute();
        }
        if($r_com&&$r_group&&$r_u)
        {
            $msg = 'Add a new patient successfully. You can add medical report for this patient.';
            $app->enqueueMessage($msg,'Message');
            $app->redirect("/component/benhan/?view=user&task=showprofile&userid=$uid", false);
        }
        else
        {
            $msg = 'Add patient failed. Something wrong have occured.';
            $view = &$this->getView('user','html');
            $model = & $this->getModel('user');       
            $view->setModel($model, true);
            $view->showForm($msg);
            $model->setValueToField(); 
        }
    }
    function updateuser()
    {
        $db = JFactory::getDbo();
        $set = array();         
        $app = JFactory::getApplication();      
        if(JRequest::getVar('name') != '') 
        { 
            
            $set[] =  'name='.$db->quote(JRequest::getVar('name'));

        }

        if(JRequest::getVar('email') != '') 
        { 
            
            $set[] =  'email='.$db->quote(JRequest::getVar('email'));
        }
        
        $s = implode(',', $set);        
      
        $cbUser = $this->getUserInfo();
        $this_user = $cbUser->_cbuser->id;

        $sql = "UPDATE #__users SET $s WHERE id = $this_user ";   
            
        $db->setQuery($sql);
        $r_u =  $db->execute();          
       
        $r_com = false;

        if($r_u)
        {

            // update user to comprofiler

            $sql = 'SELECT name FROM #__comprofiler_fields
                    WHERE published=1 AND registration=1 ORDER BY ordering';
            $db->setQuery($sql);
            $names = $db->loadResultArray();  
            $set = '';
            foreach ($names as $n) 
            {
                if($n !== 'email'&& $n !== 'name')
                {
                    $val = JRequest::getVar($n);
                
                    if( trim($val) != '' && strpos($n, 'cb_') !== false )
                    {
                        $set[] = $n.'='.$db->quote($val);
                    }
                }
                
            }
             
            $set = implode(',', $set) ;            
            //$degrees = implode('|*|', $user_info->cb_degrees);
            $sql = "UPDATE #__comprofiler SET $set WHERE user_id = $this_user";   

            $db->setQuery($sql);
            $r_com = $db->execute();
        }
        if($r_com&&$r_u)
        {
           
            $msg = 'Update  patient successfully.';
            $app->enqueueMessage($msg,'Message');
            $app->redirect('/component/benhan/?view=user&task=edituser&userid='.$this_user, false);
        }
        else
        {
            $msg = 'Update patient failed. Something wrong have occured.';
            $app->enqueueMessage($msg,'error');
            $app->redirect('/component/benhan/?view=user&task=edituser&userid='.$this_user, false);
        }
    }

    function setValueToField()
    {
        $doc = JFactory::getDocument();     
        $db = JFactory::getDbo();

        $sql = 'SELECT name FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $names = $db->loadResultArray();  

        $user_info = new \stdClass();
        $script = '<script>';
        foreach ($names as $n) 
        {
            $val = $db->quote(JRequest::getVar($n));
            $script .= " jQuery('input[name = \"$n\"]').val($val); ";            
        }  

        $script .= '</script>';  

        echo $script;
    }
    function searchUser()
    {
        $db = JFactory::getDbo();
        $name = JRequest::getVar('name');
        $mrid = JRequest::getVar('mrid');
        $fs = ['name'=>$name,'cb_so_benh_an_vao_vien'=>$mrid];
        $where='';

        if(trim($name)=='' && trim($mrid)=='' )
        {
            $where =' 1=1 ';
        }
        else
        {
            $logic = '';
            $cnt = count($fs);
            $key = array_keys($fs);
            for($i=0; $i<$cnt; $i++)
            {
                $k = $key[$i];
                $v = $fs[$k];

                if( trim($v) !== '' )
                {
                    $where .= ( $logic . " $k LIKE '%$v%' ");
                    $logic = ' AND ';
                }
                
            }            
            
        }

        $sql = "SELECT u.id,u.name, c.cb_so_benh_an_vao_vien 
                FROM #__users AS u, #__comprofiler AS c 
                WHERE u.id=c.user_id AND $where";
        //die($sql);
        $db->setQuery($sql);
        $names = $db->loadObjectList(); 
        
        $return='';
        foreach ($names as $n) 
        {
                $link = '/component/benhan/?view=user&task=showprofile&userid='.$n->id;
                $return .= '<blockquote>';
                $return .= '<p>';
                $return .= "<a href='$link' target='_blank'>$n->name</a>";
                $return .= '</p>';
                $return .= '<p>';
                $return .= "Số bệnh án: $n->cb_so_benh_an_vao_vien";
                $return .= '</p>';
                $return .= '</blockquote>';
        }  

        return $return; 
    }
    function getAvatar()
    {
        $uid = $this->getUserID();
        $ava_time = array();
        if ( $dir = opendir("patient/$uid") ) 
        {

            while (false !== ( $item = readdir($dir) ) ) 
            {

                if ($item != "." && $item != "..") 
                {
                    if(strpos($item, 'avatar') !== false)
                    {
                        preg_match('/(?<=avatar_).+?(?=\.)/', $item, $m);
                        $ava_time[] = (int)$m[0];
                    }
                }
            }

            closedir($handle);
        }
        if(count($ava_time)>0)
        {
            $max = max($ava_time);
            return "patient/$uid/avatar_".$max.'.png';
        }
        else
        {
            return false;
        }
        
    }
    function saveAvatar()
    {
        $app = JFactory::getApplication();
        $uid = $this->getUserID();

        if( !is_dir("patient/$uid") )
        {
            mkdir("patient/$uid");
        }
        $path_parts = pathinfo($_FILES["file"]["name"]);
        $extension = $path_parts['extension'];
        $filepath = "patient/$uid/avatar_".time().'.png';

        if( 0 < $_FILES['file']['error'] ) 
        {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        }
        else 
        {
            move_uploaded_file($_FILES['file']['tmp_name'], $filepath);
        }

        $img = "<img src='/$filepath' class='pro5-avatar'/>";
        echo $img;
        $app->close();
    }

}//end class

?>