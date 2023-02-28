{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h2>{$team1.name} vs. {$team2.name}</h2>

<table border='1' width='100%'>
  <tr>
    <th>{t}Team{/t}</th>
    <th>{t}Games{/t}</th>
    <th>{t}Wins{/t}</th>
    <th>{t}Losses{/t}</th>
    <th>{t}Win-%{/t}</th>
    <th>{t}Scored{/t}</th>
    <th>{t}Scored{/t}/{t}game{/t}</th>
    <th>{t}Let scores{/t}</th>
    <th>{t}Let scores{/t}/{t}game{/t}</th>
    <th>{t}Goal difference{/t}</th>
  </tr>
  <tr>
    <td><a href='?view=teamcard&amp;team=$team_id1'>{$team1.name}</a></td>
    <td>{$nGames}</td>
    <td>{$nT1Wins}</td>
    <td>{$nT1Loses}</td>
    <td>{$dblT1WinP} %</td>
    <td>{$nT1GoalsMade}</td>
    <td>{$dblT1ScoredPerGame}</td>
    <td>{$nT1GoalsAgainst}</td>
    <td>{$dblT1AgainstPerGame}</td>
    <td>{($nT1GoalsMade - $nT1GoalsAgainst)}</td>
  </tr>
  <tr>
    <td><a href='?view=teamcard&amp;team=$team_id2'>{$team2.name}</a></td>
    <td>{$nGames}</td>
    <td>{$nT2Wins}</td>
    <td>{$nT2Loses}</td>
    <td>{$dblT2WinP} %</td>
    <td>{$nT2GoalsMade}</td>
    <td>{$dblT2ScoredPerGame}</td>
    <td>{$nT2GoalsAgainst}</td>
    <td>{$dblT2AgainstPerGame}</td>
    <td>{($nT2GoalsMade - $nT2GoalsAgainst)}</td>
  </tr>
</table>

{if $nGames}
<h2>{t}Played{/t} {t}games{/t}</h2>
<table border='1' cellspacing='2' width='80%'>
  {include file="sortable_table_header.tpl" headers=$games_header sort=$sorting}

  {foreach $games as $game}
  <tr>
    <td>
      {if intval($game.homescore) > intval($game.visitorscore)}
      <b>
        {/if}
        {$game.hometeamname}
        {if intval($game.homescore) > intval($game.visitorscore)}
      </b>
      {/if}
      -
      {if intval($game.homescore) < intval($game.visitorscore)} <b>
        {/if}
        {$game.visitorteamname}
        {if intval($game.homescore) < intval($game.visitorscore)} </b>
          {/if}
    </td>
    <td>
      <a href='?view=gameplay&amp;game={$game.game_id}'>{$game.homescore} - {$game.visitorscore}</a>
    </td>
    <td>
      {u}{$game.seasonname}{/u}: <a href='?view=poolstatus&amp;pool={$game.pool_id}'>{$game.name}</a>
    </td>
  </tr>
  {/foreach}
</table>

<h2>{t}Scoreboard{/t}</h2>
<table border='1' width='80%'>
  <tr>
    <th>#</th>
    {include file="sortable_table_header.tpl" headers=$scoreboard_header sort=$sorting}
  <tr>
  {for $i = 0; $i < 200 && !empty($points[$i][0]); $i++}
  <tr>
    <td>{$i + 1}</td>
    <td class='{if $sorting == "pname"}highlight{/if}'>
      <a href='?view=playercard&amp;player={$points[$i][7]}'>{$points[$i][1]}</a>
    </td>
    <td class='{if $sorting == "pteam"}highlight{/if}'>{$points[$i][2]}</td>
    <td class='{if $sorting == "pgames"}highlight{/if}'>{$points[$i][3]}</td>
    <td class='{if $sorting == "ppasses"}highlight{/if}'>{$points[$i][4]}</td>
    <td class='{if $sorting == "pgoals"}highlight{/if}'>{$points[$i][5]}</td>
    <td class='{if $sorting == "ptotal"}highlight{/if}'>{$points[$i][6]}</td>
  </tr>
  {/for}
</table>
{/if} <!-- $nGames -->
{include file="footer.tpl"}