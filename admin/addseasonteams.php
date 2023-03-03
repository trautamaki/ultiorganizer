<?php
include_once 'lib/team.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/season.functions.php';
include_once 'lib/pool.functions.php';
include_once 'lib/club.functions.php';
include_once 'lib/country.functions.php';

$LAYOUT_ID = ADDSEASONTEAMS;
$teamId = 0;
$season = 0;
$seriesId = 0;

if (!empty($_GET["team"]))
	$teamId = intval($_GET["team"]);

$team_info = TeamInfo($teamId);
$seriesId = $team_info['series'];
$smarty->assign("series_id", $seriesId);
$season = $team_info['season'];
$smarty->assign("season", $season);

$tp = array(
	"team_id" => "",
	"name" => "",
	"club" => "",
	"country" => "",
	"abbreviation" => "",
	"series" => "",
	"pool" => "", //pool
	"rank" => "",
	"valid" => "1",
	"bye" => "0"
);

$messages = array();
// Process itself on submit
if (!empty($_POST['save']) || !empty($_POST['add'])) {
	if (empty($_POST['name'])) {
		$messages[] = _("Name is mandatory!");
	} else {
		$tp['team_id'] = $teamId;
		$tp['name'] = trim($_POST['name']);
		$tp['abbreviation'] = trim($_POST['abbreviation']);

		$tp['pool'] = $_POST['pool'];
		$tp['rank'] = intval($_POST['rank']);
		$tp['series'] = $seriesId;

		if (!empty($_POST['club'])) {
			$clubId = ClubId($_POST['club']);

			//slot owner club not found
			if ($clubId == -1) {
				$clubId = AddClub($seriesId, $_POST['club']);
			}
			$tp['club'] = $clubId;
		}

		if (!empty($_POST['country'])) {
			$tp['country'] = $_POST['country'];
		}

		if (!empty($_POST['teamvalid'])) {
			$tp['valid'] = 1;
		} else {
			$tp['valid'] = 0;
		}
		/*
		if(!empty($_POST['teambye'])){
			$tp['valid']=2;
		}		
		*/
		if ($teamId) {
			SetTeam($tp);
			if (intval($tp['pool']))
				PoolAddTeam($tp['pool'], $teamId, $tp['rank']);
				$messages[] = _("Changes saved") . "</p>";
		} else {
			$teamId = AddTeam($tp);
			if (intval($tp['pool']))
				PoolAddTeam($tp['pool'], $teamId, $tp['rank']);

			$messages[] = $tp['name'] . " " . _("added");
			$teamId = 0;
			$tp['name'] = "";
			$tp['club'] = "";
		}
		session_write_close();
		header("location:?view=admin/seasonteams&season=$season&series=$seriesId");
	}
}
$smarty->assign("team_id", $teamid);

$orgarray = "";
$result = ClubList(true);
while ($row = @GetDatabase()->FetchAssoc($result)) {
	$orgarray .= "\"" . $row['name'] . "\",";
}
$orgarray = trim($orgarray, ',');
$smarty->assign("orgarray", $orgarray);

$title = _("Edit");
$smarty->assign("title", $title);

include_once 'script/disable_enter.js.inc';
include_once 'lib/yui.functions.php';
$smarty->assign("yui_load", yuiLoad(array("utilities", "datasource", "autocomplete")));

$seasonInfo = SeasonInfo($season);
$smarty->assign("season_info", $seasonInfo);

if ($teamId) {
	$info = TeamFullInfo($teamId);

	$tp['name'] = $info['name'];
	$tp['abbreviation'] = $info['abbreviation'];
	$tp['club'] = $info['club'];
	$tp['country'] = $info['country'];
	$tp['pool'] = $info['pool'];
	$tp['valid'] = $info['valid'];
	$tp['rank'] = $info['rank'];
	$tp['series'] = $info['series'];
}
$smarty->assign("tp", $tp);

$pools = SeriesPools($seriesId, false, true, true);
$smarty->assign("pools", $pools);
$smarty->assign("club_name", ClubName($tp['club']));
$smarty->assign("series_name", SeriesName($seriesId));
$smarty->assign("countries", CountryList());
