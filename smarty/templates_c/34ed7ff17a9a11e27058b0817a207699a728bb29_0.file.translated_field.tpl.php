<?php
/* Smarty version 4.3.0, created on 2023-03-03 14:30:26
  from '/var/www/html/smarty/templates/translated_field.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401e8625d75e5_34979743',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '34ed7ff17a9a11e27058b0817a207699a728bb29' => 
    array (
      0 => '/var/www/html/smarty/templates/translated_field.tpl',
      1 => 1677836823,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6401e8625d75e5_34979743 (Smarty_Internal_Template $_smarty_tpl) {
?><div
  style='width:<?php echo (($tmp = $_smarty_tpl->tpl_vars['width']->value ?? null)===null||$tmp==='' ? "200" ?? null : $tmp);?>
px; height:20px'
  id='<?php echo $_smarty_tpl->tpl_vars['field_name']->value;?>
Autocomplete' class='yui-skin-sam'>
  <input
    class='input'
    size='<?php echo (($tmp = $_smarty_tpl->tpl_vars['size']->value ?? null)===null||$tmp==='' ? "30" ?? null : $tmp);?>
'
    maxlength='<?php echo (($tmp = $_smarty_tpl->tpl_vars['size']->value ?? null)===null||$tmp==='' ? "30" ?? null : $tmp);?>
'
    style='width:<?php echo (($tmp = $_smarty_tpl->tpl_vars['width']->value ?? null)===null||$tmp==='' ? "200" ?? null : $tmp);?>
px'
    id='<?php echo $_smarty_tpl->tpl_vars['field_name']->value;?>
' name='<?php echo $_smarty_tpl->tpl_vars['field_name']->value;?>
'
    value='<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
' />
  <div style='width:<?php echo (($tmp = $_smarty_tpl->tpl_vars['width']->value ?? null)===null||$tmp==='' ? "200" ?? null : $tmp);?>
px' id='<?php echo $_smarty_tpl->tpl_vars['field_name']->value;?>
Container'></div>
</div>
<?php }
}
