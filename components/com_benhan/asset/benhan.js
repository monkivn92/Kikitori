jQuery(document).ready(function($){
		SqueezeBox.initialize({
			size: {x:300, y:300}
		});
		SqueezeBox.assign($$('.wrap_field img.addnote'));
		SqueezeBox.open('google.com',{handler:'iframe'});			
});
