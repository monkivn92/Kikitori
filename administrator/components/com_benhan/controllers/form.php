<?php
jimport( 'joomla.application.component.controller' );
class BenhanControllerForm extends JController
{
	
	function __construct($default = array())
    {
        parent::__construct($default);

        $this->registerTask('add', 'edit');    
        $this->registerTask('apply', 'save');  
        $this->registerTask('unpublish', 'publish');  

      
    }
    function showRecords()
    {
        $view = &$this->getView('form','html');
        $model = & $this->getModel('form');       
        $view->setModel($model, true);
        $view->showForm(null);
    }
    function edit()
    {
        
        $model = $this->getModel( 'form' );        
        $view  = $this->getView( 'form','html' );
        $view->setModel($model, true);
        $view->editForm(null);

    }
    function save()
    {
        $mainframe = JFactory::getApplication();
        $model = $this->getModel( 'form' );
        $row = $model->save();     
        $task = JRequest::getVar('task');   
          
        switch ($task) 
        {
            case 'apply':
                $msg = 'Changes to Review saved';
                //$link = JRoute::_('index.php?option=com_benhan&task=edit&cid[]='. $row->id,true);
                $link = 'index.php?option=com_benhan&task=edit&cid[]='. $row->id;
                $mainframe->redirect( $link , $msg);
                break;
            case 'save':
            default:
                $msg = 'Form Saved';
                //$link = JRoute::_('index.php?option=com_benhan&task=showRecords',true);
                $link = 'index.php?option=com_benhan&task=showRecords';
                $mainframe->redirect( $link , $msg);
                break;
        }      
        
    }
    function publish()
    {
        $task = JRequest::getVar('task');
        $view = &$this->getView('form','html');
        $model = & $this->getModel('form'); 
        if($task=="unpublish")
        {
            $model->publish(0);
        }
        if($task=="publish")
        {
            $model->publish(1);
        }
                 
        $view->setModel($model, true);
        $view->showForm(null);
    }
    
    function saveorder()
    {
        
        $model = $this->getModel( 'form' );
        $list = $model->saveorder();     
        $view  = $this->getView( 'form','html' );      
        $view->showForm(null);

    }
    function orderup()
    {
        
        $model = $this->getModel( 'form' );
        $list = $model->orderup();  
        $view  = $this->getView( 'form','html' );      
        $view->showForm(null);

    }
    function  orderdown()
    {
        
        $model = $this->getModel( 'form' );
        $list = $model->orderdown();  
        $view  = $this->getView( 'form','html' );      
        $view->showForm(null);   

    }
   
    function remove()
    {
        $mainframe = JFactory::getApplication();
        $model = $this->getModel( 'form' );
        $model->remove();   
        $msg = 'Deleted';
        $link = JRoute::_('index.php?option=com_benhan&task=showRecords');   
        $mainframe->redirect( $link , $msg);

    }

	function cancel(){
		$option = JRequest::getCmd('option');
		$task = JRequest::getCmd('task', 'showRecords');
        $link = JRoute::_("index.php?option=$option&task=showRecords");
		$this->setRedirect( $link );
	}
    
}

?>