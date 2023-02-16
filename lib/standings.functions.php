<?php

function ResolvePoolStandings($database, $poolId)
{
	$poolinfo = PoolInfo($database, $poolId);
	if ($poolinfo['type'] == 1) {
		ResolveSeriesPoolStandings($database, $poolId);
	} elseif ($poolinfo['type'] == 2) {
		ResolvePlayoffPoolStandings($database, $poolId);
	} elseif ($poolinfo['type'] == 3) {
		ResolveSwissdrawPoolStandings($database, $poolId);
	} elseif ($poolinfo['type'] == 4) {
		ResolveCrossMatchPoolStandings($database, $poolId);
	}
}

function ResolvePlayoffPoolStandings($database, $poolId)
{

	//query pool teams
	$query = sprintf(
		"
		SELECT j.team_id, js.activerank 
		FROM uo_team AS j INNER JOIN uo_team_pool AS js ON (j.team_id = js.team) 
		WHERE js.pool=%d 
		ORDER BY js.rank ASC",
		(int)$poolId
	);

	$teams = $database->DBQueryToArray($query);
	$steams = PoolSchedulingTeams($database, $poolId);

	if (count($teams) <= 1 || count($teams) < count($steams)) {
		return;
	}

	for ($i = 0; $i < (count($teams) - 1); $i = $i + 2) {
		//loop team in pairs, but also be aware if there is odd number of teams
		$teamId1 = $teams[$i]['team_id'];
		$teamId2 = $teams[$i + 1]['team_id'];
		$query = sprintf(
			"SELECT 
				COUNT((hometeam=%d AND (homescore>visitorscore)) OR (visitorteam=%d AND (homescore<visitorscore)) OR NULL) AS team1wins, 
				COUNT((hometeam=%d AND (homescore>visitorscore)) OR (visitorteam=%d AND (homescore<visitorscore)) OR NULL) AS team2wins 
				FROM uo_game 
				WHERE (homescore != visitorscore) AND ((hometeam=%d AND visitorteam=%d) OR (hometeam=%d AND visitorteam=%d)) 
					AND isongoing=0
					AND game_id IN (SELECT game FROM uo_game_pool WHERE pool=%d)",
			(int)$teamId1,
			(int)$teamId1,
			(int)$teamId2,
			(int)$teamId2,
			(int)$teamId1,
			(int)$teamId2,
			(int)$teamId2,
			(int)$teamId1,
			(int)$poolId
		);
		$games = $database->DBQueryToRow($query);

		if ($games['team1wins'] > $games['team2wins']) {
			$database->DBQuery("UPDATE uo_team_pool SET activerank=" . ($i + 1) . " WHERE pool=" . intval($poolId) . " AND team=$teamId1");
			$database->DBQuery("UPDATE uo_team_pool SET activerank=" . ($i + 2) . " WHERE pool=" . intval($poolId) . " AND team=$teamId2");
		} elseif ($games['team1wins'] < $games['team2wins']) {
			$database->DBQuery("UPDATE uo_team_pool SET activerank=" . ($i + 1) . " WHERE pool=" . intval($poolId) . " AND team=$teamId2");
			$database->DBQuery("UPDATE uo_team_pool SET activerank=" . ($i + 2) . " WHERE pool=" . intval($poolId) . " AND team=$teamId1");
		} else {
			//keep current positions
		}
		//check if teams can be moved to next round
		$gamesleft1 = TeamPoolGamesLeft($database, $teamId1, $poolId);
		$gamesleft2 = TeamPoolGamesLeft($database, $teamId2, $poolId);
		if ($database->NumRows($gamesleft1) + $database->NumRows($gamesleft2) == 0) {
			TeamMove($database, $teamId1, $poolId, true);
			TeamMove($database, $teamId2, $poolId, true);
		}
	}
	// if odd number of teams
	if (count($teams) % 2 == 1) {
		$byeTeamId = $teams[count($teams) - 1]['team_id'];
		// set activerank to the last position in pool
		$database->DBQuery("UPDATE uo_team_pool SET activerank=" . (count($teams)) . " WHERE pool=" . intval($poolId) . " AND team=$byeTeamId");
		// and attempt to move
		TeamMove($database, $byeTeamId, $poolId, true);
	}

	//check if there are special ranking rules and apply them 
	CheckSpecialRanking($database, $poolId);
}

