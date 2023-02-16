<?php
/* Smarty version 4.3.0, created on 2023-03-01 17:41:10
  from '/var/www/html/smarty/templates/games.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff7216684e29_93704985',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5aeed76a1e9c59d5291951a663b11b0b69394c3' => 
    array (
      0 => '/var/www/html/smarty/templates/games.tpl',
      1 => 1677685124,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:leftmenu.tpl' => 1,
    'file:page_menu.tpl' => 1,
    'file:games/tournament_view.tpl' => 1,
    'file:games/series_view.tpl' => 1,
    'file:games/places_view.tpl' => 1,
    'file:games/time_view.tpl' => 1,
    'file:time_zone.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_63ff7216684e29_93704985 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.u.php','function'=>'smarty_block_u',),1=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php $_smarty_tpl->_subTemplateRender("file:page_menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php if (count($_smarty_tpl->tpl_vars['groups']->value) > 1) {?>
<!-- TODO print & $singleview -->
<p>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groups']->value, 'grouptmp');
$_smarty_tpl->tpl_vars['grouptmp']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['grouptmp']->value) {
$_smarty_tpl->tpl_vars['grouptmp']->do_else = false;
?>
  <?php if ($_smarty_tpl->tpl_vars['group']->value == $_smarty_tpl->tpl_vars['grouptmp']->value['reservationgroup']) {?>
  <a class='groupinglink' href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
&amp;filter=<?php echo $_smarty_tpl->tpl_vars['filter']->value;?>
&amp;group=<?php echo $_smarty_tpl->tpl_vars['grouptmp']->value['reservationgroup'];?>
'>
    <span class='selgroupinglink'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['grouptmp']->value['reservationgroup'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></span>
  </a>
  <?php } else { ?>
  <a class='groupinglink' href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
&amp;filter=<?php echo $_smarty_tpl->tpl_vars['filter']->value;?>
&amp;group=<?php echo $_smarty_tpl->tpl_vars['grouptmp']->value['reservationgroup'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['grouptmp']->value['reservationgroup'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
  <?php }?>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  <?php if ($_smarty_tpl->tpl_vars['group']->value == "all") {?>
  <a class='groupinglink' href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
&amp;filter=<?php echo $_smarty_tpl->tpl_vars['filter']->value;?>
&amp;group=all'>
    <span class='selgroupinglink'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>All<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></span></a>
  <?php } else { ?>
  <a class='groupinglink' href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
&amp;filter=<?php echo $_smarty_tpl->tpl_vars['filter']->value;?>
&amp;group=all'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>All<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
  <?php }?>
</p>
<?php }?>

<?php if (!count($_smarty_tpl->tpl_vars['games']->value)) {?>
<br><p><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>No games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></p>
<?php } elseif ($_smarty_tpl->tpl_vars['filter']->value == 'tournaments' || $_smarty_tpl->tpl_vars['filter']->value == 'next') {?>
  <?php $_smarty_tpl->_subTemplateRender("file:games/tournament_view.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('games'=>$_smarty_tpl->tpl_vars['games']->value,'grouping'=>$_smarty_tpl->tpl_vars['group_header']->value), 0, false);
} elseif ($_smarty_tpl->tpl_vars['filter']->value == 'series' || $_smarty_tpl->tpl_vars['filter']->value == 'all' || $_smarty_tpl->tpl_vars['filter']->value == 'today' || $_smarty_tpl->tpl_vars['filter']->value == 'tomorrow') {?>
  <?php $_smarty_tpl->_subTemplateRender("file:games/series_view.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('games'=>$_smarty_tpl->tpl_vars['games']->value), 0, false);
} elseif ($_smarty_tpl->tpl_vars['filter']->value == 'places') {?>
  <?php $_smarty_tpl->_subTemplateRender("file:games/places_view.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('games'=>$_smarty_tpl->tpl_vars['games']->value,'grouping'=>$_smarty_tpl->tpl_vars['group_header']->value), 0, false);
} elseif ($_smarty_tpl->tpl_vars['filter']->value == 'timeslot') {?>
  <?php $_smarty_tpl->_subTemplateRender("file:games/time_view.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('games'=>$_smarty_tpl->tpl_vars['games']->value,'grouping'=>false), 0, false);
}?>

<?php if (count($_smarty_tpl->tpl_vars['games']->value)) {
$_smarty_tpl->_subTemplateRender("file:time_zone.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>

<?php if (count($_smarty_tpl->tpl_vars['games']->value)) {?>
<hr>
<p>
  <a href='?view=ical&amp;$gamefilter=$id&amp;time=$timefilter&amp;order=$order'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>iCalendar (.ical)<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a> | 
  <a href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
&filter=onepage&group=$group'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Grid (PDF)<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a> | 
  <a href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
&filter=season&group=$group'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>List (PDF)<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a> | 
  <a href='?<?php echo $_smarty_tpl->tpl_vars['querystring']->value;?>
&amp;print=1'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Printable version<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
</p>
<?php }?>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
