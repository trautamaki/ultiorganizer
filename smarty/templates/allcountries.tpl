{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{t}Countries{/t}</h1>
<table width='100%' border='0' cellspacing='0' cellpadding='2'>
  {assign var="counter" value=0}
  {foreach $countries as $country}
  {if $counter == 0}<tr>{/if}
    <td style='width:20%'>
      <a href='?view=countrycard&amp;country={$country.country_id}'>
        <img src='images/flags/small/{$country.flagfile}' alt='' /><br />
        {$country.name}
      </a>
    </td>
    {assign var="counter" value=($counter + 1)}
    {if $counter >= $maxcols}
  </tr>
  {assign var="counter" value=0}
  {/if}
  {/foreach}

  {if $counter > 0 && $counter <= $maxcols}</tr>{/if}
</table>

{include file="footer.tpl"}