function CheckSpecialRanking($database, $poolId)
{
	//check if there are special ranking rules for this pool and apply them 
	$query = sprintf(
		"		
			SELECT team,pool,activerank as oldrank,torank as newrank
			FROM uo_specialranking r 
			LEFT JOIN uo_team_pool tp ON (tp.pool = r.frompool AND tp.activerank = r.fromplacing)
			WHERE tp.pool='%s'",
		(int)$poolId
	);
	$specialranking = $database->DBQueryToArray($query);
	foreach ($specialranking as $row) {
		//		print_r($row);
		$database->DBQuery("UPDATE uo_team_pool SET activerank=" . $row['newrank'] . " WHERE pool=" . intval($row['pool']) . " AND team=" . $row['team']);
	}
}

function ResolveCrossMatchPoolStandings($database, $poolId)
{

	//query pool teams
	$query = sprintf(
		"
		SELECT j.team_id, js.activerank 
		FROM uo_team AS j INNER JOIN uo_team_pool AS js ON (j.team_id = js.team) 
		WHERE js.pool=%d 
		ORDER BY js.activerank ASC, js.rank ASC",
		(int)$poolId
	);

	$teams = $database->DBQueryToArray($query);

	if (count($teams) <= 1) {
		return;
	}

	for ($i = 0; $i < (count($teams) - 1); $i = $i + 2) {
		//loop team in pairs, but also be aware if there is odd number of teams
		$teamId1 = $teams[$i]['team_id'];
		$teamId2 = $teams[$i + 1]['team_id'];
		$query = sprintf(
			"SELECT 
				COUNT((hometeam=%d AND (homescore>visitorscore)) OR (visitorteam=%d AND (homescore<visitorscore)) OR NULL) AS team1wins, 
				COUNT((hometeam=%d AND (homescore>visitorscore)) OR (visitorteam=%d AND (homescore<visitorscore)) OR NULL) AS team2wins 
				FROM uo_game 
				WHERE (homescore != visitorscore) AND ((hometeam=%d AND visitorteam=%d) OR (hometeam=%d AND visitorteam=%d)) 
					AND isongoing=0
					AND game_id IN (SELECT game FROM uo_game_pool WHERE pool=%d)",
			(int)$teamId1,
			(int)$teamId1,
			(int)$teamId2,
			(int)$teamId2,
			(int)$teamId1,
			(int)$teamId2,
			(int)$teamId2,
			(int)$teamId1,
			(int)$poolId
		);
		$games = $database->DBQueryToRow($query);

		if ($games['team1wins'] > $games['team2wins']) {
			$database->DBQuery("UPDATE uo_team_pool SET activerank=" . ($i + 1) . " WHERE pool=" . intval($poolId) . " AND team=$teamId1");
			$database->DBQuery("UPDATE uo_team_pool SET activerank=" . ($i + 2) . " WHERE pool=" . intval($poolId) . " AND team=$teamId2");
		} elseif ($games['team1wins'] < $games['team2wins']) {
			$database->DBQuery("UPDATE uo_team_pool SET activerank=" . ($i + 1) . " WHERE pool=" . intval($poolId) . " AND team=$teamId2");
			$database->DBQuery("UPDATE uo_team_pool SET activerank=" . ($i + 2) . " WHERE pool=" . intval($poolId) . " AND team=$teamId1");
		} else {
			//keep current positions
		}
		//check if teams can be moved to next round
		$gamesleft1 = TeamPoolGamesLeft($database, $teamId1, $poolId);
		$gamesleft2 = TeamPoolGamesLeft($database, $teamId2, $poolId);

		if ($database->NumRows($gamesleft1) + $database->NumRows($gamesleft2) == 0) {
			TeamMove($database, $teamId1, $poolId);
			TeamMove($database, $teamId2, $poolId);
		}
	}
}

