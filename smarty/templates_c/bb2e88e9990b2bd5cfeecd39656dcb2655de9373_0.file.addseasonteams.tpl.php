<?php
/* Smarty version 4.3.0, created on 2023-03-03 11:49:28
  from '/var/www/html/smarty/templates/admin/addseasonteams.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401c2a8968227_86918213',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bb2e88e9990b2bd5cfeecd39656dcb2655de9373' => 
    array (
      0 => '/var/www/html/smarty/templates/admin/addseasonteams.tpl',
      1 => 1677836966,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:leftmenu.tpl' => 1,
    'file:translated_field.tpl' => 1,
    'file:country_droplist_with_value.tpl' => 1,
    'file:translation_script.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_6401c2a8968227_86918213 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),1=>array('file'=>'/var/www/html/lib/smarty/plugins/block.u.php','function'=>'smarty_block_u',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo $_smarty_tpl->tpl_vars['yui_load']->value;?>


<?php echo '<script'; ?>
 type="text/javascript">
  var clubs = new Array(<?php echo $_smarty_tpl->tpl_vars['orgarray']->value;?>
);
<?php echo '</script'; ?>
>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['messages']->value, 'message');
$_smarty_tpl->tpl_vars['message']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['message']->value) {
$_smarty_tpl->tpl_vars['message']->do_else = false;
?>
<p>$message</p><hr />
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<?php if ($_smarty_tpl->tpl_vars['team_id']->value) {?>
<h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Edit team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
<form method='post' action='?view=admin/addseasonteams&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
&amp;series=<?php echo $_smarty_tpl->tpl_vars['series_id']->value;?>
&amp;team=<?php echo $_smarty_tpl->tpl_vars['team_id']->value;?>
'>
<?php } else { ?>
<h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
<form method='post' action='?view=admin/addseasonteams&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
&amp;series=<?php echo $_smarty_tpl->tpl_vars['series_id']->value;?>
'>
<?php }?>
  <table cellpadding='2px' class='yui-skin-sam'>
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
        <?php if (!intval($_smarty_tpl->tpl_vars['season_info']->value['isnationalteams'])) {?>
        <input class='input' id='name' name='name' size='50' value='<?php echo $_smarty_tpl->tpl_vars['tp']->value['name'];?>
' />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Club<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <div id='orgAutoComplete'>
          <input class='input' type='text' id='club' name='club' size='50' value='<?php echo $_smarty_tpl->tpl_vars['club_name']->value;?>
' />
          <div id='orgContainer'></div>
        </div>
        <?php } else { ?>
        <?php $_smarty_tpl->_subTemplateRender("file:translated_field.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field_name'=>"name",'value'=>$_smarty_tpl->tpl_vars['tp']->value['name']), 0, false);
?>
        <?php }?>
      </td>
    </tr>
    <?php if (intval($_smarty_tpl->tpl_vars['season_info']->value['isinternational'])) {?>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Country<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><?php $_smarty_tpl->_subTemplateRender("file:country_droplist_with_value.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('countries'=>$_smarty_tpl->tpl_vars['countries']->value,'id'=>"country",'name'=>"country",'selected_id'=>$_smarty_tpl->tpl_vars['tp']->value['country']), 0, false);
?></td>
    </tr>
    <?php }?>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Abbreviation<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <input class='input' id='abbreviation' name='abbreviation' maxlength='15' size='16' value='<?php echo $_smarty_tpl->tpl_vars['tp']->value['abbreviation'];?>
' />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Division<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <input class='input' id='series' name='series' disabled='disabled' size='50' value='<?php echo $_smarty_tpl->tpl_vars['series_name']->value;?>
' />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Starting pool<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <select class='dropdown' name='pool'>
          <option class='dropdown' <?php if (!intval($_smarty_tpl->tpl_vars['tp']->value['pool'])) {?> selected='selected' <?php }?> value='0'></option>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pools']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['row']->value['pool_id'] == $_smarty_tpl->tpl_vars['tp']->value['pool']) {?> selected='selected' <?php }?> value='<?php echo $_smarty_tpl->tpl_vars['row']->value['pool_id'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['row']->value['name'];
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
ob_start();?>Seed<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='rank' size='4' name='rank' value='<?php echo $_smarty_tpl->tpl_vars['tp']->value['rank'];?>
' /></td>
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
      <td>
        <input class='input' type='checkbox' id='teamvalid' name='teamvalid' <?php if (intval($_smarty_tpl->tpl_vars['tp']->value['valid']) || !$_smarty_tpl->tpl_vars['teamId']->value) {?> checked='checked' <?php }?> />
      </td>
  </table>

  <p><a href='?view=admin/users'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Select contact person<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a></p>
  <p>
    <?php if ($_smarty_tpl->tpl_vars['teamId']->value) {?>
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
    <input class='button' type='button' name='back' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Return<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' onclick="window.location.href='?view=admin/seasonteams&amp;season=$season'" />
  </p>
</form>

<?php echo '<script'; ?>
 type="text/javascript">
  YAHOO.autocomplete = function() {
    var oDS = new YAHOO.util.LocalDataSource(clubs);
    var oAC = new YAHOO.widget.AutoComplete("club", "orgContainer", oDS);
    oAC.prehighlightClassName = "yui-ac-prehighlight";
    oAC.useShadow = true;
    return {
      oDS: oDS,
      oAC: oAC
    };
  }();
<?php echo '</script'; ?>
>

<?php if (intval($_smarty_tpl->tpl_vars['season_info']->value['isnationalteams'])) {
$_smarty_tpl->_subTemplateRender("file:translation_script.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field_name'=>"name"), 0, false);
}?>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
