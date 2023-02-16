<?php
/* Smarty version 4.3.0, created on 2023-03-01 17:41:10
  from '/var/www/html/smarty/templates/page_menu.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff72166d4308_12997615',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f331a72e3f4936c4bca8cc1d1417ec8ef91d50ba' => 
    array (
      0 => '/var/www/html/smarty/templates/page_menu.tpl',
      1 => 1677685124,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63ff72166d4308_12997615 (Smarty_Internal_Template $_smarty_tpl) {
?><div class='pagemenu_container'>
  <?php if ($_smarty_tpl->tpl_vars['menu_length']->value < 100) {?> <table id='pagemenu'>
    <tr>
      <?php $_smarty_tpl->_assignInScope('first', true);?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menu_tabs']->value, 'url', false, 'name');
$_smarty_tpl->tpl_vars['url']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['name']->value => $_smarty_tpl->tpl_vars['url']->value) {
$_smarty_tpl->tpl_vars['url']->do_else = false;
?>
      <?php if (!$_smarty_tpl->tpl_vars['first']->value) {?>
      <td> - </td>
      <?php }?>
      <?php $_smarty_tpl->_assignInScope('first', false);?>
      <?php if ($_smarty_tpl->tpl_vars['url']->value == $_smarty_tpl->tpl_vars['menu_current']->value || strrpos($_smarty_tpl->tpl_vars['server_request_uri']->value,$_smarty_tpl->tpl_vars['url']->value)) {?>
      <th><a class='current' href='<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></th>
      <?php } else { ?>
      <th><a href='<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></th>
      <?php }?>
      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </tr>
    </table>
    <?php } else { ?>
    <ul id='pagemenu'>
      foreach ($menuitems as $name => $url) {
      <?php if ($_smarty_tpl->tpl_vars['url']->value == $_smarty_tpl->tpl_vars['menu_current']->value) {?>
      <li><a class='current' href='<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
'>"<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></li>
      <?php } elseif (strrpos($_smarty_tpl->tpl_vars['server_request_uri']->value,$_smarty_tpl->tpl_vars['url']->value)) {?>
      <li><a class='current' href='<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
'>"<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></li>
      <?php } else { ?>
      <li><a href='<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
'>"<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></li>\n";
      <?php }?>
    </ul>
    <?php }?>
</div>
<p style='clear:both'></p><?php }
}
