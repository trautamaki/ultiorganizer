{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{$profile.name}</h1>

<table style='width:100%'>
  <tr>
    {if !empty($profile.profile_image)}
    <td style='width:165px'>
      <a href='UPLOAD_DIRclubs/{$club_id}/{$profile.profile_image}'>
        <img src='UPLOAD_DIRclubs/{$club_id}/thumbs/{$profile.profile_image}' alt='{t}Profile image{/t}' />
      </a>
    </td>
    {else}
    <td></td>
    {/if}
    <td style='vertical-align:top;text-align:left'>
      <table border='0'>
        <tr>
          <td></td>
        </tr>
        {if $profile.country > 0}
        <tr>
          <td class='profileheader'>{t}Country{/t}:</td>
          <td style='white-space: nowrap;'>
            <div style='float: left; clear: left;'>
              <a href='?view=countrycard&amp;country={$country_info.country_id}'>{$country_info.name}</a>
            </div>
            <div>&nbsp;<img src='images/flags/tiny/{$country_info.flagfile}' alt='' /></div>
          </td>
        </tr>
        {/if}
        {if !empty($profile.city)}
        <tr>
          <td class='profileheader'>{t}City{/t}:</td>
          <td>{$profile.city}</td>
        </tr>
        {/if}
        {if !empty($profile.founded)}
        <tr>
          <td class='profileheader'>{t}Founded{/t}:</td>
          <td>{$profile.founded}</td>
        </tr>
        {/if}
        {if !empty($profile.homepage)}
        <tr>
          <td class='profileheader'>{t}Homepage{/t}:</td>
          <td>
            <a href='{if substr(strtolower($profile.homepage), 0, 4) != "http"}http://{/if}{$profile.homepage}'>{$profile.homepage}</a>
          </td>
        </tr>
        {/if}
        {if !empty($contacts)}
        <tr>
          <td class='profileheader' style='vertical-align:top'>{t}Contacts{/t}:</td>
          <td>
            {foreach $contacts as $contact}
            {$contact}<br>
            {/foreach}
          </td>
        </tr>
        {/if}
      </table>
    </td>
  </tr>
  {if !empty($story)}
  <tr>
    <td colspan='2'>
      {foreach $story as $line}
      {$line}<br>
      {/foreach}
    </td>
  </tr>
  {/if}
  {if !empty($achievements)}
  <tr>
    <td colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td class='profileheader' colspan='2'>{t}Achievements{/t}:</td>
  </tr>
  <tr>
    <td colspan='2'></td>
  </tr>
  <tr>
    <td colspan='2'>
      {foreach $achievements as $line}
      {$line}<br>
      {/foreach}
    </td>
  </tr>
  {/if}
  {if count($urls)}
  <tr>
    <td colspan='2' class='profileheader' style='vertical-align:top'>{t}Club pages{/t}:</td>
  </tr>
  <tr>
    <td colspan='2'>
      <table>
        {foreach $urls as $url}
        <tr>
          <td colspan='2'>
            <img width='16' height='16' src='images/linkicons/{$url.type}.png' alt='{$url.type}' />
          </td>
          <td>
            <a href='{$url.url}'>{if !empty($url.name)}{$url.name}{else}{$url.url}{/if}</a>
          </td>
        </tr>
        {/foreach}
      </table>
    </td>
  </tr>
  {/if}
  {if count($media_urls)}
  <tr>
    <td colspan='2' class='profileheader' style='vertical-align:top'>{t}Photos and Videos{/t}:</td>
  </tr>
  <tr>
    <td colspan='2'>
      <table>
        {foreach $media_urls as $url}
        <tr>
          <td colspan='2'>
            <img width='16' height='16' src='images/linkicons/{$url.type}.png' alt='{$url.type}' />
          </td>
          <td>
            <a href='{$url.url}'>{if !empty($url.name)}{$url.name}{else}{$url.url}{/if}</a>
            {if !empty($url.mediaowner)}
            {t}from{/t} {$url.mediaowner}
            {/if}
          </td>
        </tr>
        {/foreach}
      </table>
    </td>
  </tr>
  {/if}
</table>

{if count($teams)}
<h2>{u}{$current_season_name}{/u}:</h2>
<table style='white-space: nowrap;' border='0' cellspacing='0' cellpadding='2' width='90%'>
  <tr>
    <th>{t}Team{/t}</th>
    <th>{t}Division{/t}</th>
    <th colspan='3'></th>
  </tr>

  {foreach $teams as $team}
  <tr>
    <td style='width:30%'>
      <a href='?view=teamcard&amp;team={$team.team_id}'>{$team.name}</a>
    </td>
    <td style='width:30%'>
      <a href='?view=poolstatus&amp;series=$team.series_id}'>{u}{$team.seriesname}{/u}</a>
    </td>
    {if $is_stats_data_available}
    <td class='right' style='width:15%'>
      <a href='?view=playerlist&amp;team={$team.team_id}'>{t}Roster{/t}</a>
    </td>
    <td class='right' style='width:15%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Scoreboard{/t}</a>
    </td>
    {else}
    <td class='right' style='width:30%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Players{/t}</a>
    </td>
    {/if}
    <td class='right' style='width:10%'>
      <a href='?view=games&amp;team={$team.team_id}'>{t}Games{/t}</a>
    </td>
  </tr>
  {/foreach}
</table>
{/if}

{if count($teams_history)}
<h2>{t}History{/t}:</h2>
<table style='white-space: nowrap;' border='0' cellspacing='0' cellpadding='2' width='90%'>
  <tr>
    <th>{t}Event{/t}</th>
    <th>{t}Team{/t}</th>
    <th>{t}Division{/t}</th>
    <th colspan='3'></th>
  </tr>

  {foreach $teams_history as $team}
  <tr>
    <td style='width:20%'>{u}{$team.season_name}{/u}</td>
    <td style='width:30%'>
      <a href='?view=teamcard&amp;team={$team.team_id}'>{$team.name}</a>
    </td>
    <td style='width:20%'><a href='?view=poolstatus&amp;series={$team.series_id}'>{u}{$team.seriesname}{/u}</a></td>

    {if $is_stats_data_available}
    <td style='width:15%'>
      <a href='?view=playerlist&amp;team={$team.team_id}'>{t}Roster{/t}</a>
    </td>
    <td style='width:15%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Scoreboard{/t}</a>
    </td>
    {else}
    <td style='width:30%'>
      <a href='?view=scorestatus&amp;team={$team.team_id}'>{t}Players{/t}</a>
    </td>
    {/if}
    <td style='width:10%'>
      <a href='?view=games&amp;team={$team.team_id}'>{t}Games{/t}</a>
    </td>
  </tr>
  {/foreach}
</table>
{/if}

{if !$user_anonymous}
<div style='float:left;'>
  <hr /><a href='?view=user/addmedialink&amp;club={$club_id}'>{t}Add media{/t}</a>
</div>
{/if}
{include file="footer.tpl"}