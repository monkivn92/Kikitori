jQuery(document).ready(function() {

 	jQuery('#jreg_submit_btn').click(function() {
 		var warning = jQuery('input.required');
 		alert('asFS');
 		for(var i=0; i<warning.length; i++)
		{

			var w = warning.eq(i);
			console.log(w.val());
			/*
			if(!w.val())
			{
				jQuery('html, body').animate({
		        scrollTop: w.offset().top-50}, 300);
		        return false;	
			}
			*/				
		}

 	});


});