<?php
jimport( 'joomla.application.component.controller' );
class BenhanControllerBa extends JController
{
	
	function __construct($default = array())
    {
        parent::__construct($default);

        //$this->registerTask('add', 'edit');
        
    }

    function create()
    {
        
        $userid = JRequest::getInt('userid');
        $user = JFactory::getUser();
        $view = &$this->getView('ba','html');
        $model = & $this->getModel('ba');       
        $view->setModel($model, true);

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
                if(!$model->isAdmin($user->id))
                {
                    die('You are not authorized !');
                }                    
                else
                {
                    $this_user = $userid;
                }
                    
            }
        }
        $view->showForm(null);
       
        
    }    

    function adduser()
    {
        $view = &$this->getView('user','html');
        $model = & $this->getModel('user');       
        $view->setModel($model, true);
        $view->showForm(null);
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