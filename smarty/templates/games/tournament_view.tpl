{assign var=is_table_open value=false}
{assign var=prev_place value=""}
{assign var=prev_pool value=""}
{assign var=prev_date value=""}
{assign var=prev_tournament value=""}

{foreach $games as $game}
<!-- res:{$game.reservationgroup} pool:{$game.pool} date:{$game.starttime_justdate} -->
{if $game.reservationgroup != $prev_tournament || (empty($game.reservationgroup) && !$is_table_open)}
{if $is_table_open}
</table>
<hr>
{assign var=is_table_open value=false}
{/if}
{if $grouping}
<h1>{u}{$game.reservationgroup}{/u}</h1>
{/if}
{assign var=prev_place value=""}
{/if}

{if $game.starttime_justdate != $prev_date || $game.place_id != $prev_place}
{if $is_table_open}
</table>
{assign var=is_table_open value=false}
{/if}
<h3>
  {$game.starttime_defweekdate}
  <a href='?view=reservationinfo&amp;reservation={$game.reservation_id}'>
    {u}{$game.placename}{/u}
  </a>
</h3>
{assign var=prev_pool value=""}
{/if}

{if $game.pool != $prev_pool}
{if $is_table_open}
</table>
{assign var=is_table_open value=false}
{/if}
<table cellpadding='2' border='0' cellspacing='0'>
  {assign var=is_table_open value=true}
  <tr style='width:100%'>
    <th align='left' colspan='12'>
      {u}{$game.seriesname}{/u} {u}{$game.poolname}{/u}
    </th>
  </tr>
  {/if}

  {if $is_table_open}
  {include file="game_row.tpl" game=$game game_urls=array() date=false time=true field=true series=false pool=false info=true rss={$rss} media=true}
  {/if}

  {assign var=prev_tournament value=$game.reservationgroup}
  {assign var=prev_place value=$game.place_id}
  {assign var=prev_pool value=$game.pool}
  {assign var=prev_date value=$game.starttime_justdate}
  
  {/foreach}

  {if $is_table_open}
</table>
{/if}
