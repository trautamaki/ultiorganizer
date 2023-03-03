{include file="header.tpl"}
{include file="leftmenu.tpl"}

{foreach $messages as $message}
<p>{$message}</p>
{/foreach}

<h3>{t}Team admins{/t}:</h3>
<form method='post' action='?view=admin/addteamadmins&amp;series={$seried_id}' name='teamadmin'>
  <table style='white-space: nowrap;'>
    {foreach $admins as $user}
    {if $user.teaminfo.series != $seried_id}
    {continue}
    {/if}
    <tr>
      <td style='width:175px'>{$user.teaminfo.seriesname}, {$user.teaminfo.name}</td>
      <td style='width:75px'>{$user.userid}</td>
      <td>{$user.name} (<a href='mailto:{$user.email}'>{$user.email}</a>)</td>
      <td class='center'>
        <input class='deletebutton' type='image' src='images/remove.png' alt='X' name='remove' value='{t}X{/t}' onclick="document.teamadmin.delId.value='{$user.userid}';document.teamadmin.teamId.value='{$user.team_id}';" />
      </td>
    </tr>
  </table>
  {/foreach}

  <h3>{t}Add more{/t}</h3>
  <table style='white-space: nowrap;'>
    {foreach $teams as $team}
    <tr>
      <td style='width:175px'>{$team.teaminfo.name}</td>
      <td>{t}User Id{/t}</td>
      <td><input class='input' size='20' name='userid{$team.team_id}' id='userid{$team.team_id}' /></td>
      <td>{t}or{/t}</td>
      <td>{t}E-Mail{/t}</td>
      <td><input class='input' size='20' name='email{$team.team_id}' id='email{$team.team_id}' /></td>
    </tr>
    </tr>
    {/foreach}
  </table>
  <p><a href='?view=admin/adduser&amp;season={$seriesinfo.season}'>{t}Add new user{/t}</a></p>
  <p>
    <input class='button' name='add' type='submit' value='{t}Grant rights{/t}' />
    <input class='button' type='button' value='{t}Return{/t}' onclick="window.location.href='{$backurl}'" />
  </p>
  </p>
  <div><input type='hidden' name='delId' /></div>
  <div><input type='hidden' name='teamId' /></div>
  <div><input type='hidden' name='backurl' value='{$backurl}' /></div>
</form>

{include file="footer.tpl"}