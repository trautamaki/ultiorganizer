<?php
include_once 'lib/season.functions.php';
include_once 'lib/game.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/common.functions.php';

include_once 'classes/Game.php';

$LAYOUT_ID = EDITGAME;
$backurl = utf8entities(empty($_SERVER['HTTP_REFERER']) ? "" : $_SERVER['HTTP_REFERER']);
$gameId = $_GET["game"];
$game = new Game(GetDatabase(), $gameId);

if (!empty($_GET["season"]))
	$season = $_GET["season"];

$title = _("Game") . " $gameId";


//game parameters
$gp = array(
	"hometeam" => "",
	"visitorteam" => "",
	"scheduling_name_home" => "",
	"scheduling_name_visitor" => "",
	"reservation" => "",
	"time" => "",
	"pool" => $game->getPool(),
	"valid" => 1,
	"respteam" => 0,
	"name" => ""
);

//process itself on submit
if (!empty($_POST['save'])) {
	$backurl = $_POST['backurl'];
	$ok = true;
	if (empty($_POST['pseudo'])) {
		$gp['hometeam'] = $_POST['home'];
		$gp['visitorteam'] = $_POST['away'];
	} else {
		$gp['scheduling_name_home'] = $_POST['home'];
		$gp['scheduling_name_visitor'] = $_POST['away'];
	}
	$gp['reservation'] = $_POST['place'];

	$res = new Reservation(GetDatabase(), $gp['reservation']);
	if (!empty($_POST['time'])) {
		$gp['time'] = ToInternalTimeFormat((ShortDate($res->getStartTime()) . " " . $_POST['time']));
	}

	$gp['pool'] = $_POST['pool'];

	if (!empty($_POST['valid']))
		$gp['valid'] = 1;
	else
		$gp['valid'] = 0;

	if (!empty($_POST['respteam']))
		$gp['respteam'] = $_POST['respteam'];

	if (!empty($_POST['name']))
		$gp['name'] = $_POST['name'];


	$game->set($gp);

	$userid = $_POST['userid'];
	if (empty($userid)) {
		$userid = UserIdForMail($_POST['email']);
	}
	if (IsRegistered($userid)) {
		AddSeasonUserRole($userid, 'gameadmin:' . $gameId, $season);
	}
	if (!empty($backurl)) {
		session_write_close();
		header("location:$backurl");
	}
}

//common page
pageTopHeadOpen($title);
include_once 'script/disable_enter.js.inc';
include_once 'lib/yui.functions.php';
echo yuiLoad(array("utilities", "calendar", "datasource", "autocomplete"));
?>
<link rel="stylesheet" type="text/css" href="script/yui/calendar/calendar.css" />

<script type="text/javascript">
	<!--
	YAHOO.namespace("calendar");

	YAHOO.calendar.init = function() {

		YAHOO.calendar.cal1 = new YAHOO.widget.Calendar("cal1", "calContainer1");
		YAHOO.calendar.cal1.cfg.setProperty("START_WEEKDAY", "1");
		YAHOO.calendar.cal1.render();

		function handleCal1Button(e) {
			var containerDiv = YAHOO.util.Dom.get("calContainer1");

			if (containerDiv.style.display == "none") {
				updateCal("date", YAHOO.calendar.cal1);
				YAHOO.calendar.cal1.show();
			} else {
				YAHOO.calendar.cal1.hide();
			}
		}

		// Listener to show the Calendar when the button is clicked
		YAHOO.util.Event.addListener("showcal1", "click", handleCal1Button);
		YAHOO.calendar.cal1.hide();

		function handleSelect1(type, args, obj) {
			var dates = args[0];
			var date = dates[0];
			var year = date[0],
				month = date[1],
				day = date[2];

			var txtDate1 = document.getElementById("date");
			txtDate1.value = day + "." + month + "." + year;
		}

		function updateCal(input, obj) {
			var txtDate1 = document.getElementById(input);
			if (txtDate1.value != "") {
				var date = txtDate1.value.split(".");
				obj.select(date[1] + "/" + date[0] + "/" + date[2]);
				obj.cfg.setProperty("pagedate", date[1] + "/" + date[2]);
				obj.render();
			}
		}
		YAHOO.calendar.cal1.selectEvent.subscribe(handleSelect1, YAHOO.calendar.cal1, true);
	}
	YAHOO.util.Event.onDOMReady(YAHOO.calendar.init);
	//
	-->
