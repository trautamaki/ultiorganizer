{include file="header.tpl"}
{include file="leftmenu.tpl"}

<!-- TODO test media, defenseboard, etc. -->

{if $game_has_started}
<h1>{$game_result.hometeamname} - {$game_result.visitorteamname}
  &nbsp;&nbsp;&nbsp;&nbsp;
  {$game_result.homescore} - {$game_result.visitorscore}
  {if intval($game_result.isongoing)}
  {t}ongoing{/t}
  {/if}
</h1>

{if $game_not_fed_in}
<h2>{t}Not fed in{/t}</h2>
<p>{t}Please check the status again later{/t}.</p>
{else} <!-- game_not_fed_in -->
<!-- Scoreboard -->
<table style='width:100%'>
  <tr>
    <td valign='top' style='width:45%'>
      <table width='100%' cellspacing='0' cellpadding='0' border='0'>
        <tr style='height=20'>
          <td align='center'>
            <b>{$game_result.hometeamname}</b>
          </td>
        </tr>
      </table>
      <table width='100%' cellspacing='0' cellpadding='3' border='0'>
        <tr>
          <th class='home'>#</th>
          <th class='home'>{t}Name{/t}</th>
          <th class='home center'>{t}Assists{/t}</th>
          <th class='home center'>{t}Goals{/t}</th>
          <th class='home center'>{t}Tot.{/t}</th>
        </tr>
        {foreach $home_players_stats as $row}
        {include file="gameplay/player_row.tpl" row=$row captain=$home_captain}
        {/foreach}
      </table>
    </td>
    <td style='width:10%'>&nbsp;</td>
    <td valign='top' style='width:45%'>
      <table width='100%' cellspacing='0' cellpadding='0' border='0'>
        <tr>
          <td><b>
              {$game_result.visitorteamname}</b></td>
        </tr>
      </table>
      <table width='100%' cellspacing='0' cellpadding='3' border='0'>
        <tr>
          <th class='guest'>#</th>
          <th class='guest'>{t}Name{/t}</th>
          <th class='guest center'>{t}Assists{/t}</th>
          <th class='guest center'>{t}Goals{/t}</th>
          <th class='guest center'>{t}Tot.{/t}</th>
        </tr>
        {foreach $away_players_stats as $row}
        {include file="gameplay/player_row.tpl" row=$row captain=$away_captain}
        {/foreach}
      </table>
    </td>
  </tr>
</table>

<!-- Timeline -->
<table border='1' style='height: 15px; color: white; border-width: 1; border-color: white; width: 100%;'>
  <tr>
    {foreach $timeline_items as $item}
    <td style='width:{$item.width_a}px' class='{$item.color}' title='{$item.td_title}'></td>
    {/foreach}
  </tr>
</table>
<table border='1' cellpadding='2' width='100%'>
  <tr>
    <th>{t}Scores{/t}</th>
    <th>{t}Assist{/t}</th>
    <th>{t}Goal{/t}</th>
    <th>{t}Time{/t}</th>
    <th>{t}Dur.{/t}</th>
    {if $has_game_events || $has_media_events}
    <th>{t}Game events {/t}</th>
    {/if}
  </tr>
  {foreach $game_goals as $goal}
  {if $goal.halftime}
  <tr>
    <td colspan='6' class='halftime'>{t}Half-time{/t}</td>
  </tr>
  {/if}
  <tr>
    <td style='width:45px;white-space: nowrap {if intval($goal.ishomegoal) == 1} home {else} guest {/if}'>
      {$goal.homescore} - {$goal.visitorscore}
    </td>
    {if intval($goal.iscallahan)}
    <td class='callahan'>{t}Callahan-goal{/t}&nbsp;</td>
    {else}
    <td>{$goal.assistfirstname} {$goal.assistlastname}&nbsp;</td>
    {/if}
    <td>{$goal.scorerfirstname} {$goal.scorerlastname}&nbsp;</td>
    <td>{$goal.pretty_time}</td>
    <td>{$goal.pretty_duration}</td>
    {if $has_game_events || $has_media_events}
    <td>
      <!-- Game events -->
      {foreach $goal.game_events as $event}
      {if $event.skip_timeout_hack} {continue} {/if}
      <div class='{if intval($event.ishome)} home {else} guest {/if}'>
        {$event.game_event} {$event.pretty_time}
      </div>
      {/foreach}
      <!-- Media events -->
      {if count($goal.media_events)}
      <div class='mediaevent'>
        {foreach $goal.media_events as $event}
        <a style='color: #ffffff;' href='{$event.url}'>
          <img width='12' height='12' src='images/linkicons/{$event.type}.png' alt='{$event.type}' />
        </a>
        {/foreach}
      </div>
      {/if}
    </td>
    {/if}
  </tr>
  {/foreach}
  {if intval($game_result.isongoing)}
  <tr style='border-style:dashed;border-width:1px;'>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    {if $has_game_events || $has_media_events}
    <td>&nbsp;</td>
    {/if}
  </tr>
  {/if}
