{include file="header.tpl"}
{include file="leftmenu.tpl"}

{include file="page_menu.tpl"}

{if count($groups) > 1}
<!-- TODO print & $singleview -->
<p>
  {foreach $groups as $grouptmp}
  {if $group == $grouptmp.reservationgroup}
  <a class='groupinglink' href='{$baseurl}&amp;filter={$filter}&amp;group={$grouptmp.reservationgroup}'>
    <span class='selgroupinglink'>{u}{$grouptmp.reservationgroup}{/u}</span>
  </a>
  {else}
  <a class='groupinglink' href='{$baseurl}&amp;filter={$filter}&amp;group={$grouptmp.reservationgroup}'>{u}{$grouptmp.reservationgroup}{/u}</a>
  {/if}
  &nbsp;&nbsp;&nbsp;&nbsp;
  {/foreach}
  {if $group == "all"}
  <a class='groupinglink' href='{$baseurl}&amp;filter={$filter}&amp;group=all'>
    <span class='selgroupinglink'>{t}All{/t}</span></a>
  {else}
  <a class='groupinglink' href='{$baseurl}&amp;filter={$filter}&amp;group=all'>{t}All{/t}</a>
  {/if}
</p>
{/if}

{if !count($games)}
<br><p>{t}No games{/t}</p>
{elseif $filter == 'tournaments' || $filter == 'next'}
  {include file="games/tournament_view.tpl" games=$games grouping=$group_header}
{elseif $filter == 'series' || $filter == 'all' || $filter == 'today' || $filter == 'tomorrow'}
  {include file="games/series_view.tpl" games=$games}
{elseif $filter == 'places'}
  {include file="games/places_view.tpl" games=$games grouping=$group_header}
{elseif $filter == 'timeslot'}
  {include file="games/time_view.tpl" games=$games grouping=false}
{/if}

{if count($games)}
{include file="time_zone.tpl"}
{/if}

{if count($games)}
<hr>
<p>
  <a href='?view=ical&amp;$gamefilter=$id&amp;time=$timefilter&amp;order=$order'>{t}iCalendar (.ical){/t}</a> | 
  <a href='{$baseurl}&filter=onepage&group=$group'>{t}Grid (PDF){/t}</a> | 
  <a href='{$baseurl}&filter=season&group=$group'>{t}List (PDF){/t}</a> | 
  <a href='?{$querystring}&amp;print=1'>{t}Printable version{/t}</a>
</p>
{/if}

{include file="footer.tpl"}