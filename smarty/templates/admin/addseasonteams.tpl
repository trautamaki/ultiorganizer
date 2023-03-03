{include file="header.tpl"}
{include file="leftmenu.tpl"}

{$yui_load nofilter}

<script type="text/javascript">
  var clubs = new Array({$orgarray});
</script>

{foreach $messages as $message}
<p>$message</p><hr />
{/foreach}

{if $team_id}
<h2>{t}Edit team{/t}</h2>
<form method='post' action='?view=admin/addseasonteams&amp;season={$season}&amp;series={$series_id}&amp;team={$team_id}'>
{else}
<h2>{t}Add team{/t}</h2>
<form method='post' action='?view=admin/addseasonteams&amp;season={$season}&amp;series={$series_id}'>
{/if}
  <table cellpadding='2px' class='yui-skin-sam'>
    <tr>
      <td class='infocell'>{t}Name{/t}:</td>
      <td>
        {if !intval($season_info.isnationalteams)}
        <input class='input' id='name' name='name' size='50' value='{$tp.name}' />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Club{/t}:</td>
      <td>
        <div id='orgAutoComplete'>
          <input class='input' type='text' id='club' name='club' size='50' value='{$club_name}' />
          <div id='orgContainer'></div>
        </div>
        {else}
        {include file="translated_field.tpl" field_name="name" value=$tp.name}
        {/if}
      </td>
    </tr>
    {if intval($season_info.isinternational)}
    <tr>
      <td class='infocell'>{t}Country{/t}:</td>
      <td>{include file="country_droplist_with_value.tpl" countries=$countries id="country" name="country" selected_id=$tp.country}</td>
    </tr>
    {/if}
    <tr>
      <td class='infocell'>{t}Abbreviation{/t}:</td>
      <td>
        <input class='input' id='abbreviation' name='abbreviation' maxlength='15' size='16' value='{$tp.abbreviation}' />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Division{/t}:</td>
      <td>
        <input class='input' id='series' name='series' disabled='disabled' size='50' value='{$series_name}' />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Starting pool{/t}:</td>
      <td>
        <select class='dropdown' name='pool'>
          <option class='dropdown' {if !intval($tp.pool)} selected='selected' {/if} value='0'></option>
          {foreach $pools as $row}
          <option class='dropdown' {if $row.pool_id==$tp.pool} selected='selected' {/if} value='{$row.pool_id}'>{u}{$row.name}{/u}</option>
          {/foreach}
        </select>
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Seed{/t}:</td>
      <td><input class='input' id='rank' size='4' name='rank' value='{$tp.rank}' /></td>
    </tr>
    <tr>
      <td class='infocell'>{t}Valid{/t}:</td>
      <td>
        <input class='input' type='checkbox' id='teamvalid' name='teamvalid' {if intval($tp.valid) || !$teamId} checked='checked' {/if} />
      </td>
  </table>

  <p><a href='?view=admin/users'>{t}Select contact person{/t}</a></p>
  <p>
    {if $teamId}
    <input class='button' name='save' type='submit' value='{t}Save{/t}' />
    {else}
    <input class='button' name='add' type='submit' value='{t}Add{/t}' />
    {/if}
    <input class='button' type='button' name='back' value='{t}Return{/t}' onclick="window.location.href='?view=admin/seasonteams&amp;season=$season'" />
  </p>
</form>

<script type="text/javascript">
  YAHOO.autocomplete = function() {
    var oDS = new YAHOO.util.LocalDataSource(clubs);
    var oAC = new YAHOO.widget.AutoComplete("club", "orgContainer", oDS);
    oAC.prehighlightClassName = "yui-ac-prehighlight";
    oAC.useShadow = true;
    return {
      oDS: oDS,
      oAC: oAC
    };
  }();
</script>

{if intval($season_info.isnationalteams)}
{include file="translation_script.tpl" field_name="name"}
{/if}

{include file="footer.tpl"}