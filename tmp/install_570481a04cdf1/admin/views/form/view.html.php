<?php

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );

class MedschdViewSchedule extends JView
{

    function show($list)
	{
		
		JToolBarHelper::title(   JText::_( 'Schedule Manager' ) );
		JToolBarHelper::addNewX();
		JToolBarHelper::editListX();
		JToolBarHelper::publishList(); 
      	JToolBarHelper::unpublishList(); 
		JToolBarHelper::deleteList(JText::_('are you sure?'), 'remove', 'delete');
		$record = $list['rows'];
		$total = $list['total'];
		$search = $list['search'];
		$mainframe = JFactory::getApplication();		
		$limit = JRequest::getVar('limit',$mainframe->getCfg('list_limit'));
		$limitstart = JRequest::getVar('limitstart', 0);
		$order = $mainframe->getUserStateFromRequest( "com_medschd.schedule.filter_order", 'filter_order', 'ordering','string' );
		$order_dir = $mainframe->getUserStateFromRequest( "com_medschd.schedule.filter_order_Dir", 'filter_order_Dir', 'desc','string' );
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);	
		$this->assignRef( 'record', $record );	
		$this->assignRef( 'pageNav', $pageNav );	
		$this->assignRef( 'order', $order );	
		$this->assignRef( 'order_dir', $order_dir );
		$this->assignRef( 'search', $search );	
		parent::display();
	}

	function edit($row)
	{
		
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
		$this->assignRef( 'row', $row );
		parent::display('edit');	
	}


}

?>