function CompareTeamsSwissdraw($database, $a, $b)
{ // distinguish between first round and the rest
	if ($a['games'] == 1 && $b['games'] == 1) {
		// sort according to
		// 1. victory points
		// 2. margin
		// 3. total points scored
		// 4. spirit score <-- REMOVED!
		if ($a['vp'] != $b['vp']) {
			return ($a['vp'] > $b['vp']) ? -1 : 1;
		} else {
			if ($a['margin'] != $b['margin']) {
				return ($a['margin'] > $b['margin']) ? -1 : 1;
			} else {
				if ($a['score'] != $b['score']) {
					return ($a['score'] > $b['score']) ? -1 : 1;
				} else {
					return 0;
				}
			}
		}
	} else {
		// sort according to
		// 0. number of games
		// 1. victory points
		// 2. opponent's victory points
		// 3. total points scored
		// 4. spirit score

		if ($a['games'] != $b['games']) {
			return ($a['games'] > $b['games']) ? -1 : 1;
		} else {
			if ($a['vp'] != $b['vp']) {
				return ($a['vp'] > $b['vp']) ? -1 : 1;
			} else {
				if ($a['oppvp'] != $b['oppvp']) {
					return ($a['oppvp'] > $b['oppvp']) ? -1 : 1;
				} else {
					if ($a['score'] != $b['score']) {
						return ($a['score'] > $b['score']) ? -1 : 1;
					} else {
						return 0;
					}
				}
			}
		}
	}
}

function SolveStandingsAccordingSwissdraw($database, $points)
{
	//sort according victorypoints
	usort($points, "CompareTeamsSwissdraw");

	//update active rank
	$stand = 1;
	$points[0]['arank'] = 1;

	for ($i = 1; $i < count($points); $i++) {
		if (CompareTeamsSwissdraw($database, $points[$i - 1], $points[$i]) != 0) {
			$stand = $i + 1;
		}
		$points[$i]['arank'] = $stand;
	}
	return $points;
}


function ResolveSwissdrawPoolStandings($database, $poolId)
{
	//query pool teams
	$query = sprintf(
		"
		SELECT j.team_id, js.activerank 
		FROM uo_team AS j INNER JOIN uo_team_pool AS js ON (j.team_id = js.team) 
		WHERE js.pool='%s' 
		ORDER BY js.activerank ASC, js.rank ASC",
		$database->RealEscapeString($poolId)
	);

	$standings = $database->DBQuery($query);

	$points = array();
	$i = 0;

	if ($database->NumRows($standings) <= 1) {
		return;
	}

	while ($row = $database->FetchAssoc($standings)) {
		// retrieve nr of games, victory points, average opponent's victory points
		$stats1 = TeamVictoryPointsByPool($database, $poolId, $row['team_id']);

		$points[$i]['team'] = $row['team_id'];
		$points[$i]['games'] = $stats1['games'];
		$points[$i]['vp'] = $stats1['victorypoints'];
		$points[$i]['oppvp'] = $stats1['oppvp'];
		$points[$i]['margin'] = $stats1['margin'];
		$points[$i]['score'] = $stats1['score'];
		$i++;
	}

	//	echo "before sorting acc to games:"
	//	PrintStandingsSwissdraw($points);

	//initial sort according games
	usort($points, create_function('$a,$b', 'return $a[\'games\']==$b[\'games\']?0:($a[\'games\']>$b[\'games\']?-1:1);'));

	//	echo "before sorting acc to points:";
	//	PrintStandingsSwissdraw($points);

	$points = SolveStandingsAccordingSwissdraw($database, $points);
	//	echo "after sorting acc to points:";
	//	PrintStandingsSwissdraw($points);


	//update results
	for ($i = 0; $i < $database->NumRows($standings) && !empty($points[$i]['team']); $i++) {
		//echo "<p>win t".$points[$i]['team']." v".$points[$i]['wins']." s".$points[$i]['arank']."</p>";
		$query = sprintf(
			"UPDATE uo_team_pool 
				SET activerank='%s' WHERE pool='%s' AND team='%s'",
			$database->RealEscapeString($points[$i]['arank']),
			$database->RealEscapeString($poolId),
			$database->RealEscapeString($points[$i]['team'])
		);

		$database->DBQuery($query);
	}
}


