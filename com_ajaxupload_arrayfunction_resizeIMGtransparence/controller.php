<?php
defined('_JEXEC') or die;
class PxrdshealthboxController extends JControllerLegacy
{
	protected $default_view = 'orgs';
	public function display($cachable = false, $urlparams = false)
	{
				
		parent::display();
		return $this;
		
	}
}