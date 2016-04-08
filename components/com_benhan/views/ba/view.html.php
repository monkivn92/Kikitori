<?php

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );


class BenhanViewBa extends JView
{

    function showForm($message)
	{
		
		//get CBfield
        $CBf = $this->get('CBfield');
        $baform = $this->get('BAForm');
       	// send var to layout
		
		$this->assignRef( 'message', $message );			
		$this->assignRef( 'CBf', $CBf );	
		$this->assignRef( 'baform', $baform );	
		parent::display();

	}

}

?>
