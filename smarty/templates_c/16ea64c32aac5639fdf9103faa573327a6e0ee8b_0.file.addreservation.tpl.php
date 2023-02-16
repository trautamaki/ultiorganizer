<?php
/* Smarty version 4.3.0, created on 2023-03-01 19:28:07
  from '/var/www/html/smarty/templates/admin/addreservation.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ff8b27c69de7_77197005',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '16ea64c32aac5639fdf9103faa573327a6e0ee8b' => 
    array (
      0 => '/var/www/html/smarty/templates/admin/addreservation.tpl',
      1 => 1677691685,
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
function content_63ff8b27c69de7_77197005 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/lib/smarty/plugins/block.t.php','function'=>'smarty_block_t',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:leftmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<link rel="stylesheet" type="text/css" href="script/yui/calendar/calendar.css" />

<?php echo $_smarty_tpl->tpl_vars['yuiload']->value;?>


<?php echo $_smarty_tpl->tpl_vars['reservation_messages']->value;?>


<?php echo '<script'; ?>
 type="text/javascript">
  YAHOO.namespace("calendar");

  YAHOO.calendar.init = function() {

    YAHOO.calendar.cal1 = new YAHOO.widget.Calendar("cal1", "calContainer1");
    YAHOO.calendar.cal1.cfg.setProperty("START_WEEKDAY", "1");
    YAHOO.calendar.cal1.render();

    function handleCal1Button(e) {
      var containerDiv = YAHOO.util.Dom.get("calContainer1");

      if (containerDiv.style.display == "none") {
        updateCal("date", YAHOO.calendar.cal1);
        YAHOO.calendar.cal1.show();
      } else {
        YAHOO.calendar.cal1.hide();
      }
    }

    // Listener to show the Calendar when the button is clicked
    YAHOO.util.Event.addListener("showcal1", "click", handleCal1Button);
    YAHOO.calendar.cal1.hide();

    function handleSelect1(type, args, obj) {
      var dates = args[0];
      var date = dates[0];
      var year = date[0],
        month = date[1],
        day = date[2];

      var txtDate1 = document.getElementById("date");
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
  }
  YAHOO.util.Event.onDOMReady(YAHOO.calendar.init);
<?php echo '</script'; ?>
>

<form method='post' action='?view=admin/addreservation&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
&amp;reservation=<?php echo $_smarty_tpl->tpl_vars['res']->value['id'];?>
'>
  <table>
    <tr>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Date<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> (<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>dd.mm.yyyy<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>):</td>
      <td>
        <input type='text' class='input' name='date' id='date' value='<?php echo $_smarty_tpl->tpl_vars['res']->value['date'];?>
'/>&nbsp;
        <button type='button' class='button' id='showcal1'>
        <img width='12px' height='10px' src='images/calendar.gif' alt='cal'/>
        </button>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <div id='calContainer1'></div>
      </td>
    </tr>
    <tr>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Start time<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> (<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>hh:mm<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>):</td>
      <td>
        <input type='text' class='input' name='starttime' value='<?php echo $_smarty_tpl->tpl_vars['res']->value['starttime'];?>
'/>
      </td>
    </tr>
    <tr>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>End time<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?> (<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>hh:mm<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>):</td>
      <td>
        <input type='text' class='input' name='endtime' value='<?php echo $_smarty_tpl->tpl_vars['res']->value['endtime'];?>
'/>
      </td>
    </tr>
    <!-- Not yet supported -->
    <!-- <tr><td>" ._("Timeslots")." ("._("hh:mm,hh:mm")."):</td> -->
    <!-- <td> -->
    <!-- <input type='text' class='input' size='32' maxlength='100' name='timeslots' value='".utf8entities($res[' timeslots'])."' /> -->
    <!-- </td> -->
    <!-- </tr> -->
    <tr>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Grouping name<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td><?php echo $_smarty_tpl->tpl_vars['res']->value['translated_field_resgroup'];?>
</td>
    </tr>
    <tr>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Fields<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <?php echo $_smarty_tpl->tpl_vars['res']->value['translated_field_field_name'];?>

        <?php if (!$_smarty_tpl->tpl_vars['add_more']->value) {?>
        <?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Enter separate field numbers (1,2,3) or multiple fields (1-30)<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
        <?php }?>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
        <div id='locationAutocomplete' class='yui-skin-sam'>
          <input class='input' id='locationName' size='30' type='text' style='width:200px' name='locationName' <?php if ((isset($_smarty_tpl->tpl_vars['res']->value['location_name']))) {?>value='<?php echo $_smarty_tpl->tpl_vars['res']->value['location_name'];?>
'<?php }?> />
          <div style='width:400px' id='locationContainer'></div>
        </div>
      </td>
    </tr>
    <tr>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Location<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <?php if ($_smarty_tpl->tpl_vars['is_super_admin']->value) {?>
    <tr>
      <td><?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Season<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>:</td>
      <td>
        <select class='dropdown' name='resseason'>
          <option class='dropdown' value=''></option>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['seasons']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
          <option class='dropdown' <?php echo $_smarty_tpl->tpl_vars['row']->value['selected'];?>
 value='<?php echo $_smarty_tpl->tpl_vars['row']->value['season_id'];?>
'><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</option>
        </select></p>
      </td>
    </tr>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>
    <tr>
      <td>
        <input type='hidden' name='location' id='location' value='<?php echo $_smarty_tpl->tpl_vars['res']->value['location'];?>
' />
        <?php if (!$_smarty_tpl->tpl_vars['add_more']->value) {?>
        <input type='hidden' name='id' value='<?php echo $_smarty_tpl->tpl_vars['res']->value['id'];?>
' />
        <input type='submit' class='button' name='save' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
$_block_repeat=true;
echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();?>Save<?php $_block_repeat=false;
echo smarty_block_t(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' />
        <?php } else { ?>
        <input type='submit' class='button' name='add' value='<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('t', array());
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
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>' onclick="window.location.href='?view=admin/reservations&amp;season=<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
'" />
      </td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<?php echo '<script'; ?>
 type="text/javascript">
  var locationSelectHandler = function(sType, aArgs) {
    var oData = aArgs[2];
    document.getElementById("location").value = oData[2];
  };

  FetchLocation = function() {
    var locationSource = new YAHOO.util.XHRDataSource("ext/locationtxt.php");
    locationSource.responseSchema = {
      recordDelim: "\n",
      fieldDelim: "\t"
    };
    locationSource.responseType = YAHOO.util.XHRDataSource.TYPE_TEXT;
    locationSource.maxCacheEntries = 60;

    // First AutoComplete
    var locationAutoComp = new YAHOO.widget.AutoComplete("locationName", "locationContainer", locationSource);
    locationAutoComp.formatResult = function(oResultData, sQuery, sResultMatch) {

      // some other piece of data defined by schema 
      var moreData1 = oResultData[1];

      var aMarkup = ["<div class='myCustomResult'>",
        "<span style='font-weight:bold'>",
        sResultMatch,
        "</span>",
        " / ",
        moreData1,
        "</div>"
      ];
      return (aMarkup.join(""));
    };
    locationAutoComp.itemSelectEvent.subscribe(locationSelectHandler);
    return {
      oDS: locationSource,
      oAC: locationAutoComp
    }
  }();
<?php echo '</script'; ?>
>

<?php echo $_smarty_tpl->tpl_vars['translationscript_resgroup']->value;?>

<?php echo $_smarty_tpl->tpl_vars['translationscript_fieldname']->value;?>


<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
