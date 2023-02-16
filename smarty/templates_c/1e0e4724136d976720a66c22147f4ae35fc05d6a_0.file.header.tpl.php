<?php
/* Smarty version 4.3.0, created on 2023-03-03 11:47:09
  from '/var/www/html/smarty/templates/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401c21d3dea58_19754115',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1e0e4724136d976720a66c22147f4ae35fc05d6a' => 
    array (
      0 => '/var/www/html/smarty/templates/header.tpl',
      1 => 1677836823,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6401c21d3dea58_19754115 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="-1" />
  <link rel='icon' type='image/png' href='cust/<?php echo $_smarty_tpl->tpl_vars['cust']->value;?>
/favicon.png' />
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stylesheets']->value, 'stylesheet');
$_smarty_tpl->tpl_vars['stylesheet']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['stylesheet']->value) {
$_smarty_tpl->tpl_vars['stylesheet']->do_else = false;
?>
  <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['stylesheet']->value;?>
" type="text/css" />
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  <?php echo '<script'; ?>
 src='script/ultiorganizer.js'><?php echo '</script'; ?>
>
  <title><?php echo (($tmp = $_smarty_tpl->tpl_vars['page_title']->value ?? null)===null||$tmp==='' ? "no title" ?? null : $tmp);?>
 <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
</head>
<!-- TODO printable -->

<body style='overflow-y:scroll;' <?php echo (($tmp = $_smarty_tpl->tpl_vars['body_functions']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
>
  <div class='page'>
    <div class='page_top'>
      <div class='top_banner_space'></div>
      <form action='?<?php echo $_smarty_tpl->tpl_vars['query_string']->value;?>
' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' style='width:100%;white-space: nowrap;'>
          <tr>
            <td class='topheader_left'>
              <?php echo $_smarty_tpl->tpl_vars['page_header']->value;?>
 <!-- TODO convert to templates/cust/ -->
            </td>
            <td class='topheader_right'>
              <table border='0' cellpadding='0' cellspacing='0' style='width:95%;white-space: nowrap;'>
                <tr>
                  <td class='right' style='vertical-align:top;'>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['locales']->value, 'locale');
$_smarty_tpl->tpl_vars['locale']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['locale']->value) {
$_smarty_tpl->tpl_vars['locale']->do_else = false;
?>
                    <a href='?<?php echo $_smarty_tpl->tpl_vars['locale']->value['query_string'];?>
&amp;locale=<?php echo $_smarty_tpl->tpl_vars['locale']->value['localestr'];?>
'>
                      <img class='localeselection' src='locale/<?php echo $_smarty_tpl->tpl_vars['locale']->value['localestr'];?>
/flag.png' alt='<?php echo $_smarty_tpl->tpl_vars['locale']->value['localename'];?>
' />
                    </a>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                  </td>
                </tr>
                <tr>
                  <td class='right' style='padding-top:5px'>
                    <?php if ($_smarty_tpl->tpl_vars['enable_facebook']->value) {?>
                    <div id='fb-root'></div>
                    <fb:login-button perms='email,publish_stream,offline_access' />
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['user_anonymous']->value) {?>
                    <input class='input' type='text' id='myusername' name='myusername' size='10' style='border:1px solid #555555' />&nbsp;
                    <input class='input' type='password' id='mypassword' name='mypassword' size='10' style='border:1px solid #555555' />&nbsp;
                    <input class='button' type='submit' name='login' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Login<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' style='border:1px solid #000000' />&nbsp;
                    <span class='topheadertext'><a class='topheaderlink' href='?view=register'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>New user?<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a></span>
                    <?php } else { ?>
                    <span class='topheadertext'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>User<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: <a class='topheaderlink' href='?view=user/userinfo'><?php echo $_smarty_tpl->tpl_vars['user_info']->value['name'];?>
</a></span>&nbsp;
                    <span class='topheadertext'><a class='topheaderlink' href='?view=logout'>&raquo; <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Logout<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a></span>
                    <?php }?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </form>
    </div><!--page_top-->
    <div class='navigation_bar'>
      <p class='navigation_bar_text'>
        <?php echo $_smarty_tpl->tpl_vars['navigation_bar']->value;?>

      </p>
    </div>
    <div class='page_middle'><?php }
}
