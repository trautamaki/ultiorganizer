<?php
include_once 'lib/season.functions.php';
include_once 'lib/team.functions.php';
include_once 'lib/club.functions.php';
include_once 'lib/pool.functions.php';
include_once 'lib/series.functions.php';
$LAYOUT_ID = DBEQUALIZER;
$title = _("Database equalization");
$smarty->assign("title", $title);
$filter = 'teams';

if (!empty($_GET["filter"])) {
	$filter = $_GET["filter"];
} elseif (!empty($_POST["filter"])) {
	$filter = $_POST["filter"];
}
$baseurl = "?view=admin/dbequalize&filter=$filter";
$smarty->assign("baseurl", $baseurl);

$result = "";
if (isset($_POST['rename']) && !empty($_POST['ids']) && isSuperAdmin()) {
	$ids = $_POST["ids"];
	$name = $_POST["newname"];
	foreach ($ids as $id) {
		if ($filter == 'teams') {
			$result .= "<p>" . utf8entities(TeamName($id)) . " --> " . utf8entities($name) . "</p>";
			SetTeamName($id, $name);
		} elseif ($filter == 'clubs') {
			if ($id != $name) {
				$result .= "<p>" . utf8entities(ClubName($id)) . " --> " . utf8entities(ClubName($name)) . "</p>";
				$teams = TeamListAll();
				while ($team = GetDatabase()->FetchAssoc($teams)) {
					if ($team['club'] == $id) {
						SetTeamOwner($team['team_id'], $name);
					}
				}
				if (CanDeleteClub($id)) {
					$result .= "<p>" . utf8entities(ClubName($id)) . " " . _("removed") . "</p>";
					RemoveClub($id);
				} else {
					$result .= "<p class='warning'>" . utf8entities(ClubName($id)) . " " . _("cannot delete") . "</p>";
				}
			}
		} elseif ($filter == 'pools') {
			$result .= "<p>" . utf8entities(PoolName($id)) . " --> " . utf8entities($name) . "</p>";
			SetPoolName($id, $name);
		} elseif ($filter == 'series') {
			$result .= "<p>" . utf8entities(SeriesName($id)) . " --> " . utf8entities($name) . "</p>";
			SetSeriesName($id, $name);
		}
	}
	$result .= "<hr/>";
} elseif (isset($_POST['remove']) && !empty($_POST['ids']) && isSuperAdmin()) {
	$ids = $_POST["ids"];
	$type = $_POST["filter"];
	$name = $_POST["newname"];
	foreach ($ids as $id) {
		if ($filter == 'teams') {
			if (CanDeleteTeam($id)) {
				$result .= "<p>" . utf8entities(TeamName($id)) . " " . _("removed") . "</p>";
				DeleteTeam($id);
			} else {
				$result .= "<p class='warning'>" . utf8entities(TeamName($id)) . " " . _("cannot delete") . "</p>";
			}
		} elseif ($filter == 'clubs') {
			if (CanDeleteClub($id)) {
				$result .= "<p>" . utf8entities(ClubName($id)) . " " . _("removed") . "</p>";
				RemoveClub($id);
			} else {
				$result .= "<p class='warning'>" . utf8entities(ClubName($id)) . " " . _("cannot delete") . "</p>";
			}
		} elseif ($filter == 'pools') {
			if (CanDeletePool($id)) {
				$result .= "<p>" . utf8entities(PoolName($id)) . " " . _("removed") . "</p>";
				DeletePool($id);
			} else {
				$result .= "<p class='warning'>" . utf8entities(PoolName($id)) . " " . _("cannot delete") . "</p>";
			}
		} elseif ($filter == 'series') {
			if (CanDeleteSeries($id)) {
				$result .= "<p>" . utf8entities(SeriesName($id)) . " " . _("removed") . "</p>";
				DeletePool($id);
			} else {
				$result .= "<p class='warning'>" . utf8entities(SeriesName($id)) . " " . _("cannot delete") . "</p>";
			}
		}
	}
	$result .= "<hr/>";
}
$smarty->assign("result", $result);

include 'script/common.js.inc';

$smarty->assign("filter", $filter);

if ($filter == 'clubs') {
	$clubs = ClubList();
	$clubs_array = array();
	while ($row = GetDatabase()->FetchAssoc($clubs)) {
		$clubs_array[] = $row;
	}
	$smarty->assign("clubs", $clubs_array);
}

$prevname = "";
$prevseries = "";
$counter = 0;
if ($filter == 'teams') {
	$teams = TeamListAll();
	$teams_array = array();
	while ($team = GetDatabase()->FetchAssoc($teams)) {
		if ($prevname != $team['name'] || $prevseries != $team['seriesname']) {
			$counter++;
			$prevname = $team['name'];
			$prevseries = $team['seriesname'];
		}
		$team['counter'] = $counter;
		$teams_array[] = $team;
	}
	$smarty->assign("teams", $teams_array);
} elseif ($filter == 'clubs') {
	$clubs = ClubList();
	$clubs_array = array();
	while ($club = GetDatabase()->FetchAssoc($clubs)) {
		if ($prevname != $club['name']) {
			$counter++;
			$prevname = $club['name'];
		}
		$club['counter'] = $counter;
		$club['num_of_teams'] = ClubNumOfTeams($club['club_id']);
		$clubs_array[] = $club;
	}
	$smarty->assign("clubs", $clubs_array);
} elseif ($filter == 'pools') {
	$pools = PoolListAll();
	$pools_array = array();
	while ($pool = GetDatabase()->FetchAssoc($pools)) {
		if ($prevname != $pool['name']) {
			$counter++;
			$prevname = $pool['name'];
		}
		$pool['counter'] = $counter;
		$pool['num_of_teams'] = ClubNumOfTeams($club['club_id']);
		$pools_array[] = $pool;
	}
	$smarty->assign("pools", $pools_array);
} elseif ($filter == 'series') {
	$series = Series();
	$series_array = array();
	while ($row = GetDatabase()->FetchAssoc($series)) {
		if ($prevname != $row['name']) {
			$counter++;
			$prevname = $row['name'];
		}
		$row['counter'] = $counter;
		$series_array[] = $row;
	}
	$smarty->assign("series", $series_array);
}
