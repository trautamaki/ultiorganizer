<?php
include_once 'lib/common.functions.php';
include_once 'lib/team.functions.php';
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
$html = "";
mobilePageTop(_("Game responsibilities"));

$season = CurrentSeason();
$reservationgroup = "";
$location = "";
$showall = false;
$day = "";
$dayPar = "";
$locationPar = "";
$allPar = "";
$massPar = "";
$rgPar = "";

if (isset($_GET['rg'])) {
	$reservationgroup = urldecode($_GET['rg']);
	$rgPar = "&amp;rg=" . urlencode($reservationgroup);
}

if (isset($_GET['loc'])) {
	$location = urldecode($_GET['loc']);
	$locationPar = "&amp;loc=" . urlencode($location);
}

if (isset($_GET['day'])) {
	$day = urldecode($_GET['day']);
	$dayPar = "&amp;day=" . urlencode($day);
}

if (isset($_GET['all'])) {
	$showall = intval($_GET['all']);
	$allPar = "&amp;all=1";
}

if (!empty($_GET["massinput"])) {
	$_SESSION['massinput'] = true;
	$mass = "1";
	$massPar = "&amp;massinput=1";
} else {
	$_SESSION['massinput'] = false;
	$mass = "0";
	$massPar = "&amp;massinput=0";
}

//process itself on submit
$feedback = "";
if (!empty($_POST['save'])) {
	$feedback = Game::processMassInput($_POST);
}


$respGameArray = GameResponsibilityArray($season);
$html .= "<form action='?" . utf8entities($_SERVER['QUERY_STRING']) . "' method='post'>\n";
$html .= "<table cellpadding='2'>\n";
$html .= "<tr><td>\n";

if (count($respGameArray) == 0) {
	$html .= "<p>" . _("No game responsibilities") . ".</p>\n";
} else {
	$prevdate = "";
	$prevrg = "";
	$prevloc = "";
	if ($_SESSION['massinput']) {
		$html .= "<p><a class='button' href='?view=mobile/respgames$allPar$rgPar$locationPar$dayPar&amp;massinput=0'>" . _("Just display values") . "</a></p>";
	} else {
		$html .= "<p><a class='button' href='?view=mobile/respgames$allPar$rgPar$locationPar$dayPar&amp;massinput=1'>" . _("Mass input") . "</a></p>";
	}

	foreach ($respGameArray as $tournament => $resArray) {
		foreach ($resArray as $resId => $gameArray) {
			// TODO update loop
			foreach ($gameArray as $gameId => $game) {
				if (!is_numeric($gameId)) {
					continue;
				}

				if ($showall) {
					if (!empty($prevdate) && $prevdate != JustDate($game->getTime())) {
						$html .= "</td></tr><tr><td>\n";
						$html .= "<hr/>\n";
						$html .= "</td></tr><tr><td>\n";
					}
					$html .= gamerow($gameId, new Game(GetDatabase(), $gameId), $mass);
					$prevdate = JustDate($game->getTime());
					continue;
				}
				
				$game_reservationgroup = $game_locationname = $game_starttime = "";
				$game_reservation = $game->getReservation();
				if ($game_reservation != NULL) {
				  $game_reservationgroup = $game_reservation->getReservationGroup();
				  $game_location = $reservation->getLocation();
				  $game_starttime = $game->getStarTime();
				  if ($game_location != NULL) {
					$game_locationname = $game_location->getId();
				  }
				}

				if ($prevrg != $game_reservationgroup) {
					$html .= "</td></tr><tr><td>\n";
					if ($reservationgroup == $game_reservationgroup) {
						$html .= "<b>" . $game_reservationgroup . "</b>";
					} else {
						$html .= "+ <a href='?view=mobile/respgames&amp;rg=" . urlencode($game_reservationgroup) . "$massPar'>" . $game_reservationgroup . "</a>";
					}
					$html .= "</td></tr><tr><td>\n";
					$prevrg = $game_reservationgroup;
				}

				if ($reservationgroup == $game_reservationgroup) {
					$locationName = $game_locationname;
					$gameloc = $locationName . "#" . $game->getFieldName();

					if ($prevloc != $gameloc) {
						$html .= "</td></tr><tr><td>\n";
						if ($location == $gameloc && $day == JustDate($game_starttime)) {
							$html .= "&nbsp;&nbsp;<b>" . $locationName . " " . _("Field") . " " . $game->getFieldName() . "</b>";
						} else {
							$html .= "&nbsp;+<a href='?view=mobile/respgames&amp;rg=" . urlencode($game_reservationgroup) . "&amp;loc=" . urlencode($gameloc) . "&amp;day=" . urlencode(JustDate($game_starttime)) . "$massPar'>";
							$html .= $locationName . " " . _("Field") . " " . $game->getFieldName() . "</a>";
						}

						$html .= "</td></tr><tr><td>\n";
						$prevloc = $gameloc;
					}

					if ($location == $gameloc && $day == JustDate($game_starttime)) {
						$html .= gamerow($gameId, $game, $mass);
					}
				}
			}
		}
	}
}
$html .= "</td></tr>\n";
if ($_SESSION['massinput']) {
	$html .= "<tr><td><input class='button' name='save' type='submit' value='" . _("Save") . "' onclick='confirmLeave(null, false, null);'/></td></tr>\n";
}
if ($feedback)
	$html .= "<tr><td>" . $feedback . "</td></tr>";

