<?php
defined('_JEXEC') or die;

class PxrdshealthboxViewOrgs extends JViewLegacy
{

	protected $items;
	protected $state;
	protected $pagination;

	function display($tpl = null)
	{
		
		$this->items = $this->get('Items');
		$this->state = $this->get('State');		
		$this->pagination = $this->get('Pagination');
		
		//FolioHelper::addSubmenu('folios');
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		//$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
		
	}

	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', 0);
		JToolbarHelper::title(JText::_('Organization Management'), '');
		JToolbarHelper::addNew('org.add');		
		JToolbarHelper::custom('org.import','box-remove','box-remove','Import',false);		
		JToolbarHelper::editList('org.edit');	
		JToolbarHelper::publish('orgs.publish', 'JTOOLBAR_PUBLISH', true);	
		JToolbarHelper::unpublish('orgs.unpublish', 'JTOOLBAR_UNPUBLISH', true);		
		JToolbarHelper::archiveList('orgs.archive');	
		JToolBarHelper::deleteList('', 'orgs.delete', 'JTOOLBAR_DELETE');	
		
	}

	protected function getSortFields()
	{
		return array(
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.state' => JText::_('JSTATUS'),
			'a.name' => JText::_('Name'),
			'a.id' => JText::_('ID')
			);
	}/// get values for options of select tag 'SORT TABLE BY:'

}