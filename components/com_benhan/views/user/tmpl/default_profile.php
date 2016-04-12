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
	<div id="profile-avatar" style="margin-bottom:20px">
		<?php
		if($this->avatar)
		{
			echo "<img src='/".$this->avatar."'  />";
		}
			
		?>
	</div>
	<p>
		<input id="avatar_input" type="file" name="avatar" />
		<button id="upload_avatar">Upload</button>
	</p>
	<hr>
	<p>
		<?php
			$link = "/component/benhan/?view=user&task=edituser&userid=".$this->userInfo->_cbuser->id;
			echo "<a  class='btn btn-primary' target='_blank' style='margin:10px' href='$link'>Edit Profile</a>";
		?>
		
	</p>

	<p>
		<?php
			$link = "/component/benhan/?view=ba&userid=".$this->userInfo->_cbuser->id;
			echo "<a class='btn btn-primary' target='_blank' style='margin:10px' href='$link'>Medical Report</a>";
		?>
		
	</p>	
	
</blockquote>