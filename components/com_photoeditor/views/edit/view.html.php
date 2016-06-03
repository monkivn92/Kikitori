<?php

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );
$lang = JFactory::getLanguage();

class JregistrationViewEdit extends JView
{
	
    function showForm($error)
	{
		
		$uid = JRequest::getInt('uid');        
        $user =  JFactory::getUser();
        $this_user = 0;
        if(!$uid)
        {
            $this_user = $user->id;
            if(!JConnect_isResearcher($this_user))
            {
				JError::raiseError('403', 'You are not authorized!');
            }
        }
         
		global $_PLUGINS, $_CB_database; 
		$session = JFactory::getSession();
		$_PLUGINS->loadPluginGroup('user');	 
		$itemID = JRequest::getVar('Itemid');
		if($error)
		{
			
			$error_message = $session->get('jreg_error_message'); 
		}
		else
		{
			$session->clear('jreg_error_message');
		}
		$model      = $this->getModel();
		//get CBfield
        $CBf = $model->getCBfield($this_user);
       // send var to layout	
		$this->assignRef( 'error_message', $error_message );	
		$this->assignRef( 'cblabel', $cblabel );	
		$this->assignRef( 'CBf', $CBf );	
		parent::display('detail');

	}
	
	function show()
	{
		parent::display();
	}

}

?>
