<table style='border:1px solid #fff;background-color: #ffffff;'>
  <tr>
    <td class='menu_left'>
      <!-- Administration menu -->
      {if $has_schedule_rights || $is_super_admin || $has_translation_right}
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'>{t}Administration{/t}</td>
        </tr>
        {/if}
        {if $is_super_admin}
        <tr>
          <td>
            <a class='subnav' href='?view=admin/seasons'>&raquo; {t}Events{/t}</a>
            <a class='subnav' href='?view=admin/serieformats'>&raquo; {t}Rule templates{/t}</a>
            <a class='subnav' href='?view=admin/clubs'>&raquo; {t}Clubs & Countries{/t}</a>
            <a class='subnav' href='?view=admin/locations'>&raquo; {t}Field locations{/t}</a>
            <a class='subnav' href='?view=admin/reservations'>&raquo; {t}Field reservations{/t}</a>
            {/if}
            {if $has_schedule_rights}
        <tr>
          <td><a class='subnav' href='?view=admin/schedule'>&raquo; {t}Scheduling{/t}</a>
            {/if}
            {if $has_translation_right}
            <a class='subnav' href='?view=admin/translations'>&raquo; {t}Translations{/t}</a>
            {/if}
            {if $is_super_admin}
            <a class='subnav' href='?view=admin/users'>&raquo; {t}Users{/t}</a>
            <a class='subnav' href='?view=admin/eventviewer'>&raquo; {t}Logs{/t}</a>
            <a class='subnav' href='?view=admin/dbadmin'>&raquo; {t}Database{/t}</a>
            <a class='subnav' href='?view=admin/serverconf'>&raquo; {t}Settings{/t}</a>
            {/if}
            {if $has_schedule_rights || $is_super_admin || $has_translation_right}
          </td>
        </tr>
      </table>
      {/if}
      {if !$user_anonymous}
      <table class='leftmenulinks'>
        <tr>
          <td>
            <a class='subnav' href='?view=admin/help'>&raquo; {t}Helps{/t}</a>
          </td>
        </tr>
      </table>
      {/if}
      <!-- Event administration menu -->
      {if count($menu_edit_links)}
      {foreach $menu_edit_links as $season => $links}
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'>{$season} {t}Administration{/t}</td>
          <!-- TODO get the id for X? -->
          <td class='menuseasonlevel'><a style='text-decoration: none;' href='?view=frontpage&amp;hideseason={$season}'>x</a></td>
        </tr>
        <tr>
          <td>
            {foreach $links as $href => $name}
            <a class='subnav' href='{$href}'>&raquo; {$name}</a>
            {/foreach}
          </td>
        </tr>
      </table>
      {/foreach}
      {/if}
      {if $is_super_admin}
      <table class='leftmenulinks'>
        <tr>
          <td>
            <a class='subnav' href='?view=admin/addseasons'>&raquo; {t}Create new event{/t}</a>
          </td>
        </tr>
      </table>
      {/if}
      <!-- Team registration -->
      <!-- TODO test it -->
      {if !$user_anonymous}
      {if count($menu_enroll_seasons)}
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'>{t}Team registration{/t}</td>
        </tr>
        <tr>
          <td>
            {foreach $menu_enroll_seasons as $season_id => $season_name}
            <a class='subnav' href='?view=user/enrollteam&amp;season={$season_id}'>&raquo; {u}{$season_name}{/u}</a>
            {/foreach}
          </td>
        </tr>
      </table>
      {/if}
      {/if}
      <!-- Player profiles -->
      {if $has_player_admin_rights}
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'>{t}Player profiles{/t}</td>
        </tr>
        <tr>
          <td>
            {foreach $player_admins as $player}
            <a class='subnav' href='?view=user/playerprofile&amp;profile={$player.profile_id}'>&raquo; {$player.firstname} {$player.lastname}</a>
            {/foreach}
          </td>
        </tr>
      </table>
      {/if}
      {if count($menu_current_seasons)}
      <table>
        <tr>
          <td>
            <form action='?view=index' method='get' id='seasonsels'>
              <div>
                <select class='seasondropdown' name='selseason' onchange='changeseason(selseason.options[selseason.options.selectedIndex].value);'>
                  {foreach $menu_current_seasons as $row}
                  {assign var=selected value=""}
                  {if isset($smarty.session.userproperties.selseason) && $smarty.session.userproperties.selseason == $row.season_id}
                  {assign var=selected value="selected='selected'"}
                  {/if}
                  <option class='dropdown' {$selected} value='{$row.season_id}'>{$row.season_name}</option>
                  {/foreach}
                </select>
                <noscript>
                  <div><input type='submit' value='{t}Go{/t}' name='selectseason' /></div>
                </noscript>
              </div>
            </form>
          </td>
        </tr>
      </table>
      {/if}
      <table class='leftmenulinks'>
        {if count($menu_pools)}
        {assign var="last_season" value=""}
        {assign var="last_series" value=""}
        {foreach $menu_pools as $pool}
        {if $last_season != $pool.series}
        {assign var="last_season" value=$pool.season}
        <tr>
          <td class='menuseasonlevel'>
            <a class='seasonnav' style='text-align:center;' href='?view=teams&amp;season={$pool.season}&amp;list=bystandings'>{u}{$pool.season_name}{/u}</a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=teams&amp;season={$pool.season}&amp;list=bystandings'>{t}Final standings{/t}</a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=games&amp;season={$pool.season}&amp;filter=tournaments&amp;group=all'>{t}Games{/t}</a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=teams&amp;season={$pool.season}&amp;list=allteams'>{t}Teams{/t}</a>
          </td>
        </tr>
        <tr>
          <td class='menuseparator'></td>
        </tr>
        {/if}
        {if $last_series != $pool.series}
        {assign var="last_series" value=$pool.series}
        <tr>
          <td class='menuserieslevel'>
            <a class='subnav' href='?view=seriesstatus&amp;series={$pool.series}'>{u}{$pool.series_name}{/u}</a>
          </td>
        </tr>
        <tr>
          <td class='navpoollink'>
            <a class='subnav' href='?view=poolstatus&amp;series={$pool.series}'>&raquo; {t}Show all pools{/t}</a>
          </td>
        </tr>
        {/if}
        <tr>
          <td class='menupoollevel'>
            <a class='navpoollink' href='?view=poolstatus&amp;pool={$pool.pool}'>&raquo; {u}{$pool.pool_name}{/u}</a>
          </td>
        </tr>
        {/foreach}
        {else}
        <tr>
          <td class='menuseasonlevel'>
            <a class='seasonnav' style='text-align:center;' href='?view=teams&amp;season={$season}&amp;list=bystandings'>{u}{$current_season_name}{/u}</a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=timetables&amp;season=$season&amp;filter=tournaments&amp;group=all'>{t}Games{/t}</a>
          </td>
        </tr>
        <tr>
          <td>
            <a class='nav' href='?view=teams&amp;season=$season'>{t}Teams{/t}</a>
          </td>
        </tr>
        <tr>
          <td class='menuseparator'></td>
        </tr>
        {foreach $menu_season_series as $s}
        <tr>
          <td class='menuserieslevel'>{u}{$s.name}{/u}</td>
        </tr>
        <tr>
          <td class='menupoollevel'>
            {t}Pools not yet created{/t}
          </td>
        </tr>
        {/foreach}
        {/if}
      </table>
      <!-- Event links -->
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'>{t}Event Links{/t}</td>
        </tr>
        <tr>
          <td>
            {foreach $menu_urls as $url}
            {if $url.type == "menulink"}
            <a class='subnav' href='{$url.url}'>&raquo; {u}{$url.name}{/u}</a>
            {elseif $url.type == "menumail"}
            <a class='subnav' href='mailto:{$url.url}'>@{u}{$url.name}{/u}</a>
            {/if}
            {/foreach}
          </td>
        </tr>
        <tr>
          <td>
            <a class='subnav' style='background: url(./images/linkicons/feed_14x14.png) no-repeat 0 50%; padding: 0 0 0 19px;' href='./ext/rss.php?feed=all'>{t}Result Feed{/t}</a>
          </td>
        </tr>
        {if $twitter_enabled}
        {if !empty($saved_url.url)}
        <tr>
          <td>
            <a class='subnav' style='background: url(./images/linkicons/twitter_14x14.png) no-repeat 0 50%; padding: 0 0 0 19px;' href='" . $savedurl[' url'] . "'>{t}Result Twitter{/t}</a>
          </td>
        </tr>
        {/if}
        {/if}
      </table>
      <!-- Event history -->
      {if $menu_stat_data_available}
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'>{t}Statistics{/t}</td>
        </tr>
        <tr>
          <td>
            <a class='subnav' href=" ?view=seasonlist">&raquo; {t}Events{/t}</a>
            <a class='subnav' href="?view=allplayers">&raquo; {t}Players{/t}</a>
            <a class='subnav' href="?view=allteams">&raquo; {t}Teams{/t}</a>
            <a class='subnav' href="?view=allclubs">&raquo; {t}Clubs{/t}</a>
            {if $menu_countries_count}
            <a class='subnav' href="?view=allcountries">&raquo; {t}Countries{/t}</a>
            {/if}
            <a class='subnav' href="?view=statistics&amp;list=teamstandings">&raquo; {t}All time{/t}</a>
          </td>
        </tr>
      </table>
      {/if}
      <!-- External access -->
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'>{t}Client access{/t}</td>
        </tr>
        <tr>
          <td>
            <a class='subnav' href='?view=ext/index'>&raquo; {t}Ultiorganizer links{/t}</a>
            <a class='subnav' href='?view=ext/export'>&raquo; {t}Data export{/t}</a>
            <a class='subnav' href='?view=mobile/index'>&raquo; {t}Mobile Administration{/t}</a>
            <a class='subnav' href='./scorekeeper/'>&raquo; {t}Scorekeeper{/t}</a>
          </td>
        </tr>
      </table>
      <table class='leftmenulinks'>
        <tr>
          <td class='menuseasonlevel'>{t}Links{/t}</td>
        </tr>
        <tr>
          <td>
            {foreach $menu_urls_list_by_type_array as $url}
            {if $url.type == "menulink"}
            <a class='subnav' href='{$url.url}'>&raquo; {u}{$url.name}{/u}</a>
            {elseif $url.type == "menumail"}
            <a class='subnav' href='mailto:{$url.url}'>@{u}{$url.name}{/u}</a>
            {/if}
            {/foreach}
          </td>
        </tr>
      </table>
      <!-- Draw customizable logo if any -->
      {$menu_logo_html nofilter}
      <table style='width:90%'>
        <tr>
          <td class='guides'>
            <a href='?view=user_guide'>{t}User Guide{/t}</a> |
            <a href='?view=admin/help'>{t}Admin Help{/t}</a> |
            <a href='?view=privacy'>{t}Privacy Policy{/t}</a>
          </td>
        </tr>
      </table>
    </td>
    <td align='left' valign='top' class='tdcontent'>
      <div class='content'>