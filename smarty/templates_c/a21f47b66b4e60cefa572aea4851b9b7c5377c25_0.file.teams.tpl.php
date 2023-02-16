<?php
/* Smarty version 4.3.0, created on 2023-03-01 17:37:58
  from '/var/www/html/smarty/templates/teams.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff715681c734_52595529',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a21f47b66b4e60cefa572aea4851b9b7c5377c25' => 
    array (
      0 => '/var/www/html/smarty/templates/teams.tpl',
      1 => 1677685026,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:leftmenu.tpl' => 1,
    'file:page_menu.tpl' => 1,
    'file:teams/teams_allteams_byseeding.tpl' => 1,
    'file:teams/teams_bypool.tpl' => 1,
    'file:teams/teams_bystandings.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_63ff715681c734_52595529 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php $_smarty_tpl->_subTemplateRender("file:page_menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<h1><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Teams<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h1>

<?php if ($_smarty_tpl->tpl_vars['list_type']->value == "allteams" || $_smarty_tpl->tpl_vars['list_type']->value == "byseeding") {
$_smarty_tpl->_subTemplateRender("file:teams/teams_allteams_byseeding.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ($_smarty_tpl->tpl_vars['list_type']->value == "bypool") {
$_smarty_tpl->_subTemplateRender("file:teams/teams_bypool.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ($_smarty_tpl->tpl_vars['list_type']->value == "bystandings") {
$_smarty_tpl->_subTemplateRender("file:teams/teams_bystandings.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
