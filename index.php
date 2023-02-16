<?php
if (is_file('install.php')) {
  die("Delete install.php file from server!");
}

include_once 'lib/database.php';

$database = new Database();

global $include_prefix;
include_once $include_prefix . 'menufunctions.php';
include_once $include_prefix . 'view_ids.inc.php';
include_once $include_prefix . 'lib/user.functions.php';
include_once $include_prefix . 'lib/facebook.functions.php';
include_once $include_prefix . 'lib/logging.functions.php';

include_once $include_prefix . 'lib/debug.functions.php';


session_name("UO_SESSID");
session_start();
if (!isset($_SESSION['VISIT_COUNTER'])) {
  LogVisitor($database, $_SERVER['REMOTE_ADDR']);
  $_SESSION['VISIT_COUNTER'] = true;
}

if (!isset($_SESSION['uid'])) {
  $_SESSION['uid'] = "anonymous";
  SetUserSessionData($database, "anonymous");
}

require_once $include_prefix . 'lib/configuration.functions.php';

include_once 'localization.php';
setSessionLocale($database);

if (isset($_POST['myusername'])) {
  $view = iget("view");
  if (strpos($view, "mobile") === false)
    UserAuthenticate($database, $_POST['myusername'], $_POST['mypassword'], "FailRedirect");
  else
    UserAuthenticate($database, $_POST['myusername'], $_POST['mypassword'], "FailRedirectMobile");
}

if (!iget('view')) {
  header("location:?view=frontpage");
  exit();
} else {
  LogPageLoad($database, iget('view'));
}

global $serverConf;
if (IsFacebookEnabled() && !empty($serverConf['FacebookAppId']) && !empty($serverConf['FacebookAppSecret'])) {
  //include_once 'lib/facebook/facebook.php';
  $fb_cookie = FBCookie($serverConf['FacebookAppId'], $serverConf['FacebookAppSecret']);
  if ($_SESSION['uid'] == "anonymous" && $fb_cookie) {
    $_SESSION['uid'] = MapFBUserId($fb_cookie);
    SetUserSessionData($database, $_SESSION['uid']);
  }
}

$user = $_SESSION['uid'];

setSelectedSeason();

if (!iget("view")) {
  $view = "frontpage";
} else {
  $view = iget("view");
}

include $view . ".php";
