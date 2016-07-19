<?php
defined('_JEXEC') or die;
class PxrdshealthboxViewOrg extends JViewLegacy
{
	protected $item;
	protected $form;

	public function display($tpl = null)
	{
		$this->item = $this->get('Item');
		$this->form = $this->get('Form');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		$this->addToolbar();
		parent::display($tpl);
	}

	function importForm()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		JToolbarHelper::title(JText::_('Import CSV File'), '');
		JToolbarHelper::cancel('org.cancel', 'JTOOLBAR_CLOSE');
		parent::display('import');
	}

	function runScript()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		JToolbarHelper::title(JText::_('Execute Script'), '');
		JToolbarHelper::cancel('org.cancel', 'JTOOLBAR_CLOSE');
		include(JPATH_HELPERS.'/script_thumb.php');
	}

	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		JToolbarHelper::title(JText::_('Organization Editor'), '');
		JToolbarHelper::save('org.save');
		JToolbarHelper::apply('org.apply');
		
		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('org.cancel');
		}
		else
		{
			JToolbarHelper::cancel('org.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}