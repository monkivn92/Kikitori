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
	function showFormSearch($message)
	{
		
		parent::display('search');
	}
	function showProfile($message)
	{

		$userInfo = $this->get('UserInfo');  
		$avatar = $this->get('Avatar');  
		$attachment = $this->get('Attachment');  

       	$db = JFactory::getDbo();
       	$sql = "SELECT name FROM #__users WHERE id=".$userInfo->_cbuser->id;    

        $db->setQuery($sql);
        $name = $db->loadResult(); 			
		$this->assignRef( 'userInfo', $userInfo );
		$this->assignRef( 'name', $name );
		$this->assignRef( 'avatar', $avatar );
		$this->assignRef( 'attachment', $attachment );

		parent::display('profile');
	}

}

?>
