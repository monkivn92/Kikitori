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
		<label for="search_name">Patien Name:</label>
		<input type="text" id="search_name"/>
	</p>
	<p>
		<label for="search_mrid">Patien's Medical Report ID:</label>
		<input type="text" id="search_mrid"/>
	</p>
	<input type="submit" value="Search" class="btn btn-primary" />
	
</form>
<div id="loading" style="display:none">
		<img src="/components/com_benhan/img/hourglass.svg" alt="">
		Loading...
</div>
<div id="search_result">
	
</div>