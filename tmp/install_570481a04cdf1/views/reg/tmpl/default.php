<?php defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$controller = JRequest::getVar('controller');
$user		= JFactory::getUser();
$doc = JFactory::getDocument();


$doc->addStyleSheet('/components/com_comprofiler/plugin/templates/default/template.css');
$doc->addStyleSheet('/components/com_jregistration/asset/jregistration.css');
$doc->addScript('/components/com_jregistration/asset/jregistration.js');

$session = JFactory::getSession();
$jreg_user_info = $session->get( 'jreg_user_info');

?>

<script type="text/javascript" src="/components/com_comprofiler/js/overlib_all_mini.js">
</script>
	<script type="text/javascript"><!--
overlib_pagedefaults(WIDTH,250,VAUTO,RIGHT,AUTOSTATUSCAP, CSSCLASS,TEXTFONTCLASS,'cb-tips-font',FGCLASS,'cb-tips-fg',BGCLASS,'cb-tips-bg',CAPTIONFONTCLASS,'cb-tips-capfont', CLOSEFONTCLASS, 'cb-tips-closefont');
--></script>

<h4 class="jreg_error_status" style="color:red;"><?php echo $this->error_message; ?></h4>
<form action='<?php echo JRoute::_("index.php?option=com_jregistration&view=reg&task=save")?>' method="post" id="cbcheckedadminForm" name="adminForm" enctype="multipart/form-data" class="cb_form" autocomplete="off">
	<h2 class="jreg_header"><?php echo JText::_(COM_JREG_TITLE);?></h2>

	<p class="jreg_header_desc">
		<?php
			echo JText::_(COM_JREG_HEADER_TOP);
		?>

	</p>
	<blockquote class="rounded">
		<h3 class="legend-title"><?php echo JText::_(COM_JREG_CONTACT_INFO);?></h3>	
		<hr>
		<?php
			
			echo $this->CBf['cb_registrantfirstname']; 
			echo $this->CBf['cb_registrantlastname']; 
			echo $this->CBf['cb_degrees']; 
			echo $this->CBf['cb_degreesother'];
			echo $this->CBf['email']; 
			echo $this->CBf['confirmemail']; 
			echo $this->CBf['cb_address']; 
			echo $this->CBf['cb_addresstwo']; 
			echo $this->CBf['cb_addressthree']; 
			echo $this->CBf['cb_city'];
			echo $this->CBf['cb_state']; 
			echo $this->CBf['cb_province']; 
			echo $this->CBf['cb_postalcode']; 
			echo JText::_(COM_JREG_ZIPCODE_NOTE);			
			echo $this->CBf['cb_country']; 
			echo $this->CBf['cb_phone']; 
			echo $this->CBf['cb_secondphone'];
			echo $this->CBf['cb_website'];
		?>
	</blockquote >

	<blockquote class="rounded">
		
		<h3 class="legend-title"><?php echo JText::_(COM_JREG_NAME_OF_ORG);?></h3>	
		<hr>
		<?php 
			echo $this->CBf['cb_orgname'];
			echo $this->CBf['cb_orgtype'] ;
			echo $this->CBf['cb_orgtypeother'];
			echo $this->CBf['cb_orgdepartment'];
			echo $this->CBf['cb_orgaffiliation'] ;
			echo $this->CBf['cb_orgspecialty'];
			echo $this->CBf['cb_orgspecialtyother'];
			echo $this->CBf['cb_orgsecondaryspecialty'];
			echo $this->CBf['cb_orgsecondaryspecialtyother'];
			echo $this->CBf['cb_altemail2'];
		?>
	</blockquote>

	<blockquote class="rounded">
		<h3 class="legend-title"><?php echo JText::_(COM_JREG_ORG_CONTACT_PERSON);?></h3>	
		<?php echo JText::_(COM_JREG_ORG_CONTACT_PERSON_NOTE);?>
		<hr>
		<?php 
			echo $this->CBf['cb_orgcontactname'];
			echo $this->CBf['cb_orgcontacttitle'];
			echo $this->CBf['cb_orgcontactemail'];
			echo $this->CBf['cb_orgcontactphone'];
			echo $this->CBf['cb_orgcontacturl'];
			
		?>
	</blockquote>

	<blockquote class="rounded">
	<h3 class="legend-title"><?php echo JText::_(COM_JREG_ACCESS_PURPOSE);?></h3>	
	<?php echo JText::_(COM_JREG_ACCESS_PURPOSE_NOTE);?>
	<hr>	
	<?php 
		echo $this->CBf['cb_accesspurposelist'];
		echo $this->CBf['cb_accesspurpose'];
	?>
	</blockquote>
	
	<blockquote class="rounded">
		<h3 class="legend-title">Choose your DS-Connect Username and Password</h3>			
		<hr>	
		<?php 
			echo $this->CBf['username']; 
			echo JText::_(COM_JREG_PASSWORD_NOTE);
			echo $this->CBf['password'];
		?>
	</blockquote>
	
	<div id="toc">
		
		<?php
			echo JText::_(COM_JREG_TERM_OF_USE_NOTE);
			echo '<br>';
			echo $this->CBf['cb_agreeterms'];
			echo '<br>';
			echo $this->CBf['cb_agreedatapolicy'];
			echo '<br>';
			echo '<p>Please enter the code below</p>';
		?>
	</div>
	<div id="captcha">	
		<?php
			echo $this->captcha_html[0];
		?>
	</div>
	<input type="submit" value="<?php echo JText::_(COM_JREG_BTN_REG);?>" id="jreg_submit_bt" class="button btn btn-primary">
	<input type="hidden" name="task" value="save"/>
    <input type="hidden" name="option" value="<?php echo $option;?>"/>    
    <input type="hidden" name="controller" value="<?php echo $controller;?>" />
    <?php echo JHTML::_( 'form.token' ); ?>

