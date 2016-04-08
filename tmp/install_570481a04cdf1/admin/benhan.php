<?php
/** ensure this file is being included by a parent file **/
if ( ! defined( '_JEXEC' ) ) { die( 'Direct Access to this location is not allowed.' ); }
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_medschd'.DS.'tables');
$controller = JRequest::getVar('controller','schedule');
require_once(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
JRequest::setVar('controller', $controller);
$ctrl_class  = 'Medschd'.'Controller'.$controller ;
$controller = new $ctrl_class(array('default_task' => 'showRecords'));
// Perform the Request task
$controller->execute( JRequest::getVar('task') );
// Redirect if set by the controller
$controller->redirect();


?>