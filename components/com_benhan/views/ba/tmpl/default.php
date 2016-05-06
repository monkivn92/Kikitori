<?php defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$controller = JRequest::getVar('controller');
$userid	= JRequest::getInt('userid');
$doc = JFactory::getDocument();

$doc->addStyleSheet('/components/com_comprofiler/plugin/templates/default/template.css');
$doc->addStyleSheet('/components/com_benhan/asset/benhan.css');
$doc->addScript('/components/com_benhan/asset/jquery.min.js');
$doc->addScript('/components/com_benhan/asset/benhan.js');
JHTML::_( 'behavior.modal','a.addnote');


?>


<script type="text/javascript" src="/components/com_comprofiler/js/overlib_all_mini.js">
</script>
	<script type="text/javascript"><!--
overlib_pagedefaults(WIDTH,250,VAUTO,RIGHT,AUTOSTATUSCAP, CSSCLASS,TEXTFONTCLASS,'cb-tips-font',FGCLASS,'cb-tips-fg',BGCLASS,'cb-tips-bg',CAPTIONFONTCLASS,'cb-tips-capfont', CLOSEFONTCLASS, 'cb-tips-closefont');
--></script>

<h4 class="jreg_error_status" style="color:red;"><?php echo $this->error_message; ?></h4>
<form action='<?php echo JRoute::_("index.php?option=com_benhan&view=ba&userid=$userid")?>' method="post" id="cbcheckedadminForm" name="adminForm" enctype="multipart/form-data" class="cb_form" autocomplete="off">
	<h1 class="jreg_header" style="color:#1ba1e2"><?php echo $this->userInfo->_cbuser->name;?></h1>

	<blockquote class="rounded">
		
		<h3 class="legend-title"><?php echo $this->pageInfo->title;?></h3>	
		<hr>
		<?php 
			foreach ($this->CBf as $field) 
			{
				echo '<p>';
				echo $field;
				echo '</p>';
			}
		?>
	</blockquote>

	<?php 
		if($this->cur_page !== 1 && $this->cur_page <= $this->total)
		{
			echo '<input type="submit" value="Back" name="ba_back" class="button btn btn-primary">&nbsp;';
		}
		if($this->cur_page < $this->total)
		{
			echo '<input type="submit" value="Next" name="ba_next" class="button btn btn-primary">&nbsp;';
		}
	?>
	
	
	
	
	<input type="submit" value="Save" name="ba_save" class="button btn btn-warning">
	
    <input type="hidden" name="option" value="<?php echo $option;?>"/>    
    <input type="hidden" name="controller" value="<?php echo $controller;?>" />
    <input type="hidden" name="cur_page" value="<?php echo $this->cur_page ?>" />
    <input type="hidden" name="userid" value="<?php echo $userid ?>" />

    <?php echo JHTML::_( 'form.token' ); ?>

</form>

<div id="status_box">
	<p style="color:#1ba1e2"><?php echo $this->userInfo->_cbuser->name;?></p>
	<p style="color:#CF000F"><?php echo $this->pageInfo->title;?></p>
</div>


<script>
	jQuery(document).ready(function($){

		if( $('#cbfr_201').length )
		{

			kyThuatPhauThuat($('#cbfr_201 option:selected').val());
			
			$('#cbfr_201').change(function(){
				kyThuatPhauThuat($('#cbfr_201 option:selected').val());				
			});

		} 

		function kyThuatPhauThuat(val)
		{
			if(val == '')
			{
				$('#cbfr_122,#cbfr_123,#cbfr_124,#cbfr_125,#cbfr_126,#cbfr_127,#cbfr_128,#cbfr_129,#cbfr_130,#cbfr_131,#cbfr_132,#cbfr_133,#cbfr_202,#cbfr_203,#cbfr_204,#cbfr_205,#cbfr_206,#cbfr_207,#cbfr_208,#cbfr_209').parent().hide();
			}

			if( val == 3 )
			{
				$('#cbfr_122,#cbfr_123,#cbfr_124,#cbfr_125,#cbfr_126,#cbfr_127,#cbfr_128,#cbfr_129,#cbfr_130,#cbfr_131,#cbfr_132,#cbfr_133').parent().show();
				$('#cbfr_202,#cbfr_203,#cbfr_204,#cbfr_205,#cbfr_206,#cbfr_207,#cbfr_208,#cbfr_209').parent().hide();
			}

			if( val == 1 ||   val == 2 )
			{
				$('#cbfr_122,#cbfr_123,#cbfr_124,#cbfr_125,#cbfr_126,#cbfr_127,#cbfr_128,#cbfr_129,#cbfr_130,#cbfr_131,#cbfr_132,#cbfr_133').parent().hide();
				$('#cbfr_202,#cbfr_203,#cbfr_204,#cbfr_205,#cbfr_206,#cbfr_207,#cbfr_208,#cbfr_209').parent().show();
			}
		}


	});
</script>
