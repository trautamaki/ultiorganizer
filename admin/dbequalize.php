<?php
include_once 'lib/season.functions.php';
include_once 'lib/team.functions.php';
include_once 'lib/club.functions.php';
include_once 'lib/pool.functions.php';
include_once 'lib/series.functions.php';

$database = new Database();

$LAYOUT_ID = DBEQUALIZER;
$title = _("Database equalization");
$filter = 'teams';
$baseurl = "?view=admin/dbequalize";
$html = "";
$result = "";

if (!empty($_GET["filter"])) {
	$filter = $_GET["filter"];
} elseif (!empty($_POST["filter"])) {
	$filter = $_POST["filter"];
}

if (isset($_POST['rename']) && !empty($_POST['ids']) && isSuperAdmin()) {
	$ids = $_POST["ids"];
	$name = $_POST["newname"];
	foreach ($ids as $id) {
		if ($filter == 'teams') {
			$result .= "<p>" . utf8entities(TeamName($database, $id)) . " --> " . utf8entities($name) . "</p>";
			SetTeamName($database, $id, $name);
		} elseif ($filter == 'clubs') {
			if ($id != $name) {
				$result .= "<p>" . utf8entities(ClubName($database, $id)) . " --> " . utf8entities(ClubName($database, $name)) . "</p>";
				$teams = TeamListAll($database);
				while ($team = $database->FetchAssoc($teams)) {
					if ($team['club'] == $id) {
						SetTeamOwner($database, $team['team_id'], $name);
					}
				}
				if (CanDeleteClub($database, $id)) {
					$result .= "<p>" . utf8entities(ClubName($database, $id)) . " " . _("removed") . "</p>";
					RemoveClub($database, $id);
				} else {
					$result .= "<p class='warning'>" . utf8entities(ClubName($database, $id)) . " " . _("cannot delete") . "</p>";
				}
			}
		} elseif ($filter == 'pools') {
			$result .= "<p>" . utf8entities(PoolName($database, $id)) . " --> " . utf8entities($name) . "</p>";
			SetPoolName($database, $id, $name);
		} elseif ($filter == 'series') {
			$result .= "<p>" . utf8entities(SeriesName($database, $id)) . " --> " . utf8entities($name) . "</p>";
			SetSeriesName($database, $id, $name);
		}
	}
	$result .= "<hr/>";
} elseif (isset($_POST['remove']) && !empty($_POST['ids']) && isSuperAdmin()) {
	$ids = $_POST["ids"];
	$type = $_POST["filter"];
	$name = $_POST["newname"];
	foreach ($ids as $id) {
		if ($filter == 'teams') {
			if (CanDeleteTeam($database, $id)) {
				$result .= "<p>" . utf8entities(TeamName($database, $id)) . " " . _("removed") . "</p>";
				DeleteTeam($database, $id);
			} else {
				$result .= "<p class='warning'>" . utf8entities(TeamName($database, $id)) . " " . _("cannot delete") . "</p>";
			}
		} elseif ($filter == 'clubs') {
			if (CanDeleteClub($database, $id)) {
				$result .= "<p>" . utf8entities(ClubName($database, $id)) . " " . _("removed") . "</p>";
				RemoveClub($database, $id);
			} else {
				$result .= "<p class='warning'>" . utf8entities(ClubName($database, $id)) . " " . _("cannot delete") . "</p>";
			}
		} elseif ($filter == 'pools') {
			if (CanDeletePool($database, $id)) {
				$result .= "<p>" . utf8entities(PoolName($database, $id)) . " " . _("removed") . "</p>";
				DeletePool($database, $id);
			} else {
				$result .= "<p class='warning'>" . utf8entities(PoolName($database, $id)) . " " . _("cannot delete") . "</p>";
			}
		} elseif ($filter == 'series') {
			if (CanDeleteSeries($database, $id)) {
				$result .= "<p>" . utf8entities(SeriesName($database, $id)) . " " . _("removed") . "</p>";
				DeletePool($database, $id);
			} else {
				$result .= "<p class='warning'>" . utf8entities(SeriesName($database, $id)) . " " . _("cannot delete") . "</p>";
			}
		}
	}
	$result .= "<hr/>";
}

pageTopHeadOpen($title);
include 'script/common.js.inc';
pageTopHeadClose($title);
leftMenu($database, $LAYOUT_ID);
contentStart();
$html .= $result;
$html .=  "<div>\n";
$html .=  _("List") . ": ";
$html .=  "<a href='" . utf8entities($baseurl) . "&amp;filter=teams'>" . _("Teams") . "</a>";
$html .=  "&nbsp;&nbsp;";
$html .=  "<a href='" . utf8entities($baseurl) . "&amp;filter=clubs'>" . _("Clubs") . "</a>";
$html .=  "&nbsp;&nbsp;";
$html .=  "<a href='" . utf8entities($baseurl) . "&amp;filter=pools'>" . _("Pools") . "</a>";
$html .=  "&nbsp;&nbsp;";
$html .=  "<a href='" . utf8entities($baseurl) . "&amp;filter=series'>" . _("Division") . "</a>";
$html .=  "</div>\n";

$html .=  "<form id='ids' method='post' action='" . utf8entities($baseurl) . "'>\n";

