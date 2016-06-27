<?php
defined('_JEXEC') or die;

class PxrdshealthboxViewShow extends JViewLegacy
{
	function show($msg)
	{
		
		$data = $this->get('Data');			
		$this->addToolbar();
		$sidebar = JHtmlSidebar::render();

		$this->assignRef('data',$data);
		$this->assignRef('sidebar',$sidebar);
		parent::display();
		
	}
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', 0);
		JToolbarHelper::title('Organization Manager');
		JToolbarHelper::addNew();
		JToolbarHelper::editList();
		JToolbarHelper::publishList();
		JToolbarHelper::unpublishList();
		JToolbarHelper::deleteList();
		// De nhung toolbar nay hoat dong duoc thi
		// layout phai chua day du cac truong hidden input cua option, task, controller
		
	}
	function edit($msg)
	{
	
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();

		if(JRequest::getCmd('ref') !== '')
		{
			$session = JFactory::getSession();  
			$data = $session->get('ORG_FORM_DATA');			
			$data = unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen('JSession') . ':"' . 'JSession' . '"', serialize($data)));
					
		}
		else
		{
			$data = $this->get('Row');
		}
			
		$this->assignRef('data',$data);
		parent::display('edit');
	}



}