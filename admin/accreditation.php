<?php
include_once 'lib/accreditation.functions.php';

$LAYOUT_ID = ACCREDITATION;

$title = _("Accreditation");
$smarty->assign("title", $title);

if (isset($_GET['season'])) {
  $season = $_GET['season'];
} else {
  $season = CurrentSeason();
}
$smarty->assign("season", $season);

if (isset($_GET['list'])) {
  $list = $_GET['list'];
} else {
  $list = "acc";
}
$smarty->assign("list", $list);
$url = "?view=admin/accreditation&amp;season=" . $season . "&amp;list=" . $list;
$smarty->assign("url", $url);

if (isset($_POST['acknowledge'])) {
  foreach ($_POST['acknowledged'] as $playerGame) {
    $playerGameArr = explode("_", $playerGame);
    AcknowledgeUnaccredited($playerGameArr[0], $playerGameArr[1], "accreditation");
  }
}
if (isset($_POST['remacknowledge']) && isset($_POST['deleteAckId'])) {
  $playerGameArr = explode("_", $_POST['deleteAckId']);
  UnAcknowledgeUnaccredited($playerGameArr[0], $playerGameArr[1], "accreditation");
}

if (isset($_POST['accredit']) && isset($_POST['series'])) {
  $accrIds = explode("\n", $_POST['accrIds']);
  foreach ($accrIds as $accrId) {
    AccreditPlayerByAccrId(trim($accrId), $_POST['series'], "accreditation");
  }
}

$unAccredited = SeasonUnaccredited($season);

if ($list == "autoacc") {
  if (is_file('cust/' . CUSTOMIZATIONS . '/mass-accreditation.php')) {
    include_once 'cust/' . CUSTOMIZATIONS . '/mass-accreditation.php';
  }
}

if ($list == "acclog") {
  $acknowledged = array();
  $unaccredited_array = array();
  while ($row = GetDatabase()->FetchAssoc($unAccredited)) {
    if (hasAccredidationRight($row['team'])) {
      $row['game_name'] = utf8entities(GameName($row));
      if (!$row['acknowledged']) {
        $unaccredited_array[] = $row;
      } else {
        if (hasAccredidationRight($row['team'])) {
          $acknowledged[] = $row;
        }
      }
    }
  }
  $smarty->assign("unaccredited", $acknounaccredited_arraywledged);
  $smarty->assign("acknowledged", $acknowledged);
}

if ($list == "accevents") {
  $accevents_array = array();
  $logResult = SeasonAccreditationLog($season);
  while ($row = GetDatabase()->FetchAssoc($logResult)) {
    if (hasAccredidationRight($row['team'])) {
      if ($row['value']) {
        $row['class'] = "posvalue";
      } else {
        $row['class'] = "negvalue";
      }

      if (!empty($row['game'])) {
      $row['game_name'] = GameName($row);
      } else {
        $row['game_name'] = "&nbsp;";
      }
      $row['time_bdayformat'] = DefBirthdayFormat($row['time']);
      $row['time_hourformat'] = DefHourFormat($row['time']);
    }
  }
  $smarty->assign("accevents", $accevents_array);
}

if ($list == "accId") {
  $players = SeasonAllPlayers($season);
  $players_no_membership_array = array();
  $players_not_accredited_array = array();
  foreach ($players as $player) {
    $playerinfo = PlayerInfo($player['player_id']);
    if (empty($playerinfo['accreditation_id'])) {
      $players_array[] = $playerinfo;
    }
    
    if (empty($playerinfo['accredited'])) {
      $players_not_accredited_array[] = $playerinfo;
    }
  }
  $smarty->assign("players_no_membership", $players_no_membership_array);
  $smarty->assign("players_not_accredited", $players_not_accredited_array);
}

?>