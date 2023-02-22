{if count($players_with_def)}
<p><span class='profileheader'>{u}{$season_name}{/u} {t}roster{/t}:</span></p>

<table style='width:80%'>
  <tr>
    <th style='width:40%'>{t}Name{/t}</th>
    <th class='center' style='width:15%'>{t}Games{/t}</th>
    <th class='center' style='width:15%'>{t}Passes{/t}</th>
    <th class='center' style='width:15%'>{t}Goals{/t}</th>
    <th class='center' style='width:15%'>{t}Tot.{/t}</th>
    <th class='center' style='width:15%'>{t}Defenses{/t}</th>
  </tr>

  <!-- TODO test -->
  {foreach $players_with_def as $player}
  <tr>
    <td>
      {assign var="playerinfo" value=$team_d_player_info[$player.player_id]}
      {if !empty($playerinfo)}
      {if ($playerinfo.num > -1) {
      <a href='?view=playercard&amp;series=0&amp;player={$player.player_id}'>
        #{$playerinfo.num} {$playerinfo.firstname} {$playerinfo.lastname}
      </a>
      {else}
      <a href='?view=playercard&amp;series=0&amp;player={$player.player_id}'>
        {$playerinfo.firstname} {$playerinfo.lastname}
      </a>
      {/if}
      {if !empty($playerinfo.profile_image)}
      &nbsp;<img width='10' height='10' src='images/linkicons/image.png' alt='{t}Photo{/t}' />
      {/if}
      {else}
      {if $playerinfo.num > -1}
      #{$playerinfo.num} {$playerinfo.firstname} {$playerinfo['lastname']}
      {else}
      {$playerinfo.firstname} {$playerinfo.lastname}
      {/if}
      {/if}
    </td>
    <td class='center'>{$player.games}</td>
    <td class='center'>{$player.fedin}</td>
    <td class='center'>{$player.done}</td>
    <td class='center'>{$player.total}</td>
    <td class='center'>{$player.deftotal}</td>
  </tr>
  {/foreach}
</table>
{/if}