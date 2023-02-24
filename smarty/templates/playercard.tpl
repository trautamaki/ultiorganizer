{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{if $player.num}#{$profile.num}{/if} {$profile.firstname} {$profile.lastname}</h1>

<p>{t}Team{/t}: <a class='headerlink' href='?view=teamcard&amp;team={$player.team}'>{$player.teamname}</a></p>

{if $profile}
<table style='width:100%'>

  {if !empty($profile.profile_image) && in_array("profile_image", $public_fields)}
  <tr>
    <td style='width:125px'>
      <a href='{$UPLOAD_DIR}players/{$player.profile_id}/{$profile.profile_image}'>
        <img src='{$UPLOAD_DIR}players/{$player.profile_id}/thumbs/{$profile.profile_image}' alt='{t}Profile image{/t}' /></a>
    </td>
    {else}
  <tr>
    <td></td>
    {/if}
    <td style='vertical-align:top;text-align:left'>
      <table>
        <tr>
          <td></td>
        </tr>
        {if !empty($profile.nickname) && in_array("nickname", $public_fields)}
        <tr>
          <td class='profileheader'>{t}Nickname{/t}</td>
          <td>{$profile.nickname}</td>
        </tr>
        {/if}
        {if !isEmptyDate($profile.birthdate) && in_array("birthdate", $public_fields)}
        <tr>
          <td class='profileheader'>{t}Date of birth{/t}</td>
          <td>{$profile.pretty_birthdate}</td>
        </tr>
        {/if}
        {if !empty($profile.birthplace) && in_array("birthplace", $public_fields)}
        <tr>
          <td class='profileheader'>{t}Place of birth{/t}</td>
          <td>{$profile.birthplace}</td>
        </tr>
        {/if}
        {if !empty($profile.nationality) && in_array("nationality", $public_fields)}
        <tr>
          <td class='profileheader'>{t}Nationality{/t}</td>
          <td>{$profile.nationality}</td>
        </tr>
        {/if}
        {if !empty($profile.throwing_hand) && in_array("throwing_hand", $public_fields)}
        <tr>
          <td class='profileheader'>{t}Hand{/t}</td>
          <td>{u}{$profile.throwing_hand}{/u}</td>
        </tr>
        {/if}
        {if !empty($profile.height) && in_array("height", $public_fields)}
        <tr>
          <td class='profileheader'>{t}Height{/t}</td>
          <td>{$profile.height} {u}cm{/u}</td>
        </tr>
        {/if}
        {if !empty($profile.weight) && in_array("weight", $public_fields)}
        <tr>
          <td class='profileheader'>{t}Weight{/t}</td>
          <td>{$profile.weight} {u}kg{/u}</td>
        </tr>
        {/if}
        {if !empty($profile.position) && in_array("position", $public_fields)}
        <tr>
          <td class='profileheader'>{t}Position{/t}</td>
          <td>{$profile.position}</td>
        </tr>
        {/if}
      </table>
    </td>
  </tr>

  {if !empty($profile.story) && in_array("story", $public_fields)}
  <tr>
    <td colspan='2'>{$profile.pretty_story}</td>
  </tr>
  {/if}
  {if !empty($profile.achievements) && in_array("achievements", $public_fields)}
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2' class='profileheader'>{t}Achievements{/t}</td>
  </tr>
  <tr>
    <td colspan='2'></td>
  </tr>
  <tr>
    <td colspan='2'>{$profile.pretty_achievements}</td>
  </tr>
  {/if}
</table>
{/if}

{if count($urls)}
<table style='width:600px'>
  <tr>
    <td colspan='2' class='profileheader' style='vertical-align:top'>{t}Player pages{/t}:</td>
  </tr>
  {foreach $urls as $url}
  <tr>
    <td style='width:18px'>
      <img width='16' height='16' src='images/linkicons/{$url.type}.png' alt='{$url.type}' />
    </td>
    <td>
      <a href='{$url.url}'>{if !empty($url.name)}{$url.name}{else}{$url.url}{/if}</a>
    </td>
  </tr>
  {/foreach}
</table>
{/if}

{if count($media_urls)}
<table style='width:100%'>
  <tr>
    <td colspan='2' class='profileheader' style='vertical-align:top'>{t}Photos and Videos{/t}:</td>
  </tr>
  {foreach $media_urls as $url}
  <tr>
    <td style='width:18px'><img width='16' height='16' src='images/linkicons/{$url.type}.png' alt='{$url.type}' />
    </td>
    <td>
      <a href='{$url.url}'>{if !empty($url.name)}{$url.name}{else}{$url.url}{/if}</a>
      {if !empty($url.mediaowner)}
      {t}from{/t} {$url.mediaowner};
      {/if}
    </td>
  </tr>
  {/foreach}
</table>
{/if}

{if $games}
<h2>{u}{$current_season_name}{/u}:</h2>
<table border='1' width='100%'>
  <tr>
    <th>{t}Games{/t}</th>
    <th>{t}Passes{/t}</th>
    <th>{t}Goals{/t}</th>
    <th>{t}Tot.{/t}</th>
    {if $show_defence_stats}
    <th>{t}Defenses{/t}</th>
    {/if}
    <th>{t}Pass avg{/t}</th>
    <th>{t}Goals avg.{/t}</th>
    <th>{t}Point avg.{/t}</th>
    {if $show_defence_stats}
    <th>{t}Defenses avg.{/t}</th>
    {/if}
    <th>{t}Wins{/t}</th>
    <th>{t}Win-%{/t}</th>
  </tr>

  <tr>
    <td>{$games}</td>
    <td>{$passes}</td>
    <td>{$goals}</td>
    <td>{$total}</td>
    {if $show_defence_stats}
    <td>{$defenses}</td>
    {/if}
    <td>{$dblPassAvg}</td>
    <td>{$dblGoalAvg}</td>
    <td>{$dblScoreAvg}</td>
    {if $show_defence_stats}
    <td>{$dblDefenAvg}</td>
    {/if}
    <td>{$wins}</td>
    <td>{$dblWinsAvg} %</td>
  </tr>
</table>
{/if}

{if !empty($player.profile_id) && !empty($played_seasons)}
{if count($played_seasons)}
<h2>{t}History{/t}</h2>
{/if}
{/if}

{if $stats && count($stats)}
<!-- Season total -->
<table border='1' width='100%'>
  <tr>
    <th>{t}Event type{/t}</th>
    <th>{t}Division{/t}</th>
    <th>{t}Games{/t}</th>
    <th>{t}Passes{/t}</th>
    <th>{t}Goals{/t}</th>
    <th>{t}Cal.{/t}</th>
    <th>{t}Tot.{/t}</th>
    {if $show_defence_stats}<th>{t}Defenses.{/t}</th>{/if}
    <th>{t}Pass avg.{/t}</th>
    <th>{t}Goal avg.{/t}</th>
    <th>{t}Point avg.{/t}</th>
    {if $show_defence_stats}<th>{t}Def. avg.{/t}</th>{/if}
    <th>{t}Wins{/t}</th>
    <th>{t}Win-%{/t}</th>
  </tr>

  <!-- TODO test this -->
  {foreach $per_season_and_series_stats as $stats}
  <tr>
    <td>{u}$stats.season_type{/u}</td>
    <td>{u}$stats.series_type{/u}</td>
    <td>{$stats.games}</td>
    <td>{$stats.passes}</td>
    <td>{$stats.goals}</td>
    <td>{$stats.cal}</td>
    <td>{$stats.total}</td>
    {if $show_defence_stats}<td>{$stats.defenses}</td>{/if}
    <td>{$stats.dblPassAvg}</td>
    <td>{$stats.dblGoalAvg}</td>
    <td>{$stats.dblScoreAvg}</td>
    {if $show_defence_stats}<td>{$stats.dblDefsAvg}</td>{/if}
    <td>{$stats.wins}</td>
    <td>{$stats.dblWinsAvg} %</td>
  </tr>
  {/foreach}

  <tr class='highlight'>
    <td colspan='2'>{t}Total{/t}</td>
    <td>{$total_games}</td>
    <td>{$total_passes}</td>
    <td>{$total_goals}</td>
    <td>{$total_cal}</td>
    <td>{$total}</td>
    {if $show_defence_stats}<td>{$total_defenses}</td>{/if}
    <td>{$total_dblPassAvg}</td>
    <td>{$total_dblGoalAvg}</td>
    <td>{$total_dblScoreAvg}</td>
    {if $show_defence_stats}<td>{$total_dblDefsAvg}</td>{/if}
    <td>{$total_wins}</td>
    <td>{$total_dblWinsAvg} %</td>
  </tr>
</table>
{/if}

{if $played_seasons && count($played_seasons)}
<table style='white-space: nowrap;' border='1' cellspacing='0' width='100%'>
  <tr>
    <th>{t}Event{/t}</th>
    <th>{t}Division{/t}</th>
    <th>{t}Team{/t}</th>
    <th>{t}Games{/t}</th>
    <th>{t}Passes{/t}</th>
    <th>{t}Goals{/t}</th>
    <th>{t}Cal.{/t}</th>
    <th>{t}Tot.{/t}</th>
    {if $show_defence_stats}<th>{t}Defenses.{/t}</th>{/if}
    <th>{t}Pass avg.{/t}</th>
    <th>{t}Goal avg.{/t}</th>
    <th>{t}Point avg.{/t}</th>
    {if $show_defence_stats}<th>{t}Def. avg.{/t}</th>{/if}
    <th>{t}Wins{/t}</th>
    <th>{t}Win-%{/t}</th>
  </tr>

  {assign var="season_counter" value=0}
  {assign var="prevseason" value=""}
  {foreach $played_seasons as $season}
  {assign var="season_stats" value=$season_stats[$season.seasonname][$season.seriesname]}

  {if $season.season != $prev_season}
  {assign var="season_counter" value=$season_counter + 1}
  {assign var="prevseason" value=$season.season}
  {/if}

  <tr class='{if $season_counter % 2}highlight{/if}'>
    <td>{u}{$season.seasonname}{/u}</td>
    <td>{u}{$season.seriesname}{/u}</td>
    <td>{u}{$season.teamname}{/u}</td>
    <td>{$season_stats.games}</td>
    <td>{$season_stats.passes}</td>
    <td>{$season_stats.goals}</td>
    <td>{$season_stats.callahans}</td>
    <td>{$season_stats.season_total}</td>
    <td>{$season_stats.defenses}</td>
    <td>{$season_stats.dblPassAvg}</td>
    <td>{$season_stats.dblGoalAvg}</td>
    <td>{$season_stats.dblScoreAvg}
    <td>
    <td>{$season_stats.dblDefAvg}
    <td>
    <td>{$season_stats.wins}</td>
    <td>{$season_stats.dblWinAvg} %</td>
  </tr>

  {/foreach}
</table>
{/if}

<p></p>
{if count($player_season_games)}
<h2>{$current_season_name} {t}game events{/t}:</h2>

{foreach $player_season_games as $game}

{assign var=result value=$game_results[$game.game_id].result}

<table border='1' style='width:75%'>
  <tr>
    <th colspan='4'>
      <b>{$result.time}&nbsp;&nbsp;{$result.hometeamname} - {$result.visitorteamname}&nbsp;
        &nbsp;{$result.homescore} - {$result.visitorscore}</b>
    </th>
  </tr>

  {foreach $game_results[$game.game_id].events as $event}
  <tr>
    <td style='width:10%'>{$event.pretty_time}</td>
    <td style='width:10%'>{$event.homescore} - {$event.visitorscore}</td>

    {if $event.assist == $player.player_id}
    <td class='highlight' style='width:40%'>{$player.firstname} {$player.lastname}</td>
    {else}
    {if intval($event.iscallahan)}
    <td class='callahan' style='width:40%'>{t}Callahan-goal{/t}&nbsp;</td>
    {else}
    <td style='width:40%'>{if $event.goal_assist}{$event.goal_assist.firstname} {$event.goal_assist.lastname}{else}&nbsp;{/if}</td>
    {/if}
    {/if}

    {if $event.scorer == $player.player_id}
    <td class='highlight' style='width:40%'>{$player.firstname} {$player.lastname}</td>
    {else}
    <td style='width:40%'>
      {if $event.assist_goal}{$event.assist_goal.firstname} {$event.assist_goal.lastname}{else}&nbsp;{/if}
    </td>
    {/if}
  </tr>
  {/foreach}
</table>
{/foreach}
{/if}

{if !user_anonymous}
<div style='float:left;'>
  <hr>
  <a href='?view=user/addmedialink&amp;player={$player.profile_id}'>{t}Add media{/t}</a>
</div>
{/if}

{include file="footer.tpl"}