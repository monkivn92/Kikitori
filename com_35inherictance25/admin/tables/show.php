<?php
defined('_JEXEC') or die('Restricted access');
class TableShow extends JTable
{
	var $id = null;
	var $name = null;
	var $home_url = null;
	var $login_url = null;
	var $registration_url = null;
	var $keywords = null;
	var $description = null;
	var $address = null;
	var $logo = null;
	var $published= null;
	var $ordering = null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__xrds_portals','id', $db );
	}
}