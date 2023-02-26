{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{t}Scoreboard{/t}</h1>
<table style='width:100%' cellpadding='1' border='1'>
  <tr>
    <th style='width:5%'>#</th>
    <th style='width:30%'>
      {if $sort != "name"}<a class='thsort' href='{$view_url}sort=name'>{/if}{t}Player{/t}{if $sort != "name"}</a>{/if}
    </th>
    <th style='width:25%'>
      {if $sort != "team"}<a class='thsort' href='{$view_url}sort=team'>{/if}{t}Team{/t}{if $sort != "team"}</a>{/if}
    </th>
    <th class='center' style='width:8%'>
      {if $sort != "games"}<a class='thsort' href='{$view_url}sort=games'>{/if}{t}Games{/t}{if $sort != "games"}</a>{/if}
    </th>
    <th class='center' style='width:8%'>
      {if $sort != "pass"}<a class='thsort' href='{$view_url}sort=pass'>{/if}{t}Assists{/t}{if $sort != "pass"}</a>{/if}
    </th>
    <th class='center' style='width:8%'>
      {if $sort != "goal"}<a class='thsort' href='{$view_url}sort=goal'>{/if}{t}Goals{/t}{if $sort != "goal"}</a>{/if}
    </th>
    <th class='center' style='width:8%'>
      {if $sort != "callahan"}<a class='thsort' href='{$view_url}sort=callahan'>{/if}{t}Cal.{/t}{if $sort != "callahan"}</a>{/if}
    </th>
    <th class='center' style='width:8%'>
      {if $sort != "total"}<a class='thsort' href='{$view_url}sort=total'>{/if}{t}Tot.{/t}{if $sort != "total"}</a>{/if}
    </th>
  </tr>
  {foreach $scores as $row}
  <tr>
    <td>{$row.index}</td>
    <td class='{if $sort == "name"} highlight {/if}'>
      <a href='?view=playercard&amp;series={$pool_id}&amp;player={$row.player_id}'>
        {$row.firstname} {$row.lastname}
      </a>
    </td>
    <td class='{if $sort == "team"} highlight {/if}'>{$row.teamname}</td>
    <td class='center {if $sort == "games"} highlight {/if}'>{$row.games}</td>
    <td class='center {if $sort == "pass"} highlight {/if}'>{$row.fedin}</td>
    <td class='center {if $sort == "goal"} highlight {/if}'>{$row.done}</td>
    <td class='center {if $sort == "callahan"} highlight {/if}'>{$row.callahan}</td>
    <td class='center {if $sort == "total"} highlight {/if}'>{$row.total}</td>
  </tr>
  {/foreach}
</table>
{include file="footer.tpl"}