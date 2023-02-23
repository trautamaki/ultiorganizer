<p class='timezone'>
  {if !empty($timezone)}
  {t}Timezone{/t}: {$timezone}.
  {/if}
  {if $display_datetime}
  {t}Local time{/t}: {$datetime}
  {/if}
</p>