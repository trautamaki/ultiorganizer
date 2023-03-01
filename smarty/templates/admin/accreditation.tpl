{include file="header.tpl"}
{include file="leftmenu.tpl"}

<script type="text/javascript">
  function setId(id, name) {
    var input = document.getElementById(name);
    input.value = id;
  }
</script>

[<a href='?view=admin/accreditation&amp;season={$season}&amp;list=acc'>{t}Accreditation{/t}</a>]
&nbsp;&nbsp;
[<a href='?view=admin/accreditation&amp;season={$season}&amp;list=autoacc'>{t}Automatic Accreditation{/t}</a>]
&nbsp;&nbsp;
[<a href='?view=admin/accreditation&amp;season={$season}&amp;list=acclog'>{t}Accreditation log{/t}</a>]
&nbsp;&nbsp;
[<a href='?view=admin/accreditation&amp;season={$season}&amp;list=accevents'>{t}Accreditation events{/t}</a>]
&nbsp;&nbsp;
[<a href='?view=admin/accreditation&amp;season={$season}&amp;list=accId'>{t}Missing IDs{/t}</a>]
&nbsp;&nbsp;

{if $list == "acc"}
<p>{t}Accreditation can be done manually player by player from team roster or automatically against event organizer's external license database.{/t}</p>
{/if}

{if $list == "acclog"}
<h3>{t}Games played without accreditation{/t}</h3>
<form method='post' action='{$url}'>
  <table class='infotable'>
    <tr>
      <th>{t}Player{/t}</th>
      <th>{t}Team{/t}</th>
      <th>{t}Game{/t}</th>
      <th>{t}Acknowledged{/t}</th>
    </tr>
    {foreach $unaccredited as $row}
    <tr>
      <td>{$row.firstname} {$row.lastname}</td>
      <td>{$row.teamname}</td>
      <td>{$row.game_name}</td>
      <td style='text-align:center'>
        <input type='checkbox' name='acknowledged[]' value='{$row.player_id}_{$row.game_id}' />
      </td>
    </tr>
    {/foreach}
  </table>
  <p><input type='submit' name='acknowledge' value='{t}Acknowledge{/t}' /></p>
  <h3>{t}Acknowledged{/t}</h3>
  <table class='infotable'>
    <tr>
      <th>{t}Player{/t}</th>
      <th>{t}Team{/t}</th>
      <th>{t}Game{/t}</th>
      <th>{t}Acknowledged{/t}</th>
    </tr>
    {foreach $acknowledged as $row}
    <tr>
      <td>{$row.firstname} {$row.lastname}</td>
      <td>{$row.teamname}</td>
      <td>{$row.game_name}</td>
      <td style='text-align:center'>
        <input class='deletebutton' type='image' src='images/remove.png' name='remacknowledge' value='X' alt='X' onclick='setId("{$row.player_id}_{$row.game_id}", "deleteAckId");' />
      </td>
    </tr>
    {/foreach}
  </table>
  <div><input type='hidden' id='deleteAckId' name='deleteAckId' /></div>
</form>
{/if}

{if $list == "accevents"}
<h3>{t}Accreditation events{/t}</h3>
<table class='infotable'>
  <tr>
    <th>{t}Event{/t}</th>
    <th>{t}Time{/t}</th>
    <th>{t}Player{/t}</th>
    <th>{t}Team{/t}</th>
    <th>{t}Game{/t}</th>
    <th>{t}Value{/t}</th>
    <th>{t}User{/t}</th>
    <th>{t}Source{/t}</th>
  </tr>
  {foreach $accevents as $row}
  <tr class='{$row.class}'>
    {if !empty($row.game)}
    <td>{t}Game acknowledgement{/t}</td>
    {else}
    <td>{t}Accreditation{/t}</td>
    {/if}

    <td>{$row.time_bdayformat} {$row.time_bdayformat}</td>
    <td>{$row.firstname} {$row.lastname}</td>
    <td>{$row.teamname}</td>

    <td>{$row.game_name}</td>

    {if $row.value}
    <td>+</td>
    {else}
    <td>-</td>
    {/if}

    {if !empty($row.email)}
    <td><a href='mailto:{$row.email}'>{$row.uname}</a></td>
    {else}
    <td>{$row.uname}</td>
    {/if}
    <td>{$row.source}</td>
  </tr>
  {/foreach}
</table>
{/if}

{if $list == "accId"}
<h3>{t}Players without membership Id{/t}</h3>
<table class='infotable'>
  {foreach $players_no_membership as $playerinfo}
  <tr>
    <td>
      {$playerinfo.seriesname}
    </td>
    <td>
      {$playerinfo.teamname}
    </td>
    <td>
      {$playerinfo.firstname} {$playerinfo.lastname}
    </td>
  </tr>
  {/foreach}
</table>

<h3>{t}Players not accredited{/t}</h3>
<table class='infotable'>
  {foreach $players_not_accredited as $playerinfo}
  <tr>
    <td>
      {$playerinfo.seriesname}
    </td>
    <td>
      {$playerinfo.teamname}
    </td>
    <td>
      {$playerinfo.firstname} {$playerinfo.lastname}
    </td>
  </tr>
  {/foreach}
</table>
{/if}

{include file="footer.tpl"}