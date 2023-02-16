<?php
/* Smarty version 4.3.0, created on 2023-03-03 11:47:09
  from '/var/www/html/smarty/templates/footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401c21d41dd44_10120423',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb0a5a185b9942f76a1d2dd3dcca785128e9d5af' => 
    array (
      0 => '/var/www/html/smarty/templates/footer.tpl',
      1 => 1677836823,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6401c21d41dd44_10120423 (Smarty_Internal_Template $_smarty_tpl) {
?>            </div><!--content-->
          </td>
        </tr>
      </table>
    </div><!--page_middle-->
    <?php if ($_smarty_tpl->tpl_vars['enable_facebook']->value) {?>
    <?php echo '<script'; ?>
 src='http://connect.facebook.net/en_US/all.js'><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
      FB.init({
        appId: '<?php echo $_smarty_tpl->tpl_vars['fb_app_id']->value;?>
',
        status: true,
        cookie: true,
        xfbml: true
      });
      FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });
    <?php echo '</script'; ?>
>
    <?php }?>
    <div class='page_bottom'></div>
    </div>
  </body>
</html><?php }
}
