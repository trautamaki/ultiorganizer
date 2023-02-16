<?php
/* Smarty version 4.3.0, created on 2023-03-03 11:39:29
  from '/var/www/html/smarty/templates/country_droplist_with_value.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401c0519af567_08353439',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ffe9e56b93323e0b951e1f7533ba88c563818a8d' => 
    array (
      0 => '/var/www/html/smarty/templates/country_droplist_with_value.tpl',
      1 => 1677836244,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6401c0519af567_08353439 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
?>
<select class='dropdown' <?php echo (($tmp = $_smarty_tpl->tpl_vars['style']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
 id='<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
' name='<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
'>
  <option value='-1'></option>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['countries']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
  <option <?php if ($_smarty_tpl->tpl_vars['row']->value['country_id'] == $_smarty_tpl->tpl_vars['selected_id']->value) {?> selected='selected' <?php }?> value='<?php echo $_smarty_tpl->tpl_vars['row']->value['country_id'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['row']->value['name'];
$_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</select><?php }
}
