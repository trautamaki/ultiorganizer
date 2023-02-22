<?php
include_once $include_prefix . 'lib/season.functions.php';
include_once $include_prefix . 'lib/game.functions.php';
include_once $include_prefix . 'lib/statistical.functions.php';

if (is_file('cust/' . CUSTOMIZATIONS . '/head.php')) {
  include_once 'cust/' . CUSTOMIZATIONS . '/head.php';
} else {
  include_once 'cust/default/head.php';
}

/**
 * Shows html content with ultiorganizer menus and layout.
 *
 * @param string $title page's title
 * @param string $html page's content
 */
function showPage($title, $html, $mobile = false)
{
  if ($mobile) {
    mobilePageTop($title);
    echo $html;
    mobilePageEnd();
  } else {
    echo $html;
  }
}

/**
 * Shows html content without ultiorganizer menus and layout.
 *
 * @param string $title page's title
 * @param string $html page's content
 */
function showPrintablePage($title, $html)
{
  pageTop($title, true);
  leftMenu(0, true, true);
  contentStart();
  echo $html;
  contentEnd();
  pageEnd();
}

/**
 * HTML code with page meta information. Leaves <head> tag open.
 *
 * @param string $title - the page title
 */
function pageTopHeadOpen($title)
{
  include $include_prefix . 'script/common.js.inc';
  global $include_prefix;
  include_once $include_prefix . 'script/help.js.inc';
  return $ret;
}


/**
 * Adds on page help.
 *
 * @param string $html - html-text shown when help button pressed.
 */
function onPageHelpAvailable($html)
{
  return "<div style='float:right;'>
	<input type='image' class='helpbutton' id='helpbutton' src='images/help-icon.png'/></div>\n
	<div id='helptext' class='yui-pe-content'>$html<hr/></div>";
}


/**
 * Top of Mobile page.
 *
 * @param String $title - page title
 */
function mobilePageTop($title)
{
  pageTopHeadOpen($title);

  echo "</head><body style='overflow-y:scroll;'>\n";
  echo "<div class='mobile_page'>\n";
}

function mobilePageEnd($query = "")
{
  if ($query == "")
    $query = $_SERVER['QUERY_STRING'];
  if (!isset($_SESSION['uid']) || $_SESSION['uid'] == "anonymous") {

    $html = "<form action='?" . utf8entities($query) . "' method='post'>\n";
    $html .= "<table cellpadding='2'>\n";
    $html .= "<tr><td>\n";
    $html .= utf8entities(_("Username")) . ":";
    $html .= "</td></tr><tr><td>\n";
    $html .= "<input class='input' type='text' id='myusername' name='myusername' size='15'/> ";
    $html .= "</td></tr><tr><td>\n";
    $html .= utf8entities(_("Password")) . ":";
    $html .= "</td></tr><tr><td>\n";
    $html .= "<input class='input' type='password' id='mypassword' name='mypassword' size='15'/> ";
    $html .= "</td></tr><tr><td>\n";
    $html .= "<input class='button' type='submit' name='login' value='" . utf8entities(_("Login")) . "'/>";
    $html .= "</td></tr><tr><td>\n";
    $html .= "<hr/>\n";
    $html .= "</td></tr><tr><td>\n";
    $html .= "<a href='?view=frontpage'>" . utf8entities(_("Back to the Ultiorganizer")) . "</a>";
    $html .= "</td></tr>\n";
    $html .= "</table>\n";
    $html .= "</form>";
  } else {
    if ($query != "") {
      header($query);
    }
    // $user = $_SESSION['uid'];
    // $userinfo = UserInfo($user);
    $html = "<table cellpadding='2'>\n";
    $html .= "<tr><td></td></tr>\n";
    $html .= "<tr><td><hr /></td></tr><tr><td>\n";
    $html .= "<a href='?view=frontpage'>" . utf8entities(_("Back to the Ultiorganizer")) . "</a>";
    $html .= "</td></tr><tr><td>\n";
    $html .= "<a href='?view=mobile/logout'>" . utf8entities(_("Logout")) . "</a></td></tr></table>";
  }

  global $serverConf;
  if (IsFacebookEnabled()) {
    $html .= "<script src='http://connect.facebook.net/en_US/all.js'></script>
    <script>
      FB.init({appId: '";
    $html .= $serverConf['FacebookAppId'];
    $html .= "', status: true,
               cookie: true, xfbml: true});
      FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });
    </script>";
  }
  $html .= "<div class='page_bottom'></div>";
  $html .= "</div></body></html>";
  echo $html;
}

