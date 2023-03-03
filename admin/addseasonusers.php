<?php
include_once $include_prefix . 'lib/configuration.functions.php';
include_once $include_prefix . 'lib/facebook.functions.php';
include_once $include_prefix . 'lib/url.functions.php';

$LAYOUT_ID = ADDSEASONUSERS;
$title = _("Event users");
$smarty->assign("title", $title);
$seasonId = $_GET["season"];
$smarty->assign("season_id", $seasonId);

if (!isSeasonAdmin($seasonId)) {
  die('Insufficient rights');
}

$messages = array();
if (!empty($_POST['add'])) {
  $userid = $_POST['userid'];
  if (empty($userid)) {
    $userid = UserIdForMail($_POST['email']);
  }

  if (IsRegistered($userid)) {
    if ($_GET["access"] == "eventadmin") {
      AddSeasonUserRole($userid, "seasonadmin:" . $seasonId, $seasonId);
    } elseif ($_GET["access"] == "teamadmin") {
      AddSeasonUserRole($userid, "teamadmin:" . $_POST["team"], $seasonId);
    } elseif ($_GET["access"] == "gameadmin") {
      $reservations = $_POST["reservations"];
      foreach ($reservations as $res) {
        $games = ReservationGames($res);
        while ($game = GetDatabase()->FetchAssoc($games)) {
          AddSeasonUserRole($userid, 'gameadmin:' . $game['game_id'], $seasonId);
        }
      }
    } elseif ($_GET["access"] == "accradmin") {
      $teams = $_POST["teams"];
      foreach ($teams as $teamId) {
        AddSeasonUserRole($userid, 'accradmin:' . $teamId, $seasonId);
      }
    }
    $messages[] = sprintf(_("User rights added for %s."), utf8entities($userid));
  } else {
    $messages[] = _("Invalid user");
  }
} elseif (!empty($_POST['remove_x'])) {
  if ($_GET["access"] == "eventadmin") {
    RemoveSeasonUserRole($_POST['delId'], "seasonadmin:" . $seasonId, $seasonId);
  } elseif ($_GET["access"] == "teamadmin") {
    RemoveSeasonUserRole($_POST['delId'], "teamadmin:" . $_POST['teamId'], $seasonId);
  } elseif ($_GET["access"] == "accradmin") {
    RemoveSeasonUserRole($_POST['delId'], "accradmin:" . $_POST['teamId'], $seasonId);
  }
  $_GET["access"] = "";
}
$smarty->assign("messages", $messages);

include_once 'script/disable_enter.js.inc';

$season_admins = SeasonAdmins($seasonId);
$smarty->assign("season_admins", $admins);
$team_admins = SeasonTeamAdmins($seasonId);
foreach ($team_admins as $key => $user) {
  $team_admins[$key]['teaminfo'] = TeamInfo($user['team_id']);
}
$smarty->assign("team_admins", $team_admins);
$seasongames = SeasonAllGames($seasonId);
$smarty->assign("seasongames", $seasongames);
$game_admins = SeasonGameAdmins($seasonId);
$smarty->assign("game_admins", $game_admins);
$smarty->assign("teams", SeasonTeams($seasonId));
$accreditation_admins = SeasonAccreditationAdmins($seasonId);
foreach ($accreditation_admins as $key => $user) {
  $accreditation_admins[$key]['teaminfo'] = TeamInfo($user['team_id']);
}
$smarty->assign("accreditation_admins", $accreditation_admins);
$smarty->assign("reservations", SeasonReservations($seasonId));

$teamresp = 0;
foreach ($seasongames as $game) {
  if (!empty($game['respteam'])) {
    $teamresp++;
  }
}
$smarty->assign("teamresp", $teamresp);
