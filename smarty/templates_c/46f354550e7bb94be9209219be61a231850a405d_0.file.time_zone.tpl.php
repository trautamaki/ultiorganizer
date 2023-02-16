<?php
/* Smarty version 4.3.0, created on 2023-03-01 17:41:10
  from '/var/www/html/smarty/templates/time_zone.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff72166f77b9_04421466',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '46f354550e7bb94be9209219be61a231850a405d' => 
    array (
      0 => '/var/www/html/smarty/templates/time_zone.tpl',
      1 => 1677685124,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63ff72166f77b9_04421466 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
?>
<p class='timezone'>
  <?php if (!empty($_smarty_tpl->tpl_vars['timezone']->value)) {?>
  <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Timezone<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: <?php echo $_smarty_tpl->tpl_vars['timezone']->value;?>
.
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['display_datetime']->value) {?>
  <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Local time<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: <?php echo $_smarty_tpl->tpl_vars['datetime']->value;?>

  <?php }?>
</p><?php }
}
