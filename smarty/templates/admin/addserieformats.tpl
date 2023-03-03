{include file="header.tpl"}
{include file="leftmenu.tpl"}

{$yui_load nofilter}

{if $pool_id}
<h2>{t}Edit rule template{/t}</h2>
<form method='post' action='?view=admin/addserieformats&amp;template={$pool_id}'>
{else}
<h2>{t}Add rule template{/t}</h2>
<form method='post' action='?view=admin/addserieformats'>
{/if}
  <table cellpadding='2'>
    <tr>
      <td class='infocell'>{t}Name{/t}:</td>
      <td>{include file="translated_field.tpl" field_name="name" value=$pp.name width=150 size=30}</td>
      <td></td>
    </tr>
    <tr>
      <td class='infocell'>{t}Game points{/t}:</td>
      <td><input class='input' id='gameto' name='gameto' value='{$pp.winningscore}' /></td>
      <td></td>
    </tr>
    <tr>
      <td class='infocell'>{t}Half-time{/t}:</td>
      <td><input class='input' id='halftimelength' name='halftimelength' value='{$pp.halftime}' /></td>
      <td>{t}minutes{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Half-time at point{/t}:</td>
      <td><input class='input' id='halftimepoint' name='halftimepoint' value='{$pp.halftimescore}' /></td>
      <td></td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time cap{/t}:</td>
      <td><input class='input' id='timecap' name='timecap' value='{$pp.timecap}' /></td>
      <td>{t}minutes{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time slot{/t}:</td>
      <td><input class='input' id='timeslot' name='timeslot' value='{$pp.timeslot}' /></td>
      <td>{t}minutes{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Point cap{/t}:</td>
      <td><input class='input' id='pointcap' name='pointcap' value='{$pp.scorecap}' /></td>
      <td>{t}points{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Additional points after time cap{/t}:</td>
      <td><input class='input' id='extrapoint' name='extrapoint' value='{$pp.addscore}' /></td>
      <td>{t}points{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time between points{/t}:</td>
      <td><input class='input' id='timebetweenPoints' name='timebetweenPoints' value='{$pp.betweenpointslen}' /></td>
      <td>{t}seconds{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time-outs{/t}:</td>
      <td><input class='input' id='timeouts' name='timeouts' value='{$pp.timeouts}' /></td>
      <td>
        <select class='dropdown' name='timeoutsfor'>
          <option class='dropdown' {if $pp.timeoutsper=="game" || $pp.timeoutsper==""} selected='selected' {/if} value='game'>{t}per game{/t}</option>
          <option class='dropdown' {if $pp.timeoutsper=="half"} selected='selected' {/if} value='half'>{t}per half{/t}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time-out duration{/t}:</td>
      <td><input class='input' id='timeoutlength' name='timeoutlength' value='{$pp.timeoutlen}' /></td>
      <td>{t}seconds{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Time-outs on overtime{/t}:</td>
      <td><input class='input' id='timeoutsOnOvertime' name='timeoutsOnOvertime' value='{$pp.timeoutsovertime}' /></td>
      <td>{t}per team{/t}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Draws allowed{/t}:</td>
      <td>
        <input class='input' type='checkbox' id='drawsallowed' name='drawsallowed' {if intval($pp.drawsallowed)} checked='checked' {/if} />
      </td>
      <td></td>
    </tr>
  </table>
  <p>
    {if $pool_id}
    <input class='button' name='save' type='submit' value='{t}Save{/t}' />
    {else}
    <input class='button' name='add' type='submit' value='{t}Add{/t}' />
    {/if}
    <input class='button' type='button' name='back' value='{t}Back{/t}' onclick="window.location.href='?view=admin/serieformats'" />
  </p>
</form>

{include file="translation_script.tpl" field_name="name"}

{include file="footer.tpl"}