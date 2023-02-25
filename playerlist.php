<?php
include_once 'lib/team.functions.php';
include_once 'lib/common.functions.php';
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/player.functions.php';
include_once 'lib/statistical.functions.php';

$teamId = intval(iget("team"));
$smarty->assign("team_id", $teamId);
$teaminfo = TeamInfo($teamId);
$smarty->assign("team_info", $teaminfo);

$title = _("Roster") . ": " . utf8entities($teaminfo['name']);
$smarty->assign("title", $title);

$stats = array(array());
$i = 0;
$players = TeamPlayerList($teamId);
while ($player = GetDatabase()->FetchAssoc($players)) {
  $playerinfo = PlayerInfo($player['player_id']);
  $stats[$i]['playerinfo'] = $playerinfo;
  $stats[$i]['name'] = $playerinfo['firstname'] . " " . $playerinfo['lastname'];
  $stats[$i]['id'] = $player['player_id'];
  $stats[$i]['goals'] = 0;
  $stats[$i]['passes'] = 0;
  $stats[$i]['played'] = 0;
  $stats[$i]['seasons'] = 0;
  $stats[$i]['total'] = 0;
  if (!empty($playerinfo['profile_id'])) {
    $player_stats = PlayerStatistics($playerinfo['profile_id']);
  } else {
    $player_stats = array();
  }

  foreach ($player_stats as $season) {
    $stats[$i]['goals'] += $season['goals'];
    $stats[$i]['passes'] += $season['passes'];
    $stats[$i]['played'] += $season['games'];
    $stats[$i]['total'] = $stats[$i]['passes'] + $stats[$i]['goals'];
    $stats[$i]['seasons']++;
  }
  $i++;
}
mergesort($stats, 'sortByName');
$smarty->assign("stats", $stats);
$teamseasons = 0;
$teamplayed = 0;
$teampasses = 0;
$teamgoal = 0;
$teamtotal = 0;

foreach ($stats as $player) {
  if (!empty($player)) {
    $teamseasons += $player['seasons'];
    $teamplayed += $player['played'];
    $teampasses += $player['passes'];
    $teamgoal += $player['goals'];
    $teamtotal += $player['total'];
  }
}
$smarty->assign("teamseasons", $teamseasons);
$smarty->assign("teamplayed", $teamplayed);
$smarty->assign("teampasses", $teampasses);
$smarty->assign("teamgoal", $teamgoal);
$smarty->assign("teamtotal", $teamtotal);

function sortByName($a, $b)
{
  return strcmp($b['name'], $a['name']);
}
