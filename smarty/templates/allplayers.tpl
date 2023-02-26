{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{$title}</h1>
<table style='white-space: nowrap;width:100%'>
  <tr>
    {foreach $valid_letters as $let}
    {if $let == $filter}
    <td class='selgroupinglink'>&nbsp;{$let}&nbsp;</td>
    {else}
    <td>&nbsp;<a class='groupinglink' href='?view=allplayers&amp;list={$let}'>{$let}</a>&nbsp;</td>
    {/if}
    {/foreach}
    {if $filter == "ALL"}
    <td class='selgroupinglink'>&nbsp;{t}ALL{/t}</td>
    {else}
    <td>&nbsp;<a class='groupinglink' href='?view=allplayers&amp;list=all'>{t}ALL{/t}</a></td>
    {/if}
  </tr>
</table>

{assign var=counter value=0}
<table width='90%' style='white-space: nowrap;'>
  {foreach $players as $player}
  {if $filter == "ALL" && $player.show_letter}
  {if $counter > 0 && $counter <= $maxcols}</tr>{/if}
    <tr>
      <td></td>
    </tr>
    <tr>
      <td class='list_letter' colspan='{$maxcols}'>{$player.list_letter}</td>
    </tr>
    {assign var=counter value=0}
    {/if} <!-- $filter == "ALL" && $player.show_letter -->

    {if $counter == 0}
    </tr>
    {/if}
    {if !empty($player.profile_id)}
    <td style='width:{(100 / $maxcols)}%'>
      <a href='?view=playercard&amp;series=0&amp;player={$player.player_id}'>
        {$player.lastname} {$player.firstname}
      </a>
    </td>
    {else}
    <td style='width:{(100 / $maxcols)}%'>{$player.lastname} {$player.firstname}</td>
    {/if}
    {assign var=counter value=($counter + 1)}
    {if $counter >= $maxcols}
    <tr>
      {assign var=counter value=0}
      {/if}
      {/foreach}
      {if $counter > 0 && $counter <= $maxcols} </tr>
        {/if}
</table>
{include file="footer.tpl"}