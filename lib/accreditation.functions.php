<?php
include_once $include_prefix . 'lib/player.functions.php';
include_once $include_prefix . 'lib/common.functions.php';

function SeasonUnaccredited($database, $season)
{
	$query = sprintf(
		"SELECT p.player_id, p.firstname, p.lastname, pt.name as teamname, 
		pt.team_id as team, ht.name as hometeamname, gt.name as visitorteamname, pp.time, 
		played.acknowledged, pp.game_id, pp.hometeam, pp.visitorteam
	FROM uo_played played 
		LEFT JOIN uo_player p ON (played.player=p.player_id)
		LEFT JOIN uo_game pp ON (played.game=pp.game_id)
		LEFT JOIN uo_team ht ON (pp.hometeam=ht.team_id)
		LEFT JOIN uo_team gt ON (pp.visitorteam=gt.team_id)
		LEFT JOIN uo_team pt ON (p.team=pt.team_id)
		LEFT JOIN uo_reservation res ON (pp.reservation=res.id)
		LEFT JOIN uo_location loc ON (res.location=loc.id)
		LEFT JOIN uo_pool pool ON (pp.pool=pool.pool_id)
		LEFT JOIN uo_series ser ON (pool.series=ser.series_id)
	WHERE played.accredited=0 AND ser.season='%s'",
		$database->RealEscapeString($season)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	return $result;
}

function AccreditPlayer($database, $playerId, $source)
{
	$playerInfo = PlayerInfo($database, $playerId);
	if (hasAccredidationRight($database, $playerInfo['team'])) {
		$query = sprintf(
			"UPDATE uo_player SET accredited=1 WHERE player_id=%d",
			(int)$playerId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		AccreditationLogEntry($database, $playerId, $playerInfo['team'], $source, 1);
		checkUserAdmin($database, $playerInfo);
		return $result;
	} else {
		die('Insufficient rights to accredit player');
	}
}

function ExternalLicenseValidityList($database)
{
	return $database->DBQueryToArray("SELECT DISTINCT external_validity FROM uo_license WHERE external_validity IS NOT NULL AND external_validity > 0");
}

function ExternalLicenseTypes($database)
{
	return $database->DBQueryToArray("SELECT DISTINCT external_type FROM uo_license WHERE external_type IS NOT NULL AND external_type > 0");
}

function LicenseData($database, $accreditation_id)
{
	return $database->DBQueryToRow("SELECT membership, license, external_id, external_type, external_validity, ultimate 
		FROM uo_license WHERE accreditation_id='" . $database->RealEscapeString($accreditation_id) . "'");
}

function checkUserAdmin($database, $playerInfo)
{
	// Check for existing user for player
	$query = sprintf(
		"SELECT userid FROM uo_userproperties WHERE name='userrole' AND value='playeradmin:%s'",
		$database->RealEscapeString($playerInfo['accreditation_id'])
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	if ($userid = $result->fetch_row()) {
		//Player already administered
		return;
	} else {
		//Check for matching emails
		if (validEmail($playerInfo['email'])) {
			$query = sprintf(
				"SELECT userid FROM uo_users  WHERE LOWER(email)='%s'",
				$database->RealEscapeString(strtolower($playerInfo['email']))
			);
			$result = $database->DBQuery($query);
			if (!$result) {
				die('Invalid query: ' . $database->GetConnection()->error());
			}
			if ($userId = $result->fetch_row()) {
				$id = $userId[0];
				$query = sprintf(
					"INSERT INTO uo_userproperties (userid, name, value) VALUES ('%s', 'userrole', 'playeradmin:%s')",
					$database->RealEscapeString($id),
					$database->RealEscapeString($playerInfo['profile_id'])
				);
				$result = $database->DBQuery($query);
				if (!$result) {
					die('Invalid query: ' . $database->GetConnection()->error());
				}
				return true;
			}
		} else {
			return false;
		}
	}
}

function DeAccreditPlayer($database, $playerId, $source)
{
	$playerInfo = PlayerInfo($database, $playerId);
	if (hasAccredidationRight($database, $playerInfo['team']) || hasEditPlayersRight($database, $playerInfo['team'])) {
		$query = sprintf(
			"UPDATE uo_player SET accredited=0 WHERE player_id=%d",
			(int)$playerId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		AccreditationLogEntry($database, $playerId, $playerInfo['team'], $source, 0);
		return $result;
	} else {
		die('Insufficient rights to accredit player');
	}
}

function AccreditationLogEntry($database, $player, $team, $source, $value, $game = NULL)
{
	if (!isset($game)) {
		$gameVal = "NULL";
	} else {
		$gameVal = (int)$game;
	}
	$query = sprintf(
		"INSERT INTO uo_accreditationlog (player, team, userid, source, value, time, game) VALUES (%d, %d, '%s', '%s', %d, now(), %s)",
		(int)$player,
		(int)$team,
		$database->RealEscapeString($_SESSION['uid']),
		$database->RealEscapeString($source),
		(int)$value,
		$gameVal
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
}

function isAccredited($database, $playerId)
{
	$playerInfo = PlayerInfo($database, $playerId);
	if (isset($playerInfo['accredited'])) return $playerInfo['accredited'];
	else return 0;
}

function AcknowledgeUnaccredited($database, $playerId, $gameId, $source)
{
	$playerInfo = PlayerInfo($database, $playerId);
	if (hasAccredidationRight($database, $playerInfo['team'])) {
		$query = sprintf(
			"UPDATE uo_played SET acknowledged=1 WHERE player=%d AND game=%d",
			(int)$playerId,
			(int)$gameId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		AccreditationLogEntry($database, $playerId, $playerInfo['team'], $source, 1, $gameId);
		return $result;
	} else {
		die('Insufficient rights to accredit player');
	}
}

function UnAcknowledgeUnaccredited($database, $playerId, $gameId, $source)
{
	$playerInfo = PlayerInfo($database, $playerId);
	if (hasAccredidationRight($database, $playerInfo['team'])) {
		$query = sprintf(
			"UPDATE uo_played SET acknowledged=0 WHERE player=%d AND game=%d",
			(int)$playerId,
			(int)$gameId
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		AccreditationLogEntry($database, $playerId, $playerInfo['team'], $source, 0, $gameId);
		return $result;
	} else {
		die('Insufficient rights to accredit player');
	}
}

function AccreditPlayerByAccrId($database, $accrId, $seriesId, $source)
{
	if ($playerInfo = PlayerInfoByAccrId($database, $accrId, $seriesId)) {
		if (!$playerInfo['accredited']) {
			AccreditPlayer($database, $playerInfo['player_id'], $source);
		}
	}
}

function DeAccreditPlayerByAccrId($database, $accrId, $seriesId, $source)
{
	if ($playerInfo = PlayerInfoByAccrId($database, $accrId, $seriesId)) {
		if ($playerInfo['accredited']) {
			DeAccreditPlayer($database, $playerInfo['player_id'], $source);
		}
	}
}

function SeasonAccreditationLog($database, $season)
{
	$query = sprintf(
		"SELECT p.player_id, p.firstname, p.lastname, pt.name as teamname, 
			pt.team_id as team, ht.name as hometeamname, gt.name as visitorteamname, pp.time as gametime, 
			log.value, pp.game_id, user.name as uname, user.email, log.source, log.time, log.game,
			pp.hometeam, pp.visitorteam
		FROM uo_accreditationlog log 
			LEFT JOIN uo_player p ON (log.player=p.player_id)
			LEFT JOIN uo_game pp ON (log.game=pp.game_id)
			LEFT JOIN uo_team ht ON (pp.hometeam=ht.team_id)
			LEFT JOIN uo_team gt ON (pp.visitorteam=gt.team_id)
			LEFT JOIN uo_team pt ON (p.team=pt.team_id)
			LEFT JOIN uo_reservation res ON (pp.reservation=res.id)
			LEFT JOIN uo_location loc ON (res.location=loc.id)
			LEFT JOIN uo_series ser ON (pt.series=ser.series_id)
			LEFT JOIN uo_users user ON (log.userid=user.userid)
		WHERE ser.season='%s'
		ORDER BY log.time DESC",
		$database->RealEscapeString($season)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	return $result;
}
