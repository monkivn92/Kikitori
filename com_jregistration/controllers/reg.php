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
        }
        else
        {
            
            $saved = $model->addUser($user_info); //saved = userid if add user successfully.
            $session->clear( 'jreg_error_message');

            if($saved)
            {
                $app = JFactory::getApplication();
                $model->sendMailtoAdmin($user_info,$saved);

                $link = 'index.php?option=com_comprofiler&task=login';
                $msg = 'Thank for your registering!';   
                $app->redirect( $link , $msg);
            }
            else
            {
                $jreg_user_info['error'] = 'Registration Failed!';  
                $session->set( 'jreg_user_info', $jreg_user_info );  
                $this->create();
            }
            
        }     
   
    }



}

?>