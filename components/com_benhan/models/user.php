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

        $name = '';
        $username = '';
        $email = '';
        $password = '';
        $registerDate = '';
        $params = '""';
        $uid = null;

        $sql = 'SELECT name FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $names = $db->loadResultArray();  
        $user_info = new \stdClass();
        foreach ($names as $n) 
        {
            $user_info->$n = JRequest::getVar($n);
        }

        $name = $db->quote($user_info->name);
        $username = $db->quote($user_info->username);
        $email = $db->quote($user_info->email);
        $password = $db->quote(md5($user_info->password));
        $registerDate = $db->quote(date( 'Y-m-d H:i:s'));
        $params = '""';
        $uid = null;

        $sql = 'INSERT INTO #__users (name, username, email, password, block, sendEmail,registerDate,params)'
                .' VALUES ('
                            .$name.','
                            .$username.','
                            .$email.','
                            .$password.','
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
            $cb_so_nghien_cuu = $db->quote(JRequest::getVar('cb_so_nghien_cuu') );
            $cb_so_benh_an_vao_vien = $db->quote(JRequest::getVar('cb_so_benh_an_vao_vien') );
            $cb_ma_luu_tru = $db->quote(JRequest::getVar('cb_ma_luu_tru') );
            $cb_tuoi = $db->quote(JRequest::getVar('cb_tuoi') );
            $cb_gioi_tinh = $db->quote(JRequest::getVar('cb_gioi_tinh') );
            $cb_nghe_nghiep = $db->quote(JRequest::getVar('cb_nghe_nghiep') );
            $cb_dia_chi = $db->quote(JRequest::getVar('cb_dia_chi') );
            $cb_so_dien_thoai = $db->quote(JRequest::getVar('cb_so_dien_thoai') );       
            include_once( JPATH_ADMINISTRATOR . '/components/com_comprofiler/comprofiler.class.php' );              
            $registeripaddr = $db->quote(cbGetIPlist()); 
            //$degrees = implode('|*|', $user_info->cb_degrees);

            $fields = ' id,user_id,cb_so_nghien_cuu,cb_so_benh_an_vao_vien,cb_ma_luu_tru,cb_tuoi,
                       cb_gioi_tinh,cb_nghe_nghiep,cb_dia_chi,cb_so_dien_thoai,registeripaddr ';
            $values = " $id,$user_id,$cb_so_nghien_cuu,$cb_so_benh_an_vao_vien,$cb_ma_luu_tru,$cb_tuoi,
                       $cb_gioi_tinh,$cb_nghe_nghiep,$cb_dia_chi,$cb_so_dien_thoai,$registeripaddr ";

            $sql = "INSERT INTO #__comprofiler($fields) VALUES($values)";   
            $db->setQuery($sql);
            $r_com = $db->execute();
        }
        if($r_com&&$r_group&&$r_u)
        {
            return $uid;
        }
        else
        {
            return false;
        }
    }
    function updateuser()
    {
        $db = JFactory::getDbo();
        $set = array();         
               
        if(JRequest::getVar('name') != '') 
        { 
            
            $set[] =  'name='.$db->quote(JRequest::getVar('name'));

        }

        if(JRequest::getVar('email') != '') 
        { 
            
            $set[] =  'email='.$db->quote(JRequest::getVar('email'));
        }

        if(JRequest::getVar('password') != '') 
        { 
            
            $set[] =  'password='.$db->quote(md5(JRequest::getVar('password')));
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
                $val = JRequest::getVar($n);
                
                if( trim($val) != '' && strpos($n, 'cb_') !== false )
                {
                    $set[] = $n.'='.$db->quote($val);
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
            return true;
        }
        else
        {
            return false;
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

}//end class

?>