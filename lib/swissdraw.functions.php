<?php

function DetectTiesInPreviousPool($database, $poolId)
{
	// retrieve list of pools contributing to this pool
	$query = sprintf(
		"
		SELECT distinct frompool
		FROM uo_moveteams pmt
		WHERE pmt.topool = '%s'",
		$database->RealEscapeString($poolId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	while ($contrPool = $database->FetchAssoc($result)) {
		$query = sprintf(
			"
			SELECT count(activerank) AS activeteams,count(activerank)-count(distinct activerank) as ties
			FROM uo_team_pool
			where pool='%s'",
			$database->RealEscapeString($contrPool['frompool'])
		);

		$result2 = $database->DBQuery($query);
		if (!$result2) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		$row = $database->FetchAssoc($result2);

		if ($row['activeteams'] == 0) {
			// no active teams in this pool
			return (2);
		} elseif ($row['ties'] > 0) {
			// ties detected
			return (1);
		}
	}

	// no ties detected, all teams present
	return (0);
}

function AutoResolveTiesInSourcePools($database, $poolId)
{
	// retrieve list of pools contributing to this pool
	$query = sprintf(
		"
		SELECT distinct frompool
		FROM uo_moveteams pmt
		WHERE pmt.topool = '%s'",
		$database->RealEscapeString($poolId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	while ($contrPool = $database->FetchAssoc($result)) {
		AutoResolveTies($database, $contrPool['frompool']);
	}
}

function AutoResolveTies($database, $poolId)
{
	//	print "Resolving ties in pool".$poolId."<br>";

	$query = sprintf(
		"
		SELECT team,rank,activerank
		FROM uo_team_pool
		WHERE pool='%s'
		ORDER BY activerank,team",
		$database->RealEscapeString($poolId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	$nbrows = $database->NumRows($result);
	//	print "Number of rows: ".$nbrows."<br>";

	for ($i = 1; $i <= $nbrows; $i++) {
		$row = $database->FetchAssoc($result);
		//		print_r($row);
		if ($row['activerank'] < $i && !empty($row['activerank'])) {
			// set this team's activerank to $i
			//			print "Adjusting team ".$row['team']."'s rank to ".$i."<br>";
			$query = sprintf(
				"
				UPDATE uo_team_pool
				SET activerank='%s'
				WHERE pool='%s' AND team='%s'",
				$database->RealEscapeString($i),
				$database->RealEscapeString($poolId),
				$database->RealEscapeString($row['team'])
			);
			$result2 = $database->DBQuery($query);
			if (!$result2) {
				die('Invalid query: ' . $database->GetConnection()->error());
			}
		}
	}
}

function CheckSwissdrawMoves($database, $poolId)
{
	// returns -1 if there are ties in previous pool
	// returns -2 if there are no active teams in previous pool
	// returns 1 if everything went fine

	$ties = DetectTiesInPreviousPool($database, $poolId);
	if ($ties > 0) return (-$ties);

	//retrieve all moves
	$moves = PoolMovingsToPool($database, $poolId);
	//	print "original moves:<br>";
	//	PrintMoves($database, $moves);

	//upgrade the moves-data with the actual teams
	for ($i = 0; $i < count($moves); $i++) {
		$team = PoolTeamFromStandings($database, $moves[$i]['frompool'], $moves[$i]['fromplacing']);
		if (empty($team)) die("This should have been detected earlier ...");
		$moves[$i]['team_id'] = $team['team_id'];
	}

	// retrieve all previously played games
	$games = PoolGetGamesToMove($database, $poolId, 0);

	//	print_r($moves);

	$forward = true;
	$roundcounter = 0;
	$foundValidArrangement = AdjustForDuplicateGames($database, $moves, $games, $forward);

	while (!$foundValidArrangement) {
		$forward = !$forward;
		//		print "trying the other way round, now forward? ".$forward."<br><br>";
		$foundValidArrangement = AdjustForDuplicateGames($database, $moves, $games, $forward);
		$roundcounter++;
		if ($roundcounter > count($moves) * 2) die("Could not find a valid arrangment of teams");
	}

	// update the moves in the database
	usort($moves, create_function('$a,$b', 'return $a[\'fromplacing\']==$b[\'fromplacing\']?0:($a[\'fromplacing\']<$b[\'fromplacing\']?-1:1);'));
	//	PrintMoves($database, $moves);
	for ($i = 0; $i < count($moves); $i++) {
		$query = sprintf(
			"
			UPDATE uo_moveteams SET torank=%s,scheduling_id=%s
			WHERE fromplacing=%s AND frompool=%s",
			$database->RealEscapeString($moves[$i]['torank']),
			$database->RealEscapeString($moves[$i]['scheduling_id']),
			$database->RealEscapeString($moves[$i]['fromplacing']),
			$database->RealEscapeString($moves[$i]['frompool'])
		);
		//		print $query."<br>";
		$result = $database->DBQuery($query);
		if (!$result) die($query . 'Invalid query: ' . $database->GetConnection()->error());
	}

	// everthing went fine
	return (1);
}

function AdjustForDuplicateGames($database, &$moves, $games, $forward)
{
	// this function will change the variable $moves

	if ($forward) {
		$sign = 1;
		$startPos = 0;
		$stopPos = count($moves);
	} else {
		$sign = -1;
		$startPos = count($moves) - 1;
		$stopPos = -1;
	}

	//	print "Loop from ".$startPos." until ".$stopPos." with steps ".($sign*2)."<br>";
	for ($i = $startPos; $i != $stopPos; $i = $i + $sign * 2) {
		if (TeamsHavePlayed($database, $moves[$i]['team_id'], $moves[$i + $sign]['team_id'], $games)) {
			// Find the first team in the rest of the list that hasn't played
			$j = FindUnplayedTeam($moves[$i]['team_id'], $i + 2 * $sign, $moves, $games, $forward);
			if ($j > 0) {
				// this means we've found one.
				MoveTeamToNewPosition($j, $i + $sign, $moves);
			} else {
				// This is trouble.  There is no team further down that hasn't played
				// the current team.
				//				print "unable to find an unplayed team in this direction:".$forward." <br>";
				return (false);
			}
		}
	}

	//	print "It all worked out! :-) <br>";
	return (true);
}

function PrintMoves($database, $moves)
{
	echo "<table border='1' width='600px'><tr>
	<th>" . _("From pool") . "</th>
	<th>" . _("From pos.") . "</th>
	<th>" . _("Team") . "</th>
	<th>" . _("To pos.") . "</th>
	<th>" . _("To pool") . "</th>
	<th>" . _("Name in Schedule") . "</th></tr>";

	for ($i = 0; $i < count($moves); $i++) {
		$row = $moves[$i];
		echo "<tr>";
		echo "<td style='white-space: nowrap'>" . utf8entities($row['name']) . "</td>";
		$team = PoolTeamFromStandings($database, $row['frompool'], $row['fromplacing']);
		echo "<td class='center'>" . intval($row['fromplacing']) . "</td>";
		echo "<td class='highlight'>" . utf8entities($team['name']) . "</td>";
		echo "<td class='center'>" . intval($row['torank']) . "</td>";
		echo "<td style='white-space: nowrap'>" . $row['scheduling_id'] . "</td>";
		echo "<td>" . utf8entities($row['pteamname']) . "</td>";
		echo "</tr>\n";
	}
	echo "</table>";
}

function MoveTeamToNewPosition($posFrom, $posTo, &$moves)
{
	// This routine will move the team in posFrom to the posTo position, and shift
	// everyone in between by one to accomodate.

	//	PrintMoves($database, $moves);
	//	print "<br>Moving team in position ".$posFrom." to position ".$posTo." <br>";

	if ($posFrom > $posTo) {
		$sign = -1;
	} else {
		$sign = 1;
	}

	$tempfromplacing = $moves[$posFrom]['fromplacing'];
	$tempteam_id = $moves[$posFrom]['team_id'];


	for ($i = $posFrom; $i != $posTo; $i = $i + $sign) {
		//		print "in the loop<br>";
		$moves[$i]['fromplacing'] = $moves[$i + $sign]['fromplacing'];
		$moves[$i]['team_id'] = $moves[$i + $sign]['team_id'];
	}
	$moves[$posTo]['fromplacing'] = $tempfromplacing;
	$moves[$posTo]['team_id'] = $tempteam_id;

	//	PrintMoves($database, $moves);
}


function FindUnplayedTeam($teamid, $startPos, $moves, $games, $forward)
{

	if ($forward) {
		$sign = 1;
		$stopPos = count($moves) - 1;
		if ($startPos > $stopPos) return (-1);
	} else {
		$sign = -1;
		$stopPos = 1;
		if ($startPos < $stopPos) return (-1);
	}

	for ($i = $startPos; $i != $stopPos; $i = $i + $sign) {
		if (!TeamsHavePlayed($database, $teamid, $moves[$i]['team_id'], $games)) {
			//			print "Found an unplayed team for ".$teamid.", namely ".$moves[$i]['team_id']." on position ".$i."<br>";
			return ($i);
		}
	}
	return (-1);
}


function TeamsHavePlayed($database, $teamid1, $teamid2, $games)
{
	$i = 0;

	$team1 = TeamInfo($database, $teamid1);
	$team2 = TeamInfo($database, $teamid2);
	//	print "Checking if ".$team1['name']." has played against ".$team2['name'];

	// now just look down the list and see if these teams have played
	while ($i < count($games)) {
		$game = GameResult($database, $games[$i]);
		if (($game['hometeam'] == $teamid1 && $game['visitorteam'] == $teamid2) || ($game['hometeam'] == $teamid2 && $game['visitorteam'] == $teamid1)) {
			//			print " yes <br>";
			return (true);
		}
		$i++;
	}
	//	print " no <br>";
	return (false);
}


function FindSwissProblem($database, $moves, $games)
{
	$totalmoves = len($moves);
	$problemMove = 0;
	$i = 1;
	while ($i < $rounds && $problemMove == 0) {
		if (HavePlayed($database, $moves($i), $moves($i + 1), $games))
			$problemMove = $i;
		$i = $i + 2;
	}
}
function SwissAllMovesOK($database, $moves, $games)
{
	$totalmoves = len($moves);
	$allOK = true;
	$i = 1;
	while ($i < $rounds && $allOK) {
		if (HavePlayed($database, $moves($i), $moves($i + 1), $games))
			$allOK = false;
		$i = $i + 2;
	}
}

function GenerateSwissdrawPools($database, $poolId, $rounds, $generate = true)
{
	$poolInfo = PoolInfo($database, $poolId);
	if (hasEditTeamsRight($database, $poolInfo['series'])) {

		$pools = array();

		$query = sprintf(
			"SELECT team.team_id from uo_team_pool as tp left join uo_team team 
				on (tp.team = team.team_id) WHERE tp.pool=%d ORDER BY tp.rank",
			(int)$poolId
		);
		$result = $database->DBQuery($query);

		if ($database->NumRows($result) == 0) {
			$pseudoteams = true;
			$query = sprintf(
				"SELECT pt.scheduling_id AS team_id from uo_scheduling_name pt 
					LEFT JOIN uo_moveteams mt ON(pt.scheduling_id = mt.scheduling_id) 
					WHERE mt.topool=%d ORDER BY mt.torank",
				(int)$poolId
			);
			$result = $database->DBQuery($query);
		}
		$teams = $database->NumRows($result);

		//echo "<p>rounds to win $rounds</p>";
		$prevpoolId = $poolId;
		$offset = $teams;
		$name = "Round 1";
		$prevname = "R1";
		$poolname = $poolInfo['name'];

		//first round is played in master pool
		for ($i = 1; $i < $rounds; $i++) {

			$name = "Round " . ($i + 1);
			$prevname = "Rnd" . ($i);

			if ($generate) {
				//create pool
				$name =  $name . " " . $poolname;
				$id = PoolFromAnotherPool($database, $poolInfo['series'], $name, $poolInfo['ordering'] . ($i + 1), $poolId);
				// make it a continuation pool
				$query = sprintf("UPDATE uo_pool SET continuingpool=1 WHERE pool_id=%s", (int)$id);
				$result = $database->DBQuery($query);

				//standard move to next pool
				for ($j = 1; $j <= $teams; $j++) {
					PoolAddMove($database, $prevpoolId, $id, $j, $j, "$prevname Place $j");
				}

				// create games in new pools as well
				GenerateGames($database, $id, 1, $generate, false);

				$pools[] = PoolInfo($database, $id);
				$prevpoolId = $id;
			} else {
				$pools[] = $poolInfo;
				$pools[$i - 1]['name'] = $name . " " . $poolname;
			}
		}

		return $pools;
	} else {
		die('Insufficient rights to add games');
	}
}

function PoolTeamFromStandingsNoTies($database, $poolId, $activerank)
{
	// does the same as PoolTeamFromStandings above, but never returns an empty team
	// if there are ties, they are broken consistently by the team_id of the tied teams
	$query = sprintf(
		"
		SELECT j.team_id, j.name, js.activerank, c.flagfile
		FROM uo_team AS j 
		LEFT JOIN uo_team_pool AS js ON (j.team_id = js.team)
		LEFT JOIN uo_country c ON(c.country_id=j.country)
		WHERE js.pool='%s' AND js.activerank='%s'",
		$database->RealEscapeString($poolId),
		$database->RealEscapeString($activerank)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	if ($database->NumRows($result) == 0) {
		// must be due to ties in previous activeranks
		$searchback = 0;
		while ($database->NumRows($result) == 0) {
			$searchback++;
			$query = sprintf(
				"
				SELECT j.team_id, j.name, js.activerank, c.flagfile
				FROM uo_team AS j 
				LEFT JOIN uo_team_pool AS js ON (j.team_id = js.team)
				LEFT JOIN uo_country c ON(c.country_id=j.country)
				WHERE js.pool='%s' AND js.activerank='%s'",
				$database->RealEscapeString($poolId),
				$database->RealEscapeString($activerank - $searchback)
			);

			$result = $database->DBQuery($query);
			if (!$result) {
				die('Invalid query: ' . $database->GetConnection()->error());
			}
		}
		$database->dataseek($result, $searchback);
	}

	return $database->FetchAssoc($result);
}


function CheckBYESchedule($database, $poolId)
{
	// checks if a game with a BYE team as participant has been scheduled
	// and in the same pool, there is a game with real teams that has not been scheduled	
	// if this is the case, the slots of the real game gets the slot from the BYE game

	$query = sprintf(
		"
		SELECT game_id,hometeam,visitorteam,reservation,g.time
		FROM uo_game AS g 
		LEFT JOIN uo_team AS tvisit ON (g.visitorteam = tvisit.team_id)
		LEFT JOIN uo_team as thome  ON (g.hometeam = thome.team_id)
		WHERE g.pool='%s' AND ((thome.valid=2 OR tvisit.valid=2 AND g.time is not NULL) OR 
			(g.time is NULL AND thome.valid=1 AND tvisit.valid=1) )
		ORDER BY g.time",
		$database->RealEscapeString($poolId)
	);

	$result = $database->DBQuery($query);

	if ($database->NumRows($result) == 2) { // swap spots
		$row1 = $database->FetchAssoc($result);
		$row2 = $database->FetchAssoc($result);

		$query = sprintf(
			"
				UPDATE uo_game SET reservation='%s', time='%s' 
				WHERE game_id='%s' ",
			$database->RealEscapeString($row2['reservation']),
			$database->RealEscapeString($row2['time']),
			$database->RealEscapeString($row1['game_id'])
		);
		$result = $database->DBQuery($query);
		if (!$result || $database->affectedrows() != 1) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		if ($row1['reservation'] != "" or $row1['time'] != "") {
			die('something is fishy here');
		}

		$query = sprintf(
			"
				UPDATE uo_game SET reservation=NULL, time=NULL 
				WHERE game_id='%s' ",
			$database->RealEscapeString($row2['game_id'])
		);
		$result = $database->DBQuery($query);
		if (!$result || $database->affectedrows() != 1) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		echo "Spots swapped!!! Pool_id " . $poolId . "<br>";
	}
}


function CheckBYE($database, $poolId)
{
	// returns the number of games where the standard result has been filled in

	$poolInfo = PoolInfo($database, $poolId);
	$changes = 0;
	if ($poolInfo['type'] == 3) {
		// Swissdraw

		//		echo "actually doing it";
		// if the visitor-team is the BYE-team assign the appropriate scores to home and visitor
		$query = sprintf(
			"
				UPDATE uo_game,uo_team SET uo_game.visitorscore='%s', uo_game.homescore='%s', uo_game.hasstarted='2'
				WHERE (uo_game.pool='%s' AND uo_game.visitorteam=uo_team.team_id AND uo_team.valid=2)",
			$database->RealEscapeString($poolInfo['forfeitagainst']),
			$database->RealEscapeString($poolInfo['forfeitscore']),
			$database->RealEscapeString($poolId)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		$changes = $database->affectedrows();

		// if the home-team is the BYE-team assign the appropriate scores to home and visitor
		$query = sprintf(
			"
				UPDATE uo_game,uo_team SET uo_game.homescore='%s', uo_game.visitorscore='%s', uo_game.hasstarted='2'
				WHERE (uo_game.pool='%s' AND uo_game.hometeam=uo_team.team_id AND uo_team.valid=2)",
			$database->RealEscapeString($poolInfo['forfeitagainst']),
			$database->RealEscapeString($poolInfo['forfeitscore']),
			$database->RealEscapeString($poolId)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		$changes += $database->affectedrows();
	}
	return $changes;
}

function CheckPlayoffMoves($database, $poolId)
{
	// returns -1 if the number of teams in the pool is odd, i.e. one team will have a BYE,
	// and at least one team already had a BYE previously

	// returns 0 if everything is OK

	$poolInfo = PoolInfo($database, $poolId);
	if (is_odd($poolInfo['teams']) == false) {
		return 0;
	}  // there is no problem

	$games = array();
	//retrieve all moves
	$moves = PoolMovingsToPool($database, $poolId);
	foreach ($moves as $row) {
		$team = PoolTeamFromStandings($database, $row['frompool'], $row['fromplacing'], false);
		if (TeamPoolCountBYEs($database, $team['team_id'], $row['frompool']) > 0) {
			return -1;
		}
	}
}