</script>
<?php

pageTopHeadClose($title);
leftMenu($LAYOUT_ID);
contentStart();


//echo "<form method='post' action='" . $_SERVER[ 'PHP_SELF' ]. "'>";

echo "<h2>" . _("Edit game") . "</h2>\n";
echo "<form method='post' action='?view=admin/editgame&amp;season=$season&amp;game=$gameId'>";
$game = new Game(GetDatabase(), $gameId);
$pool_info = PoolInfo($game->getPool());
$seriesId = $pool_info['series'];
$poolId = $game->getPool();

if ($game->hasStarted()) {
	echo "<p>" . _("Game played") . ". " . _("Final scores") . ": " . $game->getHomeScore() . " - " . $game->getVisitorScore() . "</p>";
}
echo "<table>";
echo "<tr><td><a href='?view=user/addresult&amp;game=" . $gameId . "'>" . _("Change game result") . "</a></td></tr>";
echo "<tr><td><a href='?view=user/addplayerlists&amp;game=" . $gameId . "'>" . _("Change game roster") . "</a></td></tr>";
echo "<tr><td><a href='?view=user/addscoresheet&amp;game=" . $gameId . "'>" . _("Change game score sheet") . " </a></td></tr>";
if (ShowDefenseStats()) {
	echo "<tr><td><a href='?view=user/adddefensesheet&amp;game=" . $gameId . "'>" . _("Change game defense sheet") . " </a></td></tr>";
}

echo "<tr><td><a href='?view=user/pdfscoresheet&amp;game=" . $gameId . "'>" . _("Print score sheet") . " </a></td></tr>";
echo "<tr><td><a href='?view=user/addmedialink&amp;game=$gameId'>" . _("Add media") . "</a></td></tr>";
echo "</table>\n";

echo "<table cellpadding='2px'>";


echo "<tr><td class='infocell'>" . _("Home team") . ":</td><td>";
//TeamSelectionList('home', $info['hometeam'], $seriesId);
TeamSelectionListNew('home', $game->getHomeTeam(), $game->getSchedulingNameHomeId(), $poolId);
echo "</td></tr>\n";

echo "<tr><td class='infocell'>" . _("Guest team") . ":</td><td>";
//TeamSelectionList('away', $info['visitorteam'], $seriesId);
TeamSelectionListNew('away', $game->getVisitorTeam(), $game->getSchedulingNameVisitorId(), $poolId);
echo "</td></tr>\n";


echo "<tr><td class='infocell'>" . _("Location") . ":</td><td><select class='dropdown' name='place'>\n";


echo "<option class='dropdown' value='0'></option>";

// places
$places = SeasonReservations($season);

foreach ($places as $row) {
	$reservationId = "";
	$reservation = $game->getReservation();
	if ($reservation != NULL) {
		$reservationId = $reservation->getId();
	}
	if ($row['id'] == $reservationId) {
		echo "<option class='dropdown' selected='selected' value='" . utf8entities($row['id']) . "'>";
		echo utf8entities($row['reservationgroup']) . " " . utf8entities($row['name']) . ", " . _("Field") . " " . utf8entities($row['fieldname']) . " (" . JustDate($row['starttime']) . ")";
		echo "</option>";
	} else {
		echo "<option class='dropdown' value='" . utf8entities($row['id']) . "'>";
		echo utf8entities($row['reservationgroup']) . " " . utf8entities($row['name']) . ", " . _("Field") . " " . utf8entities($row['fieldname']) . " (" . JustDate($row['starttime']) . ")";
		echo "</option>";
	}
}
echo "</select></td></tr>\n";

echo "<tr><td class='infocell'>" . _("Starting time") . " (hh:mm):</td>
<td><input class='input' id='time' name='time' value='" . DefHourFormat($game->getTime()) . "'/></td></tr>\n";


echo "<tr><td class='infocell'>" . _("Division") . ":</td><td><select class='dropdown' name='pool'>\n";
echo "<option class='dropdown' value='0'></option>";

