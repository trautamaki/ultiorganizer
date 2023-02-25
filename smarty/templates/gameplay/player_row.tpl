<tr>
  <td style='text-align:right'>{$row.num}</td>
  <td>
    <a href='?view=playercard&amp;series=0&amp;player={$row.player_id}'>
      {$row.firstname} {$row.lastname}
    </a>
    {if $row.player_id == $captain}&nbsp;{t}(C){/t}{/if}
  </td>
  <td class='center'>{$row.fedin}</td>
  <td class='center'>{$row.done}</td>
  <td class='center'>{$row.total}</td>
</tr>