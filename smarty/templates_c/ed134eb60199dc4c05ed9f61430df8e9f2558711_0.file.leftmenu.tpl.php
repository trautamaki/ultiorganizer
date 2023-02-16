<?php
/* Smarty version 4.3.0, created on 2023-03-03 11:47:09
  from '/var/www/html/smarty/templates/leftmenu.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401c21d416048_00300530',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ed134eb60199dc4c05ed9f61430df8e9f2558711' => 
    array (
      0 => '/var/www/html/smarty/templates/leftmenu.tpl',
      1 => 1677836823,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6401c21d416048_00300530 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),1=>array('file'=>'/var/www/html/lib/smarty/plugins/block.u.php','function'=>'smarty_block_u',),));
?>
<table style='border:1px solid #fff;background-color: #ffffff;'>
  <tr>
    <td class='menu_left'>
      <!-- Administration menu -->
      <?php if ($_smarty_tpl->tpl_vars['has_schedule_rights']->value || $_smarty_tpl->tpl_vars['is_super_admin']->value || $_smarty_tpl->tpl_vars['has_translation_right']->value) {?>
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Administration<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['is_super_admin']->value) {?>
        <tr>
          <td>
            <a class='subnav' href='?view=admin/seasons'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Events<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='?view=admin/serieformats'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Rule templates<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='?view=admin/clubs'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Clubs & Countries<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='?view=admin/locations'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Field locations<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='?view=admin/reservations'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Field reservations<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['has_schedule_rights']->value) {?>
        <tr>
          <td><a class='subnav' href='?view=admin/schedule'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Scheduling<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['has_translation_right']->value) {?>
            <a class='subnav' href='?view=admin/translations'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Translations<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['is_super_admin']->value) {?>
            <a class='subnav' href='?view=admin/users'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Users<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='?view=admin/eventviewer'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Logs<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='?view=admin/dbadmin'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Database<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='?view=admin/serverconf'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Settings<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['has_schedule_rights']->value || $_smarty_tpl->tpl_vars['is_super_admin']->value || $_smarty_tpl->tpl_vars['has_translation_right']->value) {?>
          </td>
        </tr>
      </table>
      <?php }?>
      <?php if (!$_smarty_tpl->tpl_vars['user_anonymous']->value) {?>
      <table class='leftmenulinks'>
        <tr>
          <td>
            <a class='subnav' href='?view=admin/help'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Helps<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
      </table>
      <?php }?>
      <!-- Event administration menu -->
      <?php if (count($_smarty_tpl->tpl_vars['menu_edit_links']->value)) {?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menu_edit_links']->value, 'links', false, 'season');
$_smarty_tpl->tpl_vars['links']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['season']->value => $_smarty_tpl->tpl_vars['links']->value) {
$_smarty_tpl->tpl_vars['links']->do_else = false;
?>
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'><?php echo $_smarty_tpl->tpl_vars['season']->value;?>
 <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Administration<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
          <!-- TODO get the id for X? -->
          <td class='menuseasonlevel'><a style='text-decoration: none;' href='?view=frontpage&amp;hideseason=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
'>x</a></td>
        </tr>
        <tr>
          <td>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['links']->value, 'name', false, 'href');
$_smarty_tpl->tpl_vars['name']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['href']->value => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->do_else = false;
?>
            <a class='subnav' href='<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
'>&raquo; <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          </td>
        </tr>
      </table>
      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <?php }?>
      <?php if ($_smarty_tpl->tpl_vars['is_super_admin']->value) {?>
      <table class='leftmenulinks'>
        <tr>
          <td>
            <a class='subnav' href='?view=admin/addseasons'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Create new event<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
      </table>
      <?php }?>
      <!-- Team registration -->
      <!-- TODO test it -->
      <?php if (!$_smarty_tpl->tpl_vars['user_anonymous']->value) {?>
      <?php if (count($_smarty_tpl->tpl_vars['menu_enroll_seasons']->value)) {?>
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Team registration<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
        </tr>
        <tr>
          <td>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menu_enroll_seasons']->value, 'season_name', false, 'season_id');
$_smarty_tpl->tpl_vars['season_name']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['season_id']->value => $_smarty_tpl->tpl_vars['season_name']->value) {
$_smarty_tpl->tpl_vars['season_name']->do_else = false;
?>
            <a class='subnav' href='?view=user/enrollteam&amp;season=<?php echo $_smarty_tpl->tpl_vars['season_id']->value;?>
'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['season_name']->value;
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          </td>
        </tr>
      </table>
      <?php }?>
      <?php }?>
      <!-- Player profiles -->
      <?php if ($_smarty_tpl->tpl_vars['has_player_admin_rights']->value) {?>
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Player profiles<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
        </tr>
        <tr>
          <td>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['player_admins']->value, 'player');
$_smarty_tpl->tpl_vars['player']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['player']->value) {
$_smarty_tpl->tpl_vars['player']->do_else = false;
?>
            <a class='subnav' href='?view=user/playerprofile&amp;profile=<?php echo $_smarty_tpl->tpl_vars['player']->value['profile_id'];?>
'>&raquo; <?php echo $_smarty_tpl->tpl_vars['player']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['player']->value['lastname'];?>
</a>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          </td>
        </tr>
      </table>
      <?php }?>
      <?php if (count($_smarty_tpl->tpl_vars['menu_current_seasons']->value)) {?>
      <table>
        <tr>
          <td>
            <form action='?view=index' method='get' id='seasonsels'>
              <div>
                <select class='seasondropdown' name='selseason' onchange='changeseason(selseason.options[selseason.options.selectedIndex].value);'>
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menu_current_seasons']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
                  <?php $_smarty_tpl->_assignInScope('selected', '');?>
                  <?php if ((isset($_SESSION['userproperties']['selseason'])) && $_SESSION['userproperties']['selseason'] == $_smarty_tpl->tpl_vars['row']->value['season_id']) {?>
                  <?php $_smarty_tpl->_assignInScope('selected', "selected='selected'");?>
                  <?php }?>
                  <option class='dropdown' <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['row']->value['season_id'];?>
'><?php echo $_smarty_tpl->tpl_vars['row']->value['season_name'];?>
</option>
                  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </select>
                <noscript>
                  <div><input type='submit' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Go<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' name='selectseason' /></div>
                </noscript>
              </div>
            </form>
          </td>
        </tr>
      </table>
      <?php }?>
      <table class='leftmenulinks'>
        <?php if (count($_smarty_tpl->tpl_vars['menu_pools']->value)) {?>
        <?php $_smarty_tpl->_assignInScope('last_season', '');?>
        <?php $_smarty_tpl->_assignInScope('last_series', '');?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menu_pools']->value, 'pool');
$_smarty_tpl->tpl_vars['pool']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pool']->value) {
$_smarty_tpl->tpl_vars['pool']->do_else = false;
?>
        <?php if ($_smarty_tpl->tpl_vars['last_season']->value != $_smarty_tpl->tpl_vars['pool']->value['series']) {?>
        <?php $_smarty_tpl->_assignInScope('last_season', $_smarty_tpl->tpl_vars['pool']->value['season']);?>
        <tr>
          <td class='menuseasonlevel'>
            <a class='seasonnav' style='text-align:center;' href='?view=teams&amp;season=<?php echo $_smarty_tpl->tpl_vars['pool']->value['season'];?>
&amp;list=bystandings'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['pool']->value['season_name'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=teams&amp;season=<?php echo $_smarty_tpl->tpl_vars['pool']->value['season'];?>
&amp;list=bystandings'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Final standings<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=games&amp;season=<?php echo $_smarty_tpl->tpl_vars['pool']->value['season'];?>
&amp;filter=tournaments&amp;group=all'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=teams&amp;season=<?php echo $_smarty_tpl->tpl_vars['pool']->value['season'];?>
&amp;list=allteams'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Teams<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <tr>
          <td class='menuseparator'></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['last_series']->value != $_smarty_tpl->tpl_vars['pool']->value['series']) {?>
        <?php $_smarty_tpl->_assignInScope('last_series', $_smarty_tpl->tpl_vars['pool']->value['series']);?>
        <tr>
          <td class='menuserieslevel'>
            <a class='subnav' href='?view=seriesstatus&amp;series=<?php echo $_smarty_tpl->tpl_vars['pool']->value['series'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['pool']->value['series_name'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <tr>
          <td class='navpoollink'>
            <a class='subnav' href='?view=poolstatus&amp;series=<?php echo $_smarty_tpl->tpl_vars['pool']->value['series'];?>
'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Show all pools<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <?php }?>
        <tr>
          <td class='menupoollevel'>
            <a class='navpoollink' href='?view=poolstatus&amp;pool=<?php echo $_smarty_tpl->tpl_vars['pool']->value['pool'];?>
'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['pool']->value['pool_name'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php } else { ?>
        <tr>
          <td class='menuseasonlevel'>
            <a class='seasonnav' style='text-align:center;' href='?view=teams&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
&amp;list=bystandings'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['current_season_name']->value;
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=timetables&amp;season=$season&amp;filter=tournaments&amp;group=all'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=teams&amp;season=$season'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Teams<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <tr>
          <td class='menuseparator'></td>
        </tr>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menu_season_series']->value, 's');
$_smarty_tpl->tpl_vars['s']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['s']->value) {
$_smarty_tpl->tpl_vars['s']->do_else = false;
?>
        <tr>
          <td class='menuserieslevel'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['s']->value['name'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
        </tr>
        <tr>
          <td class='menupoollevel'>
            <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Pools not yet created<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
          </td>
        </tr>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php }?>
      </table>
      <!-- Event links -->
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Event Links<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
        </tr>
        <tr>
          <td>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menu_urls']->value, 'url');
$_smarty_tpl->tpl_vars['url']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['url']->value) {
$_smarty_tpl->tpl_vars['url']->do_else = false;
?>
            <?php if ($_smarty_tpl->tpl_vars['url']->value['type'] == "menulink") {?>
            <a class='subnav' href='<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['url']->value['name'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php } elseif ($_smarty_tpl->tpl_vars['url']->value['type'] == "menumail") {?>
            <a class='subnav' href='mailto:<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
'>@<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['url']->value['name'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php }?>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          </td>
        </tr>
        <tr>
          <td>
            <a class='subnav' style='background: url(./images/linkicons/feed_14x14.png) no-repeat 0 50%; padding: 0 0 0 19px;' href='./ext/rss.php?feed=all'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Result Feed<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <?php if ($_smarty_tpl->tpl_vars['twitter_enabled']->value) {?>
        <?php if (!empty($_smarty_tpl->tpl_vars['saved_url']->value['url'])) {?>
        <tr>
          <td>
            <a class='subnav' style='background: url(./images/linkicons/twitter_14x14.png) no-repeat 0 50%; padding: 0 0 0 19px;' href='" . $savedurl[' url'] . "'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Result Twitter<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
        <?php }?>
        <?php }?>
      </table>
      <!-- Event history -->
      <?php if ($_smarty_tpl->tpl_vars['menu_stat_data_available']->value) {?>
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Statistics<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
        </tr>
        <tr>
          <td>
            <a class='subnav' href=" ?view=seasonlist">&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Events<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href="?view=allplayers">&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Players<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href="?view=allteams">&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Teams<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href="?view=allclubs">&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Clubs<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php if ($_smarty_tpl->tpl_vars['menu_countries_count']->value) {?>
            <a class='subnav' href="?view=allcountries">&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Countries<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php }?>
            <a class='subnav' href="?view=statistics&amp;list=teamstandings">&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>All time<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
      </table>
      <?php }?>
      <!-- External access -->
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Client access<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
        </tr>
        <tr>
          <td>
            <a class='subnav' href='?view=ext/index'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Ultiorganizer links<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='?view=ext/export'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Data export<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='?view=mobile/index'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Mobile Administration<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <a class='subnav' href='./scorekeeper/'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Scorekeeper<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
      </table>
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Links<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
        </tr>
        <tr>
          <td>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menu_urls_list_by_type_array']->value, 'url');
$_smarty_tpl->tpl_vars['url']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['url']->value) {
$_smarty_tpl->tpl_vars['url']->do_else = false;
?>
            <?php if ($_smarty_tpl->tpl_vars['url']->value['type'] == "menulink") {?>
            <a class='subnav' href='<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['url']->value['name'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php } elseif ($_smarty_tpl->tpl_vars['url']->value['type'] == "menumail") {?>
            <a class='subnav' href='mailto:<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
'>@<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['url']->value['name'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
            <?php }?>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          </td>
        </tr>
      </table>
      <!-- Draw customizable logo if any -->
      <?php echo $_smarty_tpl->tpl_vars['menu_logo_html']->value;?>

      <table style='width:90%'>
        <tr>
          <td class='guides'>
            <a href='?view=user_guide'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>User Guide<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a> |
            <a href='?view=admin/help'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Admin Help<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a> |
            <a href='?view=privacy'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Privacy Policy<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
          </td>
        </tr>
      </table>
    </td>
    <td align='left' valign='top' class='tdcontent'>
      <div class='content'><?php }
}