</table>

{if !empty($game_result.official)}
<p>{t}Game official{/t}: {$game_result.official}</p>
{/if}
{if count($urls) > count($media_events)}
<h2>{t}Photos and Videos{/t}</h2>
<table>
  {foreach $urls as $url}
  {if !empty($url.time)} {continue} {/if}
  <tr>
    <td colspan='2'>
      <img width='16' height='16' src='images/linkicons/{$url.type}.png' alt='{$url.type}' />
    </td>
    <td>
      {if !empty($url.name)}
      <a href='{$url.url}'>{$url.name}</a>
      {else}
      <a href='{$url.url}'>{$url.url}</a>
      {/if}
      {if !empty($url.mediaowner)}
      {t}from{/t} {$url.mediaowner} {/if}
    </td>
  </tr>
  {/foreach}
</table>
{/if}
{if !intval($game_result.isongoing)}
<table style='width:70%' border='1' cellpadding='2' cellspacing='0'>
  <tr>
    <th></th>
    <th>{$game_result.hometeamname}</th>
    <th>{$game_result.visitorteamname}</th>
  </tr>
  <tr>
    <td>{t}Goals{/t}:</td>
    <td class='home'>{$nHGoals}</td>
    <td class='guest'>{$nVGoals}</td>
  </tr>
  <tr>
    <td>{t}Time on offence{/t}:</td>
    <td class='home'>{$nHTotalTime} min ({$dblHAvgTimeOnOffence} %)</td>
    <td class='guest'>{$nVTotalTime} min ({$dblVAvgTimeOnOffence} %)</td>
  </tr>
  <tr>
    <td>{t}Time on defense{/t}:</td>
    <td class='home'>{$nVTotalTime} min ({$dblVAvgTimeOnOffence} %)</td>
    <td class='guest'>{$nHTotalTime} min ({$dblHAvgTimeOnOffence} %)</td>
  </tr>
  <tr>
    <td>{t}Time on offence{/t}/{t}goal{/t}:</td>
    <td class='home'>{$dlbHTimeOnOffence} min</td>
    <td class='guest'>{$dlbVTimeOnOffence} min</td>
  </tr>
  <tr>
    <td>{t}Time on defense{/t}/{t}goal{/t}:</td>
    <td class='home'>{$dlbVTimeOnOffence} min</td>
    <td class='guest'>{$dlbHTimeOnOffence} min</td>
  </tr>
  <tr>
    <td>{t}Goals from starting on offence{/t}:</td>
    <td class='home'>{abs($nHGoals - $nHBreaks)}/{$nHOffencePoint} ({$dblHAvgGoalsFromOffence} %)</td>
    <td class='guest'>{abs($nVGoals - $nVBreaks)}/{$nVOffencePoint} ({$dblVAvgGoalsFromOffence} %)</td>
  </tr>
  <tr>
    <td>{t}Goals from starting on defense{/t}:</td>
    <td class='home'>{$nHBreaks}/{$nVOffencePoint} ({$dblHAvgGoalsFromDefense} %)</td>
    <td class='guest'>{$nVBreaks}/{$nHOffencePoint} ({$dblVAvgGoalsFromDefense} %)</td>
  </tr>
  {if $nHLosesDisc + $nVLosesDisc > 0}
  <tr>
    <td>{t}Turnovers{/t}:</td>
    <td class='home'>{$nHLosesDisc}</td>
    <td class='guest'>{$nVLosesDisc}</td>
  </tr>
  {/if}
  <tr>
    <td>{t}Goals from turnovers{/t}:</td>
    <td class='home'>{$nHBreaks}</td>
    <td class='guest'>{$nVBreaks}</td>
  </tr>
  <tr>
    <td>{t}Time-outs{/t}:</td>
    <td class='home'>{$nHTO}</td>
    <td class='guest'>{$nVTO}</td>
  </tr>
  {if $seasoninfo.spiritmode > 0 && ($seasoninfo.showspiritpoints || $is_season_admin)}
  <tr>
    <td>{t}Spirit points{/t}:</td>
    <td class='home'>{$game_result.homesotg}</td>
    <td class='guest'>{$game_result.visitorsotg}</td>
  </tr>
  {/if}
