<?php
/* Smarty version 4.3.0, created on 2023-03-03 11:09:01
  from '/var/www/html/smarty/templates/admin/addseasonseries.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401b92d646630_00841125',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dbdcf590ea8544472be862ecf6d77eb03b441ef2' => 
    array (
      0 => '/var/www/html/smarty/templates/admin/addseasonseries.tpl',
      1 => 1677834530,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:leftmenu.tpl' => 1,
    'file:translated_field.tpl' => 1,
    'file:translation_script.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_6401b92d646630_00841125 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),1=>array('file'=>'/var/www/html/lib/smarty/plugins/block.u.php','function'=>'smarty_block_u',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo $_smarty_tpl->tpl_vars['yui_load']->value;?>


<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['warnings']->value, 'warning');
$_smarty_tpl->tpl_vars['warning']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['warning']->value) {
$_smarty_tpl->tpl_vars['warning']->do_else = false;
?>
<p class='warning'><?php echo $_smarty_tpl->tpl_vars['warning']->value;?>
</p>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<!-- If seriesid is empty, then add new serie	-->
<h2>
  <?php if ($_smarty_tpl->tpl_vars['series_id']->value) {?>
  <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Edit division<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:
  <?php } else { ?>
  <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add division<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
</h2>
<?php }?>

<form method='post' action='?view=admin/addseasonseries&amp;series=<?php echo $_smarty_tpl->tpl_vars['series_id']->value;?>
&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
'>
  <table cellpadding='2px'>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Name<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><?php $_smarty_tpl->_subTemplateRender("file:translated_field.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field_name'=>"name",'value'=>$_smarty_tpl->tpl_vars['sp']->value['name']), 0, false);
?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Order<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> (A,B,C,D..):</td>
      <td><input class='input' id='ordering' name='ordering' value='<?php echo $_smarty_tpl->tpl_vars['sp']->value['ordering'];?>
' /></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Type<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <select class='dropdown' name='type'>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['types']->value, 'type');
$_smarty_tpl->tpl_vars['type']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->do_else = false;
?>
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['sp']->value['type'] == $_smarty_tpl->tpl_vars['type']->value) {?> selected='selected' <?php }?> value='<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['type']->value;
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </select>
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Valid<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' type='checkbox' id='valid' name='valid' <?php if (intval($_smarty_tpl->tpl_vars['sp']->value['valid'])) {?> checked='checked' <?php }?> /></td>
    </tr>
  </table>
  <p>
    <?php if ($_smarty_tpl->tpl_vars['series_id']->value) {?>
    <input class='button' name='save' type='submit' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Save<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' />
    <?php } else { ?>
    <input class='button' name='add' type='submit' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' />
    <?php }?>
    <input class='button' type='button' name='takaisin' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Return<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' onclick="window.location.href='?view=admin/seasonseries&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
'" />
  </p>
</form>

<?php $_smarty_tpl->_subTemplateRender("file:translation_script.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field_name'=>"name"), 0, false);
?>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
