{include file="header.tpl"}
{include file="leftmenu.tpl"}

<div data-role='header'>
  <h1>{t}Add result with game id{/t}</h1>
</div>
<div data-role='content'>
  {if count($errors)}
  {foreach $errors as $error}
  <p {$error[0]}>{$error[1]}</p>
  {/foreach}
  {/if}

  {if !empty($smarty.post.cancel)}
  <p class='warning'>{t}Result not saved!{/t}</p>
  {/if}

  <div style='font-size:14px;'>
    <form action='?{$query_string}' method='post' data-ajax='false'>
      {if !empty($smarty.post.save) && empty($errors)}
      <p>
        <input class='input' type='hidden' id='game' name='game' value='{$game}' />
        <input class='input' type='hidden' id='home' name='home' value='{$home}' />
        <input class='input' type='hidden' id='away' name='away' value='{$away}' />
      <p>
        {$game_result.time_shortdate} {$game_result.time_defhour}
        {if !empty($game_result['fieldname'])}
        {t}on field{/t} {$game_result.fieldname}
        {/if}
        <br />
        {u}{$game_result.seriesname}{/u}, {u}{$game_result.poolname}{/u}
      </p>
      <p>{$game_result.hometeamname} - {$game_result.visitorteamname}
        {if $game_result.has_started}
        <br />
        {t}Game is already played. Result:{/t} {$game_result.homescore} - {$game_result.visitorscore}.
        <br /><br />
        <span style='font-weight:bold'>{t}Change result to{/t} {$home} - {$away}?</span>
        {else}
        <span style='font-weight:bold'>{$home} - {$away}</span>
        {/if}
        <br /><br />
        {t}Winner is{/t}
        <span style='font-weight:bold'>
          {if $home > $away}
          {$game_result.hometeamname}
          {else}
          {$game_result.visitorteamname}
          {/if}
          ?
        </span>
        <br /><br /><input type='submit' name='confirm' data-ajax='false' value='{t}Confirm{/t}' />
        <input type='submit' name='cancel' data-ajax='false' value='{t}Cancel{/t}' />
      </p>
      {else}
      <table cellpadding='2'>
        <tr>
          <td class='infocell'>
            {t}Scoresheet #{/t}:
          </td>
          <td>
            <input class='input' type='text' id='game' name='game' size='6' maxlength='5' onkeyup='validNumber(this);' /> 
          </td>
        </tr>
        <tr>
          <td class='infocell'>
            {t}Home Goals{/t}:
          </td>
          <td>
            <input class='input' type='text' id='home' name='home' size='3' maxlength='3' onkeyup='validNumber(this);' /> 
          </td>
        </tr>
        <tr>
          <td class='infocell'>
            {t}Away Goals{/t}:
          </td>
          <td>
            <input class='input' type='text' id='away' name='away' size='3' maxlength='3' onkeyup='validNumber(this);' /> 
          </td>
        </tr>
        <tr>
          <td style='padding-top:15px' colspan='2'>
            <input style='width:100%;' class='button' type='submit' name='save' value='{t}Save{/t}' />
          </td>
        </tr>
      </table>
      {/if}
    </form>
    <p><a href='?view=played'>{t}Played games{/t}</a></p>
  </div>
</div><!-- /content -->
<script type="text/javascript">
  document.getElementById('game').setAttribute("autocomplete", "off");
  document.getElementById('home').setAttribute("autocomplete", "off");
  document.getElementById('away').setAttribute("autocomplete", "off");

  function validNumber(field) {
    field.value = field.value.replace(/[^0-9]/g, '');
  }
</script>
{include file="footer.tpl"}