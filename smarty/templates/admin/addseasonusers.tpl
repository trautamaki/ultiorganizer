{include file="header.tpl"}
{include file="leftmenu.tpl"}

{foreach $messages as $message}
<p>{$message}</p>
{/foreach}

<h3>{t}Event admins{/t}:</h3>
<form method='post' action='?view=admin/addseasonusers&amp;season={$season_id}&amp;access=eventadmin' name='eventadmin'>
  <table>
    {foreach $season_admins as $user}
    <tr>
      <td style='width:75px'>{$user.userid}</td>
      <td>{$user.name} (<a href='mailto:{$user.email}'>{$user.email}</a>)</td>
      <td class='center'><input class='deletebutton' type='image' src='images/remove.png' alt='X' name='remove' value='{t}X{/t}' onclick="document.eventadmin.delId.value='{$user.userid}';" /></td>
    </tr>
    {/foreach}
  </table>
  {if !empty($smarty.get.access) && $smarty.get.access == "eventadmin"}
  <table style='white-space: nowrap' cellpadding='2px'>
    <tr>
      <td>{t}User Id{/t}</td>
      <td><input class='input' size='20' name='userid' /></td>
      <td>{t}or{/t}</td>
      <td>{t}E-Mail{/t}</td>
      <td><input class='input' size='20' name='email' /></td>
    </tr>
  </table>
  <p><input class='button' name='add' type='submit' value='{t}Grant rights{/t}' /></p>
  {else}
  <p><a href='?view=admin/addseasonusers&amp;season={$season_id}&amp;access=eventadmin'>{t}Add more ...{/t}</a></p>
  {/if}
  <div><input type='hidden' name='delId' /></div>
</form>

<h3>{t}Team admins{/t}:</h3>
<form method='post' action='?view=admin/addseasonusers&amp;season={$season_id}&amp;access=teamadmin' name='teamadmin'>
  <table style='white-space: nowrap;'>
    {foreach $team_admins as $user}
    <tr>
      <td style='width:175px'>{u}{$user.teaminfo.seriesname}{/u}, {u}{$user.teaminfo.name}{/u}</td>
      <td style='width:75px'>{$user.userid}</td>
      <td>{$user.name} (<a href='mailto:{$user.email}'>{$user.email}</a>)</td>
      <td class='center'><input class='deletebutton' type='image' src='images/remove.png' alt='X' name='remove' value='{t}X{/t}' onclick="document.teamadmin.delId.value='{$user.userid}';document.teamadmin.teamId.value='{$user.team_id}';" /></td>
    </tr>
    {/foreach}
  </table>
  {if !empty($smarty.get.access) && $smarty.get.access == "teamadmin"}
  <table style='white-space: nowrap' cellpadding='2px'>
    <tr>
      <td>
        <select class='dropdown' name='team'>
          {foreach $teams as $team}
          <option class='dropdown' value='{$team.team_id}'>{u}{$team.seriesname}{/u}, {u}{$team.name}{/u}</option>
          {/foreach}
        </select>
      </td>
      <td>{t}User Id{/t}</td>
      <td><input class='input' size='20' name='userid' /></td>
      <td>{t}or{/t}</td>
      <td>{t}E-Mail{/t}</td>
      <td><input class='input' size='20' name='email' /></td>
    </tr>
  </table>
  <p><input class='button' name='add' type='submit' value='{t}Grant rights{/t}' /></p>
  {else}
  <p><a href='?view=admin/addseasonusers&amp;season={$season_id}&amp;access=teamadmin'>{t}Add more ...{/t}</a></p>
  {/if}
  <div><input type='hidden' name='delId' /></div>
  <div><input type='hidden' name='teamId' /></div>
</form>

