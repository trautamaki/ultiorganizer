{foreach $series as $serie}
<h2>{t}{$serie.name}{/t}</h2>
{if !count($pools[$serie.series_id])}
<p>{t}Pools not yet created{/t}</p>
{continue}
{/if}
{foreach $pools[$serie.series_id] as $pool}
<table border='0' cellspacing='0' cellpadding='2' width='100%'>
  <tr>
    <th colspan='{$cols - 1}'>
      {u}{$serie.name}{/u}, {u}{$pool.name}{/u}
    </th>
    <th class='right'>{t}Scoreboard{/t}
    </th>
  </tr>
  {foreach $teams_pool[$pool.pool_id] as $team}
  <tr>
    {if intval($season_info.isnationalteams)}
    <td style='width:150px'>
      <a href='?view=teamcard&amp;team={$team.id}'>{u}{$team.name}{/u}</a>
    </td>
    {else}
    <td style='width:150px'>
      <a href='?view=teamcard&amp;team={$team.id}'>{t}{$team.name}{/t}</a>
    </td>
    <td style='width:150px'>
      <a href='?view=clubcard&amp;club={$team.club}'>{t}{$team.clubname}{/t}</a>
    </td>
    {/if}
    {if intval($season_info.isinternational)}
    <td style='width:150px'>
      {if !empty($team.flagfile)}
      <img height='10' src='images/flags/tiny/{$team.flagfile}' alt='' />&nbsp;
      {/if}
      {if !empty($team.countryname)}
      <a href='?view=countrycard&amp;country={$team.country}'>{t}{$team.countryname}{/t}</a>
      {/if}
    </td>
    {/if}
    <td class='right' style='white-space: nowrap;width:15%'>
      <a href='?view=games&amp;team={$team.id}&amp;singleview=1'>{t}Games{/t}</a>
      &nbsp;&nbsp;
      {if $pool.type == 2}
      <a href='?view=scorestatus&amp;team={$team.id}&amp;pools={$playoffpools}'>{t}Pool{/t}</a>
      {else}
      <a href='?view=scorestatus&amp;team={$team.id}&amp;pool={$pool.pool_id}'>{t}Pool{/t}</a>
      {/if}
      &nbsp;&nbsp;
      <a href='?view=scorestatus&amp;team={$team.id}'>{t}Division{/t}</a>
    </td>
  </tr>
  {/foreach}
</table>
{/foreach}
{/foreach}
