{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{t}Roster{/t}</h1>
<h2>{$team_info.name} {u}{$team_info.seriesname}{/u}</h2>

<table style='width:60%' cellpadding='2'>
  <tr>
    <th>{t}Name{/t}</th>
    <th class='center'>{t}Events{/t}</th>
    <th class='center'>{t}Games{/t}</th>
    <th class='center'>{t}Passes{/t}</th>
    <th class='center'>{t}Goals{/t}</th>
    <th class='center'>{t}Tot.{/t}</th>
  </tr>
  {foreach $stats as $player}
  {if !empty($player)}
  <tr>
    <td>
      {assign var="playerinfo" value=$player.playerinfo}
      {if !empty($playerinfo.profile_id)}
      <a href='?view=playercard&amp;series=0&amp;player={$player.id}'>{$player.name}</a>
      {else}
      {$player.name}
      {/if}
    </td>
    <td class='center'>{$player.seasons}</td>
    <td class='center'>{$player.played}</td>
    <td class='center'>{$player.passes}</td>
    <td class='center'>{$player.goals}</td>
    <td class='center'>{$player.total}</td>
  </tr>
  {/if}
  {/foreach}
  {if $teamseasons}
  <tr class='team_players_total_row'>
    <td>
    </td>
    <td class='center'>{$teamseasons}</td>
    <td class='center'>{$teamplayed}</td>
    <td class='center'>{$teampasses}</td>
    <td class='center'>{$teamgoal}</td>
    <td class='center'>{$teamtotal}</td>
  </tr>
  {/if}
</table>

{include file="footer.tpl"}