<h3>{t}Scorekeepers{/t}:</h3>
<form method='post' action='?view=admin/addseasonusers&amp;season={$season_id}&amp;access=gameadmin' name='gameadmin'>
  <table style='white-space: nowrap;'>
    {foreach $season_admins as $user}
    <tr>
      <td style='width:75px'>{$user.userid}</td>
      <td>{$user.name} (<a href='mailto:{$user.email}'>{$user.email}</a>)</td>
      <td>{t}All games{/t}</td>
      <td>{t}In role of event admin{/t}</td>
    </tr>
    {/foreach}
    {foreach $game_admins as $user}
    <tr>
      <td style='width:75px'>{$user.userid}</td>
      <td>{$user.name} (<a href='mailto:{$user.email}'>{$user.email}</a>)</td>
      {if $user.games == count($seasongames)}
      <td>{t}All games{/t}</td>
      {else}
      <td>{t}Some games{/t}</td>
      {/if}
    </tr>
    {/foreach}
    {if $teamresp}
    <tr>
      <td colspan='2'><i>{t}All team admins have scorekeeping rights for teams' games.{/t}</i></td>
    </tr>
    {/if}
  </table>
  {if !empty($smarty.get.access) && $smarty.get.access == "gameadmin"}
  <table style='white-space: nowrap' cellpadding='2px'>
    <tr>
      <td>{t}User Id{/t}</td>
      <td><input class='input' size='20' name='userid' /></td>
      <td>{t}or{/t}</td>
      <td>{t}E-Mail{/t}</td>
      <td><input class='input' size='20' name='email' /></td>
    </tr>
    <tr>
      <td colspan='5'>
        <select multiple='multiple' size='{count($reservations)}' name='reservations[]'>
          {foreach $reservations as $row}
          <option value='{$row.id}'>
            {$row.reservationgroup} {$row.name}, {t}Field{/t} {$row.fieldname} (JustDate($row['starttime']))
          </option>
          {/foreach}
        </select>
      </td>
    </tr>
  </table>
  <p><input class='button' name='add' type='submit' value='{t}Grant rights{/t}' /></p>
  {else}
  <p><a href='?view=admin/addseasonusers&amp;season={$season_id}&amp;access=gameadmin'>{t}Add more ...{/t}</a></p>
  {/if}
</form>

<h3>{t}Roster accreditation rights{/t}:</h3>
<form method='post' action='?view=admin/addseasonusers&amp;season={$season_id}&amp;access=accradmin' name='accradmin'>
  <table style='white-space: nowrap;'>
    {foreach $season_admins as $user}
    <tr>
      <td style='width:175px'>{t}All teams{/t}</td>
      <td style='width:75px'>$user['userid']</td>
      <td>{$user.name} (<a href='mailto:{$user.email}'>{$user.email}</a>)</td>
      <td>{t}In role of event admin{/t}</td>
    </tr>
    {/foreach}
    {foreach $accreditation_admins as $user}
    <tr>
      <td style='width:175px'>{u}{$user.teaminfo.seriesname}{/u}, {u}{$user.teaminfo.name}{/u}</td>
      <td style='width:75px'>$user['userid']</td>
      <td>{$user.name} (<a href='mailto:{$user.email}'>{$user.email}</a>)</td>
      <td class='center'><input class='deletebutton' type='image' src='images/remove.png' alt='X' name='remove' value='{t}X{/t}' onclick=\"document.accradmin.delId.value='utf8entities($user[' userid'])';document.accradmin.teamId.value='utf8entities($user[' team_id'])';\" /></td>
    </tr>
    {/foreach}
  </table>
  {if !empty($smarty.get.access) && $smarty.get.access == "accradmin"}
  <table style='white-space: nowrap' cellpadding='2px'>
    <tr>
      <td>{t}User Id{/t}</td>
      <td><input class='input' size='20' name='userid' /></td>
      <td>{t}or{/t}</td>
      <td>{t}E-Mail{/t}</td>
      <td><input class='input' size='20' name='email' /></td>
    </tr>
    <tr>
      <td colspan='5'><select multiple='multiple' size='{count($teams)}' name='teams[]'>
          {foreach $teams as $team}
          <option value='{$team.team_id}'>{u}{$team.seriesname}{/u}, {u}{$team.name}{/u}</option>
          {/foreach}
        </select></td>
    </tr>
  </table>
  <p><input class='button' name='add' type='submit' value='{t}Grant rights{/t}' /></p>
  {else}
  <p><a href='?view=admin/addseasonusers&amp;season={$season_id}&amp;access=accradmin'>{t}Add more ...{/t}</a></p>
  {/if}
  <div><input type='hidden' name='delId' /></div>
  <div><input type='hidden' name='teamId' /></div>
</form>

{include file="footer.tpl"}