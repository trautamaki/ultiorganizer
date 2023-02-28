{foreach $headers as $header}
<th {$header.options}>{if $sort != $header.sort}
  <a class='thsort' href='{$header.url}'>{/if}
    {t}{$header.title}{/t}{if $sort != {$header.sort}}
  </a>{/if}
</th>
{/foreach}