<?php defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$controller = JRequest::getVar('controller');
$user		= JFactory::getUser();
$uid = JRequest::getInt('uid');

$doc = JFactory::getDocument();

$doc->addStyleSheet('/components/com_comprofiler/plugin/templates/default/template.css');
$doc->addStyleSheet('/components/com_jregistration/asset/jregistration.css');
//$doc->addScript('/components/com_jregistration/asset/jregistration.js');
$session = JFactory::getSession();
$jreg_user_info = $session->get( 'jreg_user_info');

echo JConnect_Profilename($user->id);
?>

<script type="text/javascript" src="/components/com_comprofiler/js/overlib_all_mini.js">
</script>
	<script type="text/javascript"><!--
overlib_pagedefaults(WIDTH,250,VAUTO,RIGHT,AUTOSTATUSCAP, CSSCLASS,TEXTFONTCLASS,'cb-tips-font',FGCLASS,'cb-tips-fg',BGCLASS,'cb-tips-bg',CAPTIONFONTCLASS,'cb-tips-capfont', CLOSEFONTCLASS, 'cb-tips-closefont');
--></script>

<h4 class="jreg_error_status" style="color:red;"><?php echo $this->error_message; ?></h4>
<form action='<?php echo JRoute::_("index.php?option=com_jregistration&view=edit&task=update")?>' method="post" id="cbcheckedadminForm" name="adminForm" enctype="multipart/form-data" class="cb_form" autocomplete="off">
	
	<blockquote class="rounded">
		<h3 class="legend-title"><?php echo JText::_(COM_JREG_CONTACT_INFO);?></h3>		
		<hr>
		<?php
			
			echo $this->CBf['firstname']; 
			echo $this->CBf['lastname']; 
			echo $this->CBf['cb_degrees']; 
			echo $this->CBf['cb_degreesother'];
			echo $this->CBf['email']; 
			echo $this->CBf['cb_altemail2'];//////////////// 
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
		<h3 class="legend-title"><?php echo JText::_(COM_JREG_PRO5_UPDATE_PASSWORD);?></h3>			
		<hr>	
		<?php 
			echo $this->CBf['username']; 
			echo JText::_(COM_JREG_PASSWORD_NOTE);
			echo $this->CBf['password'];
		?>
	</blockquote>
	
	<input type="submit" value="<?php echo JText::_(COM_JREG_BTN_UPDATE);?>"  name="jreg_submit_bt" class="button btn btn-primary">
	<input type="submit" value="<?php echo JText::_(COM_JREG_BTN_CANCEL);?>"  name="jreg_cancel_bt" class="button btn btn-warning">
	<input type="hidden" name="task" value="update"/>
    <input type="hidden" name="option" value="<?php echo $option;?>"/>    
    <input type="hidden" name="controller" value="<?php echo $controller;?>" />
    <input type="hidden" name="uid" value="<?php echo $uid;?>" />
    <?php echo JHTML::_( 'form.token' ); ?>

</form>
<form action=""></form>
<style>
	#cbfr_51 .cbFieldIcons img:first-child,
	#cbfr_51__verify .cbFieldIcons img:first-child{
	display: none;
	}
</style>


