<table cellpadding='2' style='width:100%;'>
  <tr>
    <th style='width:20%;'>{t}Placement{/t}</th>
    {foreach $series as $serie}
    <th style='width: {80 / count($series)}%;'>
      <a href='?view=seriesstatus&series={$serie.series_id}'>{u}{$serie.name}{/u}</a>
    </th>
    {/foreach}
  </tr>
  {for $i = 0 to $max_placements}
  {if $i < 3}
  <tr style='font-weight:bold;border-bottom-style:dashed;border-bottom-width:1px;border-bottom-color:#E0E0E0;'>
  {else}
  <tr style='border-bottom-style:dashed;border-bottom-width:1px;border-bottom-color:#E0E0E0;'>
    {/if}
    {if $i == 0}
    <td>{t}Gold{/t}</td>
    {elseif $i == 1}
    <td>{t}Silver{/t}</td>
    {elseif $i == 2}
    <td>{t}Bronze{/t}</td>
    {elseif $i > 2}
    <td>ordinal($i + 1)</td>
    {/if}

    {for $j = 0 to count($series)}
    <!-- TODO check -->
    <td>
      {if !empty($series_results[$j][$i])}
      {if intval($season_info.isinternational)}
      <img height='10' src='images/flags/tiny/{$team.flagfile}' alt=''/>
      {/if}
      <a href='?view=teamcard&amp;team={$team.team_id}'>{$team.name}</a>
      {else}
      &nbsp;
      {/if}
    </td>
    {/for}
  </tr>
  {/for}
</table>