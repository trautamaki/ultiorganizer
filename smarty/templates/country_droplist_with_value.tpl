<select class='dropdown' {$style|default:""} id='{$id}' name='{$name}'>
  <option value='-1'></option>
  {foreach $countries as $row}
  <option {if $row.country_id == $selected_id} selected='selected' {/if} value='{$row.country_id}'>{t}{$row.name}{/t}</option>
  {/foreach}
</select>