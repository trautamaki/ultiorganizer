<?php
/* Smarty version 4.3.0, created on 2023-03-01 17:41:10
  from '/var/www/html/smarty/templates/games/tournament_view.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff72166e3493_75826569',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6e8a292ca7513e4f38185a53d15413495bf6dd04' => 
    array (
      0 => '/var/www/html/smarty/templates/games/tournament_view.tpl',
      1 => 1677685124,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:game_row.tpl' => 1,
  ),
),false)) {
function content_63ff72166e3493_75826569 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.u.php','function'=>'smarty_block_u',),));
$_smarty_tpl->_assignInScope('is_table_open', false);
$_smarty_tpl->_assignInScope('prev_place', '');
$_smarty_tpl->_assignInScope('prev_pool', '');
$_smarty_tpl->_assignInScope('prev_date', '');
$_smarty_tpl->_assignInScope('prev_tournament', '');?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['games']->value, 'game');
$_smarty_tpl->tpl_vars['game']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['game']->value) {
$_smarty_tpl->tpl_vars['game']->do_else = false;
?>
<!-- res:<?php echo $_smarty_tpl->tpl_vars['game']->value['reservationgroup'];?>
 pool:<?php echo $_smarty_tpl->tpl_vars['game']->value['pool'];?>
 date:<?php echo $_smarty_tpl->tpl_vars['game']->value['starttime_justdate'];?>
 -->
<?php if ($_smarty_tpl->tpl_vars['game']->value['reservationgroup'] != $_smarty_tpl->tpl_vars['prev_tournament']->value || (empty($_smarty_tpl->tpl_vars['game']->value['reservationgroup']) && !$_smarty_tpl->tpl_vars['is_table_open']->value)) {
if ($_smarty_tpl->tpl_vars['is_table_open']->value) {?>
</table>
<hr>
<?php $_smarty_tpl->_assignInScope('is_table_open', false);
}
if ($_smarty_tpl->tpl_vars['grouping']->value) {?>
<h1><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['game']->value['reservationgroup'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h1>
<?php }
$_smarty_tpl->_assignInScope('prev_place', '');
}?>

<?php if ($_smarty_tpl->tpl_vars['game']->value['starttime_justdate'] != $_smarty_tpl->tpl_vars['prev_date']->value || $_smarty_tpl->tpl_vars['game']->value['place_id'] != $_smarty_tpl->tpl_vars['prev_place']->value) {
if ($_smarty_tpl->tpl_vars['is_table_open']->value) {?>
</table>
<?php $_smarty_tpl->_assignInScope('is_table_open', false);
}?>
<h3>
  <?php echo $_smarty_tpl->tpl_vars['game']->value['starttime_defweekdate'];?>

  <a href='?view=reservationinfo&amp;reservation=<?php echo $_smarty_tpl->tpl_vars['game']->value['reservation_id'];?>
'>
    <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['game']->value['placename'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
  </a>
</h3>
<?php $_smarty_tpl->_assignInScope('prev_pool', '');
}?>

<?php if ($_smarty_tpl->tpl_vars['game']->value['pool'] != $_smarty_tpl->tpl_vars['prev_pool']->value) {
if ($_smarty_tpl->tpl_vars['is_table_open']->value) {?>
</table>
<?php $_smarty_tpl->_assignInScope('is_table_open', false);
}?>
<table cellpadding='2' border='0' cellspacing='0'>
  <?php $_smarty_tpl->_assignInScope('is_table_open', true);?>
  <tr style='width:100%'>
    <th align='left' colspan='12'>
      <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['game']->value['seriesname'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['game']->value['poolname'];
$_block_repeat=false;
echo smarty_block_u(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
    </th>
  </tr>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['is_table_open']->value) {?>
  <?php ob_start();
echo $_smarty_tpl->tpl_vars['rss']->value;
$_prefixVariable1 = ob_get_clean();
$_smarty_tpl->_subTemplateRender("file:game_row.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('game'=>$_smarty_tpl->tpl_vars['game']->value,'game_urls'=>array(),'date'=>false,'time'=>true,'field'=>true,'series'=>false,'pool'=>false,'info'=>true,'rss'=>$_prefixVariable1,'media'=>true), 0, true);
?>
  <?php }?>

  <?php $_smarty_tpl->_assignInScope('prev_tournament', $_smarty_tpl->tpl_vars['game']->value['reservationgroup']);?>
  <?php $_smarty_tpl->_assignInScope('prev_place', $_smarty_tpl->tpl_vars['game']->value['place_id']);?>
  <?php $_smarty_tpl->_assignInScope('prev_pool', $_smarty_tpl->tpl_vars['game']->value['pool']);?>
  <?php $_smarty_tpl->_assignInScope('prev_date', $_smarty_tpl->tpl_vars['game']->value['starttime_justdate']);?>
  
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

  <?php if ($_smarty_tpl->tpl_vars['is_table_open']->value) {?>
</table>
<?php }
}
}
