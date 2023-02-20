<?php
include_once $include_prefix . 'lib/user.functions.php';


// TODO game.php?
function ResponsibleReservationGames($placeId, $gameResponsibilities)
{
	$query = "SELECT game_id, hometeam, kj.name as hometeamname, visitorteam,
			vj.name as visitorteamname, pp.pool as pool, time, homescore, visitorscore,
			pool.timecap, pool.timeslot, pool.series, 
			ser.name as seriesname, pool.name as poolname,
			loc.name as placename, res.fieldname,
			phome.name AS phometeamname, pvisitor.name AS pvisitorteamname, pool.color, pgame.name AS gamename
		FROM uo_game pp left join uo_reservation res on (pp.reservation=res.id) 
			left join uo_pool pool on (pp.pool=pool.pool_id)
			left join uo_series ser on (pool.series=ser.series_id)
			left join uo_location loc on (res.location=loc.id)
			left join uo_team kj on (pp.hometeam=kj.team_id)
			left join uo_team vj on (pp.visitorteam=vj.team_id)
			LEFT JOIN uo_scheduling_name AS pgame ON (pp.name=pgame.scheduling_id)
			LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
			LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)";
	if ($placeId)
		$query .= sprintf("WHERE res.id=%d", (int) $placeId);
	else
		$query .= "WHERE res.id IS NULL";
	$query .= " AND game_id IN (" . implode(",", $gameResponsibilities) . ")
		ORDER BY pp.time ASC";

	$result = GetDatabase()->DBQueryToArray($query);
	$games = array();
	foreach ($result as $game) {
		array_push($games, new Game(GetDatabase(), $game['game_id']));
	}
	return $games;
}

function ReservationSeasons($reservationId)
{
	$query = sprintf("SELECT DISTINCT ser.season FROM uo_game p 
		LEFT JOIN uo_pool pool ON (p.pool=pool.pool_id)
		LEFT JOIN uo_series ser ON (pool.series=ser.series_id)
		WHERE p.reservation=%d", (int)$reservationId);
	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}
	$ret = array();
	while ($row = GetDatabase()->FetchRow($result)) {
		$ret[] = $row[0];
	}
	return $ret;
}

function UnscheduledTeams()
{
	if (isSuperAdmin()) {
		$query = "SELECT team_id FROM uo_team WHERE team_id IN (SELECT hometeam FROM uo_game WHERE reservation IS NULL AND time IS NULL)
			OR team_id IN (SELECT visitorteam FROM uo_game WHERE reservation IS NULL AND time IS NULL)";
	} else {
		$query = "SELECT team_id FROM uo_team WHERE (team_id IN (SELECT hometeam FROM uo_game WHERE reservation IS NULL AND time IS NULL)
			OR team_id IN (SELECT visitorteam FROM uo_game WHERE reservation IS NULL AND time IS NULL)) AND (";
		$criteria = "";
		$first = true;
		if (isset($_SESSION['userproperties']['userrole']['seasonadmin'])) {
			foreach ($_SESSION['userproperties']['userrole']['seasonadmin'] as $season => $propId) {
				if ($first) {
					$first = false;
				} else {
					$criteria .= " OR ";
				}
				$criteria .= sprintf("series IN (SELECT series_id FROM uo_series WHERE season='%s')", GetDatabase()->RealEscapeString($season));
			}
		}
		if (isset($_SESSION['userproperties']['userrole']['seriesadmin'])) {
			$fetch = array();
			foreach ($_SESSION['userproperties']['userrole']['seriesadmin'] as $series => $propId) {
				$fetch[] = (int)$series;
			}
			if (!$first) {
				$criteria .= " OR ";
			}
			$criteria .= "series IN (" . implode(",", $fetch) . ")";
		}
		if (strlen($criteria) == 0) {
			return array();
		} else {
			$query .= $criteria . ")";
		}
	}
	echo "<!--" . $query . "-->\n";
	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}
	$ret = array();
	while ($row = GetDatabase()->FetchRow($result)) {
		$ret[] = $row[0];
	}
	return  $ret;
}