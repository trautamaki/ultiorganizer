{include file="header.tpl"}
{include file="leftmenu.tpl"}

{if $is_super_admin}
<p><span class='profileheader'>{t}Database administration{/t}: </span><br />
  <a href='?view=admin/executesql'>&raquo; {t}Run SQL{/t}</a><br />
  <a href='?view=admin/dbbackup'>&raquo; {t}Backup{/t}</a><br />
  <a href='?view=admin/dbrestore'>&raquo; {t}Restore{/t}</a><br />
  <a href='?view=admin/dbequalize'>&raquo; {t}Equalization{/t}</a><br />
</p>

{foreach $types as $type}
{if count($plugins_per_type[$type])}
<p><span class='profileheader'>{t}Plugins{/t} ({$type}): </span><br />
  {foreach $plugins_per_type[$type] as $plugin}
  <a href='?view={$plugin.file}'>&raquo; {$plugin.title}</a><br />
  {/foreach}
</p>
{/if}
{/foreach}

<p><span class='profileheader'>{t}Tables{/t}: </span></p>
<table>
  <tr>
    <th>{t}Name{/t}</th>
    <th>{t}Rows{/t}</th>
    <th>{t}avg. row length{/t}</th>
    <th>{t}Data{/t}</th>
    <th>{t}Index{/t}</th>
    <th>{t}Auto Increment{/t}</th>
    <th>{t}Updated{/t}</th>
  </tr>
  {foreach $table_statuses as $row}
  <tr>
    <td><a href='?view=admin/executesql&amp;sql={$row.sql}'>{$row.Name}</a></td>
    <td>{$row.Rows}</td>
    <td>{$row.Avg_row_length}</td>
    <td>{$row.Data_length}</td>
    <td>{$row.Index_length}</td>
    <td>{$row.Auto_increment}</td>
    <td>{$row.Update_time}</td>
  </tr>
  {/foreach}
  <tr>
    <td colspan='5'>{t}Execute{/t}: <a href='?view=admin/executesql&amp;sql={urlencode("SHOW TABLE STATUS")}'>SHOW TABLE STATUS</a></td>
  </tr>

</table>
<p>{t}Database size{/t}: {$total_size} {t}bytes{/t}</p>

<p><span class='profileheader'>{t}Statistics{/t}: </span><br />
  {foreach $stat_array as $stat}
  &nbsp;{$stat}<br />
  {/foreach}

  &nbsp;{t}Execute{/t}: <a href='?view=admin/executesql&amp;sql={urlencode("SHOW GLOBAL STATUS")}'>SHOW GLOBAL STATUS</a>
</p>

<p>
  <span class='profileheader'>{t}Client Library version{/t}: </span>{$client_info}<br />
  <span class='profileheader'>{t}Type of connection in use{/t}: </span>{$host_info}<br />
  <span class='profileheader'>{t}Protocol version{/t}: </span>{$protocol_version}<br />
  <span class='profileheader'>{t}Server version{/t}: </span>{$server_info}
</p>

<p><span class='profileheader'>{t}Character set and collation{/t}: </span><br />
  {foreach $char_set_array as $row}
    &nbsp;{$row.Variable_name}: {$row.Value}<br />
  {/foreach}

  {foreach $collation_array as $row}
  &nbsp;{$row.Variable_name}: {$row.Value}<br />
  {/foreach}
</p>
{else}
<p>{t}User credentials does not match{/t}</p>
{/if}

{include file="footer.tpl"}