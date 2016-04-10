jQuery(document).ready(function(){
	var username = jQuery('input[name="username"]');
	var email = jQuery('input[name="email"]');
	var form = jQuery('#cbcheckedadminForm');

	var search = jQuery('#patient_search');
	var search_r = jQuery('#search_result');
	var search_kw = jQuery('#search_keyword');

	var warning = jQuery('.cb_result_warning');
	var error = jQuery('.cb_result_error');
	username.blur(function(){
		username.next('.cb_result_error').remove();
		jQuery.ajax({
			   url: "/component/benhan/?view=user&task=checkusername",
			   data: {
			      value: username.val()
			   }, 
	      success: function(data) {
	        username.after(data);
	      }		
		});
	});

	email.blur(function(){
		email.next('.cb_result_error').remove();
		jQuery.ajax({
			   url: "/component/benhan/?view=user&task=checkemail",
			   data: {
			      value: email.val()
			   }, 
	      success: function(data) {
	        email.after(data);
	      }		
		});
	});

	form.submit(function(){
		var warning = jQuery('.cb_result_warning');
		var error = jQuery('.cb_result_error');
		if(warning.length || error.length)
		{
			form.after('<span class="cb_result_error">Some fields need to refill.</span>');
			return false;			
		}
		else
		{
			return true;
		}
	});

	search.submit(function(){
		
		jQuery.ajax({
			   url: "/component/benhan/?view=user&task=searchuser",
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


});