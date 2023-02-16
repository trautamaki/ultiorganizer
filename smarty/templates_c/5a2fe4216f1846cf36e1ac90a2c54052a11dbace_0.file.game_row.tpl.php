<?php
/* Smarty version 4.3.0, created on 2023-03-01 17:41:10
  from '/var/www/html/smarty/templates/game_row.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff72166f4819_33810863',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5a2fe4216f1846cf36e1ac90a2c54052a11dbace' => 
    array (
      0 => '/var/www/html/smarty/templates/game_row.tpl',
      1 => 1677685124,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63ff72166f4819_33810863 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),1=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
?>
<tr style='width:100%'>
  <?php if ($_smarty_tpl->tpl_vars['date']->value) {?>
  <!-- TODO verify -->
  <td class='game_row_date'><span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['game']->value['time'],"%j.%n.%Y");?>
</span></td>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['time']->value) {?>
  <td class='game_row_time'><span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['game']->value['time'],"%H:%i");?>
</span></td>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['field']->value) {?>
  <?php if (!empty($_smarty_tpl->tpl_vars['game']->value['fieldname'])) {?>
  <td class='game_row_field'><span><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Field<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> <?php echo $_smarty_tpl->tpl_vars['game']->value['fieldname'];?>
</span></td>
  <?php } else { ?>
  <td class='game_row_field'></td>
  <?php }?>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['game']->value['hometeam']) {?>
  <td class='game_row_team'><span><?php echo $_smarty_tpl->tpl_vars['game']->value['hometeamname'];?>
</span></td>
  <?php } else { ?>
  <td class='game_row_team'><span class='schedulingname'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['game']->value['phometeamname'];
$_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></span></td>
  <?php }?>

  <td class='game_row_againstmark'>-</td>

  <?php if ($_smarty_tpl->tpl_vars['game']->value['visitorteam']) {?>
  <td class='game_row_team'><span><?php echo $_smarty_tpl->tpl_vars['game']->value['visitorteamname'];?>
</span></td>
  <?php } else { ?>
  <td class='game_row_team'><span class='schedulingname'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['game']->value['pvisitorteamname'];
$_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></span></td>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['series']->value) {?>
  <td class='game_row_series'><span><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['game']->value['seriesname'];
$_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></span></td>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['pool']->value) {?>
  <td class='game_row_pool'><span><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['game']->value['poolname'];
$_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></span></td>
  <?php }?>

  <?php if (!$_smarty_tpl->tpl_vars['game']->value['hasstarted']) {?>
  <td class='game_row_score'><span>?</span></td>
  <td class='game_row_againstmark'><span>-</span></td>
  <td class='game_row_score'><span>?</span></td>
  <?php } else { ?>
  <?php if ($_smarty_tpl->tpl_vars['game']->value['isongoing']) {?>
  <td class='game_row_score'><span><em><?php echo $_smarty_tpl->tpl_vars['game']->value['homescore'];?>
</em></span></td>
  <td class='game_row_againstmark'><span>-</span></td>
  <td class='game_row_score'><span><em><?php echo $_smarty_tpl->tpl_vars['game']->value['visitorscore'];?>
</em></span></td>
  <?php } else { ?>
  <td class='game_row_score'><span><?php echo $_smarty_tpl->tpl_vars['game']->value['homescore'];?>
</span></td>
  <td class='game_row_againstmark'><span>-</span></td>
  <td class='game_row_score'><span><?php echo $_smarty_tpl->tpl_vars['game']->value['visitorscore'];?>
</span></td>
  <?php }?>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['game']->value['gamename']) {?>
  <td class='game_row_gamename'><span><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['game']->value['gamename'];
$_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></span></td>
  <?php } else { ?>
  <td class='game_row_gamename'></td>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['media']->value) {?>
  <td class='game_row_media' style='white-space: nowrap;'>
    <?php if (count($_smarty_tpl->tpl_vars['game_urls']->value) && intval($_smarty_tpl->tpl_vars['game']->value['isongoing']) || !$_smarty_tpl->tpl_vars['game']->value['hasstarted']) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['game_urls']->value, 'url');
$_smarty_tpl->tpl_vars['url']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['url']->value) {
$_smarty_tpl->tpl_vars['url']->do_else = false;
?>
    <?php if (!empty($_smarty_tpl->tpl_vars['url']->value['name'])) {?>
    <a href='<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
'><img border='0' width='16' height='16' title='<?php echo $_smarty_tpl->tpl_vars['url']->value['name'];?>
' src='images/linkicons/<?php echo $_smarty_tpl->tpl_vars['url']->value['type'];?>
.png' alt='<?php echo $_smarty_tpl->tpl_vars['url']->value['type'];?>
' /></a>
    <?php } else { ?>
    <a href='<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
'><img border='0' width='16' height='16' title='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Live Broadcasting<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' src='images/linkicons/<?php echo $_smarty_tpl->tpl_vars['url']->value['type'];?>
.png' alt='<?php echo $_smarty_tpl->tpl_vars['url']->value['type'];?>
' /></a>
    <?php }?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>
  </td>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['info']->value) {?>
  <?php if (!$_smarty_tpl->tpl_vars['game']->value['hasstarted']) {?>
  <?php if ($_smarty_tpl->tpl_vars['game']->value['hometeam'] && $_smarty_tpl->tpl_vars['game']->value['visitorteam']) {?>
  <?php if ((isset($_smarty_tpl->tpl_vars['xgames']->value)) && count($_smarty_tpl->tpl_vars['xgames']->value) > 0) {?>
  <td class='right' class='game_row_info'>
    <span style='white-space: nowrap'>
      <a href='?view=gamecard&amp;team1=<?php echo $_smarty_tpl->tpl_vars['game']->value['hometeam'];?>
&amp;team2=<?php echo $_smarty_tpl->tpl_vars['game']->value['visitorteam'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?> Game history<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a>
    </span>
  </td>
  <?php } else { ?>
  <td class='left' class='game_row_info'></td>
  <?php }?>
  <?php } else { ?>
  <td class='left' class='game_row_info'></td>
  <?php }?>
  <?php } else { ?>
  <?php if (!intval($_smarty_tpl->tpl_vars['game']->value['isongoing'])) {?>
  <?php if (intval($_smarty_tpl->tpl_vars['game']->value['scoresheet'])) {?>
  <td class='right' class='game_row_info'>
    <span>&nbsp;<a href='?view=gameplay&amp;game=<?php echo $_smarty_tpl->tpl_vars['game']->value['game_id'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Game play<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a></span>
  </td>
  <?php } else { ?>
  <td class='left' class='game_row_info'></td>
  <?php }?>
  <?php } else { ?>
  <?php if (intval($_smarty_tpl->tpl_vars['game']->value['scoresheet'])) {?>
  <td class='right' class='game_row_info'>
    <span>&nbsp;&nbsp;<a href='?view=gameplay&amp;game=<?php echo $_smarty_tpl->tpl_vars['game']->value['game_id'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Ongoing<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a></span>
  </td>
  <?php } else { ?>
  <td class='right' class='game_row_info'>&nbsp;&nbsp;<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Ongoing<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
  <?php }?>
  <?php }?>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['rss']->value) {?>
  <td class='feed-list'>
    <a style='color: #ffffff;' href='ext/rss.php?feed=game&amp;id1=<?php echo $_smarty_tpl->tpl_vars['game']->value['game_id'];?>
'>
      <img src='images/feed-icon-14x14.png' width='10' height='10' alt='RSS' />
    </a>
  </td>
  <?php }?>
  <?php }?>
</tr><?php }
}
