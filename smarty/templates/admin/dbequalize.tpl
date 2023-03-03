{include file="header.tpl"}
{include file="leftmenu.tpl"}

{$result nofilter}

<div>
  {t}List{/t}:
  <a href='{$baseurl}&amp;filter=teams'>{t}Teams{/t}</a>
  &nbsp;&nbsp;
  <a href='{$baseurl}&amp;filter=clubs'>{t}Clubs{/t}</a>
  &nbsp;&nbsp;
  <a href='{$baseurl}&amp;filter=pools'>{t}Pools{/t}</a>
  &nbsp;&nbsp;
  <a href='{$baseurl}&amp;filter=series'>{t}Division{/t}</a>
</div>

<form id='ids' method='post' action='{$baseurl}'>
  {if $filter == 'clubs'}
  <p>{t}Club to keep{/t}:
    <select class='dropdown' name='newname'>
      {foreach $clubs as $row}
      <option class='dropdown' value='{$row.club_id}'>{$row.name}</option>
      {/foreach}
    </select>
  </p>
  <p><input class='button' type='submit' name='rename' value='{t}Join selected{/t}' />
    {else}
  <p>{t}New name{/t}:
    <input class='input' size='50' name='newname' value='' />
  </p>
  <p><input class='button' type='submit' name='rename' value='{t}Rename selected{/t}' />
    {/if}
    <input class='button' type='submit' name='remove' value='{t}Delete selected{/t}' />
    <input class='button' type='reset' value='{t}Clear{/t}' />
    <input class='button' type='button' name='takaisin' value='{t}Return{/t}' onclick=\"window.location.href='?view=admin/dbadmin' \" />
  </p>
  <table>
    <tr>
      <th><input type='checkbox' onclick='checkAll("ids");' /></th>
      {if $filter == 'teams'}
      <th>{t}Team{/t}</th>
      <th>{t}Division{/t}</th>
      <th>{t}Club{/t}</th>
      <th>{t}Event{/t}</th>
    </tr>
    {foreach $teams as $team}
    <tr {if $team.counter % 2} class='highlight' {/if}>
      <td><input type='checkbox' name='ids[]' value='{$team.team_id}' /></td>
      <td><b>{$team.name}</b></td>
      <td>{$team.seriesname}</td>
      <td>{$team.clubname}</td>
      <td>{$team.seasonname}</td>
    </tr>
    {/foreach}
    {elseif $filter == 'clubs'}
    <th>{t}Name{/t}</th>
    <th>{t}Teams{/t}</th>
    </tr>
    {foreach $clubs as $club}
    <tr {if $club.counter % 2} class='highlight' {/if}>
      <td><input type='checkbox' name='ids[]' value='{$club.club_id}' /></td>
      <td><b>{$club.name}</b></td>
      <td class='center'>{$club.num_of_teams}</td>
    </tr>
    {/foreach}
    {elseif $filter == 'pools'}
    <th>{t}Name{/t}</th>
    <th>{t}Division{/t}</th>
    <th>{t}Event{/t}</th>
    </tr>
    {foreach $pools as $pool}
    <tr {if $pool.counter % 2} class='highlight' {/if}>
      <td><input type='checkbox' name='ids[]' value='{$pool.pool_id}' /></td>
      <td><b>{$pool.name}</b></td>
      <td>{$pool.seriesname}</td>
      <td>{$pool.seasonname}</td>
    </tr>
    {/foreach}
    {elseif $filter == 'series'}
    $series = Series();
    <th>{t}Name{/t}</th>
    <th>{t}Event{/t}</th>
    </tr>
    {foreach $series as $row}
    <tr {if $counter % 2} class='highlight' {/if}>
      <td><input type='checkbox' name='ids[]' value='{$row.series_id}' /></td>
      <td><b>{$row.name}</b></td>
      <td>{$row.seasonname}</td>
    </tr>
    {/foreach}
    {/if}
  </table>
  <div>
    <input type='hidden' id='filter' name='filter' value='$filter' />
  </div>
</form>

{include file="footer.tpl"}