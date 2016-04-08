<?php

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );

class BenhanViewForm extends JView
{

    function showForm($message)
	{
		
		JToolBarHelper::title(   JText::_( 'Schedule Manager' ) );
		JToolBarHelper::addNewX('edit');
		JToolBarHelper::editListX('edit');
		JToolBarHelper::publish('publish', 'Publish'); 
      	JToolBarHelper::unpublish('unpublish','Unpublish'); 
		JToolBarHelper::deleteList(JText::_('Are you sure?'), 'remove', 'delete');

		$list = $this->get('Records');
		$record = $list['rows'];
		$total = $list['total'];
		$search = $list['search'];

		$app = JFactory::getApplication();		
		$limit = JRequest::getVar('limit',$app->getCfg('list_limit'));
		$limitstart = JRequest::getVar('limitstart', 0);
		$order = $app->getUserStateFromRequest( "com_benhan.form.filter_order", 'filter_order', 'ordering','string' );
		$order_dir = $app->getUserStateFromRequest( "com_benhan.form.filter_order_Dir", 'filter_order_Dir', 'desc','string' );	

		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);	

		$this->assignRef( 'record', $record );	
		$this->assignRef( 'pageNav', $pageNav );	
		$this->assignRef( 'order', $order );	
		$this->assignRef( 'order_dir', $order_dir );
		$this->assignRef( 'search', $search );	
		$this->assignRef( 'message', $message );	
		parent::display();
	}

	function editForm($message)
	{
		
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
		$record = $this->get('Editor');	
		
		$this->assignRef( 'record', $record );
		parent::display('edit');	
	}


}

?>