<?php
jimport( 'joomla.application.component.controller' );
class JregistrationControllerEdit extends JController
{
	
	function __construct($default = array())
    {
        parent::__construct($default);      
        
    }

    function create()
    {

        $view = &$this->getView('edit','html');
        $model = & $this->getModel('edit');       
        $view->setModel($model, true);
        $view->show();
    }

    function detail()
    {

        $view = &$this->getView('edit','html');
        $model = & $this->getModel('edit');       
        $view->setModel($model, true);
        $view->showForm(false);
    }

    function update()
    {  
        $app = JFactory::getApplication();
        $action = JRequest::getVar('jreg_cancel_bt'); 
        if($action)
        {
            $app->redirect(JRoute::_('index.php?option=com_jregistration&view=edit', false));
        }

        $uid = JRequest::getInt('uid');        
        $user =  JFactory::getUser();
        $this_user = 0;
        if(!$uid)
        {
            $this_user = $user->id;
            if(!JConnect_isResearcher($this_user))
            {
                die('You are not authorized!');
            }
        }
              
        global $_CB_framework, $_CB_database, $ueConfig, $_POST, $_PLUGINS;
        $uid = JRequest::getInt('uid');        
        $session = JFactory::getSession();

        $view = &$this->getView('edit','html');
        $model =  $this->getModel('edit');

        $user_info = $model->getRegFormData();    
        $error = $model->jRegValidator($user_info);        

        if($error)
        {   
                                 
            $session->set( 'jreg_error_message', $error );         
            $view->setModel($model, true);
            $view->showForm(true);
            $model->setValueToField($user_info);
        }
        else
        {
            $user_info->id = $this_user;
            $saved = $model->updateUser($user_info); //
            $session->clear( 'jreg_error_message');
           
            if($saved)
            {    
                $error = 'Update infomation successfully!';  
                $session->set( 'jreg_error_message', $error );  
                $view->setModel($model, true);
                $view->showForm(true);
            }
            else
            {
                $error = 'Update infomation failed!';  
                $session->set( 'jreg_error_message', $error );  
                $view->setModel($model, true);
                $view->showForm(true);
            }
            
        }     
        $app->redirect(JRoute::_('index.php?option=com_jregistration&view=edit', false));
   
    }



}

?>