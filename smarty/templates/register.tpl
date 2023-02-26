{include file="header.tpl"}
{include file="leftmenu.tpl"}

<script src="script/disable_enter.js.inc"></script>
{if count($messages)}
<ul>
{foreach $messages as $message}
<li>{$message}</li>
{/foreach}
</ul>
{else} <!-- count($messages) -->
<!-- Help -->
<p>
  {t}Registration is only needed for event organizers, team contact persons and players needing to create or change data in system.{/t}
  {t}Registration process:{/t}
</p>
<ol>
  <li>{t}Fill registration information in fields below.{/t}</li>
  <li>{t}Confirmation mail will be sent immediately to the email address provided. (Note that confirmation mail can be incorrectly filterd as spam by e-mail client and in this case you can find the mail from spam -folder instead of inbox.){/t}</li>
  <li>{t}Follow the link in the mail to confirm registration.{/t}</li>
</ol>
<a href='?view=privacy'>{t}Privacy Policy{/t}</a>
<hr />
{/if} <!-- count($messages) -->
<!-- Content -->
{if $show_register_form}
<form method='post' action='?view=register'>
  <table cellpadding='8'>
    <tr>
      <td class='infocell'>{t}Name{/t}:</td>
      <td>
        <input type='text' class='input' maxlength='256' id='Name' name='Name' value='{if isset($_POST["Name"])} Name {/if}' />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Username{/t}:</td>
      <td>
        <input type='text' class='input' maxlength='20' id='UserName' name='UserName' value='{if isset($_POST["UserName"])} UserName {/if}' />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Password{/t}:</td>
      <td>
        <input type='password' class='input' maxlength='20' id='Password' name='Password' value='{if isset($_POST["Password"])} Password {/if}' />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Repeat password{/t}:</td>
      <td>
        <input type='password' class='input' maxlength='20' id='Password2' name='Password2' value='{if isset($_POST["Password"])} Password {/if}' />
      </td>
    </tr>
    <tr>
      <td class='infocell'>{t}Email{/t}:</td>
      <td>
        <input type='text' class='input' maxlength='512' id='Email' name='Email' size='40' value='{if isset($_POST["Email"])} Email {/if}' />
      </td>
    </tr>
    <tr>
      <td colspan='2' align='right'><br />
        <input class='button' type='submit' name='save' value='{t}Register{/t}' />
      </td>
    </tr>
  </table>
</form>
{/if}
{include file="footer.tpl"}