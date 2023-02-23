{assign var=is_table_open value=false}
{assign var=prev_tournament value=""}
{assign var=prev_place value=""}
{assign var=prev_date value=""}
{assign var=prev_field value=""}
{assign var=prev_timezone value=""}

{foreach $games as $game}
{if $game.reservationgroup != $prev_tournament || (empty($game.reservationgroup) && !$is_table_open)}
{if $is_table_open}
</table>
<hr />
{assign var=is_table_open value=false}
{/if}
{if $grouping}
<h1>{u}{$game.reservationgroup}{/u}</h1>
{/if}
{assign var=prev_date value=""}
{/if}

{if $game.starttime_justdate != $pre_Date}
{if $is_table_open}
</table>
{assign var=is_table_open value=false}
{/if}
<h3>{$game.starttime_defweekdate}</h3>
{/if}

{if $game.place_id != $prev_place || $game.fieldname != $prev_field || $game.starttime_justdate != $prev_date}
{if $isTableOpen}
</table>
{assign var=is_table_open value=false}
{/if}
<table cellpadding='2' border='0' cellspacing='0'>
  {assign var=is_table_open value=true}
  <tr>
    <th align='left' colspan='13'>
      <a class='thlink' href='?view=reservationinfo&amp;reservation={$game.reservation_id}'>
        {$info.placename}
      </a>
    </th>
  </tr>
  {/if}

  {if $is_table_open}
  {include file="game_row.tpl" game=$game game_urls=array() date=false time=true field=true series=false pool=false info=true rss={$rss} media=true}
  {/if}

  {assign var=prev_tournament value=$game.reservationgroup}
  {assign var=prev_place value=$game.place_id}
  {assign var=prev_field value={$game.fieldname}}
  {assign var=prev_date value={$game.starttime_justdate}}
  {assign var=prev_timezone value=$game.timezone}

  {/foreach}

  {if $is_table_open}
</table>
{/if}