function ResolveSeriesPoolStandings($database, $poolId)
{
	$poolId = intval($poolId);

	//query pool teams
	$query = sprintf(
		"
	SELECT j.team_id, js.activerank 
	FROM uo_team AS j INNER JOIN uo_team_pool AS js ON (j.team_id = js.team) 
	WHERE js.pool='%s' 
	ORDER BY js.activerank ASC, js.rank ASC",
		$database->RealEscapeString($poolId)
	);

	$standings = $database->DBQuery($query);

	$points = array();
	$i = 0;

	if ($database->NumRows($standings) <= 1) {
		return;
	}

	while ($row = $database->FetchAssoc($standings)) {
		$points[$i]['team'] = $row['team_id'];
		$points[$i]['arank'] = 1;
		$i++;
	}
	$points = getMatchesWins($database, $points, $poolId);

	//initial sort according games
	usort($points, create_function('$a,$b', 'return $a[\'games\']==$b[\'games\']?0:($a[\'games\']>$b[\'games\']?-1:1);'));

	//sort according to score (wins*winscore+draws*drawscore)
	$points = SolveStandings($points, 'cmp_score');
	$offset = 1;

	//if team sharing same standing
	$samerank = FindSameRank($points, $offset);

	//check in order
	//1st condition: check matches played against teams sharing same standing
	//2nd condition: check goal difference from matches played against teams sharing same standing
	//3rd condition: all matches goal difference
	//4th condition: made  goals in matches played against teams sharing same standing
	//5th condition: made goals in all matches
	//whenever one of these condtions solve one or more team standings start checking on begin for teams still sharing same standings
	while (count($samerank)) {
		$solved = false;
		$offset = $samerank[0]['arank'];

		//PrintStandings($samerank);
		//1st condition: check matches played against teams sharing same standing
		$samerank = SolveStandings(getMatchesWins($database, $samerank, $poolId, true), 'cmp_score');

		//PrintStandings($samerank);
		//continue to 2nd condition if all teams are still sharing the same standing
		if (IsSameRank($samerank)) {
			//2nd condition: check goal difference from matches played against teams sharing same standing
			//       $samerank = SolveStandingsSharedMatchesGoalsDiff($samerank, $poolId);
			$samerank = SolveStandings(getMatchesGoals($database, $samerank, $poolId, true), 'cmp_goalsdiff');
		} else {
			$solved = true;
		}

		//PrintStandings($samerank);
		//continue to 3rd condition if standings not solved
		if (!$solved && IsSameRank($samerank)) {
			//3rd condition: all matches goal difference
			//       $samerank = SolveStandingsAllMatchesGoalsDiff($samerank, $poolId);
			$samerank = SolveStandings(getMatchesGoals($database, $samerank, $poolId, false), 'cmp_goalsdiff');
		} else {
			$solved = true;
		}

		//PrintStandings($samerank);
		//continue to 4th condition if standings not solved
		if (!$solved && IsSameRank($samerank)) {
			//4th condition: made  goals in matches played against teams sharing same standing
			//       $samerank = SolveStandingsSharedMatchesGoalsMade($samerank, $poolId);
			$samerank = SolveStandings(getMatchesGoals($database, $samerank, $poolId, true), 'cmp_goalsmade');
		} else {
			$solved = true;
		}

		//PrintStandings($samerank);
		//continue to 5th condition if standings not solved
		if (!$solved && IsSameRank($samerank)) {
			//5th condition: made goals in all matches
			//       $samerank = SolveStandingsAllMatchesGoalsMade($samerank, $poolId);
			$samerank = SolveStandings(getMatchesGoals($database, $samerank, $poolId, false), 'cmp_goalsmade');
		} else {
			$solved = true;
		}

		if (!$solved && !IsSameRank($samerank)) {
			$solved = true;
		}

		//PrintStandings($samerank);
		if ($solved) {
			//update standings and check remaining standings in same pool
			$points = UpdateStandings($points, $samerank);
		} else {
			//cannot solve standings with current conditions. Leave teams to shared stands and check remaining standings in same pool
			//echo "<p>count: ".$offset." ".count($samerank)."</p>";
			$offset += count($samerank);
		}

		$samerank = FindSameRank($points, $offset);
	}

	//update results
	for ($i = 0; $i < $database->NumRows($standings) && !empty($points[$i]['team']); $i++) {
		//echo "<p>win t".$points[$i]['team']." v".$points[$i]['wins']." s".$points[$i]['arank']."</p>";
		$query = sprintf(
			"UPDATE uo_team_pool
			SET activerank='%s' WHERE pool='%s' AND team='%s'",
			$database->RealEscapeString($points[$i]['arank']),
			$database->RealEscapeString($poolId),
			$database->RealEscapeString($points[$i]['team'])
		);

		$database->DBQuery($query);
	}

	//test if pool is played
	$games = $database->DBQueryRowCount("SELECT game_id
		FROM uo_game game
		LEFT JOIN uo_pool p ON (p.pool_id=game.pool)
		WHERE p.pool_id=$poolId");
	$played = $database->DBQueryRowCount("SELECT game_id
		FROM uo_game game
		LEFT JOIN uo_pool p ON (p.pool_id=game.pool)
		WHERE p.pool_id=$poolId AND (game.hasstarted>0) AND game.isongoing=0");
	if ($games == $played) {

		//test that standings are not shared
		$query = sprintf(
			"SELECT activerank, COUNT(activerank) AS num
			FROM uo_team_pool WHERE pool=%d 
			GROUP BY activerank HAVING ( COUNT(activerank) > 1 )",
			(int)$poolId
		);

		$duplicates = $database->DBQueryRowCount($query);
		if (!$duplicates) {
			$topools = PoolMovingsFromPool($database, $poolId);

			foreach ($topools as $pool) {
				$poolinfo = PoolInfo($database, $pool['topool']);
				if ($poolinfo['mvgames'] == 1) {
					PoolMakeMove($database, $pool['frompool'], $pool['fromplacing'], false);
					//set pool visible
					$query = sprintf("UPDATE uo_pool SET visible='1' WHERE pool_id=%d", (int)$pool['topool']);
					$database->DBQuery($query);
				}
			}
		}
	}
}

function Score($point)
{
	return $point['wins'] * 2 + ($point['games'] - $point['wins'] - $point['losses']) * 1;
}

function cmp_score($pointa, $pointb)
{
	return (Score($pointa) > Score($pointb)) ? -1 : ((Score($pointa) < Score($pointb)) ? 1 : 0);
}

function cmp_goalsdiff($pointa, $pointb)
{
	return ($pointa['goalsdiff'] > $pointb['goalsdiff']) ? -1 : (($pointa['goalsdiff'] < $pointb['goalsdiff']) ? 1 : 0);
}

function cmp_goalsmade($pointa, $pointb)
{
	return ($pointa['goalsmade'] > $pointb['goalsmade']) ? -1 : (($pointa['goalsmade'] < $pointb['goalsmade']) ? 1 : 0);
}

function SolveStandings($points, $cmpf)
{
	if (count($points) == 0)
		return $points;
	//sort according wins
	usort($points, $cmpf);

	//update active rank
	$offset = 1;

	for ($i = 1; $i < count($points); $i++) {
		if ($cmpf($points[$i], $points[$i - 1]) != 0) {
			$points[$i]['arank'] = $points[$i - 1]['arank'] + $offset;
			$offset = 1;
		} else {
			$points[$i]['arank'] = $points[$i - 1]['arank'];
			$offset++;
		}
	}

	return $points;
}

function FindSameRank($points, $offset)
{
	usort($points, create_function('$a,$b', 'return $a[\'arank\']==$b[\'arank\']?0:($a[\'arank\']<$b[\'arank\']?-1:1);'));
	$samerank = array();
	$total = 0;

	for ($i = $offset; $i < count($points) && !empty($points[$i]['team']); $i++) {
		if ($points[$i]['arank'] == $points[$i - 1]['arank']) {
			//if first found, then previous team was with same rank
			if (!$total) {
				$samerank[$total]['team'] = $points[$i - 1]['team'];
				$samerank[$total]['wins'] = 0;
				$samerank[$total]['arank'] = $points[$i - 1]['arank'];
				$total++;
			}
			$samerank[$total]['team'] = $points[$i]['team'];
			$samerank[$total]['wins'] = 0;
			$samerank[$total]['arank'] = $points[$i]['arank'];
			$total++;
		} elseif ($total) {
			break;
		}
	}
	return $samerank;
}

function IsSameRank($points)
{
	for ($i = 1; $i < count($points); $i++) {
		if ($points[$i]['arank'] != $points[$i - 1]['arank']) {
			return false;
		}
	}
	return true;
}

function PrintStandings($points)
{
	for ($i = 0; $i < count($points); $i++) {
		echo "<p>t" . $points[$i]['team'] . " w" . $points[$i]['wins'] . " #" . $points[$i]['arank'] . "</p>";
	}
}

function PrintStandingsSwissdraw($points)
{
	for ($i = 0; $i < count($points); $i++) {
		echo "<p>" . $points[$i]['team'] . " g" . $points[$i]['games'] . " vp" . $points[$i]['vp'] . " oppvp" . $points[$i]['oppvp'] . " sc" . $points[$i]['score'] . " #" . $points[$i]['arank'] . "</p>";
	}
}


function UpdateStandings($to, $from)
{
	foreach ($from as $newrank) {
		for ($i = 0; $i < count($to); $i++) {
			if ($newrank['team'] == $to[$i]['team']) {
				$to[$i]['arank'] = $newrank['arank'];
				break;
			}
		}
	}
	//for ($i=0; $i < count($to); $i++) 
	//	{	
	//	echo "<p>update t".$to[$i]['team']." v".$to[$i]['wins']." s".$to[$i]['arank']."</p>";
	//	}

	return $to;
}

function getMatchesWins($database, $points, $poolId, $shared = false)
{
	$sameteams = $database->RealEscapeString($points[0]['team']);
	for ($i = 1; $i < count($points); $i++) {
		$sameteams .= "," . $database->RealEscapeString($points[$i]['team']);
	}
	for ($i = 0; $i < count($points); $i++) {
		$team = $database->RealEscapeString($points[$i]['team']);
		$query = sprintf(
			"
		SELECT COUNT(*) AS games,
    		COUNT((hometeam='%s' AND (homescore>visitorscore)) OR (visitorteam='%s' AND (homescore<visitorscore)) OR NULL) AS wins,
    		COUNT((hometeam='%s' AND (homescore<visitorscore)) OR (visitorteam='%s' AND (homescore>visitorscore)) OR NULL) AS losses
		FROM uo_game
		WHERE (hasStarted) AND (hometeam='%s' OR visitorteam='%s') AND isongoing=0
			AND game_id IN (SELECT game FROM uo_game_pool WHERE pool='%s')",
			$team,
			$team,
			$team,
			$team,
			$team,
			$team,
			$database->RealEscapeString($poolId)
		);
		if ($shared)
			$query .= sprintf(" AND hometeam IN (%s) AND visitorteam IN (%s)", $sameteams, $sameteams);

		$result = $database->DBQuery($query);
		$stats1 = $database->FetchAssoc($result);

		$points[$i]['games'] = $stats1['games'];
		$points[$i]['wins'] = $stats1['wins'];
		$points[$i]['losses'] = $stats1['losses'];
	}
	return $points;
}

function getMatchesGoals($database, $points, $poolId, $shared = false)
{
	$sameteams = $database->RealEscapeString($points[0]['team']);
	for ($i = 1; $i < count($points); $i++) {
		$sameteams .= "," . $database->RealEscapeString($points[$i]['team']);
	}
	//reset counters
	for ($i = 0; $i < count($points); $i++) {
		$points[$i]['goalsmade'] = 0;
		$points[$i]['goalsagainst'] = 0;
		$points[$i]['goalsdiff'] = 0;
	}

	// 	foreach ($points as $point) {
	for ($i = 0; $i < count($points); $i++) {
		$team = $database->RealEscapeString($points[$i]['team']);

		$query = sprintf(
			"
			SELECT hometeam,visitorteam,homescore,visitorscore
			  FROM uo_game
			  WHERE (hometeam='%s' OR visitorteam='%s') AND hasstarted AND isongoing=0
			  AND game_id IN (SELECT game FROM uo_game_pool WHERE pool='%s')",
			$team,
			$team,
			$database->RealEscapeString($poolId)
		);
		if ($shared)
			$query .= sprintf(" AND hometeam IN (%s) AND visitorteam IN (%s)", $sameteams, $sameteams);

		$result = $database->DBQuery($query);
		while ($stats = $database->FetchAssoc($result)) {
			if ($stats['hometeam'] == $points[$i]['team']) {
				$points[$i]['goalsmade'] += $stats['homescore'];
				$points[$i]['goalsagainst'] += $stats['visitorscore'];
			} elseif ($stats['visitorteam'] == $points[$i]['team']) {
				$points[$i]['goalsmade'] += $stats['visitorscore'];
				$points[$i]['goalsagainst'] += $stats['homescore'];
			}
		}
		$points[$i]['goalsdiff'] = $points[$i]['goalsmade'] - $points[$i]['goalsagainst'];
	}
	return $points;
}

function TeamPoolStanding($database, $teamId, $poolId)
{
	$query = sprintf(
		"SELECT u.activerank FROM uo_team_pool u WHERE pool='%d' AND team='%d'",
		(int)$poolId,
		(int)$teamId
	);
	return $database->DBQueryToValue($query);
}

function TeamSeriesStanding($database, $teamId)
{

	$team_info = TeamInfo($database, $teamId);
	$ppools = SeriesPlacementPoolIds($database, $team_info['series']);
	$standing = 1;

	$found = false;

	//loop all placement pools
	foreach ($ppools as $ppool) {
		$teams = PoolTeams($database, $ppool['pool_id']);
		$i = 0;
		//loop all teams
		foreach ($teams as $team) {
			$i++;
			$moved = PoolMoveExist($database, $ppool['pool_id'], $i);
			//if not moved and team searched exit loop
			if (!$moved && $team['team_id'] == $teamId) {
				$found = true;
				break;
			} elseif (!$moved) {
				$standing++;
			}
		}
		if ($found) {
			break;
		}
	}

	//if not found then return best guess
	if (!$found) {
		$standing = TeamPoolStanding($database, $teamId, $team_info['pool']);
	}

	return intval($standing);
}
