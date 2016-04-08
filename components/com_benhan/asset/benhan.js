jQuery(document).ready(function(){

	function removeColon(field)
    {
        if(jQuery(field))
        {
        var label = jQuery(field).html();
        
            jQuery(field).html(label.slice(0,-1));
        }
        
    }
   	removeColon('#cblabcb_agreeterms');
    removeColon('#cblabcb_agreedatapolicy');

});