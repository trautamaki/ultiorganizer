<?php
/* Smarty version 4.3.0, created on 2023-03-03 10:47:50
  from '/var/www/html/smarty/templates/admin/addseasons.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6401b436045123_36967439',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '904daff272b6a8d1c33a908f6eddb920e650cc1a' => 
    array (
      0 => '/var/www/html/smarty/templates/admin/addseasons.tpl',
      1 => 1677833269,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:leftmenu.tpl' => 1,
    'file:translated_field.tpl' => 1,
    'file:translation_script.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_6401b436045123_36967439 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),1=>array('file'=>'/var/www/html/lib/smarty/plugins/block.u.php','function'=>'smarty_block_u',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo $_smarty_tpl->tpl_vars['yuiload']->value;?>


<link rel="stylesheet" type="text/css" href="script/yui/calendar/calendar.css" />

<?php echo '<script'; ?>
 type="text/javascript">
	YAHOO.namespace("calendar");

	YAHOO.calendar.init = function() {

		YAHOO.calendar.cal1 = new YAHOO.widget.Calendar("cal1", "calContainer1");
		YAHOO.calendar.cal2 = new YAHOO.widget.Calendar("cal2", "calContainer2");
		YAHOO.calendar.cal3 = new YAHOO.widget.Calendar("cal3", "calContainer3");
		YAHOO.calendar.cal1.cfg.setProperty("START_WEEKDAY", "1");
		YAHOO.calendar.cal2.cfg.setProperty("START_WEEKDAY", "1");
		YAHOO.calendar.cal3.cfg.setProperty("START_WEEKDAY", "1");
		YAHOO.calendar.cal1.render();
		YAHOO.calendar.cal2.render();
		YAHOO.calendar.cal3.render();

		function handleCal1Button(e) {
			var containerDiv = YAHOO.util.Dom.get("calContainer1");

			if (containerDiv.style.display == "none") {
				updateCal("seasonstarttime", YAHOO.calendar.cal1);
				YAHOO.calendar.cal1.show();
			} else {
				YAHOO.calendar.cal1.hide();
			}
		}

		function handleCal2Button(e) {
			var containerDiv = YAHOO.util.Dom.get("calContainer2");

			if (containerDiv.style.display == "none") {
				var txtDate1 = document.getElementById("seasonendtime");
				if (txtDate1.value != "") {
					updateCal("seasonendtime", YAHOO.calendar.cal2);
				} else {
					updateCal("seasonstarttime", YAHOO.calendar.cal2);
				}
				YAHOO.calendar.cal2.show();
			} else {
				YAHOO.calendar.cal2.hide();
			}
		}

		function handleCal3Button(e) {
			var containerDiv = YAHOO.util.Dom.get("calContainer3");

			if (containerDiv.style.display == "none") {
				var txtDate1 = document.getElementById("enrollendtime");
				if (txtDate1.value != "") {
					updateCal("enrollendtime", YAHOO.calendar.cal3);
				} else {
					updateCal("seasonstarttime", YAHOO.calendar.cal3);
				}
				YAHOO.calendar.cal3.show();
			} else {
				YAHOO.calendar.cal3.hide();
			}
		}
		// Listener to show the Calendar when the button is clicked
		YAHOO.util.Event.addListener("showcal1", "click", handleCal1Button);
		YAHOO.util.Event.addListener("showcal2", "click", handleCal2Button);
		YAHOO.util.Event.addListener("showcal3", "click", handleCal3Button);
		YAHOO.calendar.cal1.hide();
		YAHOO.calendar.cal2.hide();
		YAHOO.calendar.cal3.hide();

		function handleSelect1(type, args, obj) {
			var dates = args[0];
			var date = dates[0];
			var year = date[0],
				month = date[1],
				day = date[2];

			var txtDate1 = document.getElementById("seasonstarttime");
			txtDate1.value = day + "." + month + "." + year;
		}

		function handleSelect2(type, args, obj) {
			var dates = args[0];
			var date = dates[0];
			var year = date[0],
				month = date[1],
				day = date[2];

			var txtDate1 = document.getElementById("seasonendtime");
			txtDate1.value = day + "." + month + "." + year;
		}

		function handleSelect3(type, args, obj) {
			var dates = args[0];
			var date = dates[0];
			var year = date[0],
				month = date[1],
				day = date[2];

			var txtDate1 = document.getElementById("enrollendtime");
			txtDate1.value = day + "." + month + "." + year;
		}

		function updateCal(input, obj) {
			var txtDate1 = document.getElementById(input);
			if (txtDate1.value != "") {
				var date = txtDate1.value.split(".");
				obj.select(date[1] + "/" + date[0] + "/" + date[2]);
				obj.cfg.setProperty("pagedate", date[1] + "/" + date[2]);
				obj.render();
			}
		}

		YAHOO.calendar.cal1.selectEvent.subscribe(handleSelect1, YAHOO.calendar.cal1, true);
		YAHOO.calendar.cal2.selectEvent.subscribe(handleSelect2, YAHOO.calendar.cal2, true);
		YAHOO.calendar.cal3.selectEvent.subscribe(handleSelect3, YAHOO.calendar.cal3, true);
	}
	YAHOO.util.Event.onDOMReady(YAHOO.calendar.init);
<?php echo '</script'; ?>
>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['warnings']->value, 'warning');
$_smarty_tpl->tpl_vars['warning']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['warning']->value) {
$_smarty_tpl->tpl_vars['warning']->do_else = false;
?>
<p class="warning"><?php echo $_smarty_tpl->tpl_vars['warning']->value;?>
</p>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<?php if (empty($_smarty_tpl->tpl_vars['season_id']->value)) {?>
<h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add new season/tournament<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
<form method='post' action='?view=admin/addseasons'>
<?php } else { ?>
<h2><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Edit season/tournament<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?></h2>
<form method='post' action='?view=admin/addseasons&amp;season=<?php echo $_smarty_tpl->tpl_vars['season_id']->value;?>
'>
  <?php }?>
  <table border='0'>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Event id<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <input class='input' name='season_id' <?php echo $_smarty_tpl->tpl_vars['season_id_disabled']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['sp']->value['season_id'];?>
' />
      </td>
    </tr>
    <tr rowspan='2'>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Name<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td><?php $_smarty_tpl->_subTemplateRender("file:translated_field.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field_name'=>"seasonname",'value'=>$_smarty_tpl->tpl_vars['sp']->value['name']), 0, false);
?></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Type<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <select class='dropdown' name='type'>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['types']->value, 'type');
$_smarty_tpl->tpl_vars['type']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->do_else = false;
?>
          <option class='dropdown' <?php if ($_smarty_tpl->tpl_vars['sp']->value['type'] == $_smarty_tpl->tpl_vars['type']->value) {?> selected='selected' <?php }?> value='$type'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('u', array());
$_block_repeat=true;
echo smarty_block_u(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['type']->value;
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
ob_start();?>Tournament<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <input class='input' type='checkbox' name='istournament' <?php if ($_smarty_tpl->tpl_vars['sp']->value['istournament']) {?> checked='checked' <?php }?> />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>International<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <input class='input' type='checkbox' name='isinternational' <?php if ($_smarty_tpl->tpl_vars['sp']->value['isinternational']) {?> checked='checked' <?php }?> />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>For national teams<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <input class='input' type='checkbox' name='isnationalteams' <?php if ($_smarty_tpl->tpl_vars['sp']->value['isnationalteams']) {?> checked='checked' <?php }?> />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Spirit mode<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <select class='dropdown' id='spiritmode' name='spiritmode'>
          <option value='0'></option>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['spiritmodes']->value, 'mode');
$_smarty_tpl->tpl_vars['mode']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['mode']->value) {
$_smarty_tpl->tpl_vars['mode']->do_else = false;
?>
          <option <?php if ($_smarty_tpl->tpl_vars['sp']->value['spiritmode'] == $_smarty_tpl->tpl_vars['mode']->value['mode']) {?> selected='selected' <?php }?> value='<?php echo $_smarty_tpl->tpl_vars['mode']->value['mode'];?>
'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo $_smarty_tpl->tpl_vars['mode']->value['name'];
$_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
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
ob_start();?>Spirit points visible<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <input class='input' type='checkbox' name='showspiritpoints' <?php if ($_smarty_tpl->tpl_vars['sp']->value['showspiritpoints']) {?> checked='checked' <?php }?> />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Organizer<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <input class='input' size='50' maxlength='50' name='organizer' value='<?php echo $_smarty_tpl->tpl_vars['sp']->value['organizer'];?>
' />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Category<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <input class='input' size='50' maxlength='50' name='category' value='<?php echo $_smarty_tpl->tpl_vars['sp']->value['category'];?>
' />
      </td>
    </tr>
    <tr>
      <td class='infocell' style='vertical-align:top'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
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
      <td>
        <textarea class='input' rows='10' cols='70' name='comment'><?php echo $_smarty_tpl->tpl_vars['comment']->value;?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Timezone<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <select class='dropdown' id='timezone' name='timezone'>
          <option value=''></option>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dateTimeZone']->value, 'tz');
$_smarty_tpl->tpl_vars['tz']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['tz']->value) {
$_smarty_tpl->tpl_vars['tz']->do_else = false;
?>
          <option <?php if ($_smarty_tpl->tpl_vars['sp']->value['timezone'] == $_smarty_tpl->tpl_vars['tz']->value) {?> selected='selected' <?php }?> value='<?php echo $_smarty_tpl->tpl_vars['tz']->value;?>
'>
            <?php echo $_smarty_tpl->tpl_vars['tz']->value;?>

          </option>
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
ob_start();?>Starts<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> (<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>dd.mm.yyyy<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>): </td>
      <td>
        <input class='input' size='12' maxlength='10' id='seasonstarttime' name='seasonstarttime' value='<?php echo $_smarty_tpl->tpl_vars['sp']->value['starttime_shortdate'];?>
'/>&nbsp;&nbsp;
        <button type='button' class='button' id='showcal1'>
        <img width='12px' height='10px' src='images/calendar.gif' alt='cal'/></button>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><div id='calContainer1'></div></td>
    </tr>
    <tr><td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Ends<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> (<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>dd.mm.yyyy<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>): </td>
      <td>
        <input class='input' size='12' maxlength='10' id='seasonendtime' name='seasonendtime' value='<?php echo $_smarty_tpl->tpl_vars['sp']->value['endtime_shortdate'];?>
'/>&nbsp;&nbsp;
        <button type='button' class='button' id='showcal2'>
          <img width='12px' height='10px' src='images/calendar.gif' alt='cal'/>
        </button>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><div id='calContainer2'></div></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Open for enrollment<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td>
        <input class='input' type='checkbox' name='enrollopen' <?php if ($_smarty_tpl->tpl_vars['sp']->value['enrollopen']) {?> checked='checked' <?php }?> />
      </td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Enrolling ends<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?><br/>(<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>only informational<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>): </td>
      <td>
        <input class='input' size='12' maxlength='10' id='enrollendtime' name='enrollendtime'  value='<?php echo $_smarty_tpl->tpl_vars['sp']->value['enroll_deadline_shortdate'];?>
'/>&nbsp;&nbsp;
        <button type='button' class='button' id='showcal3'>
          <img width='12px' height='10px' src='images/calendar.gif' alt='cal'/>
        </button>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><div id='calContainer3'></div></td>
    </tr>
    <tr>
      <td class='infocell'><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Shown in main menu<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>: </td>
      <td><input class='input' type='checkbox' name='iscurrent' <?php if ($_smarty_tpl->tpl_vars['sp']->value['iscurrent']) {?> checked='checked' <?php }?> /></td>
    </tr>
  </table>
  <p>
  <?php if (empty($_smarty_tpl->tpl_vars['season_id']->value)) {?>
    <input class='button' type='submit' name='add' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Add<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' />
  <?php } else { ?>
    <input class='button' type='submit' name='save' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Save<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' />
  <?php }?>
    <input type='hidden' name='backurl' value='<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
'/>
    <input class='button' type='button' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Return<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' onclick="window.location.href='<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
'" />
  </p>
</form>

<?php $_smarty_tpl->_subTemplateRender("file:translation_script.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field_name'=>"seasonname"), 0, false);
?>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
