{include file="header.tpl"}
{include file="leftmenu.tpl"}

<!-- TODO test -->

<h1>{t}Defenseboard{/t}</h1>

<table style='width:100%' cellpadding='1' border='1'>
  <tr>
    <th style='width:5%'>#</th>
    {include file="sortable_table_header.tpl" headers=$table_header sort=$sort}
  </tr>
  {foreach $data_array as $row}
  <tr>
    <td>{$row.i}</td>
    <td class='highlight'>
      <a href='?view=playercard&amp;series={$pool_id}&amp;player={$row.player_id}'>
        {$row.firstname} {$row.lastname}
      </a>
    </td>
    <td class='highlight'>{$row.teamname}</td>
    <td class='center highlight'>{$row.games}</td>
    <td class='center highlight'>{$row.deftotal}</td>
  </tr>
  {/foreach}
</table>
{include file="footer.tpl"}