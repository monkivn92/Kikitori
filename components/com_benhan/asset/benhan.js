jQuery(document).ready(function($){

	var form = $('#cbcheckedadminForm');

	var search = $('#patient_search');
	var search_r = $('#search_result');
	var search_name = $('#search_name');
	var search_mrid = $('#search_mrid');
	var name_val = search_name.val() ? search_name.val() : '';
	var mrid_val = search_mrid.val() ? search_mrid.val() : '';

	search.submit(function(e){

		$('#loading').show();
		$.ajax({
			   url: "index.php?option=com_benhan&view=user&task=searchuser",
			   data: 
			   {
			      	name:search_name.val(),
			      	mrid:search_mrid.val()
			   }, 
	      success: function(data) {
	      	$('#loading').hide();
	      	search_r.empty();
	        search_r.html(data);
	        
	      }		
		});
		e.preventDefault();
	});

	$("#upload_avatar").on("click", function() {

	    var file_data = $("#avatar_input").prop("files")[0];   
	    var form_data = new FormData();                  
	    form_data.append('file', file_data);
	                               
	    $.ajax({
	                url: 'index.php?option=com_benhan&view=user&task=saveavatar', // point to server-side PHP script 
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


});