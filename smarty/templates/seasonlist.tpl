{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{$title}</h1>
<table width='100%' border='0' cellspacing='0' cellpadding='2'>
  {assign var="counter" value=0}
  {foreach $seasons as $season}
  {if $counter == 0}<tr>{/if}
    <td style='vertical-align:text-top;'>
      <h3>{$season.season_name}</h3>
      <div>
        <a href='?view=teams&amp;season={$season.season_id}'>{t}Teams{/t}</a><br />
        <a href='?view=games&amp;season={$season.season_id}'>{t}Played games{/t}</a><br />
        <a href='?view=teams&amp;season={$season.season_id}&amp;list=bystandings'>{t}Final standings{/t}</a>
      </div>
      {if count($season.series)}
      <table cellpadding='0'>
        {foreach $season.series as $ser}
        <tr>
          <td>
            <a href='?view=seriesstatus&amp;series={$ser.series_id}'>{u}{$ser.name}{/u} {t}division{/t}</a>
          </td>
        </tr>
        {/foreach}
      </table>
      {/if}
    </td>
    {if $counter >= $maxcols}
  </tr>
  {assign var="counter" value=0}
  {/if}
  {/foreach}
  {if $counter > 0 && $counter <= $maxcols}</tr>{/if}
</table>
{include file="footer.tpl"}
