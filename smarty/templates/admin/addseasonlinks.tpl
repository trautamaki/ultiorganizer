{include file="header.tpl"}
{include file="leftmenu.tpl"}

<form method='post' action='?view=admin/addseasonlinks&amp;season={$season_id}' id='Form'>
  <table style='white-space: nowrap' cellpadding='2'>
    <tr>
      <th>{t}Type{/t}</th>
      <th>{t}Order{/t}</th>
      <th>{t}Name{/t}</th>
      <th>{t}Url{/t}</th>
      <th></th>
    </tr>
    {assign var="i" value=0}
    {foreach $urls as $url}
    <tr>
      <td>
        {$url.type}<input type='hidden' name='urltype{$i}' value='({$url.type}' />
      </td>
      <td>
        <input class='input' size='3' maxlength='2' name='urlorder{$i}' value='{$url.ordering}' />
      </td>
      <td>
        <input class='input' size='30' maxlength='150' name='urlname{$i}' value='{$url.name}' />
      </td>
      <td>
        <input class='input' size='40' maxlength='500' name='url{$i}' value='{$url.url}' />
      </td>
      <td class='center'>
        <input class='deletebutton' type='image' src='images/remove.png' name='remove' alt='{t}X{/t}' onclick="setId({$url.url_id});" />
      </td>
      <td>
        <input type='hidden' name='urlid{$i}' value='{$url.url_id}' /></td>
    </tr>
    {assign var="i" value=($i + 1)}
    {/foreach}
    <tr>
      <td>
        <select class='dropdown' name='newurltype'>
          <option value='menulink'>{t}Menu link{/t}</option>
          <option value='menumail'>{t}Menu mail{/t}</option>
        </select>
      </td>
      <td>
        <input class='input' size='3' maxlength='2' name='newurlorder' value='' />
      </td>
      <td>
        <input class='input' size='30' maxlength='150' name='newurlname' value='' />
      </td>
      <td>
        <input class='input' size='40' maxlength='500' name='newurl' value='' />
      </td>
    </tr>
  </table>
  <h1>{t}3rd party API settings{/t}</h1>
  <table style='white-space: nowrap' cellpadding='2'>
    {foreach $settings as $setting}
    <tr>
      <td class='infocell'>{t}Facebook Update Page{/t}:</td>
      <td><input class='input' size='70' name='FacebookUpdatePage' value='{$setting.value}' /></td>
    </tr>
    {/foreach}
  </table>
  <input type='hidden' name='save' value='hiddensave' />
  <p><input class='button' name='savebutton' type='submit' value='{t}Save{/t}' /></p>
  <div><input type='hidden' id='hiddenDeleteId' name='hiddenDeleteId' /></div>
</form>

{include file="footer.tpl"}