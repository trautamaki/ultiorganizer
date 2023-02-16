<?php
/* Smarty version 4.3.0, created on 2023-03-03 14:44:21
  from '/var/www/html/smarty/templates/admin/addteamadmins.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401eba5a02d19_21827632',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eef4cf26218f5c7ec15172348b69ead4cd995e5e' => 
    array (
      0 => '/var/www/html/smarty/templates/admin/addteamadmins.tpl',
      1 => 1677847460,
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
function content_6401eba5a02d19_21827632 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
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

<h3><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Team admins<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</h3>
<form method='post' action='?view=admin/addteamadmins&amp;series=<?php echo $_smarty_tpl->tpl_vars['seried_id']->value;?>
' name='teamadmin'>
  <table style='white-space: nowrap;'>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['admins']->value, 'user');
$_smarty_tpl->tpl_vars['user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->do_else = false;
?>
    <?php if ($_smarty_tpl->tpl_vars['user']->value['teaminfo']['series'] != $_smarty_tpl->tpl_vars['seried_id']->value) {?>
    <?php continue 1;?>
    <?php }?>
    <tr>
      <td style='width:175px'><?php echo $_smarty_tpl->tpl_vars['user']->value['teaminfo']['seriesname'];?>
, <?php echo $_smarty_tpl->tpl_vars['user']->value['teaminfo']['name'];?>
</td>
      <td style='width:75px'><?php echo $_smarty_tpl->tpl_vars['user']->value['userid'];?>
</td>
      <td><?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
 (<a href='mailto:<?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
'><?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
</a>)</td>
      <td class='center'>
        <input class='deletebutton' type='image' src='images/remove.png' alt='X' name='remove' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>X<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' onclick="document.teamadmin.delId.value='<?php echo $_smarty_tpl->tpl_vars['user']->value['userid'];?>
';document.teamadmin.teamId.value='<?php echo $_smarty_tpl->tpl_vars['user']->value['team_id'];?>
';" />
      </td>
    </tr>
  </table>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

  <h3><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add more<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h3>
  <table style='white-space: nowrap;'>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['teams']->value, 'team');
$_smarty_tpl->tpl_vars['team']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['team']->value) {
$_smarty_tpl->tpl_vars['team']->do_else = false;
?>
    <tr>
      <td style='width:175px'><?php echo $_smarty_tpl->tpl_vars['team']->value['teaminfo']['name'];?>
</td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>User Id<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
      <td><input class='input' size='20' name='userid<?php echo $_smarty_tpl->tpl_vars['team']->value['team_id'];?>
' id='userid<?php echo $_smarty_tpl->tpl_vars['team']->value['team_id'];?>
' /></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>or<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>E-Mail<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
      <td><input class='input' size='20' name='email<?php echo $_smarty_tpl->tpl_vars['team']->value['team_id'];?>
' id='email<?php echo $_smarty_tpl->tpl_vars['team']->value['team_id'];?>
' /></td>
    </tr>
    </tr>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </table>
  <p><a href='?view=admin/adduser&amp;season=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['season'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add new user<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a></p>
  <p>
    <input class='button' name='add' type='submit' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Grant rights<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' />
    <input class='button' type='button' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Return<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' onclick="window.location.href='<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
'" />
  </p>
  </p>
  <div><input type='hidden' name='delId' /></div>
  <div><input type='hidden' name='teamId' /></div>
  <div><input type='hidden' name='backurl' value='<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
' /></div>
</form>


<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
