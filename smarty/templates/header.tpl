<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="-1" />
  <link rel='icon' type='image/png' href='cust/{$cust}/favicon.png' />
  <link rel="stylesheet" href="cust/{$cust}/layout.css" type="text/css" />
  <link rel="stylesheet" href="cust/{$cust}/font.css" type="text/css" />
  <link rel="stylesheet" href="cust/{$cust}/default.css" type="text/css" />
  <link rel="stylesheet" href="generic.css" type="text/css" />
  <link rel="stylesheet" href="flag-icon.css" type="text/css" />
  <title>{$page_title|default:"no title"} {$title}</title>
</head>
<!-- TODO printable -->

<body style='overflow-y:scroll;' {$body_functions|default:""}>
  <div class='page'>
    <div class='page_top'>
      <div class='top_banner_space'></div>
      <form action='?{$query_string}' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' style='width:100%;white-space: nowrap;'>
          <tr>
            <td class='topheader_left'>
              {$page_header} <!-- TODO convert to templates/cust/ -->
            </td>
            <td class='topheader_right'>
              <table border='0' cellpadding='0' cellspacing='0' style='width:95%;white-space: nowrap;'>
                <tr>
                  <td class='right' style='vertical-align:top;'>
                    {foreach $locales as $locale}
                    <a href='?{$locale.query_string}&amp;locale={$locale.localestr}'>
                      <img class='localeselection' src='locale/{$locale.localestr}/flag.png' alt='{$locale.localename}' />
                    </a>
                    {/foreach}
                  </td>
                </tr>
                <tr>
                  <td class='right' style='padding-top:5px'>
                    {if $enable_facebook}
                    <div id='fb-root'></div>
                    <fb:login-button perms='email,publish_stream,offline_access' />
                    {/if}
                    {if $user_anonymous}
                    <input class='input' type='text' id='myusername' name='myusername' size='10' style='border:1px solid #555555' />&nbsp;
                    <input class='input' type='password' id='mypassword' name='mypassword' size='10' style='border:1px solid #555555' />&nbsp;
                    <input class='button' type='submit' name='login' value='{t}Login{/t}' style='border:1px solid #000000' />&nbsp;
                    <span class='topheadertext'><a class='topheaderlink' href='?view=register'>{t}New user?{/t}</a></span>
                    {else}
                    <span class='topheadertext'>{t}User{/t}: <a class='topheaderlink' href='?view=user/userinfo'>{$user_info.name}</a></span>&nbsp;
                    <span class='topheadertext'><a class='topheaderlink' href='?view=logout'>&raquo; {t}Logout{/t}</a></span>
                    {/if}
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </form>
    </div><!--page_top-->
    <div class='navigation_bar'>
      <p class='navigation_bar_text'>
        {$navigation_bar}
      </p>
    </div>
    <div class='page_middle'>