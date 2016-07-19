<?php
defined('_JEXEC') or die;

?>
<form action="<?php echo JRoute::_('index.php?option=com_pxrdshealthbox&layout=edit&id='.(int) $this->item->id); ?>" method="post" 
name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
		<fieldset>
	
			<?php 
				$options = array(
							    'active'    => 'tab1_id'    // Not in docs, but DOES work
							);
			?>
			<?php echo JHtml::_('bootstrap.startTabSet', 'ID-Tabs-Group', $options);?> 

			<?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'tab1_id', 
				empty($this->item->id)? 'New' : 'Edit',true );//add first tab ?> 
			
			

			<?php foreach ($this->form->getFieldset('orgEditForm') as $field) : ?>

			<div class="control-group"  >
				<div class="control-label" style="font-weight:bold">
					<?php echo $field->label; ?>
				</div>
				<div class="controls">		
					<?php echo $field->input; ?>
				</div>
			</div>
			<?php endforeach; ?>

			<div class="control-group">
				<div class="control-label">
					Logo
				</div>
				<div class="controls">		
					<?php
						
						if(trim($this->item->logo) !== '')
						{ 
							$path = "/components/com_pxrdshealthbox/images/logos/".$this->item->logo;
						?>
							<img src="<?php echo $path; ?>" alt="" width="200">
						<?php } else {
							echo 'No logos';

						}?>
								
					
				</div>
			</div>

			<div class="control-group"  >
				<div class="control-label" style="font-weight:bold">
					Change/Upload Logo
				</div>
				<div class="controls">					
					<input type="file" name="logo" >
				</div>
			</div>

			<?php echo JHtml::_('bootstrap.endTab');//end first tab?> 	
			

			<?php echo JHtml::_('bootstrap.endTabSet');?>
			
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
			
		</fieldset>
		</div>
	</div>

</form>