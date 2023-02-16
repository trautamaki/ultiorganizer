<?php
include_once $include_prefix . 'lib/accreditation.functions.php';
include_once $include_prefix . 'lib/facebook.functions.php';
include_once $include_prefix . 'lib/configuration.functions.php';
include_once $include_prefix . 'lib/twitter.functions.php';

function GameSetPools($database, $games)
{
	$query = "SELECT DISTINCT pool_id, p.name from uo_game g left join uo_pool p on (g.pool=p.pool_id) WHERE g.game_id in (";
	$query .= implode(",", $games);
	$query .= ") ORDER BY p.ordering ASC";
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	$ret = array();
	while ($row = $database->FetchAssoc($result)) {
		$ret[$row['pool_id']] = $row;
	}
	return $ret;
}

function PoolGameSetResults($database, $pool, $games)
{
	$query = sprintf(
		"SELECT time, k.name As hometeamname, v.name As visitorteamname, p.*,s.name AS gamename
		FROM uo_game AS p 
		LEFT JOIN uo_team As k ON (p.hometeam=k.team_id) 
		LEFT JOIN uo_team AS v ON (p.visitorteam=v.team_id)
		LEFT JOIN uo_scheduling_name s ON(s.scheduling_id=p.name)
		WHERE p.game_id IN (%s) AND pool=%d",
		$database->RealEscapeString(implode(",", $games)),
		(int)$pool
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	return $result;
}

function GameResult($database, $gameId)
{
	$query = sprintf(
		"
    SELECT time, k.name As hometeamname, v.name As visitorteamname, 
        k.valid as homevalid, v.valid as visitorvalid, 
        p.*, hspirit.mode AS spiritmode, hspirit.sotg AS homesotg, vspirit.sotg AS visitorsotg, s.name AS gamename
    FROM uo_game AS p 
    LEFT JOIN (SELECT ssc.game_id, ssc.team_id, ssc.category_id, sct.mode, SUM(value*factor) AS sotg 
               FROM uo_spirit_score ssc 
               LEFT JOIN uo_spirit_category sct ON (ssc.category_id = sct.category_id) 
               GROUP BY game_id, team_id) AS hspirit
       ON (p.game_id = hspirit.game_id AND hspirit.team_id = p.hometeam)
    LEFT JOIN (SELECT ssc.game_id, ssc.team_id, ssc.category_id, sct.mode, SUM(value*factor) AS sotg 
               FROM uo_spirit_score ssc 
               LEFT JOIN uo_spirit_category sct ON (ssc.category_id = sct.category_id) 
               GROUP BY game_id, team_id ) AS vspirit
       ON (p.game_id = hspirit.game_id AND vspirit.team_id = p.visitorteam)
    LEFT JOIN uo_team As k ON (p.hometeam=k.team_id) 
    LEFT JOIN uo_team AS v ON (p.visitorteam=v.team_id)
    LEFT JOIN uo_scheduling_name s ON(s.scheduling_id=p.name)
    WHERE p.game_id='%s'",
		$database->RealEscapeString($gameId)
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $database->FetchAssoc($result);
}

function GoalInfo($database, $gameId, $num)
{
	$query = sprintf(
		"SELECT m.*, s.profile_id AS assist_accrid, 
		s.firstname AS assistfirstname, s.lastname AS assistlastname,
		t.profile_id AS scorer_accrid,
		t.firstname AS scorerfirstname, t.lastname AS scorerlastname 
		FROM (uo_goal AS m LEFT JOIN uo_player AS s ON (m.assist = s.player_id)) 
		LEFT JOIN uo_player AS t ON (m.scorer=t.player_id)
		WHERE m.game=%d AND m.num=%d",
		(int)$gameId,
		(int)$num
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	if ($row = $database->FetchAssoc($result)) {
		return $row;
	} else return false;
}

function GameHomeTeamResults($database, $teamId, $poolId)
{
	$query = sprintf(
		"
		SELECT g.game_id, g.homescore, g.visitorscore, g.hasstarted, g.visitorteam, COALESCE(pm.goals,0) AS scoresheet,
			sn.name AS gamename, g.isongoing, g.hasstarted
			FROM uo_game g 
			LEFT JOIN (SELECT COUNT(*) AS goals, game FROM uo_goal GROUP BY game) AS pm ON (g.game_id=pm.game)
			LEFT JOIN uo_scheduling_name sn ON(g.name=sn.scheduling_id)
			WHERE g.hometeam=%d AND g.pool=%d
			GROUP BY g.game_id",
		(int) $teamId,
		(int) $poolId
	);
	return $database->DBQueryToArray($query);
}

function GameHomePseudoTeamResults($database, $schedulingId, $poolId)
{
	$query = sprintf(
		"SELECT g.game_id, g.homescore, g.visitorscore, g.hasstarted, g.visitorteam, 
			sn.name AS gamename, g.isongoing, g.hasstarted
			FROM uo_game g 
			LEFT JOIN uo_scheduling_name sn ON(g.name=sn.scheduling_id)
			WHERE g.scheduling_name_home=%d AND g.pool=%d
			GROUP BY g.game_id",
		(int) $schedulingId,
		(int) $poolId
	);
	return $database->DBQueryToArray($query);
}

function GameVisitorTeamResults($database, $teamId, $poolId)
{
	$query = sprintf(
		"
		SELECT g.game_id, g.homescore, g.visitorscore, g.hasstarted, g.hometeam, COALESCE(pm.goals,0) AS scoresheet
			FROM uo_game g 
			LEFT JOIN (SELECT COUNT(*) AS goals, game FROM uo_goal GROUP BY game) AS pm ON (g.game_id=pm.game)
			WHERE g.visitorteam=%d AND g.pool=%d AND g.hasstarted>0 AND g.valid=1 AND isongoing=0
			GROUP BY g.game_id",
		(int) $teamId,
		(int) $poolId
	);
	return $database->DBQueryToArray($query);
}

function GameNameFromId($database, $gameId)
{
	$query = sprintf(
		"
		SELECT k.name As hometeamname, v.name As visitorteamname 
		FROM (uo_game AS p LEFT JOIN uo_team As k ON (p.hometeam=k.team_id)) LEFT JOIN uo_team AS v ON (p.visitorteam=v.team_id)
		WHERE game_id=%d",
		(int)$gameId
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	$row = $database->FetchAssoc($result);
	return $row['hometeamname'] . " - " . $row['visitorteamname'];
}

function GameSeries($database, $gameId)
{
	$query = sprintf(
		"
		SELECT s.series 
		FROM uo_game p left join uo_pool s on (p.pool=s.pool_id)  
		WHERE game_id='%s'",
		$database->RealEscapeString($gameId)
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	$row = $result->fetch_row();

	return $row[0];
}

function GameRespTeam($database, $gameId)
{
	$query = sprintf(
		"
		SELECT respteam 
		FROM uo_game  
		WHERE game_id='%s'",
		(int)$gameId
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	$row = $result->fetch_row();

	return $row[0];
}

/**
 * Returns game admins (scorekeepers) for given game.
 *
 * @param int $gameId uo_game.game_id
 * @return php array of users
 */
function GameAdmins($database, $gameId)
{
	$query = sprintf(
		"SELECT u.userid, u.name FROM uo_users u
  			LEFT JOIN uo_userproperties up ON (u.userid=up.userid)
  			WHERE SUBSTRING_INDEX(up.value, ':', -1)='%d'
			ORDER BY u.name",
		(int)$gameId
	);
	return $database->DBQueryToArray($query);
}

function GamePool($database, $gameId)
{
	$query = sprintf(
		"
		SELECT pool 
		FROM uo_game  
		WHERE game_id=%d",
		(int)$gameId
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	$row = $result->fetch_row();

	return $row[0];
}

function GameIsFirstOffenceHome($database, $gameId)
{
	$query = sprintf(
		"
		SELECT ishome 
		FROM uo_gameevent  
		WHERE game=%d ORDER BY time",
		(int)$gameId
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	if (!$database->NumRows($result))
		return -1;

	$row = $result->fetch_row();

	return $row[0];
}

function GameReservation($database, $gameId)
{
	$query = sprintf(
		"
		SELECT reservation 
		FROM uo_game  
		WHERE game_id=%d",
		(int)$gameId
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	$row = $result->fetch_row();

	return $row[0];
}

function GameSeason($database, $gameId)
{
	$query = sprintf(
		"SELECT ser.season 
		FROM uo_game p LEFT JOIN uo_pool s on (p.pool=s.pool_id)
 			LEFT JOIN uo_series ser ON (s.series=ser.series_id)  
		WHERE game_id=%d",
		(int)$gameId
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	$row = $result->fetch_row();

	return $row[0];
}

function GamePlayers($database, $gameId, $teamId)
{
	$query = sprintf(
		"SELECT p.player_id, pg.num, p.firstname, p.lastname 
		FROM uo_played AS pg 
		LEFT JOIN uo_player AS p ON(pg.player=p.player_id)
		WHERE pg.game=%d AND p.team=%d",
		(int)$gameId,
		(int)$teamId
	);

	return $database->DBQueryToArray($query);
}

function GameCaptain($database, $gameId, $teamId)
{
	$query = sprintf(
		"SELECT pg.player, pg.num 
		FROM uo_played AS pg 
		LEFT JOIN uo_player AS p ON(pg.player=p.player_id)
		WHERE pg.captain=1 AND pg.game=%d AND p.team=%d",
		(int)$gameId,
		(int)$teamId
	);

	return $database->DBQueryToValue($query);
}

function GameAll($database, $limit = 50)
{
	$limit = intval($limit);
	//common game query
	$query = "SELECT pp.game_id, pp.time, pp.hometeam, pp.visitorteam, pp.homescore, 
			pp.visitorscore, pp.pool AS pool, pool.name AS poolname, pool.timeslot,
			ps.series_id, ps.name AS seriesname, ps.season, s.name AS seasonname, ps.type, pr.fieldname, pr.reservationgroup,
			pr.id AS reservation_id, pr.starttime, pr.endtime, pl.id AS place_id, 
			pl.name AS placename, pl.address, pp.isongoing, pp.hasstarted, home.name AS hometeamname, visitor.name AS visitorteamname,
			phome.name AS phometeamname, pvisitor.name AS pvisitorteamname, pool.color, pgame.name AS gamename,
			home.abbreviation AS homeshortname, visitor.abbreviation AS visitorshortname, homec.country_id AS homecountryid, 
			homec.name AS homecountry, visitorc.country_id AS visitorcountryid, visitorc.name AS visitorcountry, s.timezone
			FROM uo_game pp 
			LEFT JOIN uo_pool pool ON (pool.pool_id=pp.pool) 
			LEFT JOIN uo_series ps ON (pool.series=ps.series_id)
			LEFT JOIN uo_season s ON (s.season_id=ps.season)
			LEFT JOIN uo_reservation pr ON (pp.reservation=pr.id)
			LEFT JOIN uo_location pl ON (pr.location=pl.id)
			LEFT JOIN uo_team AS home ON (pp.hometeam=home.team_id)
			LEFT JOIN uo_team AS visitor ON (pp.visitorteam=visitor.team_id)
			LEFT JOIN uo_country AS homec ON (homec.country_id=home.country)
			LEFT JOIN uo_country AS visitorc ON (visitorc.country_id=visitor.country)
			LEFT JOIN uo_scheduling_name AS pgame ON (pp.name=pgame.scheduling_id)
			LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
			LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)
			WHERE pp.valid=true AND pp.hasstarted>0 AND pp.isongoing=0  ORDER BY pp.time DESC, ps.ordering, pool.ordering, pp.game_id
			LIMIT $limit";
	return $database->DBQuery($query);
}

function GamePlayerFromNumber($database, $gameId, $teamId, $number)
{
	$query = sprintf(
		"
		SELECT p.player_id
		FROM uo_player AS p 
		INNER JOIN (SELECT player, num FROM uo_played WHERE game='%s')
			AS pel ON (p.player_id=pel.player) 
		WHERE p.team='%s' AND pel.num='%s'",
		$database->RealEscapeString($gameId),
		$database->RealEscapeString($teamId),
		$database->RealEscapeString($number)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	if (!$database->NumRows($result))
		return -1;

	$row = $result->fetch_row();

	if ($row && $row[0])
		return intval($row[0]);
	else
		return -1;
}


function GameTeamScoreBorad($database, $gameId, $teamId)
{
	$query = sprintf(
		"
		SELECT p.player_id, p.firstname, p.lastname, p.profile_id, COALESCE(t.done,0) AS done, COALESCE(s.fedin,0) AS fedin, 
		(COALESCE(t.done,0) + COALESCE(s.fedin,0)) AS total, pel.num AS num FROM uo_player AS p 
		LEFT JOIN (SELECT m.scorer AS scorer, COUNT(*) AS done 
			FROM uo_goal AS m WHERE m.game='%s' AND m.scorer IS NOT NULL GROUP BY scorer) AS t ON (p.player_id=t.scorer) 
		LEFT JOIN (SELECT m2.assist AS assist, COUNT(*) AS fedin FROM uo_goal AS m2 
			WHERE m2.game='%s' AND m2.assist IS NOT NULL GROUP BY assist) AS s ON (p.player_id=s.assist) 
		RIGHT JOIN (SELECT player, num FROM uo_played WHERE game='%s') as pel ON (p.player_id=pel.player) 
			WHERE p.team='%s' 
		ORDER BY total DESC, done DESC, fedin DESC, lastname ASC, firstname ASC",
		$database->RealEscapeString($gameId),
		$database->RealEscapeString($gameId),
		$database->RealEscapeString($gameId),
		$database->RealEscapeString($teamId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $result;
}

function GameTeamDefenseBoard($database, $gameId, $teamId)
{
	$query = sprintf(
		"
		SELECT p.player_id, p.firstname, p.lastname, p.profile_id, COALESCE(t.done,0) AS done, pel.num AS num FROM uo_player AS p 
		LEFT JOIN (SELECT m.author AS author, COUNT(*) AS done 
			FROM uo_defense AS m WHERE m.game='%s' AND m.author IS NOT NULL GROUP BY author) AS t ON (p.player_id=t.author) 
		RIGHT JOIN (SELECT player, num FROM uo_played WHERE game='%s') as pel ON (p.player_id=pel.player) 
			WHERE p.team='%s' 
		ORDER BY done DESC, lastname ASC, firstname ASC",
		$database->RealEscapeString($gameId),
		$database->RealEscapeString($gameId),
		$database->RealEscapeString($teamId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $result;
}

function GameScoreBoard($database, $gameId)
{
	$query = sprintf(
		"
		SELECT p.profile_id, p.player_id, p.firstname, p.lastname, pj.name AS teamname, COALESCE(t.done,0) AS done, COALESCE(s.fedin,0) AS fedin, 
			(COALESCE(t.done,0) + COALESCE(s.fedin,0)) AS total 
		FROM uo_player AS p LEFT JOIN (SELECT m.scorer AS scorer, COUNT(*) AS done 
		FROM uo_goal AS m WHERE m.game='%s' AND m.scorer IS NOT NULL
			GROUP BY scorer) AS t ON (p.player_id=t.scorer) 
		LEFT JOIN (SELECT m2.assist AS assist, COUNT(*) AS fedin
		FROM uo_goal AS m2 WHERE m2.game='%s' AND m2.assist IS NOT NULL
			GROUP BY assist) AS s ON (p.player_id=s.assist) 
		RIGHT JOIN (SELECT player, num FROM uo_played
			WHERE game='%s') as pel ON (p.player_id=pel.player)
		LEFT JOIN uo_team pj ON (pj.team_id=p.team) WHERE p.profile_id IS NOT NULL AND p.lastname IS NOT NULL 
		ORDER BY p.profile_id ",
		$database->RealEscapeString($gameId),
		$database->RealEscapeString($gameId),
		$database->RealEscapeString($gameId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $result;
}

function GameGoals($database, $gameId)
{
	$query = sprintf(
		"
		SELECT m.*, s.firstname AS assistfirstname, s.lastname AS assistlastname, t.firstname AS scorerfirstname, t.lastname AS scorerlastname 
		FROM (uo_goal AS m LEFT JOIN uo_player AS s ON (m.assist = s.player_id)) 
		LEFT JOIN uo_player AS t ON (m.scorer=t.player_id) 
		WHERE m.game='%s' 
		ORDER BY m.num",
		$database->RealEscapeString($gameId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $result;
}

function GameDefenses($database, $gameId)
{
	$query = sprintf(
		"
		SELECT m.*, s.firstname AS defenderfirstname, s.lastname AS defenderlastname 
		FROM (uo_defense AS m LEFT JOIN uo_player AS s ON (m.author = s.player_id))
		WHERE m.game='%s' 
		ORDER BY m.num",
		$database->RealEscapeString($gameId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $result;
}


function GameLastGoal($database, $gameId)
{
	$query = sprintf(
		"
		SELECT m.*, s.firstname AS assistfirstname, s.lastname AS assistlastname, t.firstname AS scorerfirstname, t.lastname AS scorerlastname 
		FROM (uo_goal AS m LEFT JOIN uo_player AS s ON (m.assist = s.player_id)) 
		LEFT JOIN uo_player AS t ON (m.scorer=t.player_id) 
		WHERE m.game='%s' 
		ORDER BY m.num DESC",
		$database->RealEscapeString($gameId)
	);

	return $database->DBQueryToRow($query);
}

function GameAllGoals($database, $gameId)
{
	$query = sprintf(
		"
		SELECT num,time,ishomegoal 
		FROM uo_goal 
		WHERE game='%s' 
		ORDER BY time",
		$database->RealEscapeString($gameId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $result;
}

function GameEvents($database, $gameId)
{
	$query = sprintf(
		"
		SELECT time,ishome,type 
		FROM (SELECT time,ishome,'timeout' AS type FROM `uo_timeout` 
			WHERE game='%s' UNION ALL SELECT time,ishome,type FROM uo_gameevent WHERE game='%s') AS tapahtuma 
		WHERE type!='media'
		ORDER BY time ",
		$database->RealEscapeString($gameId),
		$database->RealEscapeString($gameId)
	);

	return $database->DBQueryToArray($query);
}

function GameMediaEvents($database, $gameId)
{
	$query = sprintf(
		"
		SELECT u.time, u.ishome, u.type as eventtype, u.info, urls.*
		FROM uo_gameevent u
		LEFT JOIN uo_urls urls ON(u.info=urls.url_id)
		WHERE u.game=%d AND u.type='media'
		ORDER BY time ",
		(int)$gameId
	);

	return $database->DBQueryToArray($query);
}

function AddGameMediaEvent($database, $gameId, $time, $urlId)
{
	if (hasAddMediaRight()) {
		$lastnum = $database->DBQueryToValue("SELECT MAX(num) FROM uo_gameevent WHERE game=" . intval($gameId));
		$lastnum = intval($lastnum) + 1;

		$query = sprintf(
			"INSERT INTO uo_gameevent (game,num,ishome,time,type,info)
				VALUES(%d,$lastnum,0,%d,'media',%d)",
			(int)$gameId,
			(int)$time,
			(int)$urlId
		);
		$database->DBQuery($query);
		return $database->GetConnection()->insert_id;
	} else {
		die('Insufficient rights to add media');
	}
}

function RemoveGameMediaEvent($database, $gameId, $urlId)
{
	if (hasAddMediaRight()) {
		$query = sprintf(
			"DELETE FROM uo_gameevent WHERE game=%d AND info=%d",
			(int)$gameId,
			(int)$urlId
		);
		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to remove media');
	}
}

function GameTimeouts($database, $gameId)
{
	$query = sprintf(
		"
		SELECT num,time,ishome 
		FROM uo_timeout 
		WHERE game='%s' 
		ORDER BY time",
		$database->RealEscapeString($gameId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $result;
}

function GameTurnovers($database, $gameId)
{
	$query = sprintf(
		"
		SELECT time, ishome 
		FROM uo_gameevent 
		WHERE game='%s' AND type='turnover' 
		ORDER BY time",
		$database->RealEscapeString($gameId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $result;
}

function GameInfo($database, $gameId)
{
	$query = sprintf(
		"SELECT game_id, hometeam, kj.name as hometeamname, kj.abbreviation as hometeamshortname, visitorteam, vj.name as visitorteamname, vj.abbreviation as visitorteamshortname, pp.pool as pool,
			time, homescore, visitorscore, pool.timecap, pool.scorecap, pool.winningscore, pool.drawsallowed, pool.timeslot AS timeslot, 
			pp.timeslot AS gametimeslot, pool.series, pool.color, ser.season, ser.name AS seriesname,
			pool.name AS poolname, phome.name AS phometeamname, pvisitor.name AS pvisitorteamname, pp.scheduling_name_home,
			pp.scheduling_name_visitor, isongoing, hasstarted, pl.name AS placename, res.fieldname, sname.name AS gamename,
			kj.valid as homevalid, vj.valid as visitorvalid
		FROM uo_game pp 
			left join uo_reservation res on (pp.reservation=res.id) 
			LEFT JOIN uo_location pl ON (res.location=pl.id)
			left join uo_pool pool on (pp.pool=pool.pool_id)
			left join uo_series ser on (ser.series_id=pool.series)
			left join uo_team kj on (pp.hometeam=kj.team_id)
			left join uo_team vj on (pp.visitorteam=vj.team_id)
			LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
			LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)
			LEFT JOIN uo_scheduling_name AS sname ON (pp.name=sname.scheduling_id)
		WHERE pp.game_id=%d",
		(int)$gameId
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	return $database->FetchAssoc($result);
}


function GameName($database, $gameInfo)
{
	if ($gameInfo['hometeam'] && $gameInfo['visitorteam']) {
		return ShortDate($gameInfo['time']) . " " . DefHourFormat($gameInfo['time']) . " " . $gameInfo['hometeamname'] . "-" . $gameInfo['visitorteamname'];
	} else {
		return ShortDate($gameInfo['time']) . " " . DefHourFormat($gameInfo['time']) . " " . $gameInfo['phometeamname'] . "-" . $gameInfo['pvisitorteamname'];
	}
}

function GameHasStarted($gameInfo)
{
	return $gameInfo['hasstarted'] > 0;
}

function CheckGameResult($database, $game, $home, $away)
{
	$gameId = (int) substr($game, 0, -1);
	$errors = "";
	if ($gameId == 0 || !checkChkNum($game)) {
		$errors .= "<p class='warning'>" . _("Erroneous scoresheet number:") . " " . $game . "</p>";
	} else {
		$pool = GamePool($database, $gameId);
		if (!$pool) {
			$errors .= "<p class='warning'>" . _("Game has no pool.") . "</p>";
		} else {
			if (IsPoolLocked($pool)) {
				$errors .= "<p class='warning'>" . _("Pool is locked.") . "</p>";
			}
		}
	}
	if (IsSeasonStatsCalculated($database, GameSeason($database, $gameId))) {
		$errors .= "<p class='warning'>" . _("Event played.") . "</p>";
	}
	if (!($home + $away)) {
		$errors .= "<p class='warning'>" . _("No goals.") . "</p>";
	}
	return $errors;
}

function GameUpdateResult($database, $gameId, $home, $away)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"UPDATE uo_game SET homescore='%s', visitorscore='%s', isongoing='1', hasstarted='1' WHERE game_id='%s'",
			$database->RealEscapeString($home),
			$database->RealEscapeString($away),
			$database->RealEscapeString($gameId)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameSetResult($database, $gameId, $home, $away, $updatePools = true, $checkRights = true)
{
	if (!$checkRights || hasEditGameEventsRight($database, $gameId)) {
		LogGameUpdate($database, $gameId, "result: $home - $away");
		$query = sprintf(
			"UPDATE uo_game SET homescore='%s', visitorscore='%s', isongoing='0', hasstarted='2' WHERE game_id='%s'",
			$database->RealEscapeString($home),
			$database->RealEscapeString($away),
			$database->RealEscapeString($gameId)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		if ($updatePools) {
			$poolId = GamePool($database, $gameId);
			ResolvePoolStandings($database, $poolId);
			PoolResolvePlayed($database, $poolId);
		}
		if (IsTwitterEnabled()) {
			TweetGameResult($database, $gameId);
		}
		if (IsFacebookEnabled()) {
			TriggerFacebookEvent($gameId, "game", 0);
		}
		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameClearResult($database, $gameId, $updatepools = true)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		LogGameUpdate($database, $gameId, "result cleared");
		$query = sprintf(
			"UPDATE uo_game SET homescore=NULL, visitorscore=NULL, isongoing='0', hasstarted='0' WHERE game_id='%s'",
			$database->RealEscapeString($gameId)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		if ($updatepools) {
			$poolId = GamePool($database, $gameId);
			ResolvePoolStandings($database, $poolId);
			PoolResolvePlayed($database, $poolId);
		}
		if (IsTwitterEnabled()) {
			TweetGameResult($database, $gameId);
		}
		if (IsFacebookEnabled()) {
			TriggerFacebookEvent($gameId, "game", 0);
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameSetDefenses($database, $gameId, $home, $away)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"UPDATE uo_game SET homedefenses='%s', visitordefenses='%s' WHERE game_id='%s'",
			$database->RealEscapeString($home),
			$database->RealEscapeString($away),
			$database->RealEscapeString($gameId)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		if (IsFacebookEnabled()) {
			TriggerFacebookEvent($gameId, "game", 0);
		}
		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameAddPlayer($database, $gameId, $playerId, $number)
{
	if (hasEditGamePlayersRight($database, $gameId)) {
		$query = sprintf(
			"INSERT INTO uo_played 
			(game, player, num, accredited) 
			VALUES ('%s', '%s', '%s', %d)
			ON DUPLICATE KEY UPDATE num=%d",
			$database->RealEscapeString($gameId),
			$database->RealEscapeString($playerId),
			$database->RealEscapeString($number),
			(int)isAccredited($database, $playerId),
			$database->RealEscapeString($number)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		$query = sprintf(
			"UPDATE uo_player SET num=%d WHERE player_id=%d",
			(int)$number,
			(int)$playerId
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameAddNewPlayer($database, $gameId, $firstname, $lastname, $accrid, $teamId, $number)
{
	if (hasEditGamePlayersRight($database, $gameId)) {
		$query = sprintf(
			"INSERT INTO uo_player (firstname, lastname, team) VALUES ('%s', '%s', %d)",
			$database->RealEscapeString($firstname),
			$database->RealEscapeString($lastname),
			(int)$teamId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		$playerId = $database->GetConnection()->insert_id;

		GameAddPlayer($database, $gameId, $playerId, $number);
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameRemovePlayer($database, $gameId, $playerId)
{
	if (hasEditGamePlayersRight($database, $gameId)) {
		$query = sprintf(
			"
			DELETE FROM uo_played 
			WHERE game='%s' AND player='%s'",
			$database->RealEscapeString($gameId),
			$database->RealEscapeString($playerId)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameRemoveAllPlayers($database, $gameId)
{
	if (hasEditGamePlayersRight($database, $gameId)) {
		$query = sprintf(
			"
			DELETE FROM uo_played
			WHERE game='%s'",
			$database->RealEscapeString($gameId)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameSetPlayerNumber($database, $gameId, $playerId, $number)
{
	if (hasEditGamePlayersRight($database, $gameId)) {
		$query = sprintf(
			"
			UPDATE uo_played 
			SET num='%s', accredited=%d 
			WHERE game=%d AND player=%d",
			$database->RealEscapeString($number),
			(int)isAccredited($database, $playerId),
			(int)$gameId,
			(int)$playerId
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameRemoveAllScores($database, $gameId)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"
			DELETE FROM uo_goal 
			WHERE game='%s'",
			$database->RealEscapeString($gameId)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameRemoveAllDefenses($database, $gameId)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"
			DELETE FROM uo_defense 
			WHERE game='%s'",
			$database->RealEscapeString($gameId)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}


function GameRemoveScore($database, $gameId, $num)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"
			DELETE FROM uo_goal 
			WHERE game='%s' AND num=%d",
			$database->RealEscapeString($gameId),
			(int)$num
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

/**
 * Add goal to game. Does not update game result!
 * 
 */
function GameAddScore($database, $gameId, $pass, $goal, $time, $number, $hscores, $ascores, $home, $iscallahan)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"
			INSERT INTO uo_goal 
			(game, num, assist, scorer, time, homescore, visitorscore, ishomegoal, iscallahan) 
			VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
			ON DUPLICATE KEY UPDATE 
			assist='%s', scorer='%s', time='%s', homescore='%s', visitorscore='%s', ishomegoal='%s', iscallahan='%s'",
			$database->RealEscapeString($gameId),
			$database->RealEscapeString($number),
			$database->RealEscapeString($pass),
			$database->RealEscapeString($goal),
			$database->RealEscapeString($time),
			$database->RealEscapeString($hscores),
			$database->RealEscapeString($ascores),
			$database->RealEscapeString($home),
			$database->RealEscapeString($iscallahan),
			$database->RealEscapeString($pass),
			$database->RealEscapeString($goal),
			$database->RealEscapeString($time),
			$database->RealEscapeString($hscores),
			$database->RealEscapeString($ascores),
			$database->RealEscapeString($home),
			$database->RealEscapeString($iscallahan)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		if (IsFacebookEnabled()) {
			TriggerFacebookEvent($gameId, "goal", $number);
		}
		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameAddDefense($database, $gameId, $player, $home, $caught, $time, $iscallahan, $number)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"
			INSERT INTO uo_defense 
			(game, num, author, time, iscallahan, iscaught, ishomedefense) 
			VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s') 
			ON DUPLICATE KEY UPDATE 
			author='%s', time='%s', iscallahan='%s', iscaught='%s', ishomedefense='%s'",
			$database->RealEscapeString($gameId),
			$database->RealEscapeString($number),
			$database->RealEscapeString($player),
			$database->RealEscapeString($time),
			$database->RealEscapeString($iscallahan),
			$database->RealEscapeString($caught),
			$database->RealEscapeString($home),
			$database->RealEscapeString($player),
			$database->RealEscapeString($time),
			$database->RealEscapeString($iscallahan),
			$database->RealEscapeString($caught),
			$database->RealEscapeString($home)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		/*if (IsFacebookEnabled()) {
			TriggerFacebookEvent($gameId, "goal", $number);
		}*/
		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameAddScoreEntry($database, $uo_goal)
{
	if (hasEditGameEventsRight($database, $uo_goal['game'])) {
		$query = sprintf(
			"
			INSERT INTO uo_goal 
			(game, num, assist, scorer, time, homescore, visitorscore, ishomegoal, iscallahan) 
			VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
			$database->RealEscapeString($uo_goal['game']),
			$database->RealEscapeString($uo_goal['num']),
			$database->RealEscapeString($uo_goal['assist']),
			$database->RealEscapeString($uo_goal['scorer']),
			$database->RealEscapeString($uo_goal['time']),
			$database->RealEscapeString($uo_goal['homescore']),
			$database->RealEscapeString($uo_goal['visitorscore']),
			$database->RealEscapeString($uo_goal['ishomegoal']),
			$database->RealEscapeString($uo_goal['iscallahan'])
		);

		$result = $database->DBQuery($query);

		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		if (IsFacebookEnabled()) {
			TriggerFacebookEvent($database, $gameId, "goal", $number);
		}
		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameRemoveAllTimeouts($database, $gameId)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"
			DELETE FROM uo_timeout 
			WHERE game='%s'",
			$database->RealEscapeString($gameId)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameAddTimeout($database, $gameId, $number, $time, $home)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"
			INSERT INTO uo_timeout 
			(game, num, time, ishome) 
			VALUES ('%s', '%s', '%s', '%s')",
			$database->RealEscapeString($gameId),
			$database->RealEscapeString($number),
			$database->RealEscapeString($time),
			$database->RealEscapeString($home)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameGetSpiritPoints($database, $gameId, $teamId)
{
	$query = sprintf(
		"SELECT * FROM uo_spirit_score WHERE game_id=%d AND team_id=%d",
		(int)$gameId,
		(int)$teamId
	);
	$scores = $database->DBQueryToArray($query);
	$points = array();
	foreach ($scores as $score) {
		$points[$score['category_id']] = $score['value'];
	}
	return $points;
}

function GameSetSpiritPoints($database, $gameId, $teamId, $home, $points, $categories)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		$query = sprintf(
			"DELETE FROM uo_spirit_score 
        WHERE game_id=%d AND team_id=%d",
			(int) $gameId,
			(int) $teamId
		);
		$database->DBQuery($query);

		foreach ($points as $cat => $value) {
			if (!is_null($value)) {
				$query = sprintf(
					"INSERT INTO uo_spirit_score (`game_id`, `team_id`, `category_id`, `value`)
            VALUES (%d, %d, %d, %d)",
					(int) $gameId,
					(int) $teamId,
					(int) $cat,
					(int) $value
				);
				$database->DBQuery($query);
			}
		}
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameSetScoreSheetKeeper($database, $gameId, $name)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		if (isset($name)) {
			$query = sprintf("
		UPDATE uo_game 
		SET official='%s' 
		WHERE game_id='%s'", $database->RealEscapeString($name), $database->RealEscapeString($gameId));
		} else {
			$query = sprintf("
		UPDATE uo_game
		SET official=NULL
		WHERE game_id='%s'", $database->RealEscapeString($gameId));
		}
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}


function GameSetHalftime($database, $gameId, $time)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		if (isset($time)) {
			$query = sprintf("
			UPDATE uo_game 
			SET halftime='%s' 
			WHERE game_id='%s'", $database->RealEscapeString($time), $database->RealEscapeString($gameId));
		} else {
			$query = sprintf("
			UPDATE uo_game 
			SET halftime=NULL 
			WHERE game_id='%s'", $database->RealEscapeString($gameId));
		}
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameSetCaptain($database, $gameId, $teamId, $playerId)
{
	if (hasEditGameEventsRight($database, $gameId)) {

		$captain = GameCaptain($database, $gameId, $teamId);

		if ($captain != $playerId) {
			$query = sprintf(
				"
				UPDATE uo_played 
				SET captain=0 
				WHERE game=%d AND player=%d",
				(int)$gameId,
				(int)$captain
			);

			$database->DBQuery($query);

			$query = sprintf(
				"
				UPDATE uo_played 
				SET captain=1 
				WHERE game=%d AND player=%d",
				(int)$gameId,
				(int)$playerId
			);

			$database->DBQuery($query);
		}
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameSetStartingTeam($database, $gameId, $home)
{
	if (hasEditGameEventsRight($database, $gameId)) {
		if ($home == NULL) {
			$query = sprintf(
				"DELETE FROM uo_gameevent WHERE game=%d AND type='offence'",
				(int)$gameId
			);

			$result = $database->DBQuery($query);
			if (!$result) {
				die('Invalid query: ' . $database->GetConnection()->error());
			}

			return $result;
		} else {
			$query = sprintf(
				"INSERT INTO uo_gameevent (game, num, time, type, ishome) VALUES (%d, 0, 0, 'offence', %d)
			ON DUPLICATE KEY UPDATE ishome='%d'",
				(int)$gameId,
				(int)$home,
				(int)$home
			);

			$result = $database->DBQuery($query);
			if (!$result) {
				die('Invalid query: ' . $database->GetConnection()->error());
			}

			return $result;
		}
	} else {
		die('Insufficient rights to edit game');
	}
}

function AddGame($database, $params)
{
	$poolinfo = PoolInfo($database, $params['pool']);
	if (hasEditGamesRight($database, $poolinfo['series'])) {
		$query = sprintf(
			"
			INSERT INTO uo_game
			(hometeam, visitorteam, reservation, time, pool, valid, respteam) 
			VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
			$database->RealEscapeString($params['hometeam']),
			$database->RealEscapeString($params['visitorteam']),
			$database->RealEscapeString($params['reservation']),
			$database->RealEscapeString($params['time']),
			$database->RealEscapeString($params['pool']),
			$database->RealEscapeString($params['valid']),
			$database->RealEscapeString($params['respteam'])
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		$id = $database->GetConnection()->insert_id;
		$query = sprintf(
			"
			INSERT INTO uo_game_pool
			(game, pool, timetable) 
			VALUES ('%s', '%s', 1)",
			$database->RealEscapeString($id),
			$database->RealEscapeString($params['pool'])
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		Log1($database, "game", "add", $id);
		return $id;
	} else {
		die('Insufficient rights to add game');
	}
}

function SetGame($database, $gameId, $params)
{
	$poolinfo = PoolInfo($database, $params['pool']);
	if (hasEditGamesRight($database, $poolinfo['series'])) {

		foreach ($params as $key => $param) {
			if (!empty($param)) {
				$query = sprintf(
					"
					UPDATE uo_game SET " . $key . "='%s' 
					WHERE game_id='%s'\n",
					$database->RealEscapeString($param),
					$database->RealEscapeString($gameId)
				);

				$result = $database->DBQuery($query);
			}
		}


		if (!empty($params['respteam'])) {
			$query = sprintf(
				"UPDATE uo_game SET respteam=%d
					WHERE game_id=%d",
				(int)$params['respteam'],
				(int)$gameId
			);

			$database->DBQuery($query);
		} else {
			$query = sprintf(
				"UPDATE uo_game SET respteam=NULL
					WHERE game_id=%d",
				(int)$gameId
			);

			$database->DBQuery($query);
		}

		if (!empty($params['name'])) {
			$query = sprintf(
				"INSERT INTO uo_scheduling_name 
				(name) VALUES ('%s')",
				$database->RealEscapeString($params['name'])
			);

			$nameId = $database->DBQueryInsert($query);

			$query = sprintf(
				"UPDATE uo_game SET
					name=%d	WHERE game_id=%d",
				(int)$nameId,
				(int)$gameId
			);
			$database->DBQuery($query);
		}

		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

/**
 * Swap home and visitor teams and results.
 */
function GameChangeHome($database, $gameId)
{
	$series = GameSeries($database, $gameId);
	if (hasEditGamesRight($database, $series)) {

		$query = sprintf(
			"SELECT hometeam,visitorteam,respteam, homescore,visitorscore, scheduling_name_home, scheduling_name_visitor FROM uo_game
					WHERE game_id=%d",
			(int)$gameId
		);
		$game = $database->DBQueryToRow($query);

		$query = sprintf(
			"UPDATE uo_game SET hometeam=%d,visitorteam=%d,homescore=%d,visitorscore=%d, scheduling_name_home=%d, scheduling_name_visitor=%d
					WHERE game_id=%d",
			(int) $game['visitorteam'],
			(int) $game['hometeam'],
			(int) $game['visitorscore'],
			(int) $game['homescore'],
			(int) $game['scheduling_name_visitor'],
			(int) $game['scheduling_name_home'],
			(int)$gameId
		);

		$database->DBQuery($query);
		if ($game['hometeam'] == $game['respteam']) {
			$query = sprintf(
				"UPDATE uo_game SET respteam=%d	WHERE game_id=%d",
				(int) $game['visitorteam'],
				(int)$gameId
			);
			$database->DBQuery($query);
		}
	} else {
		die('Insufficient rights to delete game');
	}
}

function GameChangeName($database, $gameId, $name)
{
	$gameinfo = GameInfo($database, $gameId);
	if (hasEditGamesRight($database, $gameinfo['series'])) {
		if (empty($gameinfo['name'])) {
			$query = sprintf(
				"INSERT INTO uo_scheduling_name 
				(name) VALUES ('%s')",
				$database->RealEscapeString($name)
			);
			$nameId = $database->DBQueryInsert($query);

			$query = sprintf(
				"UPDATE uo_game SET name=%d WHERE game_id=%d",
				(int)$nameId,
				(int)$gameId
			);
			$result = $database->DBQuery($query);
		} else {
			$query = sprintf(
				"UPADATE uo_scheduling_name SET 
				name='%s' WHERE scheduling_id=%d",
				$database->RealEscapeString($name),
				(int)$gameinfo['name']
			);
			$result = $database->DBQuery($query);
		}
		return $result;
	} else {
		die('Insufficient rights to edit game');
	}
}

function GameProcessMassInput($database, $post)
{
	$html = "";
	$scores = array();
	$changed = array();
	$ok_clear = 0;
	$ok_set = 0;
	$error_set = 0;
	$error_clear = 0;

	foreach ($post['scoreId'] as $key => $value) {
		$scores[$key]['gameid'] = $value;
	}
	foreach ($post['homescore'] as $key => $value) {
		$scores[$key]['home'] = $value;
	}
	foreach ($post['visitorscore'] as $key => $value) {
		$scores[$key]['visitor'] = $value;
	}
	foreach ($scores as $score) {
		$gameId = $score['gameid'];
		$game = GameInfo($database, $gameId);
		if ($game['homescore'] !== $score['home'] || $game['visitorscore'] !== $score['visitor']) {
			if ($score['home'] === "" && $score['visitor'] === "" && (!is_null($game['homescore']) || !is_null($game['visitorscore']))) {
				$ok = GameClearResult($database, $gameId, false);
				if ($ok) {
					$ok_clear++;
					$changed[GamePool($database, $gameId)] = 1;
				} else {
					$error_clear++;
				}
				// echo "clear $gameId";
			} else if ($score['home'] !== "" && $score['visitor'] !== "") {
				$ok = GameSetResult($database, $gameId, $score['home'], $score['visitor'], false);
				if ($ok) {
					$ok_set++;
					$changed[GamePool($database, $gameId)] = 1;
				} else {
					$error_set++;
				}
			}
		}
	}

	if ($ok_clear > 0)
		$html .= "<p>" . sprintf(_("Results cleared: %s."), $ok_clear) . "</p>";
	if ($ok_set > 0)
		$html .= "<p>" . sprintf(_("Results changed: %s."), $ok_set) . "</p>";
	if ($error_clear + $error_set > 0)
		$html .= "<p>" . sprintf(_("Errors: %s."), ($error_clear + $error_set)) . "</p>";

	foreach ($changed as $poolId => $ok) {
		if ($ok > 0) {
			ResolvePoolStandings($database, $poolId);
			PoolResolvePlayed($database, $poolId);
		}
	}

	return $html;
}

function DeleteGame($database, $gameId)
{
	$series = GameSeries($database, $gameId);
	if (hasEditGamesRight($database, $series)) {
		Log2($database, "game", "delete", GameNameFromId($database, $gameId));
		$query = sprintf(
			"DELETE FROM uo_game 
        WHERE game_id='%d'",
			(int) $gameId
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		$query = sprintf(
			"DELETE FROM uo_game_pool
        WHERE game='%d' AND timetable=1",
			(int) $gameId
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to delete game');
	}
}

function DeleteMovedGame($database, $gameId, $poolId)
{
	$series = GameSeries($database, $gameId);
	if (hasEditGamesRight($database, $series)) {
		Log1($database, "game", "delete", $gameId, $poolId, "Delete moved game");
		$query = sprintf(
			"DELETE FROM uo_game_pool 
		WHERE (game='%d' AND pool='%d' AND timetable='0')",
			(int) $gameId,
			(int) $poolId
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to delete game');
	}
}

function PoolDeleteAllGames($database, $poolId)
{
	$series = PoolSeries($database, $poolId);
	if (hasEditGamesRight($database, $series)) {
		Log1($database, "game", "delete", $poolId, 0, "Delete pool games");
		$query = sprintf(
			"DELETE FROM uo_game_pool
        WHERE pool=%d",
			$poolId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		$query = sprintf(
			"DELETE FROM uo_game 
        WHERE pool=%d",
			$poolId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		return $result;
	} else {
		die('Insufficient rights to delete game');
	}
}

function PoolSeries($database, $poolId)
{
	$query = sprintf(
		"SELECT pool_id
		FROM uo_pool
		WHERE series='%d'",
		(int) $poolId
	);
	return $database->DBQueryToValue($query);
}

function UnscheduledGameInfo($database, $teams = array())
{
	if (count($teams) == 0) {
		$query = "SELECT game_id FROM uo_game WHERE reservation IS NULL AND time IS NULL";
	} else {
		$fetch = array();
		foreach ($teams as $teamid) {
			$fetch[] = (int)$teamid;
		}
		$query = "SELECT game_id FROM uo_game WHERE reservation IS NULL AND time IS NULL AND
			hometeam IN (" . implode(",", $fetch) . ") AND visitorteam IN (" . implode(",", $fetch) . ")";
	}
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	$ret = array();
	while ($row = $result->fetch_row()) {
		$ret[$row[0]] = GameInfo($database, $row[0]);
	}
	return $ret;
}

function UnscheduledPoolGameInfo($database, $poolId)
{

	$query = sprintf(
		"SELECT game_id FROM uo_game 
		WHERE reservation IS NULL AND time IS NULL AND pool=%d
		ORDER BY game_id",
		(int)$poolId
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	$ret = array();
	while ($row = $result->fetch_row()) {
		$ret[$row[0]] = GameInfo($database, $row[0]);
	}
	return $ret;
}

function UnscheduledSeriesGameInfo($database, $seriesId)
{

	$query = sprintf(
		"SELECT game_id FROM uo_game 
		LEFT JOIN uo_pool pool ON(pool.pool_id=pool)
		WHERE reservation IS NULL AND time IS NULL AND pool.series=%d
		ORDER BY pool.ordering, game_id",
		(int)$seriesId
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	$ret = array();
	while ($row = $result->fetch_row()) {
		$ret[$row[0]] = GameInfo($database, $row[0]);
	}
	return $ret;
}

function UnscheduledSeasonGameInfo($database, $seasonId)
{

	$query = sprintf(
		"SELECT game_id FROM uo_game 
		LEFT JOIN uo_pool pool ON(pool.pool_id=pool)
		LEFT JOIN uo_series ser ON(ser.series_id=series)
		WHERE reservation IS NULL AND time IS NULL AND ser.season='%s'
		ORDER BY ser.ordering, pool.ordering, game_id",
		$database->RealEscapeString($seasonId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	$ret = array();
	while ($row = $result->fetch_row()) {
		$ret[$row[0]] = GameInfo($database, $row[0]);
	}
	return $ret;
}

function ScheduleGame($database, $gameId, $epoc, $reservation)
{
	if (hasEditGamesRight($database, GameSeries($database, $gameId))) {
		$query = sprintf(
			"UPDATE uo_game SET time='%s', reservation=%d WHERE game_id=%d",
			EpocToMysql($epoc),
			(int)$reservation,
			(int)$gameId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
	} else {
		die('Insufficient rights to schedule game');
	}
}

function UnScheduleGame($database, $gameId)
{
	if (hasEditGamesRight($database, GameSeries($database, $gameId))) {
		$query = sprintf(
			"UPDATE uo_game SET time=NULL, reservation=NULL WHERE game_id=%d",
			(int)$gameId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
	} else {
		die('Insufficient rights to schedule game');
	}
}

function ClearReservation($database, $reservationId)
{
	$result = ReservationGames($database, $reservationId);
	while ($row = $database->FetchAssoc($result)) {
		if (hasEditGamesRight($database, GameSeries($database, $row['game_id']))) {
			UnScheduleGame($database, $row['game_id']);
		} // else ignore games not managed by user
	}
}

function CanDeleteGame($database, $gameId)
{
	$query = sprintf(
		"SELECT count(*) FROM uo_goal WHERE game=%d",
		(int)$gameId
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	if (!$row = $result->fetch_row()) return false;
	if ($row[0] == 0) {
		$query = sprintf(
			"SELECT count(*) FROM uo_played WHERE game=%d",
			(int)$gameId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		if (!$row = $result->fetch_row()) return false;
		if ($row[0] == 0) {
			$query = sprintf(
				"SELECT count(*) FROM uo_gameevent WHERE game=%d",
				(int)$gameId
			);
			$result = $database->DBQuery($query);
			if (!$result) {
				die('Invalid query: ' . $database->GetConnection()->error());
			}
			if (!$row = $result->fetch_row()) return false;
			if ($row[0] == 0) {
				$query = sprintf(
					"SELECT homescore,visitorscore FROM uo_game WHERE game_id=%d",
					(int)$gameId
				);
				$result = $database->DBQuery($query);
				if (!$result) {
					die('Invalid query: ' . $database->GetConnection()->error());
				}
				if (!$row = $result->fetch_row()) return false;
				return (intval($row[0]) + intval($row[1])) == 0;
			} else return false; // FIXME test hasstarted?
		} else return false;
	} else return false;
}

function ResultsToCsv($database, $season, $separator)
{

	$query = sprintf(
		"SELECT kj.name as Home, vj.name as Away, 
			homescore AS HomeScores, visitorscore AS AwayScores, ser.name AS Division, pool.name AS Pool
		FROM uo_game pp 
			left join uo_reservation res on (pp.reservation=res.id) 
			left join uo_pool pool on (pp.pool=pool.pool_id)
			left join uo_series ser on (ser.series_id=pool.series)
			left join uo_team kj on (pp.hometeam=kj.team_id)
			left join uo_team vj on (pp.visitorteam=vj.team_id)
			LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
			LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)
		WHERE ser.season='%s' AND (hasstarted>0)
		ORDER BY ser.ordering, pool.ordering, pp.time ASC, pp.game_id ASC",
		$database->RealEscapeString($season)
	);

	$result = $database->DBQuery($query);
	return ResultsetToCsv($database, $result, $separator);
}

function SpiritTable($database, $gameinfo, $points, $categories, $home, $wide = true)
{
	$home = $home ? "home" : "vis";
	$html = "<table>\n";
	$html .= "<tr>";
	if ($wide)
		$html .= "<th style='width:70%;text-align: right;'></th>";
	$vmin = 99999;
	$vmax = -99999;
	foreach ($categories as $cat) {
		if ($vmin > $cat['min'])
			$vmin = $cat['min'];
		if ($vmax < $cat['max'])
			$vmax = $cat['max'];
	}

	if ($vmax - $vmin < 12) {
		$colspan = ($wide ? 3 : 2);
		$html .= "<th></th></tr>\n";

		foreach ($categories as $cat) {
			if ($cat['index'] == 0)
				continue;
			$id = $cat['category_id'];
			$html .= "<tr>";
			if ($wide)
				$html .= "<td style='width:70%'>";
			else
				$html .= "<td colspan='$colspan'>";
			$html .= _($cat['text']);
			$html .= "<input type='hidden' id='" . $home . "valueId$id' name='" . $home . "valueId[]' value='$id'/>";
			if ($wide)
				$html .= "</td>";
			else
				$html .= "</td></tr>\n<tr>";

			$html .= "<td><fieldset id='" . $home . "cat'" . $id . "_0' data-role='controlgroup' data-type='horizontal' >";
			for ($i = $vmin; $i <= $vmax; ++$i) {
				if ($i < $cat['min']) {
					// $html .= "<td></td>";
				} else {
					$id = $cat['category_id'];
					$checked = (isset($points[$id]) && !is_null($points[$id]) && $points[$id] == $i) ? "checked='checked'" : "";
					$html .= "<label for='" . $home . "cat" . $id . "_" . $i . "'>$i</label>";
					$html .= "<input type='radio' id='" . $home . "cat" . $id . "_" . $i . "' name='" . $home . "cat" . $id . "' value='$i' $checked/>";

					// $html .= "<td class='center'>
					// <input type='radio' id='".$home."cat".$id."_".$i."' name='".$home."cat". $id . "' value='$i'  $checked/></td>";
				}
			}
			$html .= "</fieldset></td>";
			$html .= "</tr>\n";
		}
	} else {
		$colspan = 2;
		$html .= "<th colspan='2'></th></tr>\n";

		foreach ($categories as $cat) {
			if ($cat['index'] == 0)
				continue;
			$id = $cat['category_id'];
			$html .= "<tr>";
			$html .= "<td style='width:70%'>" . _($cat['text']);
			$html .= "<input type='hidden' id='" . $home . "valueId$id' name='" . $home . "valueId[]' value='$id'/></td>";
			$html .= "<td class='center'>
      <input type='text' id='" . $home . "cat" . $id . "_0' name='" . $home . "cat$id' value='" . $points[$id] . "'/></td>";
			$html .= "</tr>\n";
		}
	}


	$html .= "<tr>";
	$html .= "<td class='highlight' colspan='$colspan'>" . _("Total points");
	$total = SpiritTotal($points, $categories);
	if (!isset($total))
		$total = ": -";
	else
		$html .= ": $total";
	$html .= "</tr>";

	$html .= "</table>\n";

	return $html;
}
