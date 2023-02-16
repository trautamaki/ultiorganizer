<?php
/* Smarty version 4.3.0, created on 2023-03-02 17:34:11
  from '/var/www/html/smarty/templates/admin/addseasonpools.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6400c1f326f4c7_89332848',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0bece89efd6a66b0b9aef229c5def5e8c7d5a7cd' => 
    array (
      0 => '/var/www/html/smarty/templates/admin/addseasonpools.tpl',
      1 => 1677771247,
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
function content_6400c1f326f4c7_89332848 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo $_smarty_tpl->tpl_vars['yui_load']->value;?>


<style type="text/css">
  #colorcontainer {
    position: relative;
    padding: 6px;
    background-color: #eeeeee;
    width: 300px;
    height: 180px;
  }
</style>

<?php echo '<script'; ?>
 type="text/javascript">
  (function() {
    var Event = YAHOO.util.Event,
      picker;

    Event.onDOMReady(function() {
      picker = new YAHOO.widget.ColorPicker("colorcontainer", {
        showhsvcontrols: false,
        showhexcontrols: true,
        showhexsummary: false,
        showrgbcontrols: false,
        showwebsafe: false,
        images: {
          PICKER_THUMB: "styles/yui/colorpicker/assets/picker_thumb.png",
          HUE_THUMB: "styles/yui/colorpicker/assets/hue_thumb.png"
        }
      });
      picker.setValue([<?php echo '<?php'; ?>

                        echo hexdec(substr(<?php echo $_smarty_tpl->tpl_vars['pp']->value['color'];?>
, 0, 2)) . ", ";
                        echo hexdec(substr(<?php echo $_smarty_tpl->tpl_vars['pp']->value['color'];?>
, 2, 2)) . ", ";
                        echo hexdec(substr(<?php echo $_smarty_tpl->tpl_vars['pp']->value['color'];?>
, 4, 2));
                        <?php echo '?>'; ?>
], true);
      var onRgbChange = function(o) {
        var val = picker.get("hex");
        YAHOO.util.Dom.get('color').value = val;
        var btn = YAHOO.util.Dom.get('showcolor');
        YAHOO.util.Dom.setStyle(btn, "background-color", "#" + val);
      }

      //subscribe to the rgbChange event;
      picker.on("rgbChange", onRgbChange);

      var handleColorButton = function() {
        var containerDiv = YAHOO.util.Dom.get("colorcontainer");
        if (containerDiv.style.display == "none") {
          YAHOO.util.Dom.setStyle(containerDiv, "display", "block");
        } else {
          YAHOO.util.Dom.setStyle(containerDiv, "display", "none");
        }
      }
      YAHOO.util.Event.addListener("showcolor", "click", handleColorButton);

    });
  })();
<?php echo '</script'; ?>
>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['messages']->value, 'message');
$_smarty_tpl->tpl_vars['message']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['message']->value) {
$_smarty_tpl->tpl_vars['message']->do_else = false;
?>
<p <?php echo $_smarty_tpl->tpl_vars['message']->value['class'];?>
><?php echo $_smarty_tpl->tpl_vars['message']->value['message'];?>
</p>
<hr/>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<?php if (!$_smarty_tpl->tpl_vars['pool_id']->value || $_smarty_tpl->tpl_vars['addmore']->value) {?>
<h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add pool<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
<form method='post' action='?view=admin/addseasonpools&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
&amp;series=<?php echo $_smarty_tpl->tpl_vars['series_id']->value;?>
'>
  <table cellpadding='2'>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Name<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><?php echo $_smarty_tpl->tpl_vars['name_translated']->value;?>
</td>
      </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Order<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> (A,B,C,D ...):</td>
      <td><input class='input' id='ordering' name='ordering' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['ordering'];?>
'/></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Template<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <select class='dropdown' name='template'>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['templates']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>      
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['template']->value == $_smarty_tpl->tpl_vars['row']->value['template_id']) {?> selected='selected' <?php }?> value='<?php echo $_smarty_tpl->tpl_vars['row']->value['template_id'];?>
'>
              <?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>

          </option>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </select>
      </td>
    </tr>
  </table>
  <p>
    <input class='button' name='add' type='submit' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>'/>
    <input class='button' type='button' name='takaisin'  value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Return<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' onclick="window.location.href='?view=admin/seasonpools&amp;season=$season'"/>
  </p>
</form>
<?php } else { ?> <!-- !$pool_id || $addmore -->
  <h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Edit pool<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</h2>
  <form method='post' action='?view=admin/addseasonpools&amp;pool=<?php echo $_smarty_tpl->tpl_vars['pool_id']->value;?>
&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
'>
  <table cellpadding='2'>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Name<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><?php echo $_smarty_tpl->tpl_vars['name_translated']->value;?>
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
      <td><input class='input' id='series' name='series' disabled='disabled' value='<?php echo $_smarty_tpl->tpl_vars['seriesname']->value;?>
'/></td>
      <td></td>
    </tr>

    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Order<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> (A,B,C,D ...):</td>
      <td><input class='input' id='ordering' name='ordering' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['ordering'];?>
'/></td>
    </tr>

    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Type<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <select class='dropdown' name='type'>
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['pp']->value['type'] == "1") {?> selected='selected' <?php }?> value='1'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Round Robin<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['pp']->value['type'] == "2") {?> selected='selected' <?php }?> value='2'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Play-off<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['pp']->value['type'] == "3") {?> selected='selected' <?php }?> value='3'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Swissdraw<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['pp']->value['type'] == "4") {?> selected='selected' <?php }?> value='4'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Crossmatch<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
          
          <tr><td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Special playoff template<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
          <td><input class='input' id='playoff_template' name='playoff_template' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['playoff_template'];?>
'/></td></tr>

         </select>
        </td>
      </tr>
      <tr>
        <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Move games<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
        <td>
          <select class='dropdown' name='mvgames'>
            <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['pp']->value['mvgames'] == "0") {?> selected='selected' <?php }?> value='0'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>All<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
            <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['pp']->value['mvgames'] == "1") {?> selected='selected' <?php }?> value='1'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Nothing<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
            <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['pp']->value['mvgames'] == "2") {?> selected='selected' <?php }?> value='2'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Mutual<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
          </select>
        </td>
      </tr>
      <tr>
        <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Visible<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
        <!-- CS: Sometimes you want to change the visibility setting in Swissdraw -->
        <?php ob_start();
echo $_smarty_tpl->tpl_vars['pp']->value['ordering'];
$_prefixVariable1 = ob_get_clean();
if (rtrim($_smarty_tpl->tpl_vars['frompoolinfo']->value['ordering'],"0..9") == rtrim($_prefixVariable1,"0..9")) {?> <!-- Playoff or Swissdraw -->
        <td>
          <input class='input' disabled='disabled' type='checkbox' id='visible' name='visible'/>
        </td>
        <?php } else { ?>
        <td>
          <input class='input' type='checkbox' id='visible' name='visible' <?php if (intval($_smarty_tpl->tpl_vars['pp']->value['visible'])) {?> checked='checked' <?php }?>/>
        </td>
        <?php }?>
        <td></td>
      </tr>
      <tr>
        <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Played<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
        <td><input class='input' type='checkbox' id='played' name='played' <?php if (intval($_smarty_tpl->tpl_vars['pp']->value['played'])) {?> checked='checked' <?php }?>/></td>
        <td></td>
      </tr>
      <tr>
        <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Continuing pool<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
        <?php ob_start();
echo $_smarty_tpl->tpl_vars['pp']->value['ordering'];
$_prefixVariable2 = ob_get_clean();
if (rtrim($_smarty_tpl->tpl_vars['frompoolinfo']->value['ordering'],"0..9") == rtrim($_prefixVariable2,"0..9")) {?> <!-- Playoff or Swissdraw -->
        <td>
          <input class='input' disabled='disabled' type='checkbox' id='continuationserie' name='continuationserie' checked='checked'/>
        </td>
        <?php } else { ?>
        <?php if (intval($_smarty_tpl->tpl_vars['pp']->value['continuingpool'])) {?>
        <td>
          <input class='input' type='checkbox' id='continuationserie' name='continuationserie' checked='checked'/>
        </td>
        <?php } else { ?>
        <td>
          <input class='input' type='checkbox' id='continuationserie' name='continuationserie' />
        </td>
        <?php }?>
        <?php }?>
        <td></td>
      </tr>
      <tr>
        <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Placement pool<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
        <td>
          <input class='input' type='checkbox' id='placementpool' name='placementpool' <?php if (intval($_smarty_tpl->tpl_vars['pp']->value['placementpool'])) {?> checked='checked' <?php }?>/>
        </td>
        <td></td>
      </tr>
      <?php if (intval($_smarty_tpl->tpl_vars['pp']->value['continuingpool'])) {?>
      <tr>
        <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Initial moves<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
        <td><a href='?view=admin/poolmoves&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
&amp;series=<?php echo $_smarty_tpl->tpl_vars['pp']->value['series'];?>
&amp;pool=<?php echo $_smarty_tpl->tpl_vars['pool_id']->value;?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>select<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></a></td>
        <td></td>
      </tr>
      <?php }?>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Color<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <input class='input' type='hidden' id='color' name='color' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['color'];?>
'/>
        <button type='button' id='showcolor' class='button' style='background-color:#<?php echo $_smarty_tpl->tpl_vars['pp']->value['color'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Select<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></button>
      </td>
      <td></td>
    </tr>
    <tr>
      <td class='infocell' style='vertical-align:top'>"<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Comment (you can use <?php echo "<b>";?>
, <?php echo "<em>";?>
, and <?php echo "<br />";?>
 tags)<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><textarea class='input' rows='10' cols='70' id='comment' name='comment'><?php echo $_smarty_tpl->tpl_vars['comment']->value;?>
</textarea></td>
    </tr>
  </table>
  <div class='yui-skin-sam' id='colorcontainer' style='display:none'></div>

  <h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Teams<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</h2>

  <?php if (count($_smarty_tpl->tpl_vars['teams']->value)) {?>
  <table width='75%' cellpadding='4'><tr><th><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Name<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th><th><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Club<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></th></tr>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['teams']->value, 'team');
$_smarty_tpl->tpl_vars['team']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['team']->value) {
$_smarty_tpl->tpl_vars['team']->do_else = false;
?>
    <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['team']->value['name'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['team']->value['clubname'];?>
</td>
    </tr>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </table>
  <?php } else { ?>
  <p><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>No teams<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></p>
  <?php }?>

  <h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Rules<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>(from the selected template)<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</h2>

  <table cellpadding='2'>
    <tr>
    <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Game points<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='gameto' name='gameto' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['winningscore'];?>
'/></td>
      <td></td>
    </tr>

    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Half-time<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='halftimelength' name='halftimelength' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['halftime'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>minutes<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    </tr>		

    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Half-time at point<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='halftimepoint' name='halftimepoint' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['halftimescore'];?>
'/></td>
      <td></td>
    </tr>		
      
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Time cap<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='timecap' name='timecap' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['timecap'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>minutes<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Time slot<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='timeslot' name='timeslot' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['timeslot'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>minutes<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Point cap<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='pointcap' name='pointcap' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['scorecap'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>points<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Additional points after time cap<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='extrapoint' name='extrapoint' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['addscore'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>points<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Time between points<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='timebetweenPoints' name='timebetweenPoints' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['betweenpointslen'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>seconds<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td></tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Time-outs<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='timeouts' name='timeouts' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['timeouts'];?>
'/></td>
      <td>
        <select class='dropdown' name='timeoutsfor'>
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['pp']->value['timeoutsper'] == "game" || $_smarty_tpl->tpl_vars['pp']->value['timeoutsper'] == '') {?> selected='selected' <?php }?> value='game'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>per game<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['pp']->value['timeoutsper'] == "half") {?> selected='selected' <?php }?> value='half'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>per half<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Time-out duration<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='timeoutlength' name='timeoutlength' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['timeoutlen'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>seconds<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Time-outs in overtime<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='timeoutsOnOvertime' name='timeoutsOnOvertime' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['timeoutsovertime'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>per team<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Forfeit/BYE against<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='forfeitagainst' name='forfeitagainst' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['forfeitagainst'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>points for the team giving up / BYE<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Forfeit/BYE score<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><input class='input' id='forfeitscore' name='forfeitscore' value='<?php echo $_smarty_tpl->tpl_vars['pp']->value['forfeitscore'];?>
'/></td>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>points for their remaining opponent<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Draws allowed<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <?php if (intval($_smarty_tpl->tpl_vars['pp']->value['drawsallowed'])) {?>
      <td><input class='input' type='checkbox' id='drawsallowed' name='drawsallowed' checked='checked'/></td>
      <?php } else { ?>
      <td><input class='input' type='checkbox' id='drawsallowed' name='drawsallowed' /></td>
      <?php }?>
      <td></td>
    </tr>
  </table>

  <p>
    <input class='button' name='save' type='submit' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Save<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>'/>
    <input class='button' type='button' name='back'  value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Return<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' onclick="window.location.href='?view=admin/seasonpools&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
'"/>
  </p>
</form>
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['name_translationscript']->value;?>


<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
