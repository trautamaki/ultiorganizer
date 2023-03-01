{include file="header.tpl"}
{include file="leftmenu.tpl"}

<script type="text/javascript">
  function setId(id) {
    var input = document.getElementById("hiddenDeleteId");
    var answer = confirm('<?php echo _("Are you sure you want to delete the event?"); ?>');
    if (answer) {
      input.value = id;
    } else {
      input.value = "";
    }
  }
</script>

{foreach $warnings as $warning}
<p class='warning'>{$warning}</p>
{/foreach}

<form method='post' action='?view=admin/seasons'>
  <h2>{t}Seasons/Tournaments{/t}</h2>
  <table style='white-space: nowrap;width:90%' border='0' cellpadding='4px'>
    <tr>
      <th>{t}Name{/t}</th>
      <th>{t}Type{/t}</th>
      <th>{t}Starts{/t}</th>
      <th>{t}Ends{/t}</th>
      <th>{t}Enrollment{/t}</th>
      <th>{t}Visible{/t}</th>
      <th>{t}Operations{/t}</th>
      <th></th>
    </tr>
    {foreach $seasons as $row}
    <tr>
      <td><a href='?view=admin/addseasons&amp;season={$row.info.season_id}'>{u}{$row.info.name}{/u}</a></td>
      <td>{u}{$row.info.type}{/u}</td>
      <td>{$row.info.starttime_sortdate}</td>
      <td>{$row.info.endtime}</td>
      <td>{$row.enrollment}</td>
      <td>{$row.visible}</td>
      <td>
        {if $twitter_enabled}
        <a href='?view=admin/twitterconf&amp;season={$row.info.season_id}'>{t}Conf. Twitter{/t}</a> |
        {/if}
        {if !$row.can_delete}
        <a href='?view=admin/stats&amp;season={$row.info.season_id}'>
          {if $row.is_stats_calculated} {t}Re-calc. stats{/t} {else} <b>{t}Calc. stats{/t}</b> {/if}
        </a>
        {/if}
        | <a href='?view=admin/eventdataexport&amp;season=$row.info.season_id}'>{t}Export{/t}</a>
      </td>

      {if $row.can_delete}
      <td class='center'>
        <input class='deletebutton' type='image' src='images/remove.png' alt='X' name='remove' value='{t}X{/t}' onclick="setId('{$row.season_id}');" />
      </td>
      {/if}
    </tr>
  </table>
  <div>
    <a href='?view=admin/eventdataimport'>{t}Import event{/t}</a> |
    <a href='?view=admin/seasonstats'>{t}All event statistics{/t}</a>
  </div>
  <p><input class='button' name='add' type='button' value='{t}Add{/t}' onclick="window.location.href='?view=admin/addseasons'" /></p>
  <p><input type='hidden' id='hiddenDeleteId' name='hiddenDeleteId' /></p>
</form>

{/foreach}

{include file="footer.tpl"}