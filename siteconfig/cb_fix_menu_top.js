jQuery(document).ready(function(){
	// remove "text"

		var bell = jQuery('.menu_bell').html();
		jQuery('.menu_bell').html(bell.slice(0,-5));
		 var profile = jQuery('.menu_updateprofile').html();
		jQuery('.menu_updateprofile').html(profile.slice(0,-13));
		
		//jQuery('.menu_bell').append('<i class="fa fa-bell-o fa-sm"></i>');
		//jQuery('.menu_updateprofile').append('<i class="fa fa-cog fa-sm"></i>');
		jQuery('.menu_bell').append('<img src="/images/img-demo/bell-icon.png" width="18" height="18" />');
		jQuery('.menu_updateprofile').append('<img src="/images/img-demo/settings-icon.png" width="18" height="18" />');

});
