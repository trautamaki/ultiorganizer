<?php
include_once 'lib/season.functions.php';
include_once 'lib/statistical.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/common.functions.php';
include_once 'lib/configuration.functions.php';

$LAYOUT_ID = SEASONS;

$title = _("Events");
$smarty->assign("title", $title);

// Season parameters
$sp = array(
	"season_id" => "",
	"name" => "",
	"type" => "",
	"starttime" => "",
	"endtime" => "",
	"iscurrent" => 0
);

if (!empty($_GET["season"])) {
	$info = SeasonInfo($_GET["season"]);
	$sp['season_id'] = $info['season_id'];
	$sp['name'] = $info['name'];
	$sp['type'] = $info['type'];
	$sp['starttime'] = $info['starttime'];
	$sp['endtime'] = $info['endtime'];
	$sp['iscurrent'] = $info['iscurrent'];
}

// Process itself on submit
$warnings = array();
if (!empty($_POST['remove_x']) && !empty($_POST['hiddenDeleteId'])) {
	$id = $_POST['hiddenDeleteId'];
	$ok = true;
	// Run some test to for safe deletion
	$series = SeasonSeries($id);
	if (count($series)) {
		$warnings[] = _("Event has") . " " . GetDatabase()->NumRows($series) . " " . _("Division(s)") . ". " . _("Divisions must be removed before removing the event") . ".</p>";
		$ok = false;
	}
	$cur = CurrentSeason();

	if ($cur == $id) {
		$warnings[] = _("You can not remove a current event") . ".</p>";
		$ok = false;
	}
	if ($ok) {
		DeleteSeason($id);
		// Remove rights from deleted season
		$propId = getPropId($_SESSION['uid'], 'editseason', $id);
		RemoveEditSeason($_SESSION['uid'], $propId);
		$propId = getPropId($_SESSION['uid'], 'userrole', 'seasonadmin:' . $id);
		RemoveUserRole($_SESSION['uid'], $propId);
	}
}
$smarty->assign("warnings", $warnings);

$seasons = Seasons();
$seasons_array = array();
while ($row = GetDatabase()->FetchAssoc($seasons)) {
	$info = SeasonInfo($row['season_id']);

	if (empty($info['type'])) {
		$info['type'] = '?';
	}

	if (empty($info['starttime'])) {
		$info['starttime_sortdate'] =  "-";
	} else {
		$info['starttime_sortdate'] = ShortDate($info['starttime']);
	}

	if (empty($info['endtime'])) {
		$info['endtime_sortdate'] =  "-";
	} else {
		$info['endtime_sortdate'] = ShortDate($info['endtime']);
	}

	$row['enrollment'] = intval($info['enrollopen']) ? _("open") : _("closed");
	$row['visible'] = intval($info['iscurrent']) ? _("yes") : _("no");
	$row['can_delete'] = CanDeleteSeason($row['season_id']);
	$row['is_stats_calculated'] = IsSeasonStatsCalculated($row['season_id']);
	$row['info'] = $info;
	$seasons_array[] = $row;
}
$smarty->assign("seasons", $seasons_array);