$html .= "<tr><td><hr/>\n";
if ($showall) {
	$html .= "<a href='?view=mobile/respgames'>" . _("Group games") . "</a>";
} else {
	$html .= "<a href='?view=mobile/respgames&amp;all=1'>" . _("Show all") . "</a>";
}
$html .= "</td></tr></table>\n";
$html .= "</form>";

echo $html;

pageEnd();

function gamerow($gameId, $game, $mass)
{
	$ret = "&nbsp;&nbsp;&nbsp;&nbsp;";
	$ret .= DefTimeFormat($game->getTime()) . " ";
	if ($game->getHomeTeam() && $game->getHomeTeam()) {
		$ret .= TeamName($game->getHomeTeam()) . " - " . TeamName($game->getVisitorTeam()) . " ";

		if ($mass == "1") {
			$ret .= "<input type='hidden' id='scoreId" . $gameId . "' name='scoreId[]' value='$gameId'/>
			<input type='text' size='3' maxlength='3' style='width:4ex' value='" . (is_null($game->getHomeScore()) ? "" : $game->getHomeScore()) . "' id='homescore$gameId' name='homescore[]' oninput='confirmLeave(this, true, null);' /> -
			<input type='text' size='3' maxlength='3' style='width:4ex' value='" . (is_null($game->getVisitorScore()) ? "" : $game->getVisitorScore()) . "' id='visitorscore$gameId' name='visitorscore[]' oninput='confirmLeave(this, true, null);' />";
			// $ret .= "<input class='button' name='saveOne' type='submit' value='" . _("Save") . "' onPress='setSaved(".$gameID.")'/></td></tr><tr><td>\n";
		} elseif ($game->hasStarted()) {
			$ret .=  "<a style='white-space: nowrap' href='?view=mobile/gameplay&amp;game=" . $gameId . "'>" . $game->getHomeScore() . " - " . $game->getVisitorScore() . "</a>";
		} else {
			$ret .= $game->getHomeScore() . " - " . $game->getVisitorScore();
		}
		$ret .= "</td></tr><tr><td>\n";
		$ret .= "&nbsp;&nbsp;&nbsp;&nbsp;";
		$ret .=  "<a style='white-space: nowrap' href='?view=mobile/addresult&amp;game=" . $gameId . "'>" . _("Result") . "</a> | ";
		$ret .=  "<a style='white-space: nowrap' href='?view=mobile/addplayerlists&amp;game=" . $gameId . "&amp;team=" . $game->getHomeTeam() . "'>" . _("Players") . "</a> | ";
		$ret .=  "<a style='white-space: nowrap' href='?view=mobile/addscoresheet&amp;game=$gameId'>" . _("Scoresheet") . "</a>";
		$ret .= "</td></tr><tr><td>\n";
	} else {
		$ret .= $game->getHomeScheduleName() . " - " . $game->getVisitorScheduleName() . " ";
		$ret .= "</td></tr><tr><td>\n";
	}
	return $ret;
}
