{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h2>{t}Division statistics:{/t} {$series_info.name}</h2>

<table border='1' style='width:100%'>
  <tr>
    {if $sort == 'name'}
    <th style='width:180px'>
      {t}Team{/t}
    </th>
    {else}
    <th style='width:180px'>
      <a class='thsort' href='{$view_url}&amp;Sort=name'>{t}Team{/t}</a>
    </th>
    {/if}
    <th class='center'>{if $sort != "seed"}<a class='thsort' href='{$view_url}&amp;Sort=seed'>{/if}{t}Seeding{/t}{if $sort != "seed"}</a>{/if}</th>
    <th class='center'>{if $sort != "ranking"}<a class='thsort' href='{$view_url}&amp;Sort=ranking'>{/if}{t}Ranking{/t}{if $sort != "seed"}</a>{/if}</th>
    <th class='center'>{if $sort != "games"}<a class='thsort' href='{$view_url}&amp;Sort=games'>{/if}{t}Games{/t}{if $sort != "seed"}</a>{/if}</th>
    <th class='center'>{if $sort != "wins"}<a class='thsort' href='{$view_url}&amp;Sort=wins'>{/if}{t}Wins{/t}{if $sort != "seed"}</a>{/if}</th>
    <th class='center'>{if $sort != "losses"}<a class='thsort' href='{$view_url}&amp;Sort=losses'>{/if}{t}Losses{/t}{if $sort != "seed"}</a>{/if}</th>
    <th class='center'>{if $sort != "for"}<a class='thsort' href='{$view_url}&amp;Sort=for'>{/if}{t}Goals for{/t}{if $sort != "seed"}</a>{/if}</th>
    <th class='center'>{if $sort != "against"}<a class='thsort' href='{$view_url}&amp;Sort=against'>{/if}{t}Goals against{/t}{if $sort != "seed"}</a>{/if}</th>
    <th class='center'>{if $sort != "diff"}<a class='thsort' href='{$view_url}&amp;Sort=diff'>{/if}{t}Goals diff{/t}{if $sort != "seed"}</a>{/if}</th>
    <th class='center'>{if $sort != "winavg"}<a class='thsort' href='{$view_url}&amp;Sort=winavg'>{/if}{t}Win-%{/t}{if $sort != "seed"}</a>{/if}</th>

    {if $season_info.spiritmode > 0 && ($season_info.showspiritpoints || $is_season_admin)}
    {if $sort == "spirit"}
    <th class='center'>{t}Spirit points{/t}</th>
    {else}
    <th class='center'><a class='thsort' href='{$view_url}&amp;Sort=spirit'>{t}Spirit points{/t}</a></th>
    {/if}
    {/if}
  </tr>

  {foreach $all_teams as $stats}
  <tr>
    <td class="{if $sort=='name'} highlight {/if}">
      {if intval($season_info.isinternational)}
      <img height='10' src='images/flags/tiny/{$stats.flagfile}' alt='' />
      {/if}
      <a href='?view=teamcard&amp;team={$stats.team_id}'>{u}{$stats.name}{/u}</a>
    </td>
    <td class='center {if $sort=="seed"} highlight {/if}'>{intval($stats.seed)}</td>
    <td class='center {if $sort=="ranking"} highlight {/if}'>{$stats.pretty_rank}</td>
    <td class='center {if $sort=="games"} highlight {/if}'>{intval($stats.games)}</td>
    <td class='center {if $sort=="wins"} highlight {/if}'>{intval($stats.wins)}</td>
    <td class='center {if $sort=="losses"} highlight {/if}'>{intval($stats.losses)}</td>
    <td class='center {if $sort=="for"} highlight {/if}'>{intval($stats.for)}</td>
    <td class='center {if $sort=="against"} highlight {/if}'>{intval($stats.against)}</td>
    <td class='center {if $sort=="diff"} highlight {/if}'>{intval($stats.diff)}</td>
    <td class='center {if $sort=="winavg"} highlight {/if}'>{$stats.winavg} %</td>
    {if $season_info.spiritmode > 0 && ($seasoninfo.showspiritpoints || $is_season_admin)}
    <td class='center {if $sort=="spirit"} highlight {/if}'>{$stats.pretty_spirit}</td>
    {/if}
  </tr>
  {/foreach}
</table>

<a href='?view=poolstatus&amp;series={$series_info.series_id}'>{t}Show all pools{/t}</a>

<h2>{t}Scoreboard leaders{/t}</h2>
<table cellspacing='0' border='0' width='100%'>
  <tr>
    <th style='width:200px'>{t}Player{/t}</th>
    <th style='width:200px'>{t}Team{/t}</th>
    <th class='center'>{t}Games{/t}</th>
    <th class='center'>{t}Assists{/t}</th>
    <th class='center'>{t}Goals{/t}</th>
    <th class='center'>{t}Tot.{/t}</th>
  </tr>

  {foreach $points_leaders as $score}
  <tr>
    <td>{$score.firstname} {$score.lastname}</td>
    <td>{$score.teamname}</td>
    <td class='center'>{intval($score.games)}</td>
    <td class='center'>{intval($score.fedin)}</td>
    <td class='center'>{intval($score.done)}</td>
    <td class='center'>{intval($score.total)}</td>
  </tr>
  {/foreach}
</table>

<a href='?view=scorestatus&amp;series={$series_info.series_id}'>{t}Scoreboard{/t}</a><br>

<div style='padding: 5px; width: 100%; height: 100%'>
  <div style='float: left; width: 50%;'>
    <h2>{t}Goals leaders{/t}</h2>
    <table cellspacing='0' border='0' style='margin-left: 0; padding: 0;'>
      <tr>
        <th style='width:100%'>{t}Player{/t}</th>
        <th>{t}Team{/t}</th>
        <th class='center'>{t}Games{/t}</th>
        <th class='center'>{t}Goals{/t}</th>
      </tr>
      {foreach $goals_leaders as $row}
      <tr>
        <td>{$row.firstname} {$row.lastname}</td>
        <td>{$row.abbr}</td>
        <td class='center'>{intval($row.games)}</td>
        <td class='center'>{intval($row.done)}</td>
      </tr>
      {/foreach}
    </table>
  </div>

  <div style='float: right; width: 50%;'>
    <h2>{t}Assists leaders{/t}</h2>
    <table cellspacing='0' border='0' style='margin-right: 0; padding: 0;'>
      <tr>
        <th style='width:100%'>{t}Player{/t}</th>
        <th>{t}Team{/t}</th>
        <th class='center'>{t}Games{/t}</th>
        <th class='center'>{t}Assists{/t}</th>
      </tr>

      {foreach $assists_leaders as $row}
      <tr>
        <td>{$row.firstname} {$row.lastname}</td>
        <td>{$row.abbr}</td>
        <td class='center'>{intval($row.games)}</td>
        <td class='center'>{intval($row.fedin)}</td>
      </tr>
      {/foreach}
    </table>
  </div>
</div>

{if $show_defence_stats}
<h2>{t}Defenseboard leaders{/t}</h2>
<table cellspacing='0' border='0' width='100%'>
  <tr>
    <th style='width:200px'>{t}Player{/t}</th>
    <th style='width:200px'>{t}Team{/t}</th>
    <th class='center'>{t}Games{/t}</th>
    <th class='center'>{t}Total defenses{/t}</th>
  </tr>

  {foreach $defences_leaders as $row}
  <tr>
    <td>{$row.firstname} {$row.lastname}</td>
    <td>{$row.teamname}</td>
    <td>{t}Games{/t}</td>
    <td class='center'>{intval($row.games)}</td>
    <td class='center'>{intval($row.deftotal)}</td>
  </tr>
  {/foreach}

</table>
<a href='?view=defensestatus&amp;series={$series_info.series_id}'>{t}Defenseboard{/t}</a>
{/if}

{if $season_info.showspiritpoints} <!-- TODO total -->
<h2>{t}Spirit points average per category{/t}</h2>
<table cellspacing='0' border='0' width='100%'>
  <tr>
    <th style='width:150px'>{t}Team{/t}</th>
    <th>{t}Games{/t}</th>
    {foreach $spirit_categories as $cat}
    {if $cat.index > 0}<th class='center'>{$cat.index}</th>{/if}
    {/foreach}
    <th class='center'>{t}Tot.{/t}</th>
  </tr>
  {foreach $spirit_vg as $team_avg}
  <td>{$team_avg.teamname}</td>
  <td>{$team_avg.games}</td>
  {foreach $spirit_categories as $cat}
  {if $cat.index > 0}
  {if $cat.factor != 0}
  <td class='center'><b>{number_format($team_avg[$cat.category_id], 2)}</b></td>
  {else}
  <td class='center'>{number_format($team_avg[$cat.category_id], 2)}</td>
  {/if}
  {/if}
  {/foreach}
  <td class='center'><b>{number_format($team_avg.total, 2)}</b></td>
  </tr>
  {/foreach}
</table>

<ul>
  {foreach $spirit_categories as $cat}
  {if $cat.index > 0}
  <li>{$cat.index} {$cat.text}</li>
  {/if}
  {/foreach}
</ul>
{/if}

{include file="footer.tpl"}
