<?php
defined('_JEXEC') or die('Restricted access');
$option = JRequest::getVar('option');

?>
<form method="post" name="adminForm" id="item-form" enctype="multipart/form-data">
    <table class="admintable" width="100%">
        <tr>
            <td class="title"><label for="title"><?php echo JText::_('Title')?></label></td>
            <td><input size="30" id="title" type="text" class="inputbox" name="title" value="<?php echo $this->record->title; ?>" /></td>
        </tr>
        <tr>
            <td ><label for="ordering"><?php echo JText::_('Field ID')?></label></td>
            <td><input size="30" id="ordering" type="text" class="inputbox" name="fields" value="<?php echo $this->record->fields; ?>" /></td>
        </tr>
    </table>
    <input type="hidden" name="id" id="id" value="<?php echo $this->record->id; ?>" />  
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    
    <?php echo JHTML::_( 'form.token' ); ?>
</form>