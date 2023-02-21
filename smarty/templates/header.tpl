<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="-1" />
  <link rel='icon' type='image/png' href='cust/{$cust}/favicon.png' />
  {foreach $stylesheets as $stylesheet}
  <link rel="stylesheet" href="{$stylesheet}" type="text/css" />
  {/foreach}
  <script src='script/ultiorganizer.js'></script>
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
              <a href='{$url_base}' class='header_text'>Ultimate Pelikone</a>
              <span style='color: #0bc5e0;font-size: 14pt;'> Finnish Flying Disc Association</span>
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
                    {if enable_facebook}
                    <div id='fb-root'></div>
                    <fb:login-button perms='email,publish_stream,offline_access' />
                    {/if}
                    <span class='topheadertext'>{t}User{/t}: <a class='topheaderlink' href='?view=user/userinfo'>{$userinfo.name}</a></span>&nbsp;
                    <span class='topheadertext'><a class='topheaderlink' href='?view=logout'>&raquo; {t}Logout{/t}</a></span>
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