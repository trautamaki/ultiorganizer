{include file="header.tpl"}
{include file="leftmenu.tpl"}

<form method='post' action='?view=admin/clubs'>
  <h1>{t}All Clubs{/t}</h1>
  <p>{t}Add new{/t}:
    <input class='input' maxlength='50' size='40' name='name' />
    <input class='button' type='submit' name='addclub' value='{t}Add{/t}' />
  </p>

  <table border='0'>
    <tr>
      <th>{t}Id{/t}</th>
      <th>{t}Name{/t}</th>
      <th>{t}Teams{/t}</th>
      <th>{t}Valid{/t}</th>
      <th></th>
    </tr>

    {foreach $clubs as $row}
    <tr>
      <td>{$row.club_id}&#160;</td>
      <td><a href='?view=user/clubprofile&amp;club={$row.club_id}'>{$row.name}</a></td>

      <td class='center'>{$row.num_of_teams}</td>
      <td class='center'><input class='input' type='checkbox' name='valid[]' value='{$row.club_id}' {if intval($row.valid)} checked='checked' {/if} /></td>

      {if $row.can_delete}
      <td class='center'><input class='deletebutton' type='image' src='images/remove.png' alt='X' name='removeclub' value='{t}X{/t}' onclick=\"setId('{$row.club_id}');\" /></td>
      {/if}
    </tr>
    {/foreach}

  </table>
  <p><input class='button' type='submit' name='save' value='{t}Save{/t}' /></p>

  <h1>{t}All Countries{/t}</h1>
  <p>{t}Add new{/t}<br />
    {t}Name{/t}: <input class='input' maxlength='50' size='40' name='name' /><br />
    {t}Abbreviation{/t}: <input class='input' maxlength='50' size='40' name='abbreviation' /><br />
    {t}Flag filename{/t}: <input class='input' maxlength='50' size='40' name='flag' /><br />
    <input class='button' type='submit' name='addcountry' value='{t}Add{/t}' />
  </p>

  <table border='0'>
    <tr>
      <th>{t}Id{/t}</th>
      <th>{t}Name{/t}</th>
      <th>{t}Abbreviation{/t}</th>
      <th>{t}Teams{/t}</th>
      <th>{t}Valid{/t}</th>
      <th></th>
    </tr>
    {foreach $countries as $row}
    <tr>
      <td>{$row.country_id}&#160;</td>
      <td>{$row.name}</td>
      <td class='center'>{$row.abbreviation}</td>
      <td class='center'>{$row.num_of_teams}</td>
      <td class='center'>
        <input class='input' type='checkbox' name='valid[]' value='{$row.country_id}' {if intval($row.valid)} checked='checked' {/if} />
      </td>
      {if $row.can_delete}
      <td class='center'>
        <input class='deletebutton' type='image' src='images/remove.png' alt='X' name='removecountry' value='{t}X{/t}' onclick="setId('{$row.country_id}');" />
      </td>
      {/if}
    </tr>
    {/foreach}
  </table>
  <p><input class='button' type='submit' name='savecountry' value='{t}Save{/t}' /></p>
  <p><input type='hidden' id='hiddenDeleteId' name='hiddenDeleteId' /></p>
</form>

{include file="footer.tpl"}