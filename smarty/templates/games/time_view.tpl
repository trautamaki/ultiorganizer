{assign var=is_table_open value=false}
{assign var=prev_time value=""}

{foreach $games as $game}
{if $game.time != $prev_time}
{if $is_table_open}
</table>
{assign var=is_table_open value=false}
{/if}
<h3>{$game.time_defweekdate} {$game.time_defour}</h3>
<table cellpadding='2' border='0' cellspacing='0'>
  {assign var=is_table_open value=true}
  {/if}

  {if $is_table_open}

  {include file="game_row.tpl" game=$game game_urls=array() date=false time=true field=true series=false pool=false info=true rss=false media=true}
  {/if}
  {assign var=prev_time value={$game.time}}

  {/foreach}

  {if $is_table_open}
</table>
{/if}