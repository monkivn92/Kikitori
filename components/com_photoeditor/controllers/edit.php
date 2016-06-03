<?php
jimport( 'joomla.application.component.controller' );
class PhotoeditorControllerEdit extends JController
{
	
	function __construct($default = array())
    {
        parent::__construct($default);      
        
    }

    function display()
    {

        $view = &$this->getView('edit','html');
        $model = & $this->getModel('edit');       
        $view->setModel($model, true);
        $view->show();
    }  
    function getlist()
    {
        $app = JFactory::getApplication();
        $model = & $this->getModel('edit');
        $list = $model->getPhotoList();
        echo $list;
        $app->close();
    }  
}

?>