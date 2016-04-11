<?php
jimport( 'joomla.application.component.model' );

class BenhanModelSignup extends JModel
{   
    function __construct()
    {       
        parent::__construct();
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
    function getFormData()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $msg = '';
        $user_info = new \stdClass();

        $sql = 'SELECT name,required,title,params FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $names = $db->loadObjectList();  
        foreach ($names as $fs) 
        {
            $fn = $fs->name;
            $user_info->$fn = JRequest::getVar($fn);
            $msg .= $this->getValidator($fs);
        }

        //Check recaptcha
        $post = JRequest::get('post');      
        JPluginHelper::importPlugin('captcha');
        $dispatcher = JDispatcher::getInstance();
        $res = $dispatcher->trigger('onCheckAnswer',$post['recaptcha_response_field']);
        if(!$res[0]){
            $msg .= '<p>Wrong captcha code</p>';
        }
        if(trim($msg) !== '')
        {
            
            $app->enqueueMessage($msg,'error');
            $app->redirect("/component/benhan/?view=signup", false);

        }
        else
        {
            return $user_info;
        }     
        
    }
    function getValidator($obj)
    {
        $msg = '';
        $name = $obj->name;
        $val = JRequest::getVar($name);
        $title = $obj->title;
        $required = (int)$obj->required;
        $params = $obj->params;
        $param_obj = json_decode($params);
        $pregexp = $param_obj->pregexp;

        if($required == 1 && trim($val)=='')
        {
            $msg .= "<p><b>$title</b> is required</p>";
        }
        if($pregexp)
        {
            preg_match($pregexp, $val, $matches);  
            if(!$matches)
            {
                $msg .= "<p>Value of <b>$title</b> is wrong format</p>";
            }
        }
        
        return $msg;
    }
   
    function saveuser()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $user_info = $this->getFormData();

        $name = '';
        $username = '';
        $email = '';
        $password = '';
        $registerDate = '';
        $params = '""';
        $uid = null;       

        
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
            $msg = 'Thank for Registering. You now can login.';
            $app->enqueueMessage($msg,'Message');
            $app->redirect("/login", false);
        }
        else
        {
            $msg = 'Register failed. Something wrong have occured.';
            $view = &$this->getView('signup','html');
            $model = & $this->getModel('$msg');       
            $view->setModel($model, true);
            $view->showForm(null);
            $model->setValueToField();
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