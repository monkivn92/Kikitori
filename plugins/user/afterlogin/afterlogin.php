<?php
/**
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
// Import library dependencies
jimport('joomla.plugin.plugin');
jimport('joomla.event.plugin');

/**
 * An example custom profile plugin.
 *
 * @package		Joomla.Plugin
 * @subpackage	User.profile
 * @version		2.5
 */
class plgUserAfterlogin extends JPlugin
{
	function plgUserAfterlogin(& $subject, $config)
	{
		parent::__construct($subject, $config);
		//die('asads');	
		
	}
	function onUserLoginFailure()
	{
		echo 'aaa';die();
		$app = JFactory::getApplication();
		$app->redirect(JUri::base());		
	}

	
}