/**
 * Creates locale selection html-code.
 */
function localeSelection()
{
  global $locales;
  $locale_array = array();
  $i = 0;
  foreach ($locales as $localestr => $localename) {
    $query_string = StripFromQueryString($_SERVER['QUERY_STRING'], "locale");
    $query_string = StripFromQueryString($query_string, "goindex");
    $locale_array[$i]["query_string"] = $query_string;
    $locale_array[$i]["localestr"] = $localestr;
    $locale_array[$i]["localename"] = $localename;
    $i++;
  }

  return $locale_array;
}

/**
 * Navigation bar functionality and html-code.
 *
 * @param string $title - page title
 */
function navigationBar($title)
{
  $ret = "";
  $ptitle = "";
  if (isset($_SERVER['QUERY_STRING']))
    $query_string = $_SERVER['QUERY_STRING'];
  else
    $query_string = "";

  if (isset($_GET['goindex']) && $_GET['goindex'] > 1 && isset($_SESSION['navigation'])) {
    $goindex = $_GET['goindex'];
    $count = count($_SESSION['navigation']);
    $i = 0;
    foreach ($_SESSION['navigation'] as $pview => $ptitle) {

      if ($i >= $goindex) {
        unset($_SESSION['navigation'][$pview]);
      }
      $i++;
    }
  } else if (isset($_GET['goindex']) && $_GET['goindex'] <= 1) {
    $_SESSION['navigation'] = array("view=frontpage" => _("Homepage"));
  } else {
    if (!isset($_SESSION['navigation'])) {
      if (strlen($query_string) == 0 || (isset($_GET['view']) && $_GET['view'] == 'logout')) {
        $_SESSION['navigation'] = array("view=frontpage" => _("Homepage"));
      } elseif (!empty($title)) {
        $_SESSION['navigation'] = array($query_string => $title);
      }
    } else {
      if (strlen($query_string) == 0) {
        $_SESSION['navigation']["view=frontpage"] = _("Homepage");
      } elseif (!empty($title)) {
        unset($_SESSION['navigation'][$query_string]);

        //if previous view was having same title, remove it. e.g. when navigating back and forth in profiles or in case of sorting pages trough url parameter
        $lastvalue = end($_SESSION['navigation']);
        if ($lastvalue) {
          if ($lastvalue == $title) {
            $lastkey = end((array_keys($_SESSION['navigation'])));
            unset($_SESSION['navigation'][$lastkey]);
          }
        }
        $_SESSION['navigation'][$query_string] = $title;
      }
    }
  }

  $i = 1;
  $needsdots = false;
  if (isset($_SESSION['navigation'])) {

    foreach ($_SESSION['navigation'] as $view => $ptitle) {

      if ($i < count($_SESSION['navigation'])) {
        if ($i > 1 && $i < (count($_SESSION['navigation']) - 3)) {
          $needsdots = true;
        } else {
          if ($needsdots) {
            $ret .= "... &raquo; ";
            $needsdots = false;
          }
          $ret .= "<a href='?" . utf8entities($view) . "&amp;goindex=" . $i . "'>" . $ptitle . "</a> &raquo; ";
        }
      }
      $i++;
    }
  }
  $ret = $ret . " " . $ptitle;

  return $ret;
}

function pageMainStart($printable = false)
{
  if ($printable) {
    echo "<table style='width:100%;'><tr>";
    return;
  }

  echo "<table style='border:1px solid #fff;background-color: #ffffff;'><tr>\n";
}


/**
 * Get event administration links.
 */
