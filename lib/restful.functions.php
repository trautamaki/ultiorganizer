<?php

function paramHandled($param)
{
	$query_string = $_SERVER['QUERY_STRING'];
	$query_string = StripFromQueryString($query_string, $param);
	$_SERVER['QUERY_STRING'] = $query_string;
	unset($_GET[$param]);
}

function PlayerInfod($playerId)
{
	$query = sprintf(
		"SELECT p.player_id, CONCAT(p.firstname, ' ', p.lastname) as name, p.firstname, 
		p.lastname, p.num, p.accreditation_id, p.team, t.name AS teamname, p.accredited, 
		p.team, t.series, ser.type, ser.name AS seriesname, pp.profile_image, p.email, pp.gender,
		pp.birthdate
		FROM uo_player p 
		LEFT JOIN uo_team t ON (p.team=t.team_id) 
		LEFT JOIN uo_series ser ON (ser.series_id=t.series)
		LEFT JOIN uo_player_profile pp ON (p.accreditation_id=pp.accreditation_id)
		WHERE player_id='%s'",
		$database->RealEscapeString($playerId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return $database->FetchAssoc($result);
}

function Playersd($filter = null, $ordering = null)
{
	if (!isset($ordering)) {
		$ordering = array("season.starttime" => "ASC", "series.ordering" => "ASC", "pool.ordering" => "ASC");
	}
	$tables = array("uo_player" => "player", "uo_team" => "team", "uo_pool" => "pool", "uo_series" => "series", "uo_season" => "season");
	$orderby = CreateOrdering($database, $tables, $ordering);
	$where = CreateFilter($database, $tables, $filter);
	$query = "SELECT player.player_id, player.num, player.firstname, player.lastname, player.accredited, player.accreditation_id
		FROM uo_player player
		LEFT JOIN uo_team team ON (player.team=team.team_id)
		LEFT JOIN uo_pool pool ON (team.pool=pool.pool_id)
		LEFT JOIN uo_series series ON (team.series=series.series_id)
		LEFT JOIN uo_season season ON (series.season=season.season_id)
		$where $orderby";
	return $database->DBQuery(trim($query));
}

function PlayerprofileInfod($accreditation_id)
{
	$query = sprintf(
		"SELECT pp.*,p.firstname, p.lastname, p.num
		FROM uo_player_profile pp 
		LEFT JOIN uo_player p ON pp.accreditation_id=p.accreditation_id
		WHERE pp.accreditation_id='%s'",
		$database->RealEscapeString($accreditation_id)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	if (hasEditPlayerProfileRight($database, $accreditation_id)) {
		return $database->FetchAssoc($result);
	} else {
		$data = $database->FetchAssoc($result);
		$publicfields = explode("|", $data['public']);
		$ret = array();
		$ret['firstname'] = $data['firstname'];
		$ret['lastname'] = $data['lastname'];
		$ret['num'] = $data['num'];
		foreach ($publicfields as $fieldname) {
			if (isset($data[$fieldname])) {
				$ret[$fieldname] = $data[$fieldname];
			}
		}
		return $ret;
	}
}

function Playerprofilesd($filter = null, $ordering = null)
{
	if (!isset($ordering)) {
		$ordering = array("player.lastname" => "ASC", "player.firstname" => "ASC", "player_profile.birthdate" => "ASC");
	}

	$tables = array("uo_player" => "player", "uo_player_profile" => "player_profile", "uo_team" => "team", "uo_pool" => "pool", "uo_series" => "series", "uo_season" => "season");
	$orderby = CreateOrdering($database, $tables, $ordering);
	$where = CreateFilter($database, $tables, $filter);

	$query = "SELECT player_profile.accreditation_id as playerprofile_id,player.firstname, player.lastname, player.num
		FROM uo_player_profile player_profile 
		LEFT JOIN uo_player player ON (player_profile.accreditation_id=player.accreditation_id)
		LEFT JOIN uo_team team ON (player.team=team.team_id)
		LEFT JOIN uo_pool pool ON (team.pool=pool.pool_id)
		LEFT JOIN uo_series series ON (team.series=series.series_id)
		LEFT JOIN uo_season season ON (series.season=season.season_id)
		$where $orderby";

	return $database->DBQuery(trim($query));
}
