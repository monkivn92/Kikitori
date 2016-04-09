<?php

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );


class BenhanViewBa extends JView
{

    function showForm($message)
	{
		
		//get CBfield
        $data = $this->get('CBfield');        
   		$userInfo = $this->get('UserInfo');
        $pageInfo = $data->page_info;
        $total =  $data->total;
        $cur_page =  $data->cur_page;
        $CBf = $data->CBfields;
       	// send var to layout
		
		$this->assignRef( 'message', $message );			
		$this->assignRef( 'CBf', $CBf );	
		$this->assignRef( 'userInfo', $userInfo );	
		$this->assignRef( 'pageInfo', $pageInfo );	
		$this->assignRef( 'total', $total );	
		$this->assignRef( 'cur_page', $cur_page );	
		parent::display();

	}

}

?>
