<?php
defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_folio'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

define(JPATH_SAVED_LOGOS, JPATH_SITE.'/images/logos');

$language = JFactory::getLanguage();
$language->load('com_pxrdshealthbox',  dirname(__FILE__), $language->getTag(), true);

$controller = JControllerLegacy::getInstance('Pxrdshealthbox');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();