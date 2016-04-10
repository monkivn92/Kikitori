<?php

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );


class BenhanViewUser extends JView
{

    function showForm($message)
	{
		
		//get CBfield
        $CBf = $this->get('CBfield');        
   		$userInfo = $this->get('UserInfo');       
       	// send var to layout		
		$this->assignRef( 'message', $message );			
		$this->assignRef( 'CBf', $CBf );	
		$this->assignRef( 'userInfo', $userInfo );		
		parent::display();

	}
	function showFormEdit($message)
	{
		//get CBfield
        $CBf = $this->get('CBfieldEdit');        
   		$userInfo = $this->get('UserInfo');       
       	// send var to layout		
		$this->assignRef( 'message', $message );			
		$this->assignRef( 'CBf', $CBf );	
		$this->assignRef( 'userInfo', $userInfo );		
		parent::display('edit');
	}

}

?>
