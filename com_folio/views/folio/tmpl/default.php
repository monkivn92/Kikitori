<?php
defined('_JEXEC') or die;

?>
<form action="<?php echo JRoute::_('index.php?option=com_
folio&layout=edit&id='.(int) $this->item->id); ?>" method="post" 
name="adminForm" id="adminForm" class="form-validate">
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
			
			<?php /* Day la mot cach goi field
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
			</div>
			*/?>

			<?php foreach ($this->form->getFieldset('myfields') as $field) : ?>

			<div class="control-group">
				<div class="control-label">
					<?php echo $field->label; ?>
				</div>
				<div class="controls">		
					<?php echo $field->input; ?>
				</div>
			</div>
			<?php endforeach; ?>

			<?php echo JHtml::_('bootstrap.endTab');//end first tab?> 	

			<?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'tab2_id', JText::_('COM_BOOTSTRAPTABS_TAB_2')); ?> 
			<p>Content of the second tab.</p> 
			<?php echo JHtml::_('bootstrap.endTab');?> 

			<?php echo JHtml::_('bootstrap.endTabSet');?>
			
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
			
		</fieldset>
		</div>
	</div>
</form>