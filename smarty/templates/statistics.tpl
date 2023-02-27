{include file="header.tpl"}
{include file="leftmenu.tpl"}

{include file="page_menu.tpl"}

{if $list == "teamstandings"}
<h1>{t}Team Standings{/t}</h1>
{foreach $season_types as $seasontype}
<h2>{u}{$seasontype}{/u}</h2>

{foreach $serie_types as $seriestype}
<h3>{u}{$seriestype}{/u}</h3>
<table style='width:100%' border='1'>
  <tr>
    <th>{t}Event{/t}</th>
    <th>{t}Gold{/t}</th>
    <th>{t}Silver{/t}</th>
    <th>{t}Bronze{/t}</th>
  </tr>
  {foreach $seasons_by_type[$seasontype].seasons as $season}
  {assign var="standings" value=$standings_per_season_by_type[$season.season_id][$seriestype]}
  {if !$standings} {continue} {/if}
  <tr>
    <td style='width:16%'>
      <a href='?view=teams&season={urlencode($season.season_id)}&amp;list=bystandings'>{u}{$season.name}{/u}</a>
    </td>
    {for $i = 0; $i < count($standings) && $i < 3; $i++} <td style='width:28%'>
      {if intval($standings[$i].country) > 0}
      &nbsp;<img height='10' src='images/flags/tiny/{$standings[$i].flagfile}' alt='' />&nbsp;
      {/if}
      <a href='?view=teamcard&amp;team={$standings[$i].team_id}'>{$standings[$i].teamname}</a>
      </td>
      {/for}
  </tr>
  {/foreach} <!-- $seasons_by_type[$seasontype].seasons as $season -->
</table>
{/foreach} <!-- $serie_types as $seriestype -->
{/foreach} <!-- $season_types as $seasontype -->
{if $countall == 0}
<p>{t}Season statistics have not yet been computed{/t}</p>
{/if}

{elseif ($list == "playerscoreboard")}

<h1>{t}Scoreboard TOP 3{/t}</h1>
{foreach $season_types as $seasontype}
<h2>{u}{$seasontype}{/u}</h2>
{foreach $serie_types as $seriestype}
<h3>{u}{$seriestype}{/u}</h3>
<table border='1' width='100%'>
  <tr>
    <th>{t}Event{/t}</th>
    <th>{t}First{/t}</th>
    <th>{t}Second{/t}</th>
    <th>{t}Third{/t}</th>
  </tr>
  {foreach $seasons_by_type[$seasontype].seasons as $season}
  <tr>
    <td style='width:16%'>
      <a href='?view=scorestatus&Series={$scores[0].series}'>{u}{$season.name}{/u}</a>
    </td>
    {assign var="scores" value=$scores_per_season_by_type[$season.season_id][$seriestype]}
    {if !$scores} {continue} {/if}
    {for $i = 0; $i < count($scores) && $i < 3; $i++} <td style='width:28%'>
      <a href='?view=playercard&amp;player={$scores[$i].player_id}'>
        {$scores[$i].firstname} {$scores[$i].lastname}
      </a>
      <br />
      {$scores[$i].teamname}
      <br />
      {$scores[$i].passes}+{$scores[$i].goals}={$scores[$i].total}
      </td>
      {/for}
  </tr>
  {/foreach}
</table>
{/foreach}
{/foreach}

{elseif ($list == "playerscoresall")}

<h1>{t}All time scoreboard TOP 100{/t}</h1>
<table border='1' width='100%'>
  <tr>
    <th>#</th>
    <th>{t}Name{/t}</th>
    <th>{t}Latest event / team{/t}</th>
    <th class='center'>{t}Games{/t}</th>
    <th class='center'>{t}Passes{/t}</th>
    <th class='center'>{t}Goals{/t}</th>
    <th class='center'>{t}Total{/t}</th>
  </tr>
  {foreach $scores_all as $row}
  <tr>
    <td>{$row.i}</td>
    <td>
      <a href='?view=playercard&amp;profile={$row.profile_id}'>
        {$row.firstname} {$row.lastname}</a>
    </td>
    <td>{$row.last_series_name} / {$row.last_team_name}</td>
    <td class='center'>{$row.gamestotal}</td>
    <td class='center'>{$row.goalstotal}</td>
    <td class='center'>{$row.passestotal}</td>
    <td class='center'>{$row.total}</td>
  </tr>
  {/foreach}
</table>
{foreach $season_types as $seasontype}

<h2>{u}{$seasontype}{/u}</h2>

{foreach $series_types[$seasontype] as $seriestype}
<h3>{u}{$seriestype}{/u}</h3>
<table border='1' width='100%'>
  <tr>
    <th>#</th>
    <th>{t}Name{/t}</th>
    <th>{t}Latest event / team{/t}</th>
    <th class='center'>{t}Games{/t}</th>
    <th class='center'>{t}Passes{/t}</th>
    <th class='center'>{t}Goals{/t}</th>
    <th class='center'>{t}Total{/t}</th>
  </tr>
  {foreach $scores_by_seasontype_by_serietype[$seasontype][$seriestype] as $row}
  <tr>
    <td>{$row.i}</td>
    <td>
      <a href='?view=playercard&amp;player={$row.player_id}'>
        {$row.firstname} {$row.lastname}</a>
    </td>
    <td>{$row.last_series_name} / {$row.last_team_name}</td>
    <td class='center'>{$row.gamestotal}</td>
    <td class='center'>{$row.goalstotal}</td>
    <td class='center'>{$row.passestotal}</td>
    <td class='center'>{$row.total}</td>
  </tr>
  {/foreach}
</table>
{/foreach}
{/foreach}

{/if} <!-- $list == "teamstandings" -->

{include file="footer.tpl"}