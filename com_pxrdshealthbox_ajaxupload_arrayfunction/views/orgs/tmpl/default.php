<?php
defined('_JEXEC') or die;

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

$user = JFactory::getUser();

/// FOR JQUERY UI SORTABLE////


$saveOrderingUrl = 'index.php?option=com_pxrdshealthbox&task=orgs.saveOrderAjax&tmpl=component';
JHtml::_('sortablelist.sortable', 'orgList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);

$sortFields = $this->getSortFields();
/// FOR JQUERY UI SORTABLE////


?>
<script type="text/javascript">
/// FOR JQUERY UI SORTABLE////
	Joomla.orderTable = function()
						{
							table = document.getElementById("sortTable");
							direction = document.getElementById("directionTable");
							order = table.options[table.selectedIndex].value;
							if (order != '<?php echo $listOrder; ?>')
							{
								dirn = 'asc';
							}
							else
							{
								dirn = direction.options[direction.selectedIndex].value;
							}

							Joomla.tableOrdering(order, dirn, '');
						}
/// FOR JQUERY UI SORTABLE////
</script>

<form action="<?php echo JRoute::_('index.php?option=com_pxrdshealthbox'); ?>" method="post" name="adminForm" id="adminForm">

<div id="filter-bar" class="btn-toolbar">
	<div class="filter-search btn-group pull-left">

		<label for="filter_search" class="element-invisible"><?php 
		echo JText::_('Search');?></label>

		<input type="text" name="filter_search" id="filter_search" 
		placeholder="<?php echo JText::_('Search'); ?>" 
		value="<?php echo $this->escape($this->state->get('filter.search')); 
		?>" title="<?php echo JText::_('Search'); ?>" />

	</div>
	<div class="btn-group pull-left">

		<button class="btn hasTooltip" type="submit" title="<?php echo 
		JText::_('Go'); ?>"><i class="icon-search"></i>
		</button>
		
		<button class="btn hasTooltip" type="button" title="<?php echo 
		JText::_('Clear'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();">
			<i class="icon-remove"></i>	
		</button>
		
	</div>

	<div class="btn-group pull-right hidden-phone">
		<label for="limit" class="element-invisible">
		<?php echo JText::_
		('Limit');?>
		</label>
		<?php echo $this->pagination->getLimitBox(); ?>
	</div>

	<div class="btn-group pull-right hidden-phone">

		<label for="directionTable" class="element-invisible"><?php 
		echo JText::_('JFIELD_ORDERING_DESC');?></label>

		<select name="directionTable" id="directionTable" 
		class="input-medium" onchange="Joomla.orderTable()">

			<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?>
			
			</option>

			<option value="asc" <?php if ($listDirn == 'asc') echo 
			'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?>
			</option>

			<option value="desc" <?php if ($listDirn == 'desc') echo 
			'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?>
			</option>

		</select>
	</div>
	<div class="btn-group pull-right">

		<label for="sortTable" class="element-invisible"><?php echo 
		JText::_('JGLOBAL_SORT_BY');?></label>

		<select name="sortTable" id="sortTable" class="input-medium" 
		onchange="Joomla.orderTable()">

			<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?>
			</option>			
			<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
			
		</select>
	</div>
</div>

<div class="clearfix"> </div>
	<div id="j-main-container" class="span12">		
		<div class="clearfix"> </div>
		<table class="table table-striped" id="orgList">
			<thead>
				<tr>
					<th width="1%" class="nowrap center hidden-phone">
						<?php 
							echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 
							'JGRID_HEADING_ORDERING'); 
						?>
					</th>

					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" 
						title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" 
						onclick="Joomla.checkAll(this)" />
					</th>
					
					<th width="1%" style="min-width:55px" class="nowrap center">
						<?php
							 echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder);
						 ?>
					</th>

					<th class="title center" width="20%">
						<?php 

							echo JHtml::_('grid.sort', 'Name', 'a.name', $listDirn, $listOrder); 

						?>
					
					</th>

				
					
					<th width="25%" class="nowrap title center">
						Logo
					</th>

					<th width="5%" class="nowrap title center">
						Home URL
					</th>
					<th width="5%" class="nowrap title center">
						Login URL
					</th>
					<th width="5%" class="nowrap title center">
						Registration URL
					</th>

					<th width="1%" class="nowrap center hidden-phone">
						<?php 
							echo JHtml::_('grid.sort', 'JGRID_HEADING_ID','a.id', $listDirn, $listOrder);  
						
						?>
					</th>

				</tr>
			</thead>

			<tfoot>
				<tr>
					<td colspan="10">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			
			<tbody>
				<?php foreach ($this->items as $i => $item) :
					
				?>
				<tr class="row<?php echo $i % 2; ?>"  sortable-group-id="1">

					<td class="order nowrap center hidden-phone">

						<span class="sortable-handler hasTooltip" title="">
							<i class="icon-menu"></i>
						</span>

						<input type="text" style="display:none" name="order[]" 
						size="5" value="<?php echo $item->ordering;?>" class="width-20 text-area-order " />
				
					</td>

					<td class="center hidden-phone">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>

					<td class="center">
						<?php 
							echo JHtml::_('jgrid.published', $item->state, $i, 'orgs.', true, 'cb', $item->publish_up, $item->publish_down); 
						
						?>
					</td>

					<td class="nowrap has-context center">
						<a href="<?php echo JRoute::_('index.php?option=com_pxrdshealthbox&task=org.edit&id='.(int) $item->id); ?>">		
						
						<?php echo $this->escape($item->name); ?>
						</a>
					</td>				

					<td class="center">
						<?php
						$path = "/components/com_pxrdshealthbox/images/logos/".$item->logo;
						if(trim($path) !== '')
						{ 
						?>
							<img src="<?php echo $path; ?>" alt="" width="150">
						<?php } else {
							echo 'No logos';

						}?>						
					</td>
					
					<td class="nowrap has-context center">
						
						<a align="center" href="<?php echo $item->home_url ?>" target="_blank" title="<?php echo $rec->home_url ?>">
							<span class="icon-out-2"></span>
						</a>
						
					</td>

					<td class="nowrap has-context center">
						
						<a align="center" href="<?php echo $item->login_url ?>" target="_blank" title="<?php echo $rec->home_url ?>">
							<span class="icon-out-2"></span>
						</a>
						
					</td>

					<td class="nowrap has-context center">
						
						<a align="center" href="<?php echo $item->registration_url ?>" target="_blank" title="<?php echo $rec->home_url ?>">
							<span class="icon-out-2"></span>
						</a>
						
					</td>

					<td class="center hidden-phone">
						<?php echo (int) $item->id; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />		
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />		
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>