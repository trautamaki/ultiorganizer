<?php
ob_start();
?>
<!--
[CLASSIFICATION]
category=database
type=simulator
format=any
security=superadmin
customization=all

[DESCRIPTION]
title = "Game play simulator"
description = "Automatically plays all games selected."
-->
<?php
ob_end_clean();
if (!isSuperAdmin()) {
	die('Insufficient user rights');
}

include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/standings.functions.php';

function undoPoolMoves($poolId)
{
	$frompools = PoolMovingsToPool($database, $poolId);

	foreach ($frompools as $pool) {
		$poolinfo = PoolInfo($database, $pool['topool']);

		//     if($poolinfo['mvgames']==1){
		$_SESSION['userproperties']['userrole']['seriesadmin'][$poolinfo['series']] = 1;
		PoolUndoMove($database, $pool['frompool'], $pool['fromplacing'], $poolId);
		unset($_SESSION['userproperties']['userrole']['seriesadmin'][$poolinfo['series']]);
		//     }

	}
}


$html = "";
$title = ("Game simulator");
$seasonId = "";

if (!empty($_POST['season'])) {
	$seasonId = $_POST['season'];
}

if (isset($_POST['simulate']) && !empty($_POST['pools'])) {

	$pools = $_POST["pools"];

	foreach ($pools as $poolId) {

		$poolinfo = PoolInfo($database, $poolId);
		$games = PoolGames($database, $poolId);
		set_time_limit(300); //game simulation takes time because so much inserts

		foreach ($games as $game) {
			$info = GameInfo($database, $game['game_id']);

			//all players in roster are playing
			$home_playerlist = TeamPlayerList($database, $info['hometeam']);
			$hplayers = array();
			while ($player = $database->FetchAssoc($home_playerlist)) {
				GameAddPlayer($database, $game['game_id'], $player['player_id'], intval($player['num']));
				$hplayers[] = intval($player['num']);
			}
			$hplayers[] = 'xx'; //callahan
			$away_playerlist = TeamPlayerList($database, $info['visitorteam']);
			$aplayers = array();
			while ($player = $database->FetchAssoc($away_playerlist)) {
				GameAddPlayer($database, $game['game_id'], $player['player_id'], intval($player['num']));
				$aplayers[] = intval($player['num']);
			}
			$aplayers[] = 'xx'; //callahan

			GameSetStartingTeam($database, $game['game_id'], rand(0, 1));

			$h = 0;
			$a = 0;
			$time = 0;
			$maxscore = $poolinfo['winningscore'];
			if ($maxscore <= 0) $maxscore = rand(2, 15);
			$draw = 0;
			if ($poolinfo['drawsallowed'] && rand(0, 10) == 1)
				$draw = 1;
			for ($i = 0; ($draw == 0 && $h < $maxscore && $a < $maxscore) || ($draw == 1 && ($h < $maxscore || $a < $maxscore)); $i++) {

				if ($h == $maxscore)
					$home = 0;
				elseif ($a == $maxscore)
					$home = 1;
				else
					$home = rand(0, 1);

				$pass = 0;
				$goal = 0;
				$iscallahan = 0;
				$time = $time + rand(30, 200);

				if ($home) {
					$h++;
					$pass = $hplayers[rand(0, count($hplayers) - 1)];

					if (strcasecmp($pass, 'xx') == 0 || strcasecmp($pass, 'x') == 0) {
						$iscallahan = 1;
						$pass = -1;
					} else {
						$pass = GamePlayerFromNumber($database, $game['game_id'], $info['hometeam'], $pass);
					}
					$goal = $hplayers[rand(0, count($hplayers) - 2)]; //-2 removes callahan
					$goal = GamePlayerFromNumber($database, $game['game_id'], $info['hometeam'], $goal);
				} else {
					$a++;
					$pass = $aplayers[rand(0, count($aplayers) - 1)];

					if (strcasecmp($pass, 'xx') == 0 || strcasecmp($pass, 'x') == 0) {
						$iscallahan = 1;
						$pass = -1;
					} else {
						$pass = GamePlayerFromNumber($database, $game['game_id'], $info['visitorteam'], $pass);
					}
					$goal = $aplayers[rand(0, count($aplayers) - 1)]; //-1 removes callahan
					$goal = GamePlayerFromNumber($database, $game['game_id'], $info['visitorteam'], $goal);
				}
				GameAddScore($database, $game['game_id'], $pass, $goal, $time, $i + 1, $h, $a, $home, $iscallahan);
				if ($h == $poolinfo['halftimescore'] || $a == $poolinfo['halftimescore']) {
					$time = $time + $poolinfo['halftime'];
					GameSetHalftime($database, $game['game_id'], $time);
				}
			}

			//home team timeouts
			$timeouts = rand(0, $poolinfo['timeouts']);
			$timeoutstime = array();
			for ($i = 0; $i <= $timeouts; $i++) {
				$timeoutstime[] = rand(0, $time);
			}
			sort($timeoutstime, SORT_NUMERIC);

			for ($i = 0; $i <= $timeouts; $i++) {
				GameAddTimeout($database, $game['game_id'], $i + 1, $timeoutstime[$i], 1);
			}

			//away team timeouts
			$timeouts = rand(0, $poolinfo['timeouts']);
			$timeoutstime = array();
			for ($i = 0; $i <= $timeouts; $i++) {
				$timeoutstime[] = rand(0, $time);
			}
			sort($timeoutstime, SORT_NUMERIC);

			for ($i = 0; $i <= $timeouts; $i++) {
				GameAddTimeout($database, $game['game_id'], $i + 1, $timeoutstime[$i], 0);
			}

			//game official
			GameSetScoreSheetKeeper($database, $game['game_id'], "Game Simulator");

			GameSetResult($database, $game['game_id'], $h, $a, false);
		}
		ResolvePoolStandings($database, $poolId);
		PoolResolvePlayed($database, $poolId);
	}
} elseif (isset($_POST['reset']) && !empty($_POST['pools'])) {

	$pools = $_POST["pools"];

	foreach ($pools as $poolId) {

		$poolinfo = PoolInfo($database, $poolId);
		$games = PoolGames($database, $poolId);
		set_time_limit(300); //game simulation takes time because so much inserts

		foreach ($games as $game) {

			GameRemoveAllPlayers($database, $game['game_id']);

			GameSetStartingTeam($database, $game['game_id'], NULL);

			GameRemoveAllScores($database, $game['game_id']);
			GameSetHalftime($database, $game['game_id'], NULL);

			GameRemoveAllTimeouts($database, $game['game_id']);

			GameSetScoreSheetKeeper($database, $game['game_id'], NULL);

			GameClearResult($database, $game['game_id'], false);
		}

		undoPoolMoves($poolId);


		ResolvePoolStandings($database, $poolId);
		PoolResolvePlayed($database, $poolId);
		// TODO undo moves, uo_team_pool.activerank, special ranks, ...
	}
}

