jQuery(document).ready(function(){
	
	var moduleHighlight = '<blockquote class="rounded no-avatar"/>';
	if(jQuery('.cbEditProfile').length){
        // account   #cbfr_51__verify, #cbfr_51,
        jQuery('#cbfr_84,#cbfr_1085,#cbfr_62, #cbfr_59, #cbfr_60, #cbfr_61, #cbfr_50, #cbfr_58,#cbfr_1081, #cbfr_42, #cbfr_91, #cbfr_1035').wrapAll(moduleHighlight);
    }
	// participant    Affected Person
	jQuery(' #cbfr_79,#cbfr_86, #cbfr_46, #cbfr_1031,#cbfr_1002, #cbfr_47, #cbfr_48, #cbfr_68, #cbfr_1069, #cbfr_68, #cbfr_69, #cbfr_70, #cbfr_1070, #cbfr_1071, #cbfr_71, #cbfr_72, #cbfr_89, #cbfr_93, #cbfr_1068,#cbfr_73, #cbfr_74, #cbfr_75, #cbfr_76, #cbfr_77, #cbfr_78, #cbfr_1003, #cbfr_1007').wrapAll(moduleHighlight);

    if(jQuery('.cbRegistration').length){
        // step 2
        jQuery('#cbfr_65').wrapAll(moduleHighlight);
        // account
        jQuery('#cbfr_84,#cbfr_1085,#cbfr_62, #cbfr_59, #cbfr_60, #cbfr_61, #cbfr_50, #cbfr_58,#cbfr_51__verify, #cbfr_51, #cbfr_42, #cbfr_91, #cbfr_1035').wrapAll(moduleHighlight);

    }
	
	// consent
	jQuery('#cbfr_1079, #cbfr_1017, #cbfr_1018, #cbfr_83, #cbfr_1074, #cbfr_1075, #cbfr_1076,#cbfr_1077, #cbfr_1047').wrapAll(moduleHighlight);

    // Contact & Sharing Preferences
	jQuery('#cbfr_1078, #cbfr_81, #cbfr_80, #cbfr_1048, #cbfr_1019, #cbfr_1045, #cbfr_1046').wrapAll(moduleHighlight);

    //show tab
    jQuery('.tab-page').addClass('show-page');

    //********** Remove ':' at the end of sentence **********\ 
    
    function removeColon(field)
    {
        if(jQuery(field).length)
        {
            var label = jQuery(field).html();        
            jQuery(field).html(label.slice(0,-1));
        }
        
    }

    removeColon('#cblabcb_consent1');
    removeColon('#cblabcb_consent2');
    removeColon('#cblabcb_consent8');
    removeColon('#cblabcb_consent4');
    removeColon('#cblabcb_consent7');
    removeColon('#cblabcb_consent6');
    removeColon('#cblabcb_consent5');
    removeColon('#cblabcb_consent9');
    
    //********** Move red asterisk right after the colon **********\
    var asterisk = jQuery('#cbfr_1068 span.cbFieldIcons').html();
    jQuery('#cbfr_1068 span.cbFieldIcons').empty();
    jQuery('#cbfr_1068>label').append(asterisk);   
});
