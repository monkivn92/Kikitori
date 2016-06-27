<?php

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$records = $this->data->records;
$search = $this->data->search;
$pageNav = $this->data->pagenav;
$search = $this->data->search;

?>

<form action="" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>	

	<table>
		  	<tr>
			    <td align="left" width="100%">
			    Search: 
			    <input type="text" name="search" id="search" 
		             value="<?php echo $search;?>" 
		             class="text_area"  
		             onchange="document.adminForm.submit();" 
		             style="margin:0px"/>

			    <button onclick="this.form.submit();" class="btn btn-primary">
				      
			   		<span class="icon-search"></span> Go 
		   		</button>
		   		
			    <button 
					onclick="document.getElementById('search').value='';
					this.form.submit();" class="btn btn-primary">
		     		Reset
		   		</button>
		   		&nbsp;
		   		&nbsp;
		   		<select name="limit" id="limit" onchange="document.adminForm.submit();" class="input-mini" >
		   			<?php
		   				$config = JFactory::getConfig();		   				
		   				$numchecked = JRequest::getInt('limit');
		   				if(!$numchecked)
		   				{
		   					$numchecked = $config->get('list_limit');
		   				}
		   				for($i=1; $i<10; $i++)
		   				{	
		   					$val = 5*$i;
		   					if($val == $numchecked )
		   					{
		   						echo "<option value='$val' selected>$val</option>";
		   					}
		   					else
		   					{
		   						echo "<option value='$val'>$val</option>";
		   					}
		   				}
		   			?>
		   			<option value='0'>All</option>
		   		</select>
				
		    </td>
	    </tr>
    </table>  
&nbsp;
		   		&nbsp;
	<table class="table table-striped" id="adminlist">		
		<thead>
			<tr>

				<th width="1%" class="center">
							<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				</th>			
				<th >Organization</th>
				<th >Homepage URL</th>
				<th >Login URL</th>
				<th >Registration URL</th>
				<th >Keywords</th>
				<th >Description</th>
				<th >Address</th>
				<th >Logo</th>	
				<th >Published</th>								
				<th >
					<?php echo JHTML::_('grid.sort', 'Ordering', 'ordering',@$this->data->order_dir,@$this->data->order); ?>
					<a href="" onclick="custom_saveorder(); return false;" ><img src="/components/com_pxrdshealthbox/images/save.png" alt=""></a>
				</th>				
				
			
			</tr>
		</thead>

		<tfoot>
			<tr>
				<td colspan="10" align="center">
					<?php 					
					echo $pageNav->getListFooter(); 
					?>
				</td>
			</tr>
		</tfoot>

		<tbody >
			<?php
				jimport('joomla.filter.output');
				$n=count( $records );
				for ($i=0 ; $i < $n; $i++) 
				{
					$rec = $records[$i];
					$checked = JHTML::_('grid.id', $i, $rec->id );
					$published = JHTML::_('grid.published', $rec, $i );
					$link = JFilterOutput::ampReplace( 'index.php?option=com_pxrdshealthbox&view=show&task=edit&cid[]='. $rec->id );
				?>
				<tr >
					<td align="center">
						<?php echo $checked; ?>
					</td>
					<td align="center"  width="10%">
						<?php 

							echo "<a href='$link'>$rec->name</a>"; 

						?>
					</td>

					<td align="center" width="2%">
						
						<a align="center" href="<?php echo $rec->home_url ?>" target="_blank" title="<?php echo $rec->home_url ?>">
							<span class="icon-out-2"></span>
						</a>
						
					</td>
					<td align="center" width="2%">
						<a align="center" href="<?php echo $rec->login_url ?>" target="_blank" title="<?php echo $rec->login_url ?>">
							<span class="icon-out-2"></span>
						</a>
						
					</td>
					<td align="center" width="2%">

						<a align="center" href="<?php echo $rec->registration_url ?>" target="_blank" title="<?php echo $rec->registration_url ?>">
							<span class="icon-out-2"></span>
						</a>
						
					</td>
					<td align="center" width="20%">
						<?php echo $rec->keywords ?>
					</td>
					<td align="center" width="20%">
						<?php echo $rec->description ?>
					</td>
					<td align="center" width="10%">
						<?php echo $rec->address ?>
					</td>
					<td align="center">
						<?php 
							if($rec->logo !== '')
							{
								$logo = '/components/com_pxrdshealthbox/images/logos/'.$rec->logo;
							}
							else
							{
								$logo = 'No logo';
							}
						?>
						<img src="<?php echo $logo ?>" width="150px" alt="">
					</td>
					<td align="center" width="2%">
						<?php echo $published ?>
					</td>
					<td align="center" >
						
						<input style="width:30px !important" type="text" name="order[]" value="<?php echo $rec->ordering ?>">						
						<br/>
						<span>
							<a href="<?php echo '#cb'.$i ?>" 
								onclick="move1step(this, 'orderup');return false;" 
								title="Move Up"><img src="/components/com_pxrdshealthbox/images/uparrow.png" alt=""></a>								
						</span>
						&nbsp;
						<span>
							<a href="<?php echo '#cb'.$i ?>" 
								onclick="move1step(this, 'orderdown');return false;" 
								title="Move Down">
								<img src="/components/com_pxrdshealthbox/images/downarrow.png" alt="">
							</a>
						</span>
						
					</td>

				</tr>

			<?php } ?>
			
		</tbody>
	</table>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="option" value="com_pxrdshealthbox" />
		<input type="hidden" name="view" value="show" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->data->order_dir;?>" />
	    <input type="hidden" name="filter_order" value="<?php echo $this->data->order;?>" />	   
	    <input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<script>
	function move1step(obj,task)
	{
		
		var target = jQuery(obj).attr('href');
		jQuery(target).prop('checked',true);
		jQuery('input[name="task"]').val(task);
		jQuery('#adminForm').submit();
	}
	function custom_saveorder()
	{
		jQuery('input[type="checkbox"]').prop('checked',true);
		jQuery('input[name="task"]').val('saveorder');
		jQuery('#adminForm').submit();
	}
</script>