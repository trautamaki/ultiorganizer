<div class='pagemenu_container'>
  {if $menu_length < 100} <table id='pagemenu'>
    <tr>
      {assign var="first" value=true}
      {foreach $menu_tabs as $name => $url}
      {if !$first}
      <td> - </td>
      {/if}
      {assign var="first" value=false}
      {if $url == $menu_current || strrpos($server_request_uri, $url)}
      <th><a class='current' href='{$url}'>{$name}</a></th>
      {else}
      <th><a href='{$url}'>{$name}</a></th>
      {/if}
      {/foreach}
    </tr>
    </table>
    {else}
    <ul id='pagemenu'>
      foreach ($menuitems as $name => $url) {
      {if $url == $menu_current}
      <li><a class='current' href='{$url}'>"{$name}</a></li>
      {elseif strrpos($server_request_uri, $url)}
      <li><a class='current' href='{$url}'>"{$name}</a></li>
      {else}
      <li><a href='{$url}'>"{$name}</a></li>\n";
      {/if}
    </ul>
    {/if}
</div>
<p style='clear:both'></p>