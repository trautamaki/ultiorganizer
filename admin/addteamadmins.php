<?php
include_once $include_prefix . 'lib/configuration.functions.php';
include_once $include_prefix . 'lib/facebook.functions.php';
include_once $include_prefix . 'lib/url.functions.php';

$LAYOUT_ID = ADDSEASONUSERS;
$title = _("Team admins");
$smarty->assign("title", $title);
$seriesId = intval($_GET["series"]);
$smarty->assign("seried_id", $seriesId);
$seriesinfo = SeriesInfo($seriesId);
$smarty->assign("seriesinfo", $seriesinfo);
$backurl = isset($_POST['backurl']) ? utf8entities($_POST['backurl']) : utf8entities($_SERVER['HTTP_REFERER']);
$smarty->assign("backurl", $backurl);
$teams = SeriesTeams($seriesId);

if (!isSeasonAdmin($seriesinfo['season'])) {
  die('Insufficient rights');
}

$messages = array();
if (!empty($_POST['add'])) {
  foreach ($teams as $team) {
    $tid = $team['team_id'];
    $userid = isset($_POST["userid$tid"]) ? $_POST["userid$tid"] : "";
    $email = isset($_POST["email$tid"]) ? $_POST["email$tid"] : "";

    if (empty($userid) && empty($email)) {
      continue;
    } elseif (empty($userid)) {
      $userid = UserIdForMail($email);
      if ($userid == "-1") {
        $messages[] = _("Invalid user:") . " " . $email;
        continue;
      }
    }

    if (IsRegistered($userid)) {
      AddSeasonUserRole($userid, "teamadmin:$tid", $seriesinfo['season']);
      $messages[] = _("User rights added for:") . " " . $userid;
    } else {
      $messages[] = _("Invalid user:") . " " . $userid;
    }
  }
} elseif (!empty($_POST['remove_x'])) {
  RemoveSeasonUserRole($_POST['delId'], "teamadmin:" . $_POST['teamId'], $seriesinfo['season']);
}
$smarty->assign("messages", $messages);

include_once 'script/disable_enter.js.inc';

$admins = SeasonTeamAdmins($seriesinfo['season']);
foreach ($admins as $key => $user) {
  $admins[$key]['teaminfo'] = TeamInfo($user['team_id']);
}
$smarty->assign("admins", $admins);

foreach ($teams as $key => $team) {
  $teams[$key]['teaminfo'] = TeamInfo($team['team_id']);
}
$smarty->assign("teams", $teams);