</table>
{/if}
<p>
  <a href='?view=gamecard&amp;team1={$game_result.hometeam}&amp;team2={$game_result.visitorteam}'>
    {t}Game history{/t}
  </a>
</p>
{if !$user_anonymous}
<div style='float:left;'>
  <hr><a href='?view=user/addmedialink&amp;game={$game_id}'>{t}Add media{/t}</a>
</div>
{/if}
{if $show_defense_stats}
<br><br>
<h3>{t}Defensive plays{/t}</h3>
<table style='width:100%'>
  <tr>
    <td valign='top' style='width:45%'>
      <table width='100%' cellspacing='0' cellpadding='0' border='0'>
        <tr style='height=20'>
          <td align='center'><b>
              {$game_result.hometeamname}</b></td>
        </tr>
      </table>
      <table width='100%' cellspacing='0' cellpadding='3' border='0'>
        <tr>
          <th class='home'>#</th>
          <th class='home'>{t}Name{/t}</th>
          <th class='home center'>{t}Defenses{/t}</th>
        </tr>
        {foreach $home_defenses as $row}
        <tr>
          <td style='text-align:right'>{$row.num}</td>
          <td>
            <a href='?view=playercard&amp;series=0&amp;player={$row.player_id}'>
              {$row.firstname})&nbsp; {$row.lastname}
            </a>
            {if $row.player_id == $homecaptain}&nbsp;{t}(C){/t}{/if}
          </td>
          <td class='center'>{$row.done}</td>
        </tr>
        {/foreach}
      </table>
    </td>
    <td style='width:10%'>&nbsp;</td>
    <td valign='top' style='width:45%'>
      <table width='100%' cellspacing='0' cellpadding='0' border='0'>
        <tr>
          <td><b>{$game_result.visitorteamname}</b></td>
        </tr>
        {foreach $visitor_defenses as $row}
        <tr>
          <td style='text-align:right'>{$row.num}</td>
          <td>
            <a href='?view=playercard&amp;series=0&amp;player={$row.player_id}'>
              {$row.firstname})&nbsp; {$row.lastname}
            </a>
            {if $row.player_id == $awaycaptain}&nbsp;{t}(C){/t}{/if}
          </td>
          <td class='center'>{$row.done}</td>
        </tr>
        {/foreach}
      </table>
      <table width='100%' cellspacing='0' cellpadding='3' border='0'>
        <tr>
          <th class='guest'>#</th>
          <th class='guest'>{t}Name{/t}</th>
          <th class='guest center'>{t}Defenses{/t}</th>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table border='1' cellpadding='2' width='100%'>
  <tr>
    <th>{t}Time defense play{/t}</th>
    <th>{t}Player{/t}</th>
    <th>{t}Callahan defense{/t}</th>
  </tr>
  {foreach $all_defenses as $defense}
  <tr>
    <td style='width:120px;white-space: nowrap' class="{if intval($defense.ishomedefense==1)} home {else} guest {/if}">
      SecToMin($defense['time'])
    </td>
    <td>{$defense.defenderfirstname} {$defense.defenderlastname}&nbsp;</td>
    <td style='width:100px' {if intval($defense.iscallahan)} class='callahan' {/if}>&nbsp;</td>
  </tr>
  {/foreach}
</table>

{/if} <!-- show_defense_stats -->
{/if} <!-- game_not_fed_in -->
{else} <!-- game_has_started -->
{if $game_result.hometeam && $game_result.visitorteam}
<h1>
  {$game_result.hometeamname} - {$game_result.visitorteamname}
  &nbsp;&nbsp;&nbsp;&nbsp;
  ? - ?
</h1>
{else}
<h1>
  {u}{$game_result.gamename}{/u}
</h1>
<h2>
  {u}{$game_result.phometeamname}{/u} - {u}{$game_result.pvisitorteamname}{/u}
  &nbsp;&nbsp;&nbsp;&nbsp;
  ? - ?
</h2>
{/if}
<p>
  {$pretty_game_result_time} {$hourformat_game_result_time}
  {if !empty($game_result.fieldname)}
  {t}on field{/t} {$game_result.fieldname}
  {/if}
</p>
{/if} <!-- game_has_started -->

{include file="footer.tpl"}