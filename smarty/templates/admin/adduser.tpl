{include file="header.tpl"}
{include file="leftmenu.tpl"}

{foreach $messages as $message}
<p>{$message nofilter}</p>
{/foreach}

<form method='post' action='?view=admin/adduser'>
  <table cellpadding='8'>
    <tr>
      <td class='infocell'>{t}Name{/t}:</td>
      <td>
        <input type='text' class='input' maxlength='256' id='Name' name='Name' {if isset($smarty.post.Name)} value='{$smarty.post.Name}' {/if} />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Username{/t}:</td>
      <td>
        <input type='text' class='input' maxlength='50' id='UserName' name='UserName' {if isset($smarty.post.UserName)} value='{$smarty.post.UserName}' {/if} />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Password{/t}:</td>
      <td>
        <input type='text' class='input' maxlength='20' id='Password' name='Password' value='{$password}' />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Email{/t}:</td>
      <td>
        <input type='text' class='input' maxlength='512' id='Email' name='Email' size='40' {if isset($smarty.post.Email)} value='{$smarty.post.Email}' {/if} />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Responsible team{/t}:</td>
      <td>
        <select class='dropdown' name='team'>
          <option class='dropdown' {if !isset($smarty.post.team)} selected='selected' {/if} value='0'></option>
          {foreach $teams as $team}
          <option class='dropdown' {if isset($smarty.post.team) && $team.team_id==$smarty.post.team} selected='selected' {/if} value='{$team.team_id}'>
            {u}{$team.seriesname}{/u} {$team.name}
          </option>
          {/foreach}
        </select>
      </td>
    </tr>
    <tr>
      <td colspan='2' align='right'><br />
        <input class='button' type='submit' name='save' value='{t}Add{/t}' />
      </td>
    </tr>
  </table>
</form>

{include file="footer.tpl"}