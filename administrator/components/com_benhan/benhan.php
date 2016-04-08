<?php
/** ensure this file is being included by a parent file **/
if ( ! defined( '_JEXEC' ) ) { die( 'Direct Access to this location is not allowed.' ); }

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_benhan'.DS.'tables');

$task = JRequest::getVar('task','view');

require_once(JPATH_COMPONENT.DS.'controllers'.DS.'form.php');

JRequest::setVar('task', $task);

$controller = new BenhanControllerForm(array('default_task' => 'showRecords'));
// Perform the Request task
$controller->execute( JRequest::getVar('task') );
// Redirect if set by the controller
$controller->redirect();


?>