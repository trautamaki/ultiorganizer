<?php
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/pool.functions.php';
include_once 'lib/team.functions.php';

$LAYOUT_ID = SERIESTATUS;

$title = _("Statistics") . " ";
$smarty->assign("title",  _("Statistics"));

$viewUrl = "?view=seriesstatus";
$sort = "ranking";

if (iget("series")) {
  $seriesinfo = SeriesInfo(iget("series"));
  $viewUrl .= "&amp;series=" . $seriesinfo['series_id'];
  $seasoninfo = SeasonInfo($seriesinfo['season']);
  $title .= U_($seriesinfo['name']);
  $smarty->assign("series_info",  $seriesinfo);
}

$smarty->assign("season_info",  $seasoninfo);
$smarty->assign("title",  $title);
$smarty->assign("view_url",  $viewUrl);

if (iget("sort")) {
  $sort = iget("sort");
}
$smarty->assign("sort",  $sort);

$teamstats = array();
$allteams = array();
$teams = SeriesTeams($seriesinfo['series_id']);
$spiritAvg = SeriesSpiritBoard($seriesinfo['series_id']);
$smarty->assign("spirit_avg",  $spiritAvg);
foreach ($teams as $team) {
  $stats = TeamStats($team['team_id']);
  $points = TeamPoints($team['team_id']);

  $teamstats['name'] = $team['name'];
  $teamstats['team_id'] = $team['team_id'];
  $teamstats['seed'] = $team['rank'];
  $teamstats['flagfile'] = $team['flagfile'];
  $teamstats['pool'] = $team['poolname'];
  $teamstats['wins'] = $stats['wins'];
  $teamstats['games'] = $stats['games'];
  $teamstats['for'] = $points['scores'];
  $teamstats['against'] = $points['against'];
  $teamstats['losses'] = $teamstats['games'] - $teamstats['wins'];
  $teamstats['diff'] = $teamstats['for'] - $teamstats['against'];
  $teamstats['spirit'] = isset($spiritAvg[$team['team_id']]) ? $spiritAvg[$team['team_id']]['total'] : null;
  $teamstats['winavg'] = number_format(SafeDivide(intval($stats['wins']), intval($stats['games'])) * 100, 1);
  $teamstats['ranking'] = 0;

  $rank = $teamstats['ranking'];
  if ($rank == null) {
    $teamstats['pretty_rank'] = "-";
  } else {
    $teamstats['pretty_rank'] = intval($rank);
  }

  $teamstats['pretty_spirit'] = ($teamstats['spirit'] ? $teamstats['spirit'] : "-");

  $allteams[] = $teamstats;
}

$rankedteams  = SeriesRanking($seriesinfo['series_id']);
$rank = 0;
foreach ($rankedteams as $rteam) {
  $rank++;
  foreach ($allteams as &$ateam) {
    if ($ateam['team_id'] == $rteam['team_id'])
      $ateam['ranking'] = $rank;
  }
}

if ($sort == "ranking") {
  mergesort($allteams, 'sortByRanking');
} else if ($sort == "name" || $sort == "pool" || $sort == "against" || $sort == "seed") {
  mergesort($allteams, 'sortByNPAS');
} else {
  mergesort($allteams, 'sortByOther');
}

$smarty->assign("is_season_admin", isSeasonAdmin($seriesinfo['season']));
$smarty->assign("all_teams", $allteams);

// TODO https://github.com/trautamaki/ultiorganizer/blob/php7-upgrade/seriesstatus.php#L183

$scores = SeriesScoreBoard($seriesinfo['series_id'], "total", 10);
$scores_array = array();
while ($row = GetDatabase()->FetchAssoc($scores)) {
  $scores_array[] = $scores;
}
$smarty->assign("points_leaders", $scores);

$scores = SeriesScoreBoard($seriesinfo['series_id'], "goal", 10);
$goals_array = array();
while ($row = GetDatabase()->FetchAssoc($scores)) {
  $goals_array[] = $row;
}
$smarty->assign("goals_leaders", $goals_array);

$scores = SeriesScoreBoard($seriesinfo['series_id'], "pass", 10);
$assists_array = array();
while ($row = GetDatabase()->FetchAssoc($scores)) {
  $assists_array[] = $row;
}
$smarty->assign("assists_leaders", $assists_array);

$show_defence_stats = ShowDefenseStats();
if ($show_defence_stats) {
  $defenses = SeriesDefenseBoard($series_info['series_id'], "deftotal", 10);
  $defences_array = array();
  while ($row = GetDatabase()->FetchAssoc($defenses)) {
    $defences_array[] = $row;
  }
  $smarty->assign("defences_leaders", $defences_array);
}
$smarty->assign("show_defence_stats", $show_defence_stats);

function sortByRanking($a, $b)
{
  global $sort;
  $va = $a[$sort];
  $vb = $b[$sort];
  return $va == $vb ? 0 :($va == null ? 1 :
      ($vb = null ? -1 : ($a[$sort] < $b[$sort] ? -1 : 1)));
}

function sortByNPAS($a, $b) {
  global $sort;
  return $a[$sort] == $b[$sort] ? 0 : ($a[$sort] < $b[$sort] ? -1 : 1);
}

function sortByOther($a, $b) {
  global $sort;
  return $a[$sort] == $b[$sort] ? 0 : ($a[$sort] > $b[$sort] ? -1 : 1);
}
