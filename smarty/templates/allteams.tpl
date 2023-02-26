{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{$title}</h1>
<table style='white-space: nowrap;width:100%'>
  <tr>
    {foreach $valid_letters as $let}
    {if $let == $filter}
    <td class='selgroupinglink'>&nbsp;{$let}&nbsp;</td>
    {else}
    <td>&nbsp;<a class='groupinglink' href='?view=allteams&amp;list={urlencode($let)}'>{$let}</a>&nbsp;</td>
    {/if}
    {/foreach}
    {if $filter == "ALL"}
    <td class='selgroupinglink'>&nbsp;{t}ALL{/t}</td>
    {else}
    <td>&nbsp;<a class='groupinglink' href='?view=allteams&amp;list=all'>{t}ALL{/t}</a></td>
    {/if}
  </tr>
</table>
{assign var=counter value=0}
<table width='100%' style='white-space: nowrap;'>
  {foreach $teams as $team}
  {if $filter == "ALL" && $team.show_letter}
  {if $counter > 0 && $counter <= $maxcols}</tr>{/if}
    <tr>
      <td></td>
    </tr>
    <tr>
      <td class='list_letter' colspan='{$maxcols}'>{$team.list_letter}</td>
    </tr>
    {assign var=counter value=0}
    {/if} <!-- $filter == "ALL" && $team.show_letter -->

    {if $counter == 0}
    <tr>
      {/if}
      <td style='width: 33%'>
        {if intval($team.country)}
        <img height='10' src='images/flags/tiny/{$team.flagfile}' alt='' />&nbsp;
        {/if}
        <a href='?view=teamcard&amp;team={$team.team_id}'>
          {$team.name} [{u}{$team.seriesname}{/u}]
        </a>
      </td>
      {assign var=counter value=($counter + 1)}
      {if $counter >= $maxcols}
    </tr>
    {assign var=counter value=0}
    {/if}
    {/foreach}
    {if $counter > 0 && $counter <= $maxcols} </tr>
      {/if}
</table>
{include file="footer.tpl"}