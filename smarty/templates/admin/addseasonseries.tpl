{include file="header.tpl"}
{include file="leftmenu.tpl"}

{$yui_load nofilter}

{foreach $warnings as $warning}
<p class='warning'>{$warning}</p>
{/foreach}

<!-- If seriesid is empty, then add new serie	-->
<h2>
  {if $series_id}
  {t}Edit division{/t}:
  {else}
  {t}Add division{/t}
</h2>
{/if}

<form method='post' action='?view=admin/addseasonseries&amp;series={$series_id}&amp;season={$season}'>
  <table cellpadding='2px'>
    <tr>
      <td class='infocell'>{t}Name{/t}:</td>
      <td>{include file="translated_field.tpl" field_name="name" value=$sp.name}</td>
    </tr>
    <tr>
      <td class='infocell'>{t}Order{/t} (A,B,C,D..):</td>
      <td><input class='input' id='ordering' name='ordering' value='{$sp.ordering}' /></td>
    </tr>
    <tr>
      <td class='infocell'>{t}Type{/t}: </td>
      <td>
        <select class='dropdown' name='type'>
          {foreach $types as $type}
          <option class='dropdown' {if $sp.type==$type} selected='selected' {/if} value='{$type}'>{u}{$type}{/u}</option>
          {/foreach}
        </select>
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Valid{/t}:</td>
      <td><input class='input' type='checkbox' id='valid' name='valid' {if intval($sp.valid)} checked='checked' {/if} /></td>
    </tr>
  </table>
  <p>
    {if $series_id}
    <input class='button' name='save' type='submit' value='{t}Save{/t}' />
    {else}
    <input class='button' name='add' type='submit' value='{t}Add{/t}' />
    {/if}
    <input class='button' type='button' name='takaisin' value='{t}Return{/t}' onclick="window.location.href='?view=admin/seasonseries&amp;season={$season}'" />
  </p>
</form>

{include file="translation_script.tpl" field_name="name"}

{include file="footer.tpl"}