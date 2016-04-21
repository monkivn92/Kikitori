<?php defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$controller = JRequest::getVar('controller');
$user		= JFactory::getUser();
$doc = JFactory::getDocument();

$doc->addStyleSheet('/components/com_comprofiler/plugin/templates/default/template.css');
$doc->addStyleSheet('/components/com_benhan/asset/benhan.css');
$doc->addScript('/components/com_benhan/asset/jquery.min.js');
$doc->addScript('/components/com_benhan/asset/benhan.js');
JHTML::_('behavior.modal','a.jmodal');
?>


<blockquote class="rounded" id="profile">
	<h2><?php echo $this->name ?></h2>
	<div id="profile-avatar" style="margin-bottom:20px">
		<?php
		if($this->avatar)
		{
			echo "<img style='height:100px' class='pro5-avatar' src='/".$this->avatar."'  />";
		}
			
		?>
		
	</div>
	<p id="change_avatar"><a href="">Change Avatar</a></p>
	<p id="avatar_upload_area" class="default_hide" >
		<input id="avatar_input" type="file" name="avatar" />
		<button id="upload_avatar">Upload</button>
	</p>
	<hr><!-- Patient avatar and name end -->

	<div id="pro5-attachment">
		<h3>Attachments</h3>
		<p id="upload_attachment" class="btn btn-primary"><a style="color:#FFF" href="">Upload attachment</a></p>
		<p id="show_attachment" class="btn btn-primary"><a style="color:#FFF" href="">Show/Hide attachment</a></p>
		
		<p id="attachment_upload_area" class="default_hide" >
			<input id="attach_input" type="file" name="attach[]" multiple="multiple" />
			<button id="upload_attach">Upload</button>
		</p>

		<blockquote id="attachment-items">
			<?php
				echo $this->attachment;
			?>
		</blockquote>
	</div>
	<hr><!-- Attachment end -->
	<h3>Edit Patient</h3>
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
<script>
	
jQuery(document).ready(function($){

	$("#upload_avatar").on("click", function() {

	    var file_data = $("#avatar_input").prop("files")[0];  

	    var form_data = new FormData();                  
	    form_data.append('file', file_data);
	                               
	    $.ajax({
	                url: '<?php echo 'index.php?option=com_benhan&view=user&task=saveavatar&userid='.$this->userInfo->_cbuser->id ?>', // point to server-side PHP script 
	                dataType: 'text',  // what to expect back from the PHP script, if anything
	                cache: false,
	                contentType: false,
	                processData: false,
	                data: form_data,                         
	                type: 'post',
	                success: function(res)
	                {
	                    $('#profile-avatar').empty(); 
	                    $('#profile-avatar').append(res);
	                }
	     });
	});

	$('#change_avatar').click(function(){

		$('#avatar_upload_area').slideToggle();
		return false;

	});
	$('#upload_attachment').click(function(){

		$('#attachment_upload_area').slideToggle();
		return false;

	});
	$('#show_attachment').click(function(){

		$('#attachment-items').slideToggle();
		return false;

	});
	$("#upload_attach").on("click", function() {

	    var file_data = $("#attach_input").prop("files");	    
	    var form_data = new FormData();                  
	    //form_data.append('attach', file_data);
	    $.each(file_data, function(i, file) {
		    form_data.append('attach[]', file);
		});
	                            
	    $.ajax({
	                url: '<?php echo 'index.php?option=com_benhan&view=user&task=saveattachment&userid='.$this->userInfo->_cbuser->id ?>', // point to server-side PHP script 
	                dataType: 'text',  // what to expect back from the PHP script, if anything
	                cache: false,
	                contentType: false,
	                processData: false,
	                data: form_data,                         
	                type: 'post',
	                success: function(res)
	                {
	                    
	                    //$('#attachment-items').empty(); 	                   
	                    //$('#attachment-items').append(res);	         
	                    location.reload();           
	                   
	                }
	     });
	});


});
</script>