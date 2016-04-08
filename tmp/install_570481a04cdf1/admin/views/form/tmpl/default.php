`<?php defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$controller = JRequest::getVar('controller');
$user		= JFactory::getUser();
$canOrder	= $user->authorise('core.edit.state', 'com_medschd.schedule');
$saveOrder	= $this->order == 'ordering';
$ordering	= $this->order == 'ordering';
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
		<table>
			  <tr>
			    <td align="left" width="100%">
			    <?php echo JText::_( 'Search' ); ?>:
			    <input type="text" name="search" id="search" 
		             value="<?php echo $this->search;?>" 
		             class="text_area"  
		             onchange="document.adminForm.submit();" />
			    <button onclick="this.form.submit();">
		       <?php echo JText::_( 'Go' ); ?></button>
			    <button 
					onclick="document.getElementById('search').value='';
					this.form.submit();">
		       <?php echo JText::_( 'Reset' ); ?></button>
			    </td>
		    </tr>
	    </table>    
		<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
				<input type="checkbox" name="toggle" 
				value="" onclick="checkAll(<?php echo 
				count( $this->record ); ?>);" />
				</th>			
				<th width="5%">ID</th>
				<th width="10">Title</th>
				<th width="10%">					
					<?php echo JHTML::_('grid.sort', 'Ordering', 'ordering',@$this->order_dir,@$this->order); ?>
					
					<?php echo JHtml::_('grid.order',  $this->record, 'filesave.png', 'saveorder'); ?>
					
				</th>				
				<!-- <th width="2%" nowrap="nowrap">Published</th> -->
			</tr>
		</thead>
		<?php
		jimport('joomla.filter.output');
		$k = 0;
		for ($i=0, $n=count( $this->record ); $i < $n; $i++) 
		{
		$rec = $this->record[$i];
		$checked = JHTML::_('grid.id', $i, $rec->id );
		//$published = JHTML::_('grid.published', $rec, $i );
		$link = JFilterOutput::ampReplace( 'index.php?option=com_medschd&controller=schedule&task=edit&cid[]='. $rec->id );
		?>
		<tr class="<?php echo 'rec'.$k; ?>">
		<td align="center">
		<?php echo $checked; ?>
		</td>
		<td align="center">
		<?php echo $rec->id; ?>
		</td>
		<td align="center">
		<a href="<?php echo $link; ?>">
		<?php echo $rec->title; ?></a>
		</td>		
		<td align="center" class="order">		
			<?php if ($this->order_dir == 'asc') : ?>
				<span><?php echo $this->pageNav->orderUpIcon($i, true, 'orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
				<span><?php echo $this->pageNav->orderDownIcon($i, $this->pageNav->total, true, 'orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
			<?php elseif ($this->order_dir  == 'desc') : ?>
				<span><?php echo $this->pageNav->orderUpIcon($i, true, 'orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
				<span><?php echo $this->pageNav->orderDownIcon($i, $this->pageNav->total, true, 'orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
			<?php endif; ?>		
			<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
			<input type="text" name="order[]" size="5" value="<?php echo $rec->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
		</td>	
		<!--	
		<td align="center">
		<?php //echo $published;?>
		</td>
		-->
		</tr>
		<?php
		$k = 1 - $k;
		}
		?>
		<tfoot>
			<td colspan="7"><?php echo $this->pageNav->getListFooter(); ?></td>
		</tfoot>
	</table>
	<input type="hidden" name="task" value=""/>
    <input type="hidden" name="option" value="<?php echo $option;?>"/>    
    <input type="hidden" name="controller" value="<?php echo $controller;?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->order_dir;?>" />
    <input type="hidden" name="filter_order" value="<?php echo $this->order;?>" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_( 'form.token' ); ?>

</form>

