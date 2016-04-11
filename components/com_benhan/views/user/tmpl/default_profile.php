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

<blockquote class="rounded" id="profile">
	<h2><?php echo $this->name ?></h2>

	<p>
		<?php
			$link = "/component/benhan/?view=ba&userid=".$this->userInfo->_cbuser->id;
			echo "<a href='$link'>Medical Report</a>";
		?>
		
	</p>
	<p>
		<?php
			$link = "/component/benhan/?view=user&task=edituser&userid=".$this->userInfo->_cbuser->id;
			echo "<a href='$link'>Edit Profile</a>";
		?>
		
	</p>
	
</blockquote>