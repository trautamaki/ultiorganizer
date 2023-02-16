<?php

function EventCategories()
{
	return array("security", "user", "enrolment", "club", "team", "player", "season", "series", "pool", "game", "media");
}

function LogEvent($database, $event)
{
	if (empty($event['id1']))
		$event['id1'] = "";

	if (empty($event['id2']))
		$event['id2'] = "";

	if (empty($event['source']))
		$event['source'] = "";

	if (empty($event['description']))
		$event['description'] = "";

	if (strlen($event['description']) > 50)
		$event['description'] = substr($event['description'], 0, 50);

	if (strlen($event['id1']) > 20)
		$event['id1'] = substr($event['id1'], 0, 20);

	if (strlen($event['id2']) > 20)
		$event['id2'] = substr($event['id2'], 0, 20);

	if (empty($event['user_id'])) {
		if (!empty($_SESSION['uid']))
			$event['user_id'] = $_SESSION['uid'];
		else
			$event['user_id'] = "unknown";
	}

	$event['ip'] = "";
	if (!empty($_SERVER['REMOTE_ADDR']))
		$event['ip'] = $_SERVER['REMOTE_ADDR'];

	$query = sprintf(
		"INSERT INTO uo_event_log (user_id, ip, category, type, source,
			id1, id2, description)
				VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
		$database->RealEscapeString($event['user_id']),
		$database->RealEscapeString($event['ip']),
		$database->RealEscapeString($event['category']),
		$database->RealEscapeString($event['type']),
		$database->RealEscapeString($event['source']),
		$database->RealEscapeString($event['id1']),
		$database->RealEscapeString($event['id2']),
		$database->RealEscapeString($event['description'])
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error);
	}
	return $database->GetConnection()->insert_id;
}

function EventList($database, $categoryfilter, $userfilter)
{
	if (isSuperAdmin()) {
		if (count($categoryfilter) == 0) {
			return false;
		}
		$query = "SELECT * FROM uo_event_log WHERE ";

		$i = 0;
		foreach ($categoryfilter as $cat) {
			if ($i == 0) {
				$query .= "(";
			}
			if ($i > 0) {
				$query .= " OR ";
			}

			$query .= sprintf("category='%s'", $database->RealEscapeString($cat));
			$i++;
			if ($i == count($categoryfilter)) {
				$query .= ")";
			}
		}

		if (!empty($userfilter)) {
			$query .= sprintf("AND user_id='%s'", $database->RealEscapeString($userfilter));
		}
		$query .= " ORDER BY time DESC";
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error);
		}
		return $result;
	}
}

function ClearEventList($database, $ids)
{
	if (isSuperAdmin()) {
		$query = sprintf("DELETE FROM uo_event_log WHERE event_id IN (%s)", $database->RealEscapeString($ids));

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error);
		}
		return $result;
	}
}

function Log1($database, $category, $type, $id1 = "", $id2 = "", $description = "", $source = "")
{
	$event['category'] = $category;
	$event['type'] = $type;
	$event['id1'] = $id1;
	$event['id2'] = $id2;
	$event['description'] = $description;
	$event['source'] = $source;
	return LogEvent($database, $event);
}

function Log2($database, $category, $type, $description = "", $source = "")
{
	$event['category'] = $category;
	$event['type'] = $type;
	$event['description'] = $description;
	$event['source'] = $source;
	return LogEvent($database, $event);
}

function LogPlayerProfileUpdate($database, $playerId, $source = "")
{
	$event['category'] = "player";
	$event['type'] = "change";
	$event['source'] = $source;
	$event['id1'] = $playerId;
	$event['description'] = "profile updated";
	return LogEvent($database, $event);
}

function LogTeamProfileUpdate($database, $teamId, $source = "")
{
	$event['category'] = "team";
	$event['type'] = "change";
	$event['source'] = $source;
	$event['id1'] = $teamId;
	$event['description'] = "profile updated";
	return LogEvent($database, $event);
}

function LogUserAuthentication($database, $userId, $result, $source = "")
{
	$event['user_id'] = $userId;
	$event['category'] = "security";
	$event['type'] = "authenticate";
	$event['source'] = $source;
	$event['description'] = $result;
	return LogEvent($database, $event);
}

