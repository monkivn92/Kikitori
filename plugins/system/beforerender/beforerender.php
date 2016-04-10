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
 * @version		1.6
 */
class plgSystemBeforerender extends JPlugin
{
	function plgSystemBeforerender(& $subject, $config)
	{
		parent::__construct($subject, $config);
		//$this->onBeforeRender();
		
	}
	function onBeforeRender()
	{
		$doc = JFactory::getDocument();
		$doc->addStyleSheet('/extra/FontAwesome/css/font-awesome.min.css');
		
	}

	
}
