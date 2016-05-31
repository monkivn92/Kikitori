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
		//get CBfield
        $UserRecentlyAdd = $this->get('UserRecentlyAdd'); 
        $this->assignRef( 'UserRecentlyAdd', $UserRecentlyAdd );	  
		parent::display('search');
	}
	function showProfile($message)
	{
		
		$userid = $this->get('UserID');  
		$attachments = $this->get('Attachment');		
		$imgGallery = $this->get('ImgGallery');		

       	$db = JFactory::getDbo();
       	$sql = "SELECT name FROM #__users WHERE id=".$userid;    
        $db->setQuery($sql);
        $name = $db->loadResult(); 			
		
		$this->assignRef( 'name', $name );	
		$this->assignRef( 'userid', $userid );
		$this->assignRef( 'attachments', $attachments );
		$this->assignRef( 'imgGallery', $imgGallery );

		parent::display('profile');
	}

}

?>
