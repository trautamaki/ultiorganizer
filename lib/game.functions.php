<?php

// TODO Pool.php
function PoolDeleteAllGames($poolId)
{
	$series = PoolSeries($poolId);
	if (hasEditGamesRight($series)) {
		Log1("game", "delete", $poolId, 0, "Delete pool games");
		$query = sprintf(
			"DELETE FROM uo_game_pool
        WHERE pool=%d",
			$poolId
		);
		$result = GetDatabase()->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . GetDatabase()->SQLError());
		}

		$query = sprintf(
			"DELETE FROM uo_game 
        WHERE pool=%d",
			$poolId
		);
		$result = GetDatabase()->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . GetDatabase()->SQLError());
		}
		return $result;
	} else {
		die('Insufficient rights to delete game');
	}
}

function PoolSeries($poolId)
{
	$query = sprintf(
		"SELECT pool_id
		FROM uo_pool
		WHERE series='%d'",
		(int) $poolId
	);
	return GetDatabase()->DBQueryToValue($query);
}

function UnscheduledGameInfo($teams = array())
{
	if (count($teams) == 0) {
		$query = "SELECT game_id FROM uo_game WHERE reservation IS NULL AND time IS NULL";
	} else {
		$fetch = array();
		foreach ($teams as $teamid) {
			$fetch[] = (int) $teamid;
		}
		$query = "SELECT game_id FROM uo_game WHERE reservation IS NULL AND time IS NULL AND
			hometeam IN (" . implode(",", $fetch) . ") AND visitorteam IN (" . implode(",", $fetch) . ")";
	}
	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}
	$ret = array();
	while ($row = GetDatabase()->FetchRow($result)) {
		$ret[$row[0]] = GameInfo($row[0]);
	}
	return $ret;
}

function UnscheduledPoolGameInfo($poolId)
{

	$query = sprintf(
		"SELECT game_id FROM uo_game 
		WHERE reservation IS NULL AND time IS NULL AND pool=%d
		ORDER BY game_id",
		(int) $poolId
	);

	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}
	$ret = array();
	while ($row = GetDatabase()->FetchRow($result)) {
		$ret[$row[0]] = GameInfo($row[0]);
	}
	return $ret;
}

function UnscheduledSeriesGameInfo($seriesId)
{

	$query = sprintf(
		"SELECT game_id FROM uo_game 
		LEFT JOIN uo_pool pool ON(pool.pool_id=pool)
		WHERE reservation IS NULL AND time IS NULL AND pool.series=%d
		ORDER BY pool.ordering, game_id",
		(int) $seriesId
	);

	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}
	$ret = array();
	while ($row = GetDatabase()->FetchRow($result)) {
		$ret[$row[0]] = GameInfo($row[0]);
	}
	return $ret;
}

function UnscheduledSeasonGameInfo($seasonId)
{

	$query = sprintf(
		"SELECT game_id FROM uo_game 
		LEFT JOIN uo_pool pool ON(pool.pool_id=pool)
		LEFT JOIN uo_series ser ON(ser.series_id=series)
		WHERE reservation IS NULL AND time IS NULL AND ser.season='%s'
		ORDER BY ser.ordering, pool.ordering, game_id",
		GetDatabase()->RealEscapeString($seasonId)
	);

	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}
	$ret = array();
	while ($row = GetDatabase()->FetchRow($result)) {
		$ret[$row[0]] = GameInfo($row[0]);
	}
	return $ret;
}


function ClearReservation($reservationId)
{
	$result = ReservationGames($reservationId);
	foreach ($result as $game) {
		if (hasEditGamesRight($game->getSeries())) {
			$game->removeSchedule();
		} // else ignore games not managed by user
	}
}


function ResultsToCsv($season, $separator)
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
		GetDatabase()->RealEscapeString($season)
	);

	$result = GetDatabase()->DBQuery($query);
	return ResultsetToCsv($result, $separator);
}

// TODO: class spirit
function SpiritTable($gameinfo, $points, $categories, $home, $wide = true)
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
