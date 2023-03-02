{include file="header.tpl"}
{include file="leftmenu.tpl"}

{$yui_load nofilter}

<style type="text/css">
  #colorcontainer {
    position: relative;
    padding: 6px;
    background-color: #eeeeee;
    width: 300px;
    height: 180px;
  }
</style>

<script type="text/javascript">
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
      picker.setValue([<?php
                        echo hexdec(substr({$pp.color}, 0, 2)) . ", ";
                        echo hexdec(substr({$pp.color}, 2, 2)) . ", ";
                        echo hexdec(substr({$pp.color}, 4, 2));
                        ?>], true);
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
</script>

{foreach $messages as $message}
<p {$message.class}>{$message.message}</p>
<hr/>
{/foreach}

{if !$pool_id || $addmore}
<h2>{t}Add pool{/t}</h2>
<form method='post' action='?view=admin/addseasonpools&amp;season={$season}&amp;series={$series_id}'>
  <table cellpadding='2'>
    <tr>
      <td class='infocell'>{t}Name{/t}:</td>
      <td>{$name_translated}</td>
      </tr>
    <tr>
      <td class='infocell'>{t}Order{/t} (A,B,C,D ...):</td>
      <td><input class='input' id='ordering' name='ordering' value='{$pp.ordering}'/></td>
    </tr>
    <tr>
      <td class='infocell'>{t}Template{/t}:</td>
      <td>
        <select class='dropdown' name='template'>
          {foreach $templates as $row}      
          <option class='dropdown' {if $template == $row.template_id} selected='selected' {/if} value='{$row.template_id}'>
              {$row.name}
          </option>
          {/foreach}
        </select>
      </td>
    </tr>
  </table>
  <p>
    <input class='button' name='add' type='submit' value='{t}Add{/t}'/>
    <input class='button' type='button' name='takaisin'  value='{t}Return{/t}' onclick="window.location.href='?view=admin/seasonpools&amp;season=$season'"/>
  </p>
