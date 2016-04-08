<?php
defined('_JEXEC') or die('Restricted access');
class TableForm extends JTable
{
	var $id = null;
	var $title = null;
	var $fields = null;
	var $ordering = null;
	var $published = null;
	function __construct(&$db)
	{
		parent::__construct( '#__com_benhan_form','id', $db );
	}
}
?>