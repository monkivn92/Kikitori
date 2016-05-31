<?php defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$controller = JRequest::getVar('controller');
$user		= JFactory::getUser();
$doc = JFactory::getDocument();

$userid = $this->userid;
$user_name = $this->name;
$attachments = $this->attachments;
$imgGallery = $this->imgGallery;

$doc->addStyleSheet('/components/com_comprofiler/plugin/templates/default/template.css');
$doc->addStyleSheet('/components/com_benhan/asset/benhan.css');
$doc->addScript('/components/com_benhan/asset/jquery.min.js');
$doc->addScript('/components/com_benhan/asset/benhan.js');
JHTML::_('behavior.modal','a.jmodal');
?>

<div id="profile-page">
	<?php
		include_once('/components/com_benhan/helper/patient_info.php');
		include_once('/components/com_benhan/helper/attachments.php');
		include_once('/components/com_benhan/helper/img_data.php');

	?>
</div>

