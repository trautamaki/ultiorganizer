<style>
  .game_row_date {
    width: 60px
  }

  .game_row_time {
    width: 40px
  }

  .game_row_field {
    width: 60px
  }

  .game_row_team {
    width: 120px
  }

  .game_row_againstmark {
    width: 5px
  }

  .game_row_series {
    width: 80px
  }

  .game_row_pool {
    width: 130px
  }

  .game_row_score {
    width: 15px
  }

  .game_row_info {
    width: 80px
  }

  .game_row_gamename {
    width: 50px
  }

  .game_row_media {
    width: 40px
  }
</style>
<tr style='width:100%'>
  {if $date}
  <!-- TODO verify -->
  <td class='game_row_date'><span>{$game.time|date_format: "%j.%n.%Y"}</span></td>
  {/if}

  {if $time}
  <td class='game_row_time'><span>{$game.time|date_format: "%H:%i"}</span></td>
  {/if}

  {if $field}
  {if !empty($game.fieldname)}
  <td class='game_row_field'><span>{t}Field{/t} {$game.fieldname}</span></td>
  {else}
  <td class='game_row_field'></td>
  {/if}
  {/if}

  {if $game.hometeam}
  <td class='game_row_team'><span>{$game.hometeamname}</span></td>
  {else}
  <td class='game_row_team'><span class='schedulingname'>{t}{$game.phometeamname}{/t}</span></td>
  {/if}

  <td class='game_row_againstmark'>-</td>

  {if $game.visitorteam}
  <td class='game_row_team'><span>{$game.visitorteamname}</span></td>
  {else}
  <td class='game_row_team'><span class='schedulingname'>{t}{$game.pvisitorteamname}{/t}</span></td>
  {/if}

  {if $series}
  <td class='game_row_series'><span>{t}{$game.seriesname}{/t}</span></td>
  {/if}

  {if $pool}
  <td class='game_row_pool'><span>{t}{$game.poolname}{/t}</span></td>
  {/if}

  {if !$game.hasstarted}
  <td class='game_row_score'><span>?</span></td>
  <td class='game_row_againstmark'><span>-</span></td>
  <td class='game_row_score'><span>?</span></td>
  {else}
  {if $game.isongoing}
  <td class='game_row_score'><span><em>{$game.homescore}</em></span></td>
  <td class='game_row_againstmark'><span>-</span></td>
  <td class='game_row_score'><span><em>{$game.visitorscore}</em></span></td>
  {else}
  <td class='game_row_score'><span>{$game.homescore}</span></td>
  <td class='game_row_againstmark'><span>-</span></td>
  <td class='game_row_score'><span>{$game.visitorscore}</span></td>
  {/if}
  {/if}

  {if $game.gamename}
  <td class='game_row_gamename'><span>{t}{$game.gamename}{/t}</span></td>
  {else}
  <td class='game_row_gamename'></td>
  {/if}

  {if $media}
  <td class='game_row_media' style='white-space: nowrap;'>
    {if count($game_urls) && intval($game.isongoing) || !$game.hasstarted}
    {foreach $game_urls as $url}
    {if !empty($url.name)}
    <a href='{$url.url}'><img border='0' width='16' height='16' title='{$url.name}' src='images/linkicons/{$url.type}.png' alt='{$url.type}' /></a>
    {else}
    <a href='{$url.url}'><img border='0' width='16' height='16' title='{t}Live Broadcasting{/t}' src='images/linkicons/{$url.type}.png' alt='{$url.type}' /></a>
    {/if}
    {/foreach}
    {/if}
  </td>
  {/if}

  {if $info}
  {if !$game.hasstarted}
  {if $game.hometeam && $game.visitorteam}
  {if count($xgames) > 0}
  <td class='right' class='game_row_info'>
    <span style='white-space: nowrap'>
      <a href='?view=gamecard&amp;team1={$game.hometeam}&amp;team2={$game.visitorteam}'>{t} Game history{/t}</a>
    </span>
  </td>
  {else}
  <td class='left' class='game_row_info'></td>
  {/if}
  {else}
  <td class='left' class='game_row_info'></td>
  {/if}
  {else}
  {if !intval($game.isongoing)}
  {if intval($game.scoresheet)}
  <td class='right' class='game_row_info'>
    <span>&nbsp;<a href='?view=gameplay&amp;game={$game.game_id}'>{t} Game play{/t}</a></span>
  </td>
  {else}
  <td class='left' class='game_row_info'></td>
  {/if}
  {else}
  {if intval($game.scoresheet)}
  <td class='right' class='game_row_info'>
    <span>&nbsp;&nbsp;<a href='?view=gameplay&amp;game={$game.game_id}'>{t} Ongoing{/t}</a></span>
  </td>
  {else}
  <td class='right' class='game_row_info'>&nbsp;&nbsp;{t}Ongoing{/t}</td>
  {/if}
  {/if}
  {/if}
  {if $rss}
  <td class='feed-list'>
    <a style='color: #ffffff;' href='ext/rss.php?feed=game&amp;id1={$game.game_id}'>
      <img src='images/feed-icon-14x14.png' width='10' height='10' alt='RSS' />
    </a>
  </td>
  {/if}
  {/if}
</tr>