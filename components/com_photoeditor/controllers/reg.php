<?php
jimport( 'joomla.application.component.controller' );
class JregistrationControllerReg extends JController
{
	
	function __construct($default = array())
    {
        parent::__construct($default);

        //$this->registerTask('add', 'edit');
        
    }

    function create()
    {
        
        $view = &$this->getView('reg','html');
        $model = & $this->getModel('reg');       
        $view->setModel($model, true);
        $view->showForm();
    }

    function save()
    {        
        global $_CB_framework, $_CB_database, $ueConfig, $_POST, $_PLUGINS;
        $session = JFactory::getSession();
        $app = JFactory::getApplication();
        $model =  $this->getModel('reg');

        $user_info = $model->getRegFormData();    
        $error = $model->jRegValidator($user_info);   
        
        $_PLUGINS->loadPluginGroup('user');
        $_PLUGINS->trigger( 'onCheckCaptchaHtmlElements', array() );

        if($error || $_PLUGINS->is_errors())
        {    
            if($_PLUGINS->is_errors())
            {
                $error .= ("<p>".$_PLUGINS->getErrorMSG()."</p>");   
            }
            
            $session->set( 'jreg_error_message', $error );         
            $this->create();
            $model->setValueToField($user_info);
        }
        else
        {
            
            $saved = $model->addUser($user_info); //saved = userid if add user successfully.
            $session->clear( 'jreg_error_message');

            if($saved)
            {
                
                $model->sendMailtoAdmin($user_info,$saved);
                /// Log new user in user's pro5
                cbimport( 'cb.authentication' ); 
                $cbAuthenticate     =   new CBAuthentication();                             
                $messagesToUser     =   array('Thank for your registeringms!');
                $alertmessages      =   array('Thank for your registeringalert!');
                $redirect_url       =   'index.php?option=com_jregistration&view=edit';
                $resultError       =   $cbAuthenticate->login( $user_info->username, false, 0, 1, $redirect_url, $messagesToUser, $alertmessages, 0 );
                $app->enqueueMessage('Registration Completed!','Message');
                $app->redirect(JRoute::_($redirect_url, false));
            }
            else
            {
                $app->enqueueMessage('Registration failed!','error');  
                $app->redirect(JRoute::_('index.php?option=com_jregistration&view=reg', false));
                $model->setValueToField($user_info);
            }
            
        }     
   
    }

    function checkUsername()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $username = JRequest::getVar('value');
        if($username !== '')
        {
            $uname = $db->quote($username);
            $sql = "SELECT id FROM #__users WHERE `username`=$uname";
            $db->setQuery($sql); 
            $r =  $db->loadResult();
            if($r)
            {
                echo ( '<span class="cb_result_error">' . sprintf( ISOtoUtf8( _UE_USERNAME_ALREADY_EXISTS ), htmlspecialchars( $username ) ) . '</span>' );
            }
            else
            {
                
                echo ( '<span class="cb_result_ok">' . sprintf( ISOtoUtf8( _UE_USERNAME_DOESNT_EXISTS ), htmlspecialchars( $username ) ) . '</span>' );
            }
        }
        $app->close();
    }   

}

?>