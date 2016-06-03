<?php

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );
$lang = JFactory::getLanguage();

class PhotoeditorViewEdit extends JView
{
	
    function show($error)
	{
		$uid = $this->get('UserID');
		$this->assignRef( 'uid', $uid );	
		
		parent::display();

	}
	
}

?>
