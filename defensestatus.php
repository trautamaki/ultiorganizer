<?php
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/team.functions.php';

$poolId = 0;
$poolIds = array();
$seriesId = 0;
$teamId = 0;
$sort = "deftotal";

$title = _("Defenseboard");

if (iget("pool")) {
  $poolId = intval(iget("pool"));
  $title = $title . ": " . utf8entities(U_(PoolName($poolId)));
}
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
$smarty->assign("pool_id", $poolId);
$smarty->assign("title", $title);

if (iget("sort")) {
  $sort = iget("sort");
}
$smarty->assign("sort", $sort);

$viewUrl = "?view=defensestatus&amp;";
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

$table_header = array(
  array(
    "title" => _("Player"),
    "sort" => "name",
    "url" => $viewUrl . "sort=name",
    "options" => "style='width:30%'",
  ),
  array(
    "title" => _("Team"),
    "sort" => "team",
    "url" => $viewUrl . "sort=team",
    "options" => "style='width:25%'",
  ),
  array(
    "title" => _("Games"),
    "sort" => "games",
    "url" => $viewUrl . "sort=games",
    "options" => "class='center' style='width:8%'",
  ),
  array(
    "title" => _("Defenses"),
    "sort" => "deftotal",
    "url" => $viewUrl . "sort=deftotal",
    "options" => "class='center' style='width:8%'",
  ),
);
$smarty->assign("table_header", $table_header);

if ($teamId) {
  if (count($poolIds)) {
    $defenses = TeamScoreBoardWithDefenses($teamId, $poolIds, $sort, 0);
  } else {
    $defenses = TeamScoreBoardWithDefenses($teamId, $poolId, $sort, 0);
  }
} elseif ($poolId) {
  $defenses = PoolScoreBoardWithDefenses($poolId, $sort, 0);
} elseif (count($poolIds)) {
  $defenses = PoolScoreBoardWithDefenses($poolIds, $sort, 0);
} elseif ($seriesId) {
  $defenses = SeriesDefenseBoard($seriesId, $sort, 0);
}

$i = 1;
$data_array = array();
while ($row = GetDatabase()->FetchAssoc($defenses)) {
  $row['i'] = $i++;
  $data_array[] = $row;
}
