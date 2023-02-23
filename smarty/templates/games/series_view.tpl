{assign var=is_table_open value=false}
{assign var=prev_series value=""}
{assign var=prev_pool value=""}

{foreach $games as $game}
{if $game.series_id != $prev_series || (empty($game.series_id) && !$is_table_open)}
{if $is_table_open}
</table>
<hr />
{assign var=is_table_open value=false}
{/if}
<h1>{u}{$game.seriesname}{/u}</h1>
{/if}

{if $game.pool != $prev_pool}
{if $is_table_open}
</table>
{assign var=is_table_open value=false}
{/if}
<table cellpadding='2' border='0' cellspacing='0'>
  {assign var=is_table_open value=true}
  <tr style='width:100%'>
    <th align='left' colspan='13'>{u}{$game.poolname}{/u}</th>
  </tr>

  {/if}

  {include file="game_row.tpl" game=$game game_urls=array() date=true time=true field=true series=false pool=false info=true rss={$rss} media=true}

  {assign var=prev_series value=$game.series_id}
  {assign var=prev_pool value=$game.pool}
  {assign var=prev_date value={$game.starttime_formatted}}

  {/foreach}

  {if $is_table_open}
</table>
{/if}
