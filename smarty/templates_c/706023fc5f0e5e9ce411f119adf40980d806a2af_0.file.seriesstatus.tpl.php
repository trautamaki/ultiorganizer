<?php
/* Smarty version 4.3.0, created on 2023-03-01 17:37:56
  from '/var/www/html/smarty/templates/seriesstatus.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff715477cd04_18461410',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '706023fc5f0e5e9ce411f119adf40980d806a2af' => 
    array (
      0 => '/var/www/html/smarty/templates/seriesstatus.tpl',
      1 => 1677685026,
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
function content_63ff715477cd04_18461410 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),1=>array('file'=>'/var/www/html/lib/smarty/plugins/block.u.php','function'=>'smarty_block_u',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Division statistics:<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> <?php echo $_smarty_tpl->tpl_vars['series_info']->value['name'];?>
</h2>

<table border='1' style='width:100%'>
  <tr>
    <?php if ($_smarty_tpl->tpl_vars['sort']->value == 'name') {?>
    <th style='width:180px'>
      <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
    </th>
    <?php } else { ?>
    <th style='width:180px'>
      <a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=name'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
    </th>
    <?php }?>
    <th class='center'><?php if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=seed'><?php }
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Seeding<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?></a><?php }?></th>
    <th class='center'><?php if ($_smarty_tpl->tpl_vars['sort']->value != "ranking") {?><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=ranking'><?php }
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Ranking<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?></a><?php }?></th>
    <th class='center'><?php if ($_smarty_tpl->tpl_vars['sort']->value != "games") {?><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=games'><?php }
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?></a><?php }?></th>
    <th class='center'><?php if ($_smarty_tpl->tpl_vars['sort']->value != "wins") {?><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=wins'><?php }
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Wins<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?></a><?php }?></th>
    <th class='center'><?php if ($_smarty_tpl->tpl_vars['sort']->value != "losses") {?><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=losses'><?php }
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Losses<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?></a><?php }?></th>
    <th class='center'><?php if ($_smarty_tpl->tpl_vars['sort']->value != "for") {?><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=for'><?php }
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Goals for<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?></a><?php }?></th>
    <th class='center'><?php if ($_smarty_tpl->tpl_vars['sort']->value != "against") {?><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=against'><?php }
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Goals against<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?></a><?php }?></th>
    <th class='center'><?php if ($_smarty_tpl->tpl_vars['sort']->value != "diff") {?><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=diff'><?php }
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Goals diff<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?></a><?php }?></th>
    <th class='center'><?php if ($_smarty_tpl->tpl_vars['sort']->value != "winavg") {?><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=winavg'><?php }
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Win-%<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
if ($_smarty_tpl->tpl_vars['sort']->value != "seed") {?></a><?php }?></th>

    <?php if ($_smarty_tpl->tpl_vars['season_info']->value['spiritmode'] > 0 && ($_smarty_tpl->tpl_vars['season_info']->value['showspiritpoints'] || $_smarty_tpl->tpl_vars['is_season_admin']->value)) {?>
    <?php if ($_smarty_tpl->tpl_vars['sort']->value == "spirit") {?>
    <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Spirit points<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <?php } else { ?>
    <th class='center'><a class='thsort' href='<?php echo $_smarty_tpl->tpl_vars['view_url']->value;?>
&amp;Sort=spirit'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Spirit points<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a></th>
    <?php }?>
    <?php }?>
  </tr>

  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['all_teams']->value, 'stats');
$_smarty_tpl->tpl_vars['stats']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['stats']->value) {
$_smarty_tpl->tpl_vars['stats']->do_else = false;
?>
  <tr>
    <td class="<?php if ($_smarty_tpl->tpl_vars['sort']->value == 'name') {?> highlight <?php }?>">
      <?php if (intval($_smarty_tpl->tpl_vars['season_info']->value['isinternational'])) {?>
      <img height='10' src='images/flags/tiny/<?php echo $_smarty_tpl->tpl_vars['stats']->value['flagfile'];?>
' alt='' />
      <?php }?>
      <a href='?view=teamcard&amp;team=<?php echo $_smarty_tpl->tpl_vars['stats']->value['team_id'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['stats']->value['name'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
    </td>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "seed") {?> highlight <?php }?>'><?php echo intval($_smarty_tpl->tpl_vars['stats']->value['seed']);?>
</td>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "ranking") {?> highlight <?php }?>'><?php echo $_smarty_tpl->tpl_vars['stats']->value['pretty_rank'];?>
</td>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "games") {?> highlight <?php }?>'><?php echo intval($_smarty_tpl->tpl_vars['stats']->value['games']);?>
</td>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "wins") {?> highlight <?php }?>'><?php echo intval($_smarty_tpl->tpl_vars['stats']->value['wins']);?>
</td>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "losses") {?> highlight <?php }?>'><?php echo intval($_smarty_tpl->tpl_vars['stats']->value['losses']);?>
</td>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "for") {?> highlight <?php }?>'><?php echo intval($_smarty_tpl->tpl_vars['stats']->value['for']);?>
</td>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "against") {?> highlight <?php }?>'><?php echo intval($_smarty_tpl->tpl_vars['stats']->value['against']);?>
</td>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "diff") {?> highlight <?php }?>'><?php echo intval($_smarty_tpl->tpl_vars['stats']->value['diff']);?>
</td>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "winavg") {?> highlight <?php }?>'><?php echo $_smarty_tpl->tpl_vars['stats']->value['winavg'];?>
 %</td>
    <?php if ($_smarty_tpl->tpl_vars['season_info']->value['spiritmode'] > 0 && ($_smarty_tpl->tpl_vars['seasoninfo']->value['showspiritpoints'] || $_smarty_tpl->tpl_vars['is_season_admin']->value)) {?>
    <td class='center <?php if ($_smarty_tpl->tpl_vars['sort']->value == "spirit") {?> highlight <?php }?>'><?php echo $_smarty_tpl->tpl_vars['stats']->value['pretty_spirit'];?>
</td>
    <?php }?>
  </tr>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>

<a href='?view=poolstatus&amp;series=<?php echo $_smarty_tpl->tpl_vars['series_info']->value['series_id'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Show all pools<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>

<h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Scoreboard leaders<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
<table cellspacing='0' border='0' width='100%'>
  <tr>
    <th style='width:200px'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Player<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <th style='width:200px'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Assists<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Goals<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Tot.<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
  </tr>

  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['points_leaders']->value, 'score');
$_smarty_tpl->tpl_vars['score']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['score']->value) {
$_smarty_tpl->tpl_vars['score']->do_else = false;
?>
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['score']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['score']->value['lastname'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['score']->value['teamname'];?>
</td>
    <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['score']->value['games']);?>
</td>
    <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['score']->value['fedin']);?>
</td>
    <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['score']->value['done']);?>
</td>
    <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['score']->value['total']);?>
</td>
  </tr>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>

<a href='?view=scorestatus&amp;series=<?php echo $_smarty_tpl->tpl_vars['series_info']->value['series_id'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Scoreboard<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a><br>

<div style='padding: 5px; width: 100%; height: 100%'>
  <div style='float: left; width: 50%;'>
    <h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Goals leaders<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
    <table cellspacing='0' border='0' style='margin-left: 0; padding: 0;'>
      <tr>
        <th style='width:100%'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Player<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
        <th><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
        <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
        <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Goals<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
      </tr>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['goals_leaders']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
      <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['lastname'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['abbr'];?>
</td>
        <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['row']->value['games']);?>
</td>
        <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['row']->value['done']);?>
</td>
      </tr>
      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </table>
  </div>

  <div style='float: right; width: 50%;'>
    <h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Assists leaders<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
    <table cellspacing='0' border='0' style='margin-right: 0; padding: 0;'>
      <tr>
        <th style='width:100%'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Player<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
        <th><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
        <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
        <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Assists<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
      </tr>

      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['assists_leaders']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
      <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['lastname'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['abbr'];?>
</td>
        <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['row']->value['games']);?>
</td>
        <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['row']->value['fedin']);?>
</td>
      </tr>
      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </table>
  </div>
</div>

<?php if ($_smarty_tpl->tpl_vars['show_defence_stats']->value) {?>
<h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Defenseboard leaders<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
<table cellspacing='0' border='0' width='100%'>
  <tr>
    <th style='width:200px'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Player<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <th style='width:200px'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Total defenses<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
  </tr>

  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['defences_leaders']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['lastname'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['row']->value['teamname'];?>
</td>
    <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['row']->value['games']);?>
</td>
    <td class='center'><?php echo intval($_smarty_tpl->tpl_vars['row']->value['deftotal']);?>
</td>
  </tr>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

</table>
<a href='?view=defensestatus&amp;series=<?php echo $_smarty_tpl->tpl_vars['series_info']->value['series_id'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Defenseboard<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['season_info']->value['showspiritpoints']) {?> <!-- TODO total -->
<h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Spirit points average per category<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
<table cellspacing='0' border='0' width='100%'>
  <tr>
    <th style='width:150px'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <th><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['spirit_categories']->value, 'cat');
$_smarty_tpl->tpl_vars['cat']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->do_else = false;
?>
    <?php if ($_smarty_tpl->tpl_vars['cat']->value['index'] > 0) {?><th class='center'><?php echo $_smarty_tpl->tpl_vars['cat']->value['index'];?>
</th><?php }?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <th class='center'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Tot.<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th>
  </tr>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['spirit_vg']->value, 'team_avg');
$_smarty_tpl->tpl_vars['team_avg']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['team_avg']->value) {
$_smarty_tpl->tpl_vars['team_avg']->do_else = false;
?>
  <td><?php echo $_smarty_tpl->tpl_vars['team_avg']->value['teamname'];?>
</td>
  <td><?php echo $_smarty_tpl->tpl_vars['team_avg']->value['games'];?>
</td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['spirit_categories']->value, 'cat');
$_smarty_tpl->tpl_vars['cat']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->do_else = false;
?>
  <?php if ($_smarty_tpl->tpl_vars['cat']->value['index'] > 0) {?>
  <?php if ($_smarty_tpl->tpl_vars['cat']->value['factor'] != 0) {?>
  <td class='center'><b><?php echo number_format($_smarty_tpl->tpl_vars['team_avg']->value[$_smarty_tpl->tpl_vars['cat']->value['category_id']],2);?>
</b></td>
  <?php } else { ?>
  <td class='center'><?php echo number_format($_smarty_tpl->tpl_vars['team_avg']->value[$_smarty_tpl->tpl_vars['cat']->value['category_id']],2);?>
</td>
  <?php }?>
  <?php }?>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  <td class='center'><b><?php echo number_format($_smarty_tpl->tpl_vars['team_avg']->value['total'],2);?>
</b></td>
  </tr>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>

<ul>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['spirit_categories']->value, 'cat');
$_smarty_tpl->tpl_vars['cat']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->do_else = false;
?>
  <?php if ($_smarty_tpl->tpl_vars['cat']->value['index'] > 0) {?>
  <li><?php echo $_smarty_tpl->tpl_vars['cat']->value['index'];?>
 <?php echo $_smarty_tpl->tpl_vars['cat']->value['text'];?>
</li>
  <?php }?>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</ul>
<?php }?>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
