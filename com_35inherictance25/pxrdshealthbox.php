<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}

if (!JFactory::getUser()->authorise('core.admin', 'com_contact'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_pxrdshealthbox'.DS.'tables');

$controller = JRequest::getVar('view','show');
require_once(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');

JRequest::setVar('controller', $controller);
$ctrl_class  = 'Pxrdshealthbox'.'Controller'.$controller ;
$controller = new $ctrl_class(array('default_task' => 'show'));
// Perform the Request task
$controller->execute( JRequest::getVar('task') );
// Redirect if set by the controller
$controller->redirect();

