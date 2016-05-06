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


<div class="row">
	<div class="span6">
		<h2>Search Patient</h2>
		<form action="" id="patient_search">
			<p>
				<label for="search_name">Patien Name:</label>
				<input type="text" id="search_name"/>
			</p>
			<p>
				<label for="search_mrid">Patien's Medical Report ID:</label>
				<input type="text" id="search_mrid"/>
			</p>
			<p>
				<label for="search_ktphth">Kỹ thuật phẫu thuật:</label>
				<select name="cb_iv_ppdtr_kt_phau_thuat" id="search_ktphth" class="form-control">
					<option value=""></option>
					<option value="1" id="cbf228">1 bó Isometric</option>
					<option value="2" id="cbf229">1 bó tăng cường</option>
					<option value="3" id="cbf230">2 bó</option>
				</select>
			</p>

			<input type="submit" value="Search" class="btn btn-primary" />
			
		</form>

		<div id="loading" style="display:none">
		<img src="/components/com_benhan/img/hourglass.svg" alt="">
		Loading...
		</div>
		<div id="search_result">
			
		</div>
	</div>
	<div class="span6">
		<div id="recent-add">
			<h4>Recently Added Patients</h4>
			<?php
				echo $this->UserRecentlyAdd;
			?>
		</div>
	</div>
</div>



<script>
jQuery(document).ready(function($){

	var form = $('#cbcheckedadminForm');

	var search = $('#patient_search');
	var search_r = $('#search_result');
	var search_name = $('#search_name');
	var search_mrid = $('#search_mrid');
	var search_ktphth = $('#search_ktphth option:selected');
	var name_val = search_name.val() ? search_name.val() : '';
	var mrid_val = search_mrid.val() ? search_mrid.val() : '';
	var ktphth_val = search_ktphth.val() ? search_ktphth.val() : '';


	search.submit(function(e){

		$('#loading').show();
		$.ajax({
			   url: "index.php?option=com_benhan&view=user&task=searchuser",
			   data: 
			   {
			      	name:search_name.val(),
			      	mrid:search_mrid.val(),
			      	ktphth:$('#search_ktphth option:selected').val()
			   }, 
	      success: function(data) {
	      	$('#loading').hide();
	      	search_r.empty();
	        search_r.html(data);
	        
	      }		
		});
		e.preventDefault();
	});

});
</script>