</form>
{else} <!-- !$pool_id || $addmore -->
  <h2>{t}Edit pool{/t}:</h2>
  <form method='post' action='?view=admin/addseasonpools&amp;pool={$pool_id}&amp;season={$season}'>
  <table cellpadding='2'>
    <tr>
      <td class='infocell'>{t}Name{/t}:</td>
      <td>{$name_translated}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Division{/t}:</td>
      <td><input class='input' id='series' name='series' disabled='disabled' value='{$seriesname}'/></td>
      <td></td>
    </tr>

    <tr>
      <td class='infocell'>{t}Order{/t} (A,B,C,D ...):</td>
      <td><input class='input' id='ordering' name='ordering' value='{$pp.ordering}'/></td>
    </tr>

    <tr>
      <td class='infocell'>{t}Type{/t}:</td>
      <td>
        <select class='dropdown' name='type'>
          <option class='dropdown' {if $pp.type == "1"} selected='selected' {/if} value='1'>{t}Round Robin{/t}</option>
          <option class='dropdown' {if $pp.type == "2"} selected='selected' {/if} value='2'>{t}Play-off{/t}</option>
          <option class='dropdown' {if $pp.type == "3"} selected='selected' {/if} value='3'>{t}Swissdraw{/t}</option>
          <option class='dropdown' {if $pp.type == "4"} selected='selected' {/if} value='4'>{t}Crossmatch{/t}</option>
          
          <tr><td class='infocell'>{t}Special playoff template{/t}:</td>
          <td><input class='input' id='playoff_template' name='playoff_template' value='{$pp.playoff_template}'/></td></tr>

         </select>
        </td>
      </tr>
      <tr>
        <td class='infocell'>{t}Move games{/t}:</td>
        <td>
          <select class='dropdown' name='mvgames'>
            <option class='dropdown' {if $pp.mvgames == "0"} selected='selected' {/if} value='0'>{t}All{/t}</option>
            <option class='dropdown' {if $pp.mvgames == "1"} selected='selected' {/if} value='1'>{t}Nothing{/t}</option>
            <option class='dropdown' {if $pp.mvgames == "2"} selected='selected' {/if} value='2'>{t}Mutual{/t}</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class='infocell'>{t}Visible{/t}:</td>
        <!-- CS: Sometimes you want to change the visibility setting in Swissdraw -->
        {if rtrim($frompoolinfo['ordering'], "0..9") == rtrim({$pp.ordering}, "0..9")} <!-- Playoff or Swissdraw -->
        <td>
          <input class='input' disabled='disabled' type='checkbox' id='visible' name='visible'/>
        </td>
        {else}
        <td>
          <input class='input' type='checkbox' id='visible' name='visible' {if intval($pp.visible)} checked='checked' {/if}/>
        </td>
        {/if}
        <td></td>
      </tr>
      <tr>
        <td class='infocell'>{t}Played{/t}:</td>
        <td><input class='input' type='checkbox' id='played' name='played' {if intval($pp.played)} checked='checked' {/if}/></td>
        <td></td>
      </tr>
      <tr>
        <td class='infocell'>{t}Continuing pool{/t}:</td>
        {if rtrim($frompoolinfo['ordering'], "0..9") == rtrim({$pp.ordering}, "0..9")} <!-- Playoff or Swissdraw -->
        <td>
          <input class='input' disabled='disabled' type='checkbox' id='continuationserie' name='continuationserie' checked='checked'/>
        </td>
        {else}
        {if intval($pp.continuingpool)}
        <td>
          <input class='input' type='checkbox' id='continuationserie' name='continuationserie' checked='checked'/>
        </td>
        {else}
        <td>
          <input class='input' type='checkbox' id='continuationserie' name='continuationserie' />
        </td>
        {/if}
        {/if}
        <td></td>
      </tr>
      <tr>
        <td class='infocell'>{t}Placement pool{/t}:</td>
        <td>
          <input class='input' type='checkbox' id='placementpool' name='placementpool' {if intval($pp.placementpool)} checked='checked' {/if}/>
        </td>
        <td></td>
      </tr>
      {if intval($pp.continuingpool)}
      <tr>
        <td class='infocell'>{t}Initial moves{/t}:</td>
        <td><a href='?view=admin/poolmoves&amp;season={$season}&amp;series={$pp.series}&amp;pool={$pool_id}'>{t}select{/t}</a></td>
        <td></td>
      </tr>
      {/if}
    <tr>
      <td class='infocell'>{t}Color{/t}:</td>
      <td>
        <input class='input' type='hidden' id='color' name='color' value='{$pp.color}'/>
        <button type='button' id='showcolor' class='button' style='background-color:#{$pp.color}'>{t}Select{/t}</button>
      </td>
      <td></td>
    </tr>
    <tr>
      <td class='infocell' style='vertical-align:top'>"{t}Comment (you can use {"<b>"}, {"<em>"}, and {"<br />"} tags){/t}:</td>
      <td><textarea class='input' rows='10' cols='70' id='comment' name='comment'>{$comment}</textarea></td>
    </tr>
  </table>
  <div class='yui-skin-sam' id='colorcontainer' style='display:none'></div>

  <h2>{t}Teams{/t}:</h2>

  {if count($teams)}
  <table width='75%' cellpadding='4'><tr><th>{t}Name{/t}</th><th>{t}Club{/t}</th></tr>
  {foreach $teams as $team}
    <tr>
    <td>{$team.name}</td>
    <td>{$team.clubname}</td>
    </tr>
    {/foreach}
  </table>
  {else}
  <p>{t}No teams{/t}</p>
  {/if}

  <h2>{t}Rules{/t} {t}(from the selected template){/t}:</h2>

  <table cellpadding='2'>
    <tr>
    <td class='infocell'>{t}Game points{/t}:</td>
      <td><input class='input' id='gameto' name='gameto' value='{$pp.winningscore}'/></td>
      <td></td>
    </tr>

    <tr>
      <td class='infocell'>{t}Half-time{/t}:</td>
      <td><input class='input' id='halftimelength' name='halftimelength' value='{$pp.halftime}'/></td>
      <td>{t}minutes{/t}</td>
    </tr>		

    <tr>
      <td class='infocell'>{t}Half-time at point{/t}:</td>
      <td><input class='input' id='halftimepoint' name='halftimepoint' value='{$pp.halftimescore}'/></td>
      <td></td>
    </tr>		
      
    <tr>
      <td class='infocell'>{t}Time cap{/t}:</td>
      <td><input class='input' id='timecap' name='timecap' value='{$pp.timecap}'/></td>
      <td>{t}minutes{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time slot{/t}:</td>
      <td><input class='input' id='timeslot' name='timeslot' value='{$pp.timeslot}'/></td>
      <td>{t}minutes{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Point cap{/t}:</td>
      <td><input class='input' id='pointcap' name='pointcap' value='{$pp.scorecap}'/></td>
      <td>{t}points{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Additional points after time cap{/t}:</td>
      <td><input class='input' id='extrapoint' name='extrapoint' value='{$pp.addscore}'/></td>
      <td>{t}points{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time between points{/t}:</td>
      <td><input class='input' id='timebetweenPoints' name='timebetweenPoints' value='{$pp.betweenpointslen}'/></td>
      <td>{t}seconds{/t}</td></tr>
    <tr>
      <td class='infocell'>{t}Time-outs{/t}:</td>
      <td><input class='input' id='timeouts' name='timeouts' value='{$pp.timeouts}'/></td>
      <td>
        <select class='dropdown' name='timeoutsfor'>
          <option class='dropdown' {if $pp.timeoutsper == "game" || $pp.timeoutsper == ""} selected='selected' {/if} value='game'>{t}per game{/t}</option>
          <option class='dropdown' {if $pp.timeoutsper == "half"} selected='selected' {/if} value='half'>{t}per half{/t}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time-out duration{/t}:</td>
      <td><input class='input' id='timeoutlength' name='timeoutlength' value='{$pp.timeoutlen}'/></td>
      <td>{t}seconds{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time-outs in overtime{/t}:</td>
      <td><input class='input' id='timeoutsOnOvertime' name='timeoutsOnOvertime' value='{$pp.timeoutsovertime}'/></td>
      <td>{t}per team{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Forfeit/BYE against{/t}:</td>
      <td><input class='input' id='forfeitagainst' name='forfeitagainst' value='{$pp.forfeitagainst}'/></td>
      <td>{t}points for the team giving up / BYE{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Forfeit/BYE score{/t}:</td>
      <td><input class='input' id='forfeitscore' name='forfeitscore' value='{$pp.forfeitscore}'/></td>
      <td>{t}points for their remaining opponent{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Draws allowed{/t}:</td>
      {if intval($pp.drawsallowed)}
      <td><input class='input' type='checkbox' id='drawsallowed' name='drawsallowed' checked='checked'/></td>
      {else}
      <td><input class='input' type='checkbox' id='drawsallowed' name='drawsallowed' /></td>
      {/if}
      <td></td>
    </tr>
  </table>

  <p>
    <input class='button' name='save' type='submit' value='{t}Save{/t}'/>
    <input class='button' type='button' name='back'  value='{t}Return{/t}' onclick="window.location.href='?view=admin/seasonpools&amp;season={$season}'"/>
  </p>
</form>
{/if}

{$name_translationscript nofilter}

{include file="footer.tpl"}