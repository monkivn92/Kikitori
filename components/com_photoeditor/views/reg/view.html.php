<?php

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );
$lang = JFactory::getLanguage();

class JregistrationViewReg extends JView
{

    function showForm()
	{
		
		global $_PLUGINS, $_CB_database; 
		$session = JFactory::getSession();
		$_PLUGINS->loadPluginGroup('user');	 
		$itemID = JRequest::getVar('Itemid');
		if($itemID)
		{
			$session->clear('jreg_error_message');
		}
		$error_message = $session->get('jreg_error_message');
        //get captcha tab
		$captcha_html = $_PLUGINS->trigger( 'onGetCaptchaHtmlElements', array( true ) );
		$captcha_html[0] = str_replace('160', '0', $captcha_html[0])	;

		//get CBfield
        $CBf = $this->get('CBfield');
       // send var to layout
		$this->assignRef( 'captcha_html', $captcha_html );	
		$this->assignRef( 'error_message', $error_message );	
		$this->assignRef( 'cblabel', $cblabel );	
		$this->assignRef( 'CBf', $CBf );	
		parent::display();

	}

}

?>
