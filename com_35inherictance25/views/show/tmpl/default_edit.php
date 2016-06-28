<?php

defined('_JEXEC') or die;

$data = $this->data;
$ref = JRequest::getCmd('ref');

?>

<form action="index.php?option=com_pxrdshealthbox&view=show&task=save" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<p class="org-field-row">
	<label for="name">Name</label>
	<input type="text" name="name"  value="<?php echo $data->name; ?>" >
	</p>

	<p class="org-field-row">
	<label for="name">Homepage URL</label>
	<input type="text" name="home_url"  value="<?php echo $data->home_url; ?>" >
	</p>

	<p class="org-field-row">
	<label for="name">Login URL</label>
	<input type="text" name="login_url"  value="<?php echo $data->login_url; ?>" >
	</p>

	<p class="org-field-row">
		<label for="name">Registration URL</label>
		<input type="text" name="registration_url"  value="<?php echo $data->registration_url; ?>" >
	</p>

	<p class="org-field-row">
		<label for="name">Keywords</label>
		<textarea  name="keywords"  value=""  style="width: 300px; height: 150px;">
			<?php echo $data->keywords; ?>
		</textarea>
	</p>

	<p class="org-field-row">
		<label for="name">Description</label>
		<textarea name="description"  value=""  style="width: 300px; height: 150px;">
			<?php echo $data->description; ?>
		</textarea>
	</p>	

	<p class="org-field-row">
	<label for="name">Address</label>
	<input type="textarea" name="address"  value="<?php echo $data->address; ?>" >
	</p>

	<p class="org-field-row">
	<label for="name">Publish</label>
	<select  name="published"  value="<?php echo $data->published; ?>" >
		<?php

			$option = $data->published == 1 ? '<option value="0">No</option><option value="1" selected>Yes</option>':'<option value="0"  selected>No</option><option value="1">Yes</option>';
			echo $option;
		?>		
	</select>
	</p>

	<p class="org-field-row">
		<label for="name">Logo</label>

		<?php
			if($data->logo)
			{
				$logo_path = '/components/com_pxrdshealthbox/images/logos/'.$data->logo;			
				
				echo "<img src='$logo_path' width='200px' /><br/>";
			}	
			else
			{
				echo '<i>No logos</i>';
			}		
		?>
	
	</p>
	<p class="org-field-row">
		<label for="name">Upload/Change Logo</label>
		<input type="file" name='logo'>
	</p>
	
	<input type="submit" value='Save' class="btn btn-primary" onclick="Joomla.submitbutton()">

	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="id" id="id" value="<?php echo $data->id; ?>" />
	<input type="hidden" name="option" value="com_pxrdshealthbox" />
	<input type="hidden" name="view" value="show" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>

<style>
	.org-field-row{
		margin: 20px 0px;
	}
	.org-field-row label{
		font-weight: bold;
		display: inline-block;
		width: 200px;
	}
</style>
<script>
	jQuery('#adminForm').submit(function(){

		var name = jQuery('input[name="name"]'),
			name_val = name.val();
		if(jQuery.trim(name_val)==='')
		{
			jQuery('html, body').animate({
			        scrollTop: name.offset().top - 150
			    }, 250);
			name.focus();
			return false;
		}
		return true;

	});
</script>