function LogGameResult($database, $gameId, $result, $source = "")
{
	$event['category'] = "game";
	$event['type'] = "change";
	$event['source'] = $source;
	$event['id1'] = $gameId;
	$event['description'] = $result;
	return LogEvent($database, $event);
}

function LogDefenseResult($database, $gameId, $result, $source = "")
{
	$event['category'] = "defense";
	$event['type'] = "change";
	$event['source'] = $source;
	$event['id1'] = $gameId;
	$event['description'] = $result;
	return LogEvent($database, $event);
}

function LogGameUpdate($database, $gameId, $details, $source = "")
{
	$event['category'] = "game";
	$event['type'] = "change";
	$event['source'] = $source;
	$event['id1'] = $gameId;
	$event['description'] = $details;
	return LogEvent($database, $event);
}

function LogDefenseUpdate($database, $gameId, $details, $source = "")
{
	$event['category'] = "defense";
	$event['type'] = "change";
	$event['source'] = $source;
	$event['id1'] = $gameId;
	$event['description'] = $details;
	return LogEvent($database, $event);
}

function GetLastGameUpdateEntry($database, $gameId, $source)
{
	$query = sprintf(
		"SELECT * FROM uo_event_log WHERE id1=%d AND source='%s' ORDER BY TIME DESC",
		(int)$gameId,
		$database->RealEscapeString($source)
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error);
	}
	return $database->FetchAssoc($result);
}

function LogPoolUpdate($database, $poolId, $details, $source = "")
{
	$event['category'] = "pool";
	$event['type'] = "change";
	$event['source'] = $source;
	$event['id1'] = $poolId;
	$event['description'] = $details;
	return LogEvent($database, $event);
}

function LogDbUpgrade($database, $version, $end = false, $source = "")
{
	$event['category'] = "database";
	$event['type'] = "change";
	$event['source'] = $source;
	$event['id1'] = $version;
	$event['description'] = $end ? "finished" : "started";
	return LogEvent($database, $event);
}

/**
 * Log page load into database for usage statistics.
 *
 * @param string $page
 *          - loaded page
 */
function LogPageLoad($database, $page)
{

	$query = sprintf(
		"SELECT loads FROM uo_pageload_counter WHERE page='%s'",
		$database->RealEscapeString($page)
	);
	$loads = $database->DBQueryToValue($query);

	if ($loads < 0) {
		$query = sprintf(
			"INSERT INTO uo_pageload_counter (page, loads) VALUES ('%s',%d)",
			$database->RealEscapeString($page),
			1
		);
		$database->DBQuery($query);
	} else {
		$loads++;
		$query = sprintf(
			"UPDATE uo_pageload_counter SET loads=%d WHERE page='%s'",
			$loads,
			$database->RealEscapeString($page)
		);
		$database->DBQuery($query);
	}
}

/**
 * Log visitors visit into database for usage statistics.
 * 
 * @param string $ip - ip address
 */
function LogVisitor($database, $ip)
{

	$query = sprintf(
		"SELECT visits FROM uo_visitor_counter WHERE ip='%s'",
		$database->RealEscapeString($ip)
	);
	$visits = $database->DBQueryToValue($query);

	if ($visits < 0) {
		$query = sprintf(
			"INSERT INTO uo_visitor_counter (ip, visits) VALUES ('%s',%d)",
			$database->RealEscapeString($ip),
			1
		);
		$database->DBQuery($query);
	} else {
		$visits++;
		$query = sprintf(
			"UPDATE uo_visitor_counter SET visits=%d WHERE ip='%s'",
			$visits,
			$database->RealEscapeString($ip)
		);
		$database->DBQuery($query);
	}
}

/**
 * Get visitor count.
 */
function LogGetVisitorCount($database)
{
	$query = sprintf("SELECT SUM(visits) AS visits, COUNT(ip) AS visitors FROM uo_visitor_counter");
	return $database->DBQueryToRow($query);
}

/**
 * Get page loads.
 */
function LogGetPageLoads($database)
{
	$query = sprintf("SELECT page, loads FROM uo_pageload_counter ORDER BY loads DESC");
	return $database->DBQueryToArray($query);
}
