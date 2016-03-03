<?php defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$controller = JRequest::getVar('controller');
$user		= JFactory::getUser();
$doc = JFactory::getDocument();
$doc->setTitle('Registration');
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
<form action="index.php?option=com_jregistration&controller=reg&task=save" method="post" id="cbcheckedadminForm" name="adminForm" enctype="multipart/form-data" class="cb_form" autocomplete="off">
	<h2 class="jreg_header">Registration</h2>

	<p class="jreg_header_desc">
		<h3>Create your professional account today!</h3>
		<h4>DS-Connect®™ and Research</h4>
		<p>
			The purpose of DS-Connect®™ is to collect information to better understand the health issues in the Down syndrome community and to promote research in Down syndrome.
		</p>
		<h4>Professional Registration</h4>
		<h4 style="color: blue;">
			<u>Level 1 Access</u>
		</h4>
		<p>
		(<strong>Note</strong>: Registration for a level 1 access account is required for either level 2 or level 3 access)
		</p>
		<p>
			Professionals, advocacy representatives, researchers and other users with a scientific or research interest in Down syndrome can create an account on the DS-Connect®™ Professional Portal. Once their account is set-up, they will have access to the de-identified data from DS-Connect®™ participants which is similar to a registrant’s view.
		</p>
		<p>
			Contact the DS-Connect®™ registry coordinator at <a href="mailto:DSConnect@nih.gov">DSConnect@nih.gov</a> with questions.
		</p>
		<p>
			<u>
				<strong>Registration Request Form</strong>
			</u>
		</p>
		<p>
			<strong>Please register for an account by completing the fields below.</strong>
		</p>

	</p>
	<blockquote class="rounded">
		<h3 class="legend-title">Contact Information</h3>	
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
			echo '<div class="cb_form_line">
					  <label></label>
					  <div class="cb_field">
					    <p>Note: Enter 00 for countries that do not have zipcodes.</p>
					  </div>
					</div>';			
			echo $this->CBf['cb_country']; 
			echo $this->CBf['cb_phone']; 
			echo $this->CBf['cb_secondphone'];
			echo $this->CBf['cb_website'];
		?>
	</blockquote >

	<blockquote class="rounded">
		<h3 class="legend-title">Institutional/Organizational/Industry Contact Person</h3>	

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
		<h3 class="legend-title">Name of Institution or Organization</h3>	
		<p>This section refers to registrant's superior, administrative contact, institutional business official, or colleague in your organization.</p>
		<p>This is for verification purposes only and we will not be contacting this person unless we would need to verify your affiliation.</p>
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
	<h3 class="legend-title">Access Purpose</h3>	
	<p><strong>Why do you request access to DS-Connect™? (Select all that apply)</strong></p>	
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
			echo '<div class="cb_form_line">
					  <label></label>
					  <div class="cb_field">
					    <p>Please enter a valid password. No spaces, at least 8 characters and contain at least one lowercase letter, one uppercase letter, one number and one special character. For example: Password@1. In an effort to maintain security, your password will be required to be re-set regularly.</p>
					  </div>
					</div>';
			echo $this->CBf['password'];
		?>
	</blockquote>
	
	<div id="toc">
		<p><strong>Terms of Use</strong></p>
		<p>DS-Connect®™ has an interest in promoting scientific investigation and allows access to the de-identified data subject to the limitations outlined in the following agreement. These limitations are:</p>
		<ul>
			<li>Only de-identified data will be provided to requestors.</li>			
			<li>DS-Connect®™ is not responsible for any interpretation of the data in this registry.</li>			
			<li>DS-Connect®™ is not designed as a surveillance tool for comprehensive epidemiological analyses.</li>			
			<li>The data may not be representative of the Down syndrome population in the United States or worldwide.</li>			

		</ul>
		<?php
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
	<input type="submit" value="Submit" id="jreg_submit_bt" class="button btn btn-primary">
	<input type="hidden" name="task" value="save"/>
    <input type="hidden" name="option" value="<?php echo $option;?>"/>    
    <input type="hidden" name="controller" value="<?php echo $controller;?>" />
    <?php echo JHTML::_( 'form.token' ); ?>

</form>

