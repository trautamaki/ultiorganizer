{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{$team_info.name} {u}{$team_info.type}{/u}</h1>
{if intval($team_info.country)}
<p>
  <img height='10' src='images/flags/tiny/{$team_info.flagfile}' alt='' />&nbsp;
  <a class='headerlink' href='?view=countrycard&amp;country={$team_info.country}'>{$team_info.countryname}</a>
</p>
{/if}
{if intval($team_info.club)}
<p>
  {t}Club{/t}
  <a class='headerlink' href='?view=clubcard&amp;club={$team_info.club}'>{$team_info.clubname}</a>
</p>
{if $profile}
<table style='width:100%'>
  {if !empty($profile.profile_image)}
  <tr>
    <td colspan='2'>
      <a href='{$UPLOAD_DIR}teams/{$team_info.team_id}/{$profile.profile_image}'>
        <img src='{$UPLOAD_DIR}teams/{$team_info.team_id}/thumbs/{$profile.profile_image}' alt='{t}Profile image{/t}' />
      </a>
    </td>
  </tr>
  {else}
  <tr>
    <td colspan='2'></td>
  </tr>
  {/if}

  {if !empty($profile.coach)}
  <tr>
    <td class='profileheader' style='width:100px'>{t}Coach{/t}</td>
    <td>{$profile.coach}</td>
  </tr>
  {/if}
  {if !empty($profile.captain)}
  <tr>
    <td class='profileheader' style='width:100px'>{t}Captain{/t}</td>
    <td>{$profile.captain}</td>
  </tr>
  {/if}

  {if !empty($profile.story)}
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <!-- TODO check br -->
  <tr>
    <td colspan='2'>{$profile.story}</td>
  </tr>
  {/if}

  {if !empty($profile.achievements)}
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <!-- TODO check br -->
  <tr>
    <td class='profileheader' colspan='2'>{t}Achievements{/t}</td>
  </tr>
  <tr>
    <td colspan='2'></td>
  </tr>
  <tr>
    <td colspan='2'>{$profile.achievements}</td>
  </tr>
  {/if}
</table>
{/if}
{/if}
{if count($urls)}
<table style='width:100%'>
  <tr>
    <td colspan='2' class='profileheader' style='vertical-align:top'>{t}Team pages{/t}</td>
  </tr>
  {foreach $urls as $url}
  <tr>
    <td style='width:18px'>
      <img width='16' height='16' src='images/linkicons/{$url.type}.png' alt='{$url.type}' />
    </td>
    <td>
      {if !empty($url.name)}
      <a href='{$url.url}'>{$url.name}</a>
      {else}
      <a href='{$url.url}'>{$url.url}</a>
      {/if}
    </td>
  </tr>
  {/foreach}
</table>
{/if}

{if count($urls)}
<table style='width:100%'>
  <tr>
    <td colspan='2' class='profileheader' style='vertical-align:top'>
      {t}Photos and Videos{/t}:
    </td>
  </tr>
  {foreach $media_urls as $url}
  <tr>
    <td style='width:18px'>
      <img width='16' height='16' src='images/linkicons/{$url.type}".png' alt='{$url.type}' />
    </td>
    <td>
      {if !empty($url.name)}
      <a href='{$url.url}'>{$url.name}</a>
      {else}
      <a href='{$url.url}'>{$url.url}</a>
      {/if}
      {if !empty($url.mediaowner)}
      {t}from{/t} $url.mediaowner
      {/if}
    </td>
  </tr>
  {/foreach}
</table>
{/if}

{if $show_defense_stats}
{include file="teamcard/defense_stats.tpl"}
{else}
<p><span class='profileheader'>{u}{$season_name}{/u} {t}roster{/t}:</span></p>

<table style='width:80%'>
  <tr>
    <th style='width:40%'>{t}Name{/t}</th>
    <th class='center' style='width:15%'>{t}Games{/t}</th>
    <th class='center' style='width:15%'>{t}Passes{/t}</th>
    <th class='center' style='width:15%'>{t}Goals{/t}</th>
    <th class='center' style='width:15%'>{t}Tot.{/t}</th>
  </tr>

  {foreach $team_players as $player}
  {assign var="playerinfo" value=$team_player_info[$player.player_id]}
  <tr>
    <td>
      {if !empty($playerinfo.profile_id)}
      {if $playerinfo.num > -1}
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
      #{$playerinfo.num} {$playerinfo.firstname} {$playerinfo.lastname}
      {else}
      {$playerinfo.firstname} {$playerinfo.lastname}
      {/if}
      {/if}
    </td>
    <td class='center'>{$player.games}</td>
    <td class='center'>{$player.fedin}</td>
    <td class='center'>{$player.done}</td>
    <td class='center'>{$player.total}</td>
  </tr>
  {/foreach}
</table>
{/if}

{if count($all_games)}
<h2>{u}{$season_name}{/u}:</h2>
<p>{t}Division{/t}: <a href='?view=poolstatus&amp;series={$teaminfo.series}'>{u}{$teaminfo.seriesname}{/u}</a></p>
<table style='width:80%'>
  {foreach $all_games as $game}
  {include file="game_row.tpl" game=$game date=false time=false field=false series=false pool=false false=true rss=false media=true}
  {/foreach}
</table>
{/if}

{if count($seasons)}
<h2>{t}History{/t}:</h2>
<table border='1' width='100%'>
  <tr>
    <th>{t}Event type{/t}</th>
    <th>{t}Games{/t}</th>
    <th>{t}Wins{/t}</th>
    <th>{t}Losses{/t}</th>
    <th>{t}Win-%{/t}</th>
    <th>{t}Goals for{/t}</th>
    <th>{t}GF/game{/t}</th>
    <th>{t}against{/t}</th>
    <th>{t}GA/game{/t}</th>
    <th>{t}diff.{/t}</th>
    {if show_defense_stats}<th>{t}Defenses{/t}</th>{/if}
  </tr>
  {foreach $stats_per_season_type as $type => $stat}
  <tr>
    <td>{u}{$type}{/u}</td>
    <td>{$stat.games}</td>
    <td>{$stat.wins}</td>
    <td>{$stat.losses}</td>
    <td>{$stat.win_p} %</td>
    <td>{$stat.goals_made}</td>
    <td>{$stat.goals_per_game}</td>
    <td>{$stat.goals_against}</td>
    <td>{$stat.goals_a_per_game}</td>
    <td>{$stat.goals_diff}</td>
    {if show_defense_stats}<td>{$stat.defenses}</td>{/if}
  </tr>
  {/foreach}
  <tr class='highlight'>
    <td>{t}Total{/t}</td>
    <td>{$stats_total.total_games}</td>
    <td>{$stats_total.total_wins}</td>
    <td>{$stats_total.total_losses}</td>
    <td>{$stats_total.total_win_p} %</td>
    <td>{$stats_total.total_goals_made}</td>
    <td>{$stats_total.total_goals_per_game}</td>
    <td>{$stats_total.total_goals_against}</td>
    <td>{$stats.total_goals_a_per_game}</td>
    <td>{$stats.total_goals_diff}</td>
    {if show_defense_stats}<td>{$stats_total.total_defenses}</td>{/if}
  </tr>
</table>

<table style='white-space: nowrap;' border='1' cellspacing='0' width='100%'>
  <tr>
    <th>{t}Event{/t}</th>
    <th>{t}Division{/t}</th>
    <th>{t}Pos.{/t}</th>
    <th>{t}Games{/t}</th>
    <th>{t}Wins{/t}</th>
    <th>{t}Losses{/t}</th>
    <th>{t}Win-%{/t}</th>
    <th>{t}Goals for{/t}</th>
    <th>{t}GF/game{/t}</th>
    <th>{t}against{/t}</th>
    <th>{t}GA/game{/t}</th>
    <th>{t}diff.{/t}</th>
    {if show_defense_stats}<th>{t}Defenses{/t}</th>{/if}
  </tr>

  {assign var=seasoncounter value=0}
  {foreach $stats_per_season as $stats}

  {if $seasoncounter % 2}
  <tr class='highlight'>
    {else}
  <tr>
    {/if}
    <td>{u}{$stats.season_name}{/u}</td>
    <td>{u}{$stats.series_name}{/u}</td>
    <td>{$stats.standing}</td>
    <td>{$stats.games}</td>
    <td>{$stats.wins}</td>
    <td>{$stats.losses}</td>
    <td>{$stats.win_p}</td>
    <td>{$stats.goals_made}</td>
    <td>{$stats.goals_per_game}</td>
    <td>{$stats.goals_against}</td>
    <td>{$stats.goals_a_per_game}</td>
    <td>{$stats.goals_diff}</td>
    {if show_defense_stats}<td>{$stats.defenses}</td>{/if}
  </tr>
  {assign var=seasoncounter value=$seasoncounter+1}
  {/foreach}
  {/if}
</table>

<h2>{t}Game history{/t}</h2>

<table border='1' cellspacing='2' width='100%'>
  <tr>
    <th><a class='thsort' href="?view=teamcard&amp;team=$teamId&amp;sort=team\">{t}Team{/t}</a></th>
    <th><a class='thsort' href="?view=teamcard&amp;team=$teamId&amp;sort=result\">{t}Result{/t}</a></th>
    <th><a class='thsort' href="?view=teamcard&amp;team=$teamId&amp;sort=serie">{t}Division{/t}</a></th>
  </tr>

  {foreach $played as $game}
  {if $game.homescore > $game.visitorscore}
  <tr>
    <td><b>{$game.hometeamname}</b> - {$game.visitorteamname}</td>
    {else}
  <tr>
    <td>{$game.hometeamname} - <b>{$game.visitorteamname}</b></td>
    {/if}
    <td><a href="?view=gameplay&amp;game={$game.game_id}">{$game.homescore} - {$game.visitorscore}</a></td>
    <td>{u}{$game.season_name}{/u}: <a href="?view=poolstatus&amp;pool={$game.pool_id}">{u}{$game.name}{/u}</a></td>
  </tr>
  {/foreach}
</table>

{if $user_anonymous}
<div style='float:left;'>
  <hr><a href='?view=user/addmedialink&amp;team=$teamId'>{t}Add media{/t}</a>
</div>
{/if}

{include file="footer.tpl"}