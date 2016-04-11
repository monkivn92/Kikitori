<?php
jimport( 'joomla.application.component.controller' );
class BenhanControllerSignup extends JController
{
	
	function __construct($default = array())
    {
        parent::__construct($default);

        //$this->registerTask('add', 'edit');
        
    }

    function create()
    {
        
        $view = &$this->getView('signup','html');
        $model = & $this->getModel('signup');       
        $view->setModel($model, true);
        $view->showForm(null);
        
    }  
    
    function saveuser()
    {
        $app = JFactory::getApplication();        
        $model = & $this->getModel('signup');        
        $result = $model->saveuser();   
        
      
    }
    
    function checkusername()
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
                echo ( '<span class="cb_result_error">This username has already existed.</span>' );
            }
            else
            {
                
                echo ( '<span class="cb_result_ok">This username is free to use</span>' );
            }
        }
        $app->close();
    }   
    function checkemail()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $email = JRequest::getVar('value');
        if($email !== '')
        {
            $email = $db->quote($email);
            $sql = "SELECT id FROM #__users WHERE `email`=$email";
            $db->setQuery($sql); 
            $r =  $db->loadResult();
            if($r)
            {
                echo ( '<span class="cb_result_error">This email has already existed.</span>' );
            }
            else
            {
                
                echo ( '<span class="cb_result_ok">This email is free to use</span>' );
            }
        }
        $app->close();
    }


}

?>