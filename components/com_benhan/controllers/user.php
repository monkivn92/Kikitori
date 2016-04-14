<?php
jimport( 'joomla.application.component.controller' );
class BenhanControllerUser extends JController
{
	
	function __construct($default = array())
    {
        parent::__construct($default);

        //$this->registerTask('add', 'edit');
        
    }

    function create()
    {
        
        $view = &$this->getView('user','html');
        $model = & $this->getModel('user');       
        $view->setModel($model, true);
        $view->showForm(null);
        
    }    

    function adduser()
    {
       
        $view = &$this->getView('user','html');
        $model = & $this->getModel('user');       
        $view->setModel($model, true);
        $view->showForm(null);
    }

    function edituser()
    {
       
        $view = &$this->getView('user','html');
        $model = & $this->getModel('user');       
        $view->setModel($model, true);
        $view->showFormEdit(null);
    }

    function updateuser()
    {
        $app = JFactory::getApplication();      
        $model = & $this->getModel('user');     
        $result = $model->updateuser();      
    }
    function saveuser()
    {
        $app = JFactory::getApplication();        
        $model = & $this->getModel('user');  
        $view = &$this->getView('user','html');
        $result = $model->saveuser();     
      
    }
    function search()
    {
          
        $view = &$this->getView('user','html');
        $view->showFormSearch($msg);
    }
    function searchuser()
    {
        $app = JFactory::getApplication(); 
        $model = & $this->getModel('user');  
        $r = $model->searchUser();
        echo $r;
        $app->close();
    }
    function showprofile()
    {
        
        $view = &$this->getView('user','html');
        $model = & $this->getModel('user');       
        $view->setModel($model, true);
        $view->showProfile(null);
        
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
    function saveavatar()
    {
               
        $model = & $this->getModel('user');        
        $result = $model->saveAvatar();     
      
    }
    function saveattachment()
    {
               
        $model = & $this->getModel('user');        
        $result = $model->saveAttachment();     
      
    }


}

?>