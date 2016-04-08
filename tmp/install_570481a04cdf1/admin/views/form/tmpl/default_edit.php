<?php
defined('_JEXEC') or die('Restricted access');
$option = JRequest::getVar('option');
$controller = JRequest::getVar('controller');

?>
<form method="post" name="adminForm" id="item-form" enctype="multipart/form-data">
    <table class="admintable" width="100%">
        <tr>
            <td class="title"><label for="title"><?php echo JText::_('Title')?></label></td>
            <td><input size="30" id="title" type="text" class="inputbox" name="title" value="<?php echo $this->row->title; ?>" /></td>
        </tr>
        <tr>
            <td class="ordering" ><label for="ordering"><?php echo JText::_('Ordering')?></label></td>
            <td><input size="30" id="ordering" type="text" class="inputbox" name="ordering" value="<?php echo $this->row->ordering; ?>" /></td>
        </tr>
    </table>
    <input type="hidden" name="id" id="id" value="<?php echo $this->row->id; ?>" />
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="controller" value="<?php echo $controller;?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>