$pools = SeasonPools($season);
foreach ($pools as $row) {
	if ($row['pool_id'] == $game->getPool())
		echo "<option class='dropdown' selected='selected' value='" . utf8entities($row['pool_id']) . "'>" . utf8entities(U_($row['seriesname'])) . ", " . utf8entities(U_($row['poolname'])) . "</option>";
	else
		echo "<option class='dropdown' value='" . utf8entities($row['pool_id']) . "'>" . utf8entities(U_($row['seriesname'])) . ", " . utf8entities(U_($row['poolname'])) . "</option>";
}
echo "</select></td></tr>\n";

echo "<tr><td class='infocell'>" . _("Responsible team") . ":</td><td>";
//TeamSelectionList('respteam', $info['respteam'], $seriesId);
TeamSelectionListNew('respteam', $game->getRespTeam(), $game->getRespTeam(), $poolId);
echo "</td></tr>";
echo "<tr><td class='infocell' style='vertical-align:text-top;'>" . _("Responsible person") . ":</td><td>";
$users = $game->getAdmins();
foreach ($users as $user) {
	echo utf8entities($user['name']) . "<br/>";
}
echo _("User Id") . " <input class='input' size='20' name='userid'/> " . _("or") . " ";
echo _("E-Mail") . " <input class='input' size='20' name='email'/>\n";
echo "</td></tr>";

echo "<tr><td class='infocell'>" . _("Name") . ":</td>";
echo "<td>" . TranslatedField("name", $game->getName());
echo TranslationScript("name");
echo "</td></tr>\n";

if ($game->isValid()) {
	echo "<tr><td class='infocell'>" . _("Valid") . ":</td>
		<td><input class='input' type='checkbox' id='valid' name='valid' checked='checked' value='" . $game->isValid() . "'/></td></tr>";
} else {
	echo "<tr><td class='infocell'>" . _("Valid") . ":</td>
		<td><input class='input' type='checkbox' id='valid' name='valid' value='" . $game->isValid() . "'/></td></tr>";
}

echo "</table>";

echo "<div><input type='hidden' name='backurl' value='$backurl'/></div>";
echo "<p><input class='button' name='save' type='submit' value='" . _("Save") . "'/>";
if (!empty($backurl)) {
	echo "<input class='button' type='button' name='return'  value='" . _("Return") . "' onclick=\"window.location.href='$backurl'\"/>";
}
echo "</p></form>\n";

contentEnd();
pageEnd();

function TeamSelectionListNew($name, $selected, $schedule_selected, $poolId)
{
	echo "<select class='dropdown' name='$name'>";
	echo "<option class='dropdown' value='0'></option>";

	$pseudoteams = false;
	$teams = PoolTeams($poolId);
	if (count($teams) == 0) {
		$teams = PoolSchedulingTeams($poolId);
		$pseudoteams = true;
	}

	$teamlist = "";
	foreach ($teams as $row) {
		if ($pseudoteams) {
			if ($row['scheduling_id'] == $schedule_selected) {
				$teamlist .= "<option class='dropdown' selected='selected' value='" . utf8entities($row['scheduling_id']) . "'>" . utf8entities($row['name']) . "</option>\n";
			} else {
				$teamlist .= "<option class='dropdown' value='" . utf8entities($row['scheduling_id']) . "'>" . utf8entities($row['name']) . "</option>\n";
			}
		} else {
			if ($row['team_id'] == $selected) {
				$teamlist .= "<option class='dropdown' selected='selected' value='" . utf8entities($row['team_id']) . "'>" . utf8entities($row['name']) . "</option>\n";
			} else {
				$teamlist .= "<option class='dropdown' value='" . utf8entities($row['team_id']) . "'>" . utf8entities($row['name']) . "</option>\n";
			}
		}
	}
	echo $teamlist;
	echo "</select>";

	if ($pseudoteams) {
		echo "<div><input type='hidden' name='pseudo' value='1' /></div>";
	}
}

function TeamSelectionList($name, $selected, $seriesId)
{

	echo "<select class='dropdown' name='$name'>";
	echo "<option class='dropdown' value='0'></option>";

	// teams from series
	$teams = SeriesTeams($seriesId);
	foreach ($teams as $team) {
		if ($team['team_id'] == $selected) {
			echo "<option class='dropdown' selected='selected' value='" . utf8entities($team['team_id']) . "'>" . utf8entities($team['name']) . "</option>";
		} else {
			echo "<option class='dropdown' value='" . utf8entities($team['team_id']) . "'>" . utf8entities($team['name']) . "</option>";
		}
	}
	echo "</select>";
}

?>