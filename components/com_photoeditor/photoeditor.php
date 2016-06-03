<?php
/** ensure this file is being included by a parent file **/
if ( ! defined( '_JEXEC' ) ) { die( 'Direct Access to this location is not allowed.' ); }

$controller = JRequest::getVar('view','edit');

if( is_file(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php') )
{
	require_once(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}
else
{
	JError::raiseError(403,'Forbidden');
}

JRequest::setVar('controller', $controller);
$ctrl_class  = 'Photoeditor'.'Controller'.$controller ;
$controller = new $ctrl_class(array('default_task' => 'display'));
// Perform the Request task
$controller->execute( JRequest::getVar('task') );
// Redirect if set by the controller
$controller->redirect();


?>