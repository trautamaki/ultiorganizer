<?php
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/team.functions.php';

$title = _("Scoreboard");

$poolId = 0;
$poolIds = array();
$seriesId = 0;
$teamId = 0;
$sort = "total";

if (iget("pool")) {
  $poolId = intval(iget("pool"));
  $title = $title . ": " . utf8entities(U_(PoolName($poolId)));
}
$smarty->assign("pool_id", $poolId);
if (iget("pools")) {
  $poolIds = explode(",", iget("pools"));
  $title = $title . ": " . utf8entities(U_(PoolName($poolId)));
}
if (iget("series")) {
  $seriesId = intval(iget("series"));
  $title = $title . ": " . utf8entities(U_(SeriesName($seriesId)));
}
if (iget("team")) {
  $teamId = intval(iget("team"));
  $title = $title . ": " . utf8entities(TeamName($teamId));
}
$smarty->assign("title", $title);

if (iget("sort")) {
  $sort = iget("sort");
}
$smarty->assign("sort", $sort);

$viewUrl = "?view=scorestatus&amp;";
if ($teamId) {
  $viewUrl .= "Team=$teamId&amp;";
}
if ($poolId) {
  $viewUrl .= "Pool=$poolId&amp;";
}
if (count($poolIds)) {
  $viewUrl .= "Pools=" . implode(",", $poolIds) . "&amp;";
}
if ($seriesId) {
  $viewUrl .= "Series=$seriesId&amp;";
}
$smarty->assign("view_url", $viewUrl);

if ($teamId) {
  if (count($poolIds)) {
    $scores = TeamScoreBoard($teamId, $poolIds, $sort, 0);
  } else {
    $scores = TeamScoreBoard($teamId, $poolId, $sort, 0);
  }
} elseif ($poolId) {
  $scores = PoolScoreBoard($poolId, $sort, 0);
} elseif (count($poolIds)) {
  $scores = PoolsScoreBoard($poolIds, $sort, 0);
} elseif ($seriesId) {
  $scores = SeriesScoreBoard($seriesId, $sort, 0);
}

$i = 1;
$scores_array = array();
while ($row = GetDatabase()->FetchAssoc($scores)) {
  $row['index'] = $i;
  $scores_array[] = $row;
  $i++;
}
$smarty->assign("scores", $scores_array);

