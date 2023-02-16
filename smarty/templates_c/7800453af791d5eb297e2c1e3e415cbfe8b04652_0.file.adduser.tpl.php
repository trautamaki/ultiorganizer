<?php
/* Smarty version 4.3.0, created on 2023-03-03 14:58:05
  from '/var/www/html/smarty/templates/admin/adduser.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401eedd7cf303_85347140',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7800453af791d5eb297e2c1e3e415cbfe8b04652' => 
    array (
      0 => '/var/www/html/smarty/templates/admin/adduser.tpl',
      1 => 1677848284,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:leftmenu.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_6401eedd7cf303_85347140 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),1=>array('file'=>'/var/www/html/lib/smarty/plugins/block.u.php','function'=>'smarty_block_u',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['messages']->value, 'message');
$_smarty_tpl->tpl_vars['message']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['message']->value) {
$_smarty_tpl->tpl_vars['message']->do_else = false;
?>
<p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<form method='post' action='?view=admin/adduser'>
  <table cellpadding='8'>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Name<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <input type='text' class='input' maxlength='256' id='Name' name='Name' <?php if ((isset($_POST['Name']))) {?> value='<?php echo $_POST['Name'];?>
' <?php }?> />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Username<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <input type='text' class='input' maxlength='50' id='UserName' name='UserName' <?php if ((isset($_POST['UserName']))) {?> value='<?php echo $_POST['UserName'];?>
' <?php }?> />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Password<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <input type='text' class='input' maxlength='20' id='Password' name='Password' value='<?php echo $_smarty_tpl->tpl_vars['password']->value;?>
' />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Email<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <input type='text' class='input' maxlength='512' id='Email' name='Email' size='40' <?php if ((isset($_POST['Email']))) {?> value='<?php echo $_POST['Email'];?>
' <?php }?> />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Responsible team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <select class='dropdown' name='team'>
          <option class='dropdown' <?php if (!(isset($_POST['team']))) {?> selected='selected' <?php }?> value='0'></option>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['teams']->value, 'team');
$_smarty_tpl->tpl_vars['team']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['team']->value) {
$_smarty_tpl->tpl_vars['team']->do_else = false;
?>
          <option class='dropdown' <?php if ((isset($_POST['team'])) && $_smarty_tpl->tpl_vars['team']->value['team_id'] == $_POST['team']) {?> selected='selected' <?php }?> value='<?php echo $_smarty_tpl->tpl_vars['team']->value['team_id'];?>
'>
            <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['team']->value['seriesname'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> <?php echo $_smarty_tpl->tpl_vars['team']->value['name'];?>

          </option>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan='2' align='right'><br />
        <input class='button' type='submit' name='save' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' />
      </td>
    </tr>
  </table>
</form>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
