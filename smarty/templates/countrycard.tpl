{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{$profile.name}</h1>
<img class='flag' src='images/flags/medium/{$profile.flagfile}' alt='' />

{if !empty($season)}
{if count($current_season_teams)}
<h2>{$current_season_name}:</h2>
<table style='white-space: nowrap;' border='0' cellspacing='0' cellpadding='2' width='90%'>
  <tr>
    <th>{t}Team{/t}</th>
    <th>{t}Division{/t}</th>
    <th colspan='4'></th>
  </tr>
  {foreach $current_season_teams as $team}
  <tr>
    <td style='width:30%'>
      <a href='?view=teamcard&amp;team={$team.team_id}'>{$team.name}</a>
    </td>
    <td style='width:30%'>
      <a href='?view=poolstatus&amp;series={$team.series_id}'>{u}{$team.seriesname}{/u}</a>
    </td>
    {if $is_stats_data_available}
    <td class='right' style='width:10%'>
      <a href='?view=playerlist&amp;team={$team.team_id}'>{t}Roster{/t}</a>
    </td>
    <td class='right' style='width:10%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Scoreboard{/t}</a>
    </td>
    {else}
    <td class='right' style='width:20%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Players{/t}</a>
    </td>
    {/if}
    <td class='right' style='width:20%'>
      <a href='?view=games&amp;team={$team.team_id}'>{t}Games{/t}</a>
    </td>
  </tr>
  {/foreach}
</table>
{/if}
{/if}

{if count($national_teams)}
<h2>{t}History{/t}:</h2>
<table style='white-space: nowrap;' border='0' cellspacing='0' cellpadding='2' width='90%'>
  <tr>
    <th>{t}Event{/t}</th>
    <th>{t}Team{/t}</th>
    <th>{t}Division{/t}</th>
    <th colspan='4'></th>
  </tr>
  {foreach $national_teams as $team}
  <tr>
    <td style='width:30%'>
      {u}{$team.season}{/u}
    </td>
    <td style='width:30%'>
      <a href='?view=teamcard&amp;team={$team.team_id}'>{$team.name}</a>
    </td>
    <td style='width:30%'>
      <a href='?view=poolstatus&amp;series={$team.series_id}'>{$team.seriesname}</a>
    </td>
    {if $is_stats_data_available}
    <td class='right' style='width:10%'>
      <a href='?view=playerlist&amp;team={$team.team_id}'>{t}Roster{/t}</a>
    </td>
    <td class='right' style='width:10%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Scoreboard{/t}</a>
    </td>
    {else}
    <td class='right' style='width:20%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Players{/t}</a>
    </td>
    {/if}
    <td class='right' style='width:20%'>
      <a href='?view=games&amp;team={$team.team_id}'>{t}Games{/t}</a>
    </td>
  </tr>
  {/foreach}
</table>
{/if}
{if count($club_teams)}
<h2>{t}Club teams{/t}:</h2>
<table style='white-space: nowrap;' border='0' cellspacing='0' cellpadding='2' width='90%'>
  <tr>
    <th>{t}Event{/t}</th>
    <th>{t}Team{/t}</th>
    <th>{t}Division{/t}</th>
    <th colspan='4'></th>
  </tr>
  {foreach $club_teams as $team}
  <tr>
    <td style='width:30%'>
      {u}{$team.season}{/u}
    </td>
    <td style='width:30%'>
      <a href='?view=teamcard&amp;team={$team.team_id}'>{$team.name}</a>
    </td>
    <td style='width:30%'>
      <a href='?view=poolstatus&amp;series={$team.series_id}'>{$team.seriesname}</a>
    </td>
    {if $is_stats_data_available}
    <td class='right' style='width:10%'>
      <a href='?view=playerlist&amp;team={$team.team_id}'>{t}Roster{/t}</a>
    </td>
    <td class='right' style='width:10%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Scoreboard{/t}</a>
    </td>
    {else}
    <td class='right' style='width:20%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Players{/t}</a>
    </td>
    {/if}
    <td class='right' style='width:20%'>
      <a href='?view=games&amp;team={$team.team_id}'>{t}Games{/t}</a>
    </td>
  </tr>
  {/foreach}
</table>
{/if}

{include file="footer.tpl"}