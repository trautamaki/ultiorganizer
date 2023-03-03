{include file="header.tpl"}
{include file="leftmenu.tpl"}

{if is_super_admin}
<form method='post' id='tables' action='?view=admin/dbbackup'>
  <p><span class='profileheader'>{t}Select tables to backup{/t}: </span></p>
  <table>
    <tr>
      <th><input type='checkbox' onclick='checkAll("tables");' /></th>
      <th>{t}Name{/t}</th>
      <th>{t}Data{/t}</th>
      <th>{t}Index{/t}</th>
      <th>{t}Rows{/t}</th>
      <th>{t}avg. row length{/t}</th>
      <th>{t}Auto Increment{/t}</th>
      <th>{t}Updated{/t}</th>
    </tr>
    {foreach $statuses as $row}
    <tr>
      <td class='center'>
        <input type='checkbox' name='tables[]' value='{$row.Name}' />
      </td>
      <td>{$row.Name}</td>
      <td>{$row.Data_length}</td>
      <td>{$row.Index_length}</td>
      <td>{$row.Rows}</td>
      <td>{$row.Avg_row_length}</td>
      <td>{$row.Auto_increment}</td>
      <td>{$row.Update_time}</td>
    </tr>
    {/foreach}
  </table>
  <p>
    <span class='profileheader'>{t}Database size{/t}: </span>{$total_size} {t}bytes{/t}
  </p>
  <p>
    <input class='button' type='submit' name='backup' value='{t}Backup{/t}' />
    <input class='button' type='button' name='takaisin' value='{t}Return{/t}' onclick="window.location.href='?view=admin/dbadmin'" />
  </p>
</form>
{else}
<p>{t}User credentials does not match{/t}</p>
{/if}

{include file="footer.tpl"}