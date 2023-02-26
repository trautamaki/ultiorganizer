{include file="header.tpl"}
{include file="leftmenu.tpl"}

{if $reset_password}
{if $reset_password_success}
<p>{t}New password sent.{/t}</p>
{else}
<p>{t}Resetting password for {$user_id} failed. Email address may be invalid. Password was not sent.{/t}</p>
{/if}
{else} <!-- reset_password -->
{if $valid_user}
<form method='post' action='?view=login_failed&amp;user={$user_id}'>
  <p>
    {t}Check the username and password.{/t}
    {t}If you have forgotten your password, click the button below and a new password will be sent to your e-mail address given at registration.{/t}
  </p>
  <p><input class='button' type='submit' name='resetpassword' value='{t}Reset password{/t}' /></p>
</form>
{else}
<p>{t}Invalid username {$user_id}.{/t}</p>
{/if}
{/if}

{include file="footer.tpl"}
