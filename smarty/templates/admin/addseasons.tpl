{include file="header.tpl"}
{include file="leftmenu.tpl"}

{$yuiload nofilter}

<link rel="stylesheet" type="text/css" href="script/yui/calendar/calendar.css" />

<script type="text/javascript">
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
</script>

{foreach $warnings as $warning}
<p class="warning">{$warning}</p>
{/foreach}

{if empty($season_id)}
<h2>{t}Add new season/tournament{/t}</h2>
<form method='post' action='?view=admin/addseasons'>
{else}
<h2>{t}Edit season/tournament{/t}</h2>
<form method='post' action='?view=admin/addseasons&amp;season={$season_id}'>
  {/if}
  <table border='0'>
    <tr>
      <td class='infocell'>{t}Event id{/t}: </td>
      <td>
        <input class='input' name='season_id' {$season_id_disabled} value='{$sp.season_id}' />
      </td>
    </tr>
    <tr rowspan='2'>
      <td class='infocell'>{t}Name{/t}: </td>
      <td>{include file="translated_field.tpl" field_name="seasonname" value=$sp.name}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Type{/t}: </td>
      <td>
        <select class='dropdown' name='type'>
          {foreach $types as $type}
          <option class='dropdown' {if $sp.type==$type} selected='selected' {/if} value='$type'>{u}{$type}{/u}</option>
          {/foreach}
        </select>
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Tournament{/t}: </td>
      <td>
        <input class='input' type='checkbox' name='istournament' {if $sp.istournament} checked='checked' {/if} />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}International{/t}: </td>
      <td>
        <input class='input' type='checkbox' name='isinternational' {if $sp.isinternational} checked='checked' {/if} />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}For national teams{/t}: </td>
      <td>
        <input class='input' type='checkbox' name='isnationalteams' {if $sp.isnationalteams} checked='checked' {/if} />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Spirit mode{/t}: </td>
      <td>
        <select class='dropdown' id='spiritmode' name='spiritmode'>
          <option value='0'></option>
          {foreach $spiritmodes as $mode}
          <option {if $sp.spiritmode == $mode.mode} selected='selected' {/if} value='{$mode.mode}'>{t}{$mode.name}{/t}</option>
          {/foreach}
        </select>
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Spirit points visible{/t}: </td>
      <td>
        <input class='input' type='checkbox' name='showspiritpoints' {if $sp.showspiritpoints} checked='checked' {/if} />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Organizer{/t}: </td>
      <td>
        <input class='input' size='50' maxlength='50' name='organizer' value='{$sp.organizer}' />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Category{/t}: </td>
      <td>
        <input class='input' size='50' maxlength='50' name='category' value='{$sp.category}' />
      </td>
    </tr>
    <tr>
      <td class='infocell' style='vertical-align:top'>{t}Comment (you can use {"<b>"}, {"<em>"}, and {"<br />"} tags){/t}:</td>
      <td>
        <textarea class='input' rows='10' cols='70' name='comment'>{$comment nofilter}</textarea>
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Timezone{/t}: </td>
      <td>
        <select class='dropdown' id='timezone' name='timezone'>
          <option value=''></option>
          {foreach $dateTimeZone as $tz}
          <option {if $sp.timezone == $tz} selected='selected' {/if} value='{$tz}'>
            {$tz}
          </option>
          {/foreach}
        </select>
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Starts{/t} ({t}dd.mm.yyyy{/t}): </td>
      <td>
        <input class='input' size='12' maxlength='10' id='seasonstarttime' name='seasonstarttime' value='{$sp.starttime_shortdate}'/>&nbsp;&nbsp;
        <button type='button' class='button' id='showcal1'>
        <img width='12px' height='10px' src='images/calendar.gif' alt='cal'/></button>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><div id='calContainer1'></div></td>
    </tr>
    <tr><td class='infocell'>{t}Ends{/t} ({t}dd.mm.yyyy{/t}): </td>
      <td>
        <input class='input' size='12' maxlength='10' id='seasonendtime' name='seasonendtime' value='{$sp.endtime_shortdate}'/>&nbsp;&nbsp;
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
      <td class='infocell'>{t}Open for enrollment{/t}: </td>
      <td>
        <input class='input' type='checkbox' name='enrollopen' {if $sp.enrollopen} checked='checked' {/if} />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Enrolling ends{/t}<br/>({t}only informational{/t}): </td>
      <td>
        <input class='input' size='12' maxlength='10' id='enrollendtime' name='enrollendtime'  value='{$sp.enroll_deadline_shortdate}'/>&nbsp;&nbsp;
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
      <td class='infocell'>{t}Shown in main menu{/t}: </td>
      <td><input class='input' type='checkbox' name='iscurrent' {if $sp.iscurrent} checked='checked' {/if} /></td>
    </tr>
  </table>
  <p>
  {if empty($season_id)}
    <input class='button' type='submit' name='add' value='{t}Add{/t}' />
  {else}
    <input class='button' type='submit' name='save' value='{t}Save{/t}' />
  {/if}
    <input type='hidden' name='backurl' value='{$backurl}'/>
    <input class='button' type='button' value='{t}Return{/t}' onclick="window.location.href='{$backurl}'" />
  </p>
</form>

{include file="translation_script.tpl" field_name="seasonname"}

{include file="footer.tpl"}