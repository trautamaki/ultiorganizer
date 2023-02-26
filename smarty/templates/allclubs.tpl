{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{$title}</h1>
<table style='white-space: nowrap;'>
  <tr>
    {foreach $valid_letters as $let}
    {if $let == $filter}
    <td class='selgroupinglink'>&nbsp;{$let}&nbsp;</td>
    {else}
    <td>&nbsp;<a class='groupinglink' href='?view=allclubs&amp;list={urlencode($let)}'>{$let}</a>&nbsp;</td>
    {/if}
    {/foreach}
    {if $filter == "ALL"}
    <td class='selgroupinglink'>&nbsp;{t}ALL{/t}</td>
    {else}
    <td>&nbsp;<a class='groupinglink' href='?view=allclubs&amp;list=all'>{t}ALL{/t}</a></td>
    {/if}
  </tr>
</table>
{assign var=counter value=0}
<table width='100%' style='white-space: nowrap;'>
  {foreach $clubs as $club}
  {if $filter == "ALL" && $club.show_letter}
  {if $counter > 0 && $counter <= $maxcols}</tr>{/if}
    <tr>
      <td></td>
    </tr>
    <tr>
      <td class='list_letter' colspan='{$maxcols}'>{$club.list_letter}</td>
    </tr>
    {assign var=counter value=0}
    {/if} <!-- $filter == "ALL" && $club.show_letter -->

    {if $counter == 0}
    <tr>
      {/if}
      <td style='width: 33%'>
        {if intval($club.country)}
        <img height='10' src='images/flags/tiny/{$club.flagfile}' alt='' />&nbsp;
        {/if}
        <a href='?view=clubcard&amp;club={$club.club_id}'>
          {$club.name}
        </a>
      </td>
      {assign var=counter value=($counter + 1)}
      {if $counter >= $maxcols}
    </tr>
    {assign var=counter value=0}
    {/if}
    {/foreach}
    {if $counter > 0 && $counter <= $maxcols} </tr>
      {/if}
</table>
{include file="footer.tpl"}