jQuery(document).ready(function($){

	var form = $('#cbcheckedadminForm');

	var search = $('#patient_search');
	var search_r = $('#search_result');
	var search_kw = $('#search_keyword');

	search.submit(function(){
		
		$.ajax({
			   url: "index.php?option=com_benhan&view=user&task=searchuser",
			   data: {
			      value: search_kw.val()
			   }, 
	      success: function(data) {
	      	search_r.empty();
	        search_r.html(data);
	      }		
		});
		return false;
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