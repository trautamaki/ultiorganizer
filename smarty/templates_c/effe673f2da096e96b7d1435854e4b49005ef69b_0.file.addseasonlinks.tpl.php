<?php
/* Smarty version 4.3.0, created on 2023-03-01 19:39:54
  from '/var/www/html/smarty/templates/admin/addseasonlinks.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff8deac17145_60143846',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'effe673f2da096e96b7d1435854e4b49005ef69b' => 
    array (
      0 => '/var/www/html/smarty/templates/admin/addseasonlinks.tpl',
      1 => 1677692393,
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
function content_63ff8deac17145_60143846 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<form method='post' action='?view=admin/addseasonlinks&amp;season=<?php echo $_smarty_tpl->tpl_vars['season_id']->value;?>
' id='Form'>
  <table style='white-space: nowrap' cellpadding='2'>
    <tr>
      <th><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Type<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
      <th><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Order<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
      <th><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Name<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
      <th><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Url<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
      <th></th>
    </tr>
    <?php $_smarty_tpl->_assignInScope('i', 0);?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['urls']->value, 'url');
$_smarty_tpl->tpl_vars['url']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['url']->value) {
$_smarty_tpl->tpl_vars['url']->do_else = false;
?>
    <tr>
      <td>
        <?php echo $_smarty_tpl->tpl_vars['url']->value['type'];?>
<input type='hidden' name='urltype<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='(<?php echo $_smarty_tpl->tpl_vars['url']->value['type'];?>
' />
      </td>
      <td>
        <input class='input' size='3' maxlength='2' name='urlorder<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['url']->value['ordering'];?>
' />
      </td>
      <td>
        <input class='input' size='30' maxlength='150' name='urlname<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['url']->value['name'];?>
' />
      </td>
      <td>
        <input class='input' size='40' maxlength='500' name='url<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
' />
      </td>
      <td class='center'>
        <input class='deletebutton' type='image' src='images/remove.png' name='remove' alt='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>X<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' onclick="setId(<?php echo $_smarty_tpl->tpl_vars['url']->value['url_id'];?>
);" />
      </td>
      <td>
        <input type='hidden' name='urlid<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['url']->value['url_id'];?>
' /></td>
    </tr>
    <?php $_smarty_tpl->_assignInScope('i', ($_smarty_tpl->tpl_vars['i']->value+1));?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <tr>
      <td>
        <select class='dropdown' name='newurltype'>
          <option value='menulink'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Menu link<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
          <option value='menumail'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Menu mail<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
        </select>
      </td>
      <td>
        <input class='input' size='3' maxlength='2' name='newurlorder' value='' />
      </td>
      <td>
        <input class='input' size='30' maxlength='150' name='newurlname' value='' />
      </td>
      <td>
        <input class='input' size='40' maxlength='500' name='newurl' value='' />
      </td>
    </tr>
  </table>
  <h1><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>3rd party API settings<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h1>
  <table style='white-space: nowrap' cellpadding='2'>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['settings']->value, 'setting');
$_smarty_tpl->tpl_vars['setting']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['setting']->value) {
$_smarty_tpl->tpl_vars['setting']->do_else = false;
?>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Facebook Update Page<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' size='70' name='FacebookUpdatePage' value='<?php echo $_smarty_tpl->tpl_vars['setting']->value['value'];?>
' /></td>
    </tr>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </table>
  <input type='hidden' name='save' value='hiddensave' />
  <p><input class='button' name='savebutton' type='submit' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Save<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' /></p>
  <div><input type='hidden' id='hiddenDeleteId' name='hiddenDeleteId' /></div>
</form>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