//season selection
$html .= "<form method='post' id='tables' action='?view=plugins/simulate_games'>\n";

if (empty($seasonId)) {
	$html .= "<p>" . ("Select event") . ": <select class='dropdown' name='season'>\n";

	$seasons = Seasons($database);

	while ($row = $database->FetchAssoc($seasons)) {
		$html .= "<option class='dropdown' value='" . utf8entities($row['season_id']) . "'>" . utf8entities($row['name']) . "</option>";
	}

	$html .= "</select></p>\n";
	$html .= "<p><input class='button' type='submit' name='select' value='" . ("Select") . "'/></p>";
} else {

	$html .= "<p>" . ("Select pools to play") . ":</p>\n";
	$html .= "<table>";
	$html .= "<tr><th class='left'><input type='checkbox' onclick='checkAll(\"tables\");'/>";
	$html .= "<input type='image' src='images/remove.png' name='clearall' alt='" . _("X") . "' onclick='clearAll(\"tables\"); return false;'/></th>";
	$html .= "<th>" . ("Pool") . "</th>";
	$html .= "<th>" . ("Series") . "</th>";
	$html .= "<th>" . ("Teams") . "</th>";
	$html .= "<th>" . ("Played/Total") . "</th>";
	$html .= "</tr>\n";

	$series = SeasonSeries($database, $seasonId);
	foreach ($series as $row) {

		$pools = SeriesPools($database, $row['series_id']);
		foreach ($pools as $pool) {
			$html .= "<tr>";
			if (
				PoolTotalPlayedGames($database, $pool['pool_id']) < count(PoolGames($database, $pool['pool_id']))
				&& PoolIsMoveFromPoolsPlayed($database, $pool['pool_id'])
			) {
				$html .= "<td class='left'><input type='checkbox' checked='checked' name='pools[]' value='" . utf8entities($pool['pool_id']) . "' /></td>";
			} else {
				$html .= "<td class='left'><input type='checkbox' name='pools[]' value='" . utf8entities($pool['pool_id']) . "' /></td>";
			}
			$html .= "<td>" . $pool['name'] . "</td>";
			$html .= "<td>" . $row['name'] . "</td>";
			$html .= "<td class='center'>" . count(PoolTeams($database, $pool['pool_id'])) . "</td>";
			$html .= "<td class='center'>" . PoolTotalPlayedGames($database, $pool['pool_id']);
			$html .= "/" . count(PoolGames($database, $pool['pool_id'])) . "</td>";
			$html .= "</tr>\n";
		}
	}
	$html .= "</table>\n";
	$html .= "<p><input class='button' type='submit' name='simulate' value='" . ("Simulate") . "'/> <input class='button' type='submit' name='reset' value='" . ("Reset played games") . "'/></p>";
	$html .= "<div>";
	$html .= "<input type='hidden' name='season' value='$seasonId' />\n";
	$html .= "</div>\n";
}

$html .= "</form>";

showPage($database, $title, $html);
?>