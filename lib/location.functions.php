<?php

function GetSearchLocations($database)
{
	$locale = str_replace(".", "_", getSessionLocale());
	if (isset($_GET['search']) || isset($_GET['query']) || isset($_GET['q'])) {
		if (isset($_GET['search']))
			$search = $_GET['search'];
		elseif (isset($_GET['query']))
			$search = $_GET['query'];
		else
			$search = $_GET['q'];

		$query1 = sprintf(
			"SELECT loc.*, 
		    inf1.locale as locale, inf1.info as locale_info,  
		    inf2.locale as default_locale, inf2.info as info
		    FROM uo_location loc 
		    LEFT JOIN uo_location_info inf1 ON (loc.id = inf1.location_id)
		    LEFT JOIN uo_location_info inf2 ON (loc.id = inf2.location_id and inf2.locale='%s' )
		    WHERE (name like '%%%s%%' OR address like '%%%s%%') ORDER BY name",
			$database->RealEscapeString($locale),
			$database->RealEscapeString($search),
			$database->RealEscapeString($search)
		);
	} elseif (isset($_GET['id'])) {
		$query1 = sprintf(
			"SELECT loc.*, 
		    inf1.locale as locale, inf1.info as locale_info,  
		    inf2.locale as default_locale, inf2.info as info
		    FROM uo_location loc 
		    LEFT JOIN uo_location_info inf1 ON (loc.id = inf1.location_id)
		    LEFT JOIN uo_location_info inf2 ON (loc.id = inf2.location_id and inf2.locale='%s' )
	      WHERE id=%d ORDER BY name",
			$database->RealEscapeString($locale),
			(int)$_GET['id']
		);
	} else {
		$query1 = sprintf(
			"SELECT loc.*, 
		    inf1.locale as locale, inf1.info as locale_info,  
		    inf2.locale as default_locale, inf2.info as info
		    FROM uo_location loc 
		    LEFT JOIN uo_location_info inf1 ON (loc.id = inf1.location_id)
		    LEFT JOIN uo_location_info inf2 ON (loc.id = inf2.location_id and inf2.locale='%s' )
	      WHERE 1 ORDER BY name",
			$database->RealEscapeString($locale)
		);
	}
	$result1 = $database->DBQuery($query1);

	if (!$result1) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	return $result1;
}

function LocationInfo($database, $id)
{
	$locale = str_replace(".", "_", getSessionLocale());
	$query = sprintf("SELECT id, name, fields, indoor, address, inf.info as info, lat, lng 
	    FROM uo_location loc LEFT JOIN uo_location_info inf ON ( loc.id = inf.location_id and inf.locale='%s' )
	    WHERE id=%d", $database->RealEscapeString($locale), (int)$id);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	return $database->FetchAssoc($result);
}

function SetLocation($database, $id, $name, $address, $info, $fields, $indoor, $lat, $lng, $season)
{
	if (isSuperAdmin() || isSeasonAdmin($season)) {
		$query = sprintf(
			"UPDATE uo_location SET name='%s', address='%s', fields=%d, indoor=%d, lat='%s', lng='%s'  WHERE id=%d",
			$database->RealEscapeString($name),
			$database->RealEscapeString($address),
			(int)$fields,
			(int)$indoor,
			$database->RealEscapeString($lat),
			$database->RealEscapeString($lng),
			(int)$id
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		updateInfos($database, $id, $info);
	} else {
		die('Insufficient rights to change location');
	}
}

function updateInfos($database, $id, $info)
{
	foreach ($info as $locale => $infostr) {
		if (empty($infostr)) {
			$query = sprintf(
				"DELETE FROM uo_location_info WHERE location_id=%d AND locale='%s'",
				(int)$id,
				$database->RealEscapeString($locale)
			);
		} else {
			$query = sprintf(
				"INSERT INTO uo_location_info (location_id, locale, info) VALUE (%d, '%s', '%s')
		    ON DUPLICATE KEY UPDATE info='%s'",
				(int)$id,
				$database->RealEscapeString($locale),
				$database->RealEscapeString($infostr),
				$database->RealEscapeString($infostr)
			);
		}
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
	}
}

function AddLocation($database, $name, $address, $info, $fields, $indoor, $lat, $lng, $season)
{
	if (isSuperAdmin() || isSeasonAdmin($season)) {
		$query = sprintf(
			"INSERT INTO uo_location (name, address, fields, indoor, lat, lng)
	       VALUES ('%s', '%s', %d, %d, '%s', '%s')",
			$database->RealEscapeString($name),
			$database->RealEscapeString($address),
			(int)$fields,
			(int)$indoor,
			$database->RealEscapeString($lat),
			$database->RealEscapeString($lng)
		);

		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		$locationId = $database->GetConnection()->insert_id;

		updateInfos($database, $locationId, $info);

		return $locationId;
	} else {
		die('Insufficient rights to add location');
	}
}

function RemoveLocation($database, $id)
{
	if (isSuperAdmin()) {
		$query = sprintf("DELETE FROM uo_location WHERE id=%d", (int)$id);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		$query = sprintf("DELETE FROM uo_location_info WHERE location_id=%d", (int)$id);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
	} else {
		die('Insufficient rights to remove location');
	}
}
