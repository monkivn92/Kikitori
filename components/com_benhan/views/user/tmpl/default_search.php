<?php defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$controller = JRequest::getVar('controller');
$user		= JFactory::getUser();
$doc = JFactory::getDocument();

$doc->addStyleSheet('/components/com_comprofiler/plugin/templates/default/template.css');
$doc->addStyleSheet('/components/com_benhan/asset/benhan.css');
$doc->addScript('/components/com_benhan/asset/jquery.min.js');
$doc->addScript('/components/com_benhan/asset/benhan.js');

?>

<h2>Search Patient</h2>
<form action="" id="patient_search">
	<p>
		<label for="patient_search">Patien Name:</label>
		<input type="text" id="search_keyword"/>
	</p>
	<input type="submit" value="Search" class="btn btn-primary" />
	
</form>
<blockquote class="rounded" id="search_result">
	
</blockquote>