if ($filter == 'clubs') {
	$html .=  "<p>" . _("Club to keep") . ":\n";
	//$html .=  "<input class='input' size='50' name='newname' value=''/></p>";
	$html .=  "<select class='dropdown' name='newname'>";
	$clubs = ClubList($database);
	while ($row = $database->FetchAssoc($clubs)) {
		$html .= "<option class='dropdown' value='" . utf8entities($row['club_id']) . "'>" . utf8entities($row['name']) . "</option>";
	}
	$html .=  "</select></p>";
	$html .= "<p><input class='button' type='submit' name='rename' value='" . _("Join selected") . "'/>";
} else {
	$html .=  "<p>" . _("New name") . ":\n";
	$html .=  "<input class='input' size='50' name='newname' value=''/></p>";
	$html .= "<p><input class='button' type='submit' name='rename' value='" . _("Rename selected") . "'/>";
}
$html .= "<input class='button' type='submit' name='remove' value='" . _("Delete selected") . "'/>";
$html .= "<input class='button' type='reset' value='" . _("Clear") . "'/>";
$html .= "<input class='button' type='button' name='takaisin'  value='" . _("Return") . "' onclick=\"window.location.href='?view=admin/dbadmin'\"/></p>";

$html .= "<table><tr><th><input type='checkbox' onclick='checkAll(\"ids\");'/></th>";
$prevname = "";
$prevseries = "";
$counter = 0;

if ($filter == 'teams') {
	$teams = TeamListAll($database);
	$html .= "<th>" . _("Team") . "</th><th>" . _("Division") . "</th><th>" . _("Club") . "</th><th>" . _("Event") . "</th></tr>\n";
	while ($team = $database->FetchAssoc($teams)) {
		if ($prevname != $team['name'] || $prevseries != $team['seriesname']) {
			$counter++;
			$prevname = $team['name'];
			$prevseries = $team['seriesname'];
		}
		if ($counter % 2) {
			$html .= "<tr class='highlight'>";
		} else {
			$html .= "<tr>";
		}

		$html .= "<td><input type='checkbox' name='ids[]' value='" . utf8entities($team['team_id']) . "'/></td>";
		$html .= "<td><b>" . utf8entities($team['name']) . "</b></td>";
		$html .= "<td>" . utf8entities($team['seriesname']) . "</td>";
		$html .= "<td>" . utf8entities($team['clubname']) . "</td>";
		$html .= "<td>" . utf8entities($team['seasonname']) . "</td>";
		$html .= "</tr>\n";
	}
} elseif ($filter == 'clubs') {
	$clubs = ClubList($database);
	$html .= "<th>" . _("Name") . "</th><th>" . _("Teams") . "</th></tr>\n";
	while ($club = $database->FetchAssoc($clubs)) {
		if ($prevname != $club['name']) {
			$counter++;
			$prevname = $club['name'];
		}
		if ($counter % 2) {
			$html .= "<tr class='highlight'>";
		} else {
			$html .= "<tr>";
		}

		$html .= "<td><input type='checkbox' name='ids[]' value='" . utf8entities($club['club_id']) . "'/></td>";
		$html .= "<td><b>" . utf8entities($club['name']) . "</b></td>";
		$html .= "<td class='center'>" . ClubNumOfTeams($database, $club['club_id']) . "</td>";
		$html .= "</tr>\n";
	}
} elseif ($filter == 'pools') {
	$pools = PoolListAll($database);
	$html .= "<th>" . _("Name") . "</th><th>" . _("Division") . "</th><th>" . _("Event") . "</th></tr>\n";
	while ($pool = $database->FetchAssoc($pools)) {
		if ($prevname != $pool['name']) {
			$counter++;
			$prevname = $pool['name'];
		}
		if ($counter % 2) {
			$html .= "<tr class='highlight'>";
		} else {
			$html .= "<tr>";
		}

		$html .= "<td><input type='checkbox' name='ids[]' value='" . utf8entities($pool['pool_id']) . "'/></td>";
		$html .= "<td><b>" . utf8entities($pool['name']) . "</b></td>";
		$html .= "<td>" . utf8entities($pool['seriesname']) . "</td>";
		$html .= "<td>" . utf8entities($pool['seasonname']) . "</td>";
		$html .= "</tr>\n";
	}
} elseif ($filter == 'series') {
	$series = Series($database);
	$html .= "<th>" . _("Name") . "</th><th>" . _("Event") . "</th></tr>\n";
	while ($row = $database->FetchAssoc($series)) {
		if ($prevname != $row['name']) {
			$counter++;
			$prevname = $row['name'];
		}
		if ($counter % 2) {
			$html .= "<tr class='highlight'>";
		} else {
			$html .= "<tr>";
		}

		$html .= "<td><input type='checkbox' name='ids[]' value='" . utf8entities($row['series_id']) . "'/></td>";
		$html .= "<td><b>" . utf8entities($row['name']) . "</b></td>";
		$html .= "<td>" . utf8entities($row['seasonname']) . "</td>";
		$html .= "</tr>\n";
	}
}

$html .= "</table>\n";
$html .= "<div><input type='hidden' id='filter' name='filter' value='$filter'/></div>\n";
$html .= "</form>\n";
echo $html;
contentEnd();
pageEnd();