function getEditSeasonLinks()
{
  $ret = array();
  if (isset($_SESSION['userproperties']['editseason'])) {
    $editSeasons = getEditSeasons($_SESSION['uid']);
    foreach ($editSeasons as $season => $propid) {
      $ret[$season] = array();
    }
    $respgamesset = array();
    foreach ($ret as $season => $links) {
      if (isSeasonAdmin($season)) {
        $links['?view=admin/seasonadmin&amp;season=' . $season] = _("Event");
        $links['?view=admin/seasonseries&amp;season=' . $season] = _("Divisions");
        $links['?view=admin/seasonteams&amp;season=' . $season] = _("Teams");
        $links['?view=admin/seasonpools&amp;season=' . $season] = _("Pools");
        $links['?view=admin/reservations&amp;season=' . $season] = _("Scheduling");
        $links['?view=admin/seasongames&amp;season=' . $season] = _("Games");
        $links['?view=admin/seasonstandings&amp;season=' . $season] = _("Standings");
        $links['?view=admin/accreditation&amp;season=' . $season] = _("Accreditation");
        $respgamesset[$season] = "set";
      }
      $ret[$season] = $links;
    }
    if (isset($_SESSION['userproperties']['userrole']['seriesadmin'])) {
      foreach ($_SESSION['userproperties']['userrole']['seriesadmin'] as $series => $param) {
        $seriesseason = SeriesSeasonId($series);
        // Links already added if superadmin or seasonadmin
        if (isset($ret[$seriesseason]) && !isSeasonAdmin($seriesseason)) {
          $links = $ret[$seriesseason];
          $seriesname = U_(getSeriesName($series));
          $links['?view=admin/seasonteams&amp;season=' . $season . '&amp;series=' . $series] = $seriesname . " " . _("Teams");
          $links['?view=admin/seasongames&amp;season=' . $season . '&amp;series=' . $series] = $seriesname . " " . _("Games");
          $links['?view=admin/seasonstandings&amp;season=' . $season . '&amp;series=' . $series] = $seriesname . " " . _("Pool standings");
          $links['?view=admin/accreditation&amp;season=' . $seriesseason] = _("Accreditation");
          $ret[$seriesseason] = $links;
          $respgamesset[$seriesseason] = "set";
        }
      }
    }

    $teamPlayersSet = array();
    if (isset($_SESSION['userproperties']['userrole']['teamadmin'])) {

      foreach ($_SESSION['userproperties']['userrole']['teamadmin'] as $team => $param) {
        $teamseason = getTeamSeason($team);
        $teamresps = TeamResponsibilities($_SESSION['uid'], $teamseason);
        if (isset($ret[$teamseason])) {
          if (count($teamresps) < 2) {
            $teamname = getTeamName($team);
            $links = $ret[$teamseason];
            $links['?view=user/teamplayers&amp;team=' . $team] = _("Team") . ": " . $teamname;
            $respgamesset[$teamseason] = "set";
            $teamPlayersSet["" . $team] = "set";
            $ret[$teamseason] = $links;
          } else {
            $links = $ret[$teamseason];
            $links['?view=user/respteams&amp;season=' . $teamseason] = _("Team responsibilities");
            $respgamesset[$teamseason] = "set";
            $ret[$teamseason] = $links;
          }
        }
      }
    }
    if (isset($_SESSION['userproperties']['userrole']['accradmin'])) {
      if (count($_SESSION['userproperties']['userrole']['teamadmin']) <= 4) {
        foreach ($_SESSION['userproperties']['userrole']['accradmin'] as $team => $param) {
          if (!isset($teamPlayersSet[$team])) {
            $teamseason = getTeamSeason($team);
            if (isset($ret[$teamseason])) {
              $teamname = getTeamName($team);
              $links = $ret[$teamseason];
              $links['?view=user/teamplayers&amp;team=' . $team] = _("Team") . ": " . $teamname;
              $links['?view=admin/accreditation&amp;season=' . $teamseason] = _("Accreditation");
              $teamPlayersSet["" . $team] = "set";
              $ret[$teamseason] = $links;
            }
          }
        }
      } else {
        $links = $ret[$season];
        $links['?view=user/respteams&amp;season=' . $season] = _("Team responsibilities");
        $links['?view=admin/accreditation&amp;season=' . $season] = _("Accreditation");
        $ret[$season] = $links;
      }
    }
    if (isset($_SESSION['userproperties']['userrole']['gameadmin'])) {
      foreach ($_SESSION['userproperties']['userrole']['gameadmin'] as $game => $param) {
        $gameseason = GameSeason($game);
        if (isset($ret[$gameseason])) {
          $respgamesset[$gameseason] = "set";
        }
      }
    }
    if (isset($_SESSION['userproperties']['userrole']['resgameadmin'])) {
      foreach ($_SESSION['userproperties']['userrole']['resgameadmin'] as $resId => $param) {
        foreach (ReservationSeasons($resId) as $resSeason) {
          if (isset($ret[$resSeason])) {
            $respgamesset[$resSeason] = "set";
          }
        }
      }
    }
    foreach ($respgamesset as $season => $set) {
      $links = $ret[$season];
      $links['?view=user/respgames&amp;season=' . $season] = _("Game responsibilities");
      $links['?view=user/contacts&amp;season=' . $season] = _("Contacts");
      $ret[$season] = $links;
    }
  }

  foreach ($ret as $season => $links) {
    if (!isset($links) || empty($links) || count($links) == 0) {
      unset($ret[$season]);
    }
  }
  return $ret;
}
