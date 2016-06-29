<?php
defined('_JEXEC') or die;
if (!JFactory::getUser()->authorise('core.manage', 'com_folio'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$language = JFactory::getLanguage();
$language->load('com_folio',  dirname(__FILE__), $language->getTag(), true);

$controller = JControllerLegacy::getInstance('Folio');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();