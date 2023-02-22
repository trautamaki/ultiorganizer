{foreach $series as $serie}
<table border='0' cellspacing='0' cellpadding='2' width='100%'>
  <tr>
    <th colspan='{$cols}'>
      {u}{$serie.name}{/u}
    </th>
  </tr>
  {foreach $teams[$serie.series_id] as $team}
  <tr>
    {if $list_type == "byseeding"}
    {if !empty($team.rank)}
    <td style='width:2px'>{$team.rank}</td>
    {else}
    <td style='width:2px'>-</td>
    {/if}
    {/if}
    {if intval($season_info.isnationalteams)}
    <td style='width:200px'><a href='?view=teamcard&amp;team={$team.team_id}'>{u}{$team.name}{/u}</a></td>
    {else}
    <td style='width:150px'><a href='?view=teamcard&amp;team={$team.team_id}'>{$team.name}</a></td>
    <td style='width:150px'><a href='?view=clubcard&amp;club={$team.club}'>{$team.clubname}</a></td>
    {/if}
    {if intval($season_info.isinternational)}
    <td style='width:150px'>
      {if !empty($team.flagfile)}
      <img height='10' src='images/flags/tiny/{$team.flagfile}' alt='' />&nbsp;
      {/if}
      {if !empty($team.countryname)}
      <a href='?view=countrycard&amp;country={$team.country}'>{t}$team.countryname{/t}</a>
      {/if}
    </td>
    {/if}
    <td class='right' style='white-space: nowrap;width:15%'>
      {if $is_stat_data}
      <a href='?view=playerlist&amp;team={$team.team_id}'>{t}Roster{/t}</a>
      &nbsp;&nbsp;
      {/if}
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Scoreboard{/t}</a>
      &nbsp;&nbsp;
      <a href='?view=games&amp;team={$team.team_id}&amp;singleview=1'>{t}Games{/t}</a>
    </td>
  </tr>
  {/foreach}
</table>
{/foreach}