</form>


<script>

cbjQuery( document ).ready( function( $ ) {
var host = location.protocol+'//'+location.hostname; 
var jQuery = $;
jQuery.validator.addMethod("cbusername", function(value, element) {	return this.optional(element) || ! /[\<|\>|\"|\'|\%|\;|\(|\)|\&]/i.test(value);}, "Please enter a valid Username:.  No spaces, more than 2 characters and contain 0-9,a-z,A-Z"); 
$.extend(jQuery.validator.messages, {
		required: "This field is required.",
		remote: "Please fix this field.",
		email: "Please enter a valid email address.",
		url: "Please enter a valid URL.",
		date: "Please enter a valid date.",
		dateISO: "Please enter a valid date (ISO).",
		number: "Please enter a valid number.",
		digits: "Please enter only digits.",
		creditcard: "Please enter a valid credit card number.",
		equalTo: "Please enter the same value again.",
		accept: "Please enter a value with a valid extension.",
		maxlength: $.validator.format("Please enter no more than {0} characters."),
		minlength: $.validator.format("Please enter at least {0} characters."),
		rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
		range: $.validator.format("Please enter a value between {0} and {1}."),
		max: $.validator.format("Please enter a value less than or equal to {0}."),
		min: $.validator.format("Please enter a value greater than or equal to {0}.")
});

{
	var firstInvalidFieldFound	=	0;
	$('#cbcheckedadminForm').submit( function() {
		var v = $(this).validate();
		v.cbIsFormSubmitting = true;
		var r = $(this).validate().form();
		v.cbIsFormSubmitting = false;
		if ( ! r ) {
			$(this).validate().focusInvalid();
			return r;
		}
		else{
				//return confirm('You are accessing DS-Connect: The Down Syndrome Registry which may contain sensitive information that must be protected under the U.S. Privacy Act.\nUnauthorized or malicious attempts to upload information, change information, or misuse this web site may result in disciplinary action, civil, and/or criminal penalties.\nUnauthorized users of this web site should have no expectation of privacy regarding any communications or data processed by this web site.\nNIH may report criminal activity to law enforcement officials.')		
			}
		
	});
	$('#cbcheckedadminForm').validate( {
		onsubmit : false,
		ignoreTitle : true,
		errorClass: 'cb_result_warning',
		// debug: true,
		cbIsOnKeyUp: false,
		cbIsFormSubmitting: false,
		highlight: function( element, errorClass ) {
			$( element ).parents('.fieldCell').parent().addClass( 'cbValidationError' );		// tables
			$( element ).parents('.cb_field,.cb_form_line').addClass( 'cbValidationError' );	// divs
			$( element ).addClass( 'cbValidationError' + $(element).attr('type') );
			$( element ).parents('.tab-page').addClass('cbValidationErrorTab')
			.each( function() {
				$(this).siblings('.tab-row')
				.find('h2:nth-child(' + $(this).index() + ')')
				.addClass('cbValidationErrorTabTip');
			})
			.filter(':not(:visible)').each( function() {
				if ( ! firstInvalidFieldFound++ ) {
					showCBTab( $(this).attr('id').substr(5) );
				}
			});;
		},
		unhighlight: function( element, errorClass ) {
			if ( this.errorList.length == 0 ) {
				firstInvalidFieldFound = 0;
			}
			$( element ).parents('.fieldCell').parent().removeClass( 'cbValidationError' );		// tables
			$( element ).parents('.cb_field,.cb_form_line').removeClass( 'cbValidationError' );	// divs
			$( element ).removeClass( 'cbValidationError' + $(element).attr('type') );
			$( element ).parents('.tab-page')
			.each( function() {
				if ( $(this).find('.cbValidationError').size() == 0 ) {
					$(this).removeClass('cbValidationErrorTab')
					.siblings('.tab-row')
					.find('h2:nth-child(' + $(this).index() + ')')
					.removeClass('cbValidationErrorTabTip');
				}
			});
		},
		errorElement: 'div',
		errorPlacement: function(error, element) {
			element.closest('.fieldCell, .cb_field').append( error[0] );		// .fieldCell : tables, .cb_field : div
		},
		onkeyup: function(element) {
			if ( element.name in this.submitted || element == this.lastElement ) {
				// avoid remotejhtml rule onkeyup
				this.cbIsOnKeyUp = true;
				this.element(element);
				this.cbIsOnKeyUp = false;
			}
        }
	} );
	$('#cbcheckedadminForm input:checkbox,#cbcheckedadminForm input:radio').click( function() {
		$('#cbcheckedadminForm').validate().element( $(this) );
	} );
	$( '#cbcheckedadminForm .cbDateinputJs select' ).change( function() {
		var datefield	=	$(this).parent().prev('input');
		if ( datefield.length ) {
			$('#cbcheckedadminForm').validate().element( datefield );
		}
	} );
}
jQuery.validator.addMethod("remotejhtml", function(value, element, param) {
			if ( this.optional(element) )
				return "dependency-mismatch";

			var previous = this.previousValue(element);

			if (!this.settings.messages[element.name] )
				this.settings.messages[element.name] = {};
			this.settings.messages[element.name].remote = typeof previous.message == "function" ? previous.message(value) : previous.message;

			param = typeof param == "string" && {url:param} || param;

			var respField = $('#'+$(element).attr('id')+'__Response');
			if ( respField.html() != '&nbsp;' ) {
				if ( previous.old !== value ) {
					respField.fadeOut('medium' );
				} else {
					respField.fadeIn('medium' );
				}
			}

			if ( previous.old !== value && ! this.cbIsOnKeyUp && ! this.cbIsFormSubmitting ) {

				var inputid = $(element).attr('id');
				if ( ! $('#'+inputid+'__Response').size() ) {
					var respField = '<div class=\"cb_result_container\"><div id=\"' + inputid + '__Response\">&nbsp;</div></div>';
					$(element).parent().each( function() {
						if (this.tagName.toLowerCase() == 'td') {
							$(this).append(respField);
						} else {
							$(this).after(respField);
						}
						$(inputid+'__Response').hide();
					} );
				}

				previous.old = value;
				var validator = this;
				// this.startRequest(element);
				var data = {};
				data[element.name] = value;
				$.ajax($.extend(true, {
					type: 'POST',
					url:  '/index.php?option=com_jregistration&view=reg&task=checkUsername',
					mode: "abort",
					port: "validate" + element.name,
					dataType: "html",	/* """json", */
					data: 'value=' + encodeURIComponent(value),
					/* data: data, */
					success: function(response) {
						// never errors on that one: */
						var submitted = validator.formSubmitted;
						validator.prepareElement(element);
						validator.formSubmitted = submitted;
						validator.successList.push(element);
						validator.showErrors();

						previous.valid = response;
						// validator.stopRequest(element, response);

						var respField = $('#'+$(element).attr('id')+'__Response');
						respField.fadeOut('fast', function() {
							respField.html(response).fadeIn('fast');
						} );
					},
					error: function(jqXHR, textStatus) {
						// validator.stopRequest(element, textStatus);
						var respField = $('#'+$(element).attr('id')+'__Response');
						respField.fadeOut('fast', function() {
							respField.html(textStatus).fadeIn('fast');
						} );
					}
				}, param));
				$('#'+inputid+'__Response').html('<img alt=\"\" src=\"'+host+'/components/com_comprofiler/images/wait.gif\" /> Checking...').fadeIn('fast');
				return true;		// "pending";
			} else if( this.pending[element.name] ) {
				return "pending";
			}
			return true; // previous.valid;
}, 'Ajax Reply Error');

//$("#cbcheckedadminForm input[type!='hidden']:first").filter("[type='text'],textarea,[type='password']").focus();
});
if ( typeof window.cbjqldr_tmpsave$ != 'undefined' ) {
	window.$ = window.cbjqldr_tmpsave$;
}
if ( typeof window.cbjqldr_tmpsavejquery != 'undefined' ) {
	window.jQuery = window.cbjqldr_tmpsavejquery;
}

</script>
