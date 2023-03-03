{include file="header.tpl"}
{include file="leftmenu.tpl"}

<link rel="stylesheet" type="text/css" href="script/yui/calendar/calendar.css" />

{$yuiload nofilter}

{$reservation_messages nofilter}

<script type="text/javascript">
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
</script>

<form method='post' action='?view=admin/addreservation&amp;season={$season}&amp;reservation={$res.id}'>
  <table>
    <tr>
      <td>{t}Date{/t} ({t}dd.mm.yyyy{/t}):</td>
      <td>
        <input type='text' class='input' name='date' id='date' value='{$res.date}'/>&nbsp;
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
      <td>{t}Start time{/t} ({t}hh:mm{/t}):</td>
      <td>
        <input type='text' class='input' name='starttime' value='{$res.starttime}'/>
      </td>
    </tr>
    <tr>
      <td>{t}End time{/t} ({t}hh:mm{/t}):</td>
      <td>
        <input type='text' class='input' name='endtime' value='{$res.endtime}'/>
      </td>
    </tr>
    <!-- Not yet supported -->
    <!-- <tr><td>" ._("Timeslots")." ("._("hh:mm,hh:mm")."):</td> -->
    <!-- <td> -->
    <!-- <input type='text' class='input' size='32' maxlength='100' name='timeslots' value='".utf8entities($res[' timeslots'])."' /> -->
    <!-- </td> -->
    <!-- </tr> -->
    <tr>
      <td>{t}Grouping name{/t}:</td>
      <td>{include file="translated_field.tpl" field_name="reservationgroup" value=$res.reservationgroup}</td>
    </tr>
    <tr>
      <td>{t}Fields{/t}:</td>
      <td>
      {include file="translated_field.tpl" field_name="fieldname" value=$res.fieldname}
        {if !$add_more}
        {t}Enter separate field numbers (1,2,3) or multiple fields (1-30){/t}
        {/if}
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
        <div id='locationAutocomplete' class='yui-skin-sam'>
          <input class='input' id='locationName' size='30' type='text' style='width:200px' name='locationName' {if isset($res.location_name)}value='{$res.location_name}'{/if} />
          <div style='width:400px' id='locationContainer'></div>
        </div>
      </td>
    </tr>
    <tr>
      <td>{t}Location{/t}:</td>
      <td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    {if $is_super_admin}
    <tr>
      <td>{t}Season{/t}:</td>
      <td>
        <select class='dropdown' name='resseason'>
          <option class='dropdown' value=''></option>
          {foreach $seasons as $row}
          <option class='dropdown' {$row.selected} value='{$row.season_id}'>{$row.name}</option>
        </select></p>
      </td>
    </tr>
    {/foreach}
    {/if}
    <tr>
      <td>
        <input type='hidden' name='location' id='location' value='{$res.location}' />
        {if !$add_more}
        <input type='hidden' name='id' value='{$res.id}' />
        <input type='submit' class='button' name='save' value='{t}Save{/t}' />
        {else}
        <input type='submit' class='button' name='add' value='{t}Add{/t}' />
        {/if}
        <input class='button' type='button' name='back' value='{t}Return{/t}' onclick="window.location.href='?view=admin/reservations&amp;season={$season}'" />
      </td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<script type="text/javascript">
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
</script>

{include file="translation_script.tpl" field_name="reservationgroup"}
{include file="translation_script.tpl" field_name="fieldname"}

{include file="footer.tpl"}