<form action="" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
	<?php
	echo '<p><b>Running...</b></p>';

	$logos = scandir(JPATH_SAVED_LOGOS);
	$thumbs  = scandir(JPATH_SAVED_LOGOS.'/thumb');
	foreach ($logos as $indx => $logo) 
	{
		if(is_dir(JPATH_SAVED_LOGOS."/$logo"))
		{
			unset($logos[$indx]);
		}
	}

	foreach ($thumbs as $indx => $thumb) 
	{
		if(is_dir(JPATH_SAVED_LOGOS."/$thumb"))
		{
			unset($thumbs[$indx]);
		}
	}

	$diff_key = array_keys(array_diff($logos, $thumbs));
	if($diff_key)
	{
		require_once(JPATH_HELPERS.'/resize-class.php');

		foreach ($diff_key as $idx => $key ) 
		{
			$file_name = $logos[$key];
			$resizeClass = new resize(JPATH_SAVED_LOGOS."/$file_name");
			$resizeClass->resizeImage(100,100,'auto');
			$resizeClass->saveImage(JPATH_SAVED_LOGOS."/thumb/$file_name");
			if($idx == 20)
			{
				echo '<p><b> Process '. $idx .' images successfully!</b></p>';
				break;
			}
		}
	}
		
	//echo '<p><b> Process '. count($diff_key) .' images successfully!</b></p>';

	?>
	<input type="hidden" name="task" value=''>
	<input type="hidden" name="controller" value='org'>
	<input type="hidden" name="option" value='com_pxrdshealthbox'>
	<?php echo JHtml::_('form.token'); ?>
</form>	