<?php
if (is_file('install.php')) {
  die("Delete install.php file from server!");
}

include_once 'lib/database.php';

global $include_prefix;
include_once $include_prefix . 'menufunctions.php';
include_once $include_prefix . 'view_ids.inc.php';
include_once $include_prefix . 'lib/user.functions.php';
include_once $include_prefix . 'lib/facebook.functions.php';
include_once $include_prefix . 'lib/logging.functions.php';

include_once $include_prefix . 'lib/debug.functions.php';

include_once $include_prefix . 'lib/smarty/Smarty.class.php';

if (is_file('cust/' . CUSTOMIZATIONS . '/head.php')) {
  include_once 'cust/' . CUSTOMIZATIONS . '/head.php';
} else {
  include_once 'cust/default/head.php';
}

session_name("UO_SESSID");
session_start();
if (!isset($_SESSION['VISIT_COUNTER'])) {
  LogVisitor($_SERVER['REMOTE_ADDR']);
  $_SESSION['VISIT_COUNTER'] = true;
}

if (!isset($_SESSION['uid'])) {
  $_SESSION['uid'] = "anonymous";
  SetUserSessionData("anonymous");
}

require_once $include_prefix . 'lib/configuration.functions.php';

include_once 'localization.php';
setSessionLocale();

if (isset($_POST['myusername'])) {
  $view = iget("view");
  if (strpos($view, "mobile") === false)
    UserAuthenticate($_POST['myusername'], $_POST['mypassword'], "FailRedirect");
  else
    UserAuthenticate($_POST['myusername'], $_POST['mypassword'], "FailRedirectMobile");
}

$smarty = new Smarty();
$smarty->setTemplateDir($include_prefix . 'smarty/templates');
$smarty->setCompileDir($include_prefix . 'smarty/templates_c');
$smarty->setCacheDir($include_prefix . 'smarty/cache');
$smarty->setConfigDir($include_prefix . 'smarty/configs');

if (!iget('view')) {
  header("location:?view=frontpage");
  exit();
} else {
  LogPageLoad(iget('view'));
}

global $serverConf;
if (IsFacebookEnabled() && !empty($serverConf['FacebookAppId']) && !empty($serverConf['FacebookAppSecret'])) {
  //include_once 'lib/facebook/facebook.php';
  $fb_cookie = FBCookie($serverConf['FacebookAppId'], $serverConf['FacebookAppSecret']);
  if ($_SESSION['uid'] == "anonymous" && $fb_cookie) {
    $_SESSION['uid'] = MapFBUserId($fb_cookie);
    SetUserSessionData($_SESSION['uid']);
  }
}

$user = $_SESSION['uid'];

setSelectedSeason();

if (!iget("view")) {
  $view = "frontpage";
} else {
  $view = iget("view");
}

$curseason = CurrentSeason();

$smarty->assign("page_title", GetPageTitle());
$smarty->assign("cust", CUSTOMIZATIONS);
$smarty->assign("locales", localeSelection());
$smarty->assign("enable_facebook", IsFacebookEnabled() && $user == 'anonymous');
$smarty->assign("has_schedule_rights", hasScheduleRights());
$smarty->assign("is_super_admin", isSuperAdmin());
$smarty->assign("has_translation_right", hasTranslationRight());
$smarty->assign("has_player_admin_rights", hasPlayerAdminRights());
$smarty->assign("user_anonymous", $_SESSION['uid'] == 'anonymous');
$smarty->assign("menu_edit_links", getEditSeasonLinks());
$smarty->assign("menu_enroll_seasons", EnrollSeasons());
$smarty->assign("menu_pools", getViewPools($curseason));
$smarty->assign("menu_season_series", SeasonSeries($season, true));
$smarty->assign("menu_urls", GetUrlListByTypeArray(array("menulink", "menumail"), $curseason));
$smarty->assign("menu_stat_data_available", IsStatsDataAvailable());
$smarty->assign("menu_countries_count", count(CountryList(true, true)));
$smarty->assign("menu_urls_list_by_type_array", GetUrlListByTypeArray(array("menulink", "menumail"), 0));
$smarty->assign("menu_logo_html", logo());
$smarty->assign("fb_app_id", $serverConf['FacebookAppId']);
$smarty->assign("user_info", UserInfo($user));
$smarty->assign("page_header", pageHeader());
$smarty->assign("rss", IsGameRSSEnabled());
$smarty->assign("server_request_uri", $_SERVER["REQUEST_URI"]);

$twitter_enabled = IsTwitterEnabled();
$smarty->assign("twitter_enabled", $twitter_enabled);
if ($twitter_enabled) {
  $smarty->assign("saved_url", GetUrl("season", $season, "result_twitter"));
}

$playerAdmins = array();
if (!empty($_SESSION['userproperties']['userrole']['playeradmin'])) {
  foreach ($_SESSION['userproperties']['userrole']['playeradmin'] as $profile_id => $propid) {
    array_push($playerAdmins, PlayerProfile($profile_id));
  }
}
$smarty->assign("player_admins", $playerAdmins);
$smarty->assign("current_season_name", CurrentSeasonName());

include $view . ".php";
$smarty->display($view . '.tpl');
