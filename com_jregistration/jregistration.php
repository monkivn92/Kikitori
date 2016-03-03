<?php
/** ensure this file is being included by a parent file **/
if ( ! defined( '_JEXEC' ) ) { die( 'Direct Access to this location is not allowed.' ); }

/** connect to CB API **/
global $_CB_framework, $_PLUGINS; 

$mainframe = JFactory::getApplication();

if ( defined( 'JPATH_ADMINISTRATOR' ) ) {
	if ( ! file_exists( JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.foundation.php' ) ) {
		 echo 'CB not installed!';
		 return;
	}	 
	include_once( JPATH_ADMINISTRATOR . '/components/com_comprofiler/plugin.foundation.php' );
} 
else 
{
	if ( ! file_exists( $mainframe->getCfg( 'absolute_path' ) . '/administrator/components/com_comprofiler/plugin.foundation.php' ) ) {
		echo 'CB not installed!';
		return;
	}
 
	include_once( $mainframe->getCfg( 'absolute_path' ) . '/administrator/components/com_comprofiler/plugin.foundation.php' );
}
include_once( $mainframe->getCfg( 'absolute_path' ) . '/components/com_comprofiler/plugin/language/default_language/default_language.php' );

cbimport( 'language.front' );
cbimport( 'cb.database' );
cbimport( 'cb.plugins' );
cbimport( 'cb.tables' );
cbimport( 'cb.html' );
cbimport( 'cb.tabs' );


ob_start();
cbimport( 'cb.validator' );
cbValidator::renderGenericJs();
$cbjavascript	=	ob_get_contents();
ob_end_clean();
$_CB_framework->outputCbJQuery( $cbjavascript, array( 'metadata', 'validate' ) );		
//CB API END
/*  */
$language = JFactory::getLanguage();
$language->load('com_jregistration', JPATH_SITE.'/components/com_jregistration/language','en-GB', true);

$controller = JRequest::getVar('controller','reg');
require_once(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
JRequest::setVar('controller', $controller);
$ctrl_class  = 'Jregistration'.'Controller'.$controller ;
$controller = new $ctrl_class(array('default_task' => 'create'));
// Perform the Request task
$controller->execute( JRequest::getVar('task') );
// Redirect if set by the controller
$controller->redirect();


?>