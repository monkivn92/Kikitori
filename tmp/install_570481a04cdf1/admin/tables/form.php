<?php
defined('_JEXEC') or die('Restricted access');
class TableSchedule extends JTable
{
	var $id = null;
	var $title = null;
	var $ordering = null;
	function __construct(&$db)
	{
		parent::__construct( '#__jmed_schd','id', $db );
	}
}
?>