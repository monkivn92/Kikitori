<?php
jimport( 'joomla.application.component.controller' );
class MedschdControllerSchedule extends JController
{
	
	function __construct($default = array())
    {
        parent::__construct($default);

        $this->registerTask('add', 'edit');
        $this->registerTask('edit', 'edit');
        $this->registerTask('apply', 'save');
        $this->registerTask('save', 'save');
        $this->registerTask('cancel', 'cancel');
        $this->registerTask('saveorder', 'saveorder');
        $this->registerTask('orderup', 'orderup');
        $this->registerTask('orderdown', 'orderdown');        
        $this->registerTask('remove', 'remove');
    }
    function showRecords()
    {
        $model = $this->getModel( 'schedule' );
        $list = $model->show();
        $view  = $this->getView( 'schedule','html' );      
        $view->show($list);
    }
    function edit()
    {
        
        $model = $this->getModel( 'schedule' );
        $row = $model->edit();
        $view  = $this->getView( 'schedule','html' );
        $view->edit($row);

    }
    function save()
    {
        $mainframe = JFactory::getApplication();
        $model = $this->getModel( 'schedule' );
        $row = $model->save();        
        switch ($task) 
        {
            case 'apply':
                $msg = 'Changes to Review saved';
                $link = 'index.php?option=com_medschd&controller=schedule&task=edit&cid[]='. $row->id;
                break;
            case 'save':
            default:
                $msg = 'Review Saved';
                $link = 'index.php?option=com_medschd&controller=schedule';
                break;
        }
        
        $mainframe->redirect( $link , $msg);

    }
    
    function saveorder()
    {
        
        $model = $this->getModel( 'schedule' );
        $list = $model->saveorder();     
        $view  = $this->getView( 'schedule','html' );      
        $view->show($list);     

    }
    function orderup()
    {
        
        $model = $this->getModel( 'schedule' );
        $list = $model->orderup();     
        $view  = $this->getView( 'schedule','html' );      
        $view->show($list);     

    }
    function  orderdown()
    {
        
        $model = $this->getModel( 'schedule' );
        $list = $model-> orderdown();     
        $view  = $this->getView( 'schedule','html' );      
        $view->show($list);     

    }
   
    function remove()
    {
        $mainframe = JFactory::getApplication();
        $model = $this->getModel( 'schedule' );
        $model->remove();   
        $msg = 'Deleted';
        $link = 'index.php?option=com_medschd&controller=schedule';   
        $mainframe->redirect( $link , $msg);

    }

	function cancel(){
		$option = JRequest::getCmd('option');
		$controller = JRequest::getCmd('controller', 'schedule');
		$this->setRedirect( "index.php?option=$option&controller=$controller" );
	}
    
}

?>