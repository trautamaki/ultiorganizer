<?php

function GetSearchLocations()
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
			GetDatabase()->RealEscapeString($locale),
			GetDatabase()->RealEscapeString($search),
			GetDatabase()->RealEscapeString($search)
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
			GetDatabase()->RealEscapeString($locale),
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
			GetDatabase()->RealEscapeString($locale)
		);
	}
	$result1 = GetDatabase()->DBQuery($query1);

	if (!$result1) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}
	return $result1;
}

function LocationInfo($id)
{
	$locale = str_replace(".", "_", getSessionLocale());
	$query = sprintf("SELECT id, name, fields, indoor, address, inf.info as info, lat, lng 
	    FROM uo_location loc LEFT JOIN uo_location_info inf ON ( loc.id = inf.location_id and inf.locale='%s' )
	    WHERE id=%d", GetDatabase()->RealEscapeString($locale), (int)$id);
	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}
	return GetDatabase()->FetchAssoc($result);
}

function SetLocation($id, $name, $address, $info, $fields, $indoor, $lat, $lng, $season)
{
	if (isSuperAdmin() || isSeasonAdmin($season)) {
		$query = sprintf(
			"UPDATE uo_location SET name='%s', address='%s', fields=%d, indoor=%d, lat='%s', lng='%s'  WHERE id=%d",
			GetDatabase()->RealEscapeString($name),
			GetDatabase()->RealEscapeString($address),
			(int)$fields,
			(int)$indoor,
			GetDatabase()->RealEscapeString($lat),
			GetDatabase()->RealEscapeString($lng),
			(int)$id
		);
		$result = GetDatabase()->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . GetDatabase()->SQLError());
		}

		updateInfos($id, $info);
	} else {
		die('Insufficient rights to change location');
	}
}

function updateInfos($id, $info)
{
	foreach ($info as $locale => $infostr) {
		if (empty($infostr)) {
			$query = sprintf(
				"DELETE FROM uo_location_info WHERE location_id=%d AND locale='%s'",
				(int)$id,
				GetDatabase()->RealEscapeString($locale)
			);
		} else {
			$query = sprintf(
				"INSERT INTO uo_location_info (location_id, locale, info) VALUE (%d, '%s', '%s')
		    ON DUPLICATE KEY UPDATE info='%s'",
				(int)$id,
				GetDatabase()->RealEscapeString($locale),
				GetDatabase()->RealEscapeString($infostr),
				GetDatabase()->RealEscapeString($infostr)
			);
		}
		$result = GetDatabase()->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . GetDatabase()->SQLError());
		}
	}
}

function AddLocation($name, $address, $info, $fields, $indoor, $lat, $lng, $season)
{
	if (isSuperAdmin() || isSeasonAdmin($season)) {
		$query = sprintf(
			"INSERT INTO uo_location (name, address, fields, indoor, lat, lng)
	       VALUES ('%s', '%s', %d, %d, '%s', '%s')",
			GetDatabase()->RealEscapeString($name),
			GetDatabase()->RealEscapeString($address),
			(int)$fields,
			(int)$indoor,
			GetDatabase()->RealEscapeString($lat),
			GetDatabase()->RealEscapeString($lng)
		);

		$result = GetDatabase()->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . GetDatabase()->SQLError());
		}

		$locationId = GetDatabase()->InsertID();

		updateInfos($locationId, $info);

		return $locationId;
	} else {
		die('Insufficient rights to add location');
	}
}

function RemoveLocation($id)
{
	if (isSuperAdmin()) {
		$query = sprintf("DELETE FROM uo_location WHERE id=%d", (int)$id);
		$result = GetDatabase()->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . GetDatabase()->SQLError());
		}

		$query = sprintf("DELETE FROM uo_location_info WHERE location_id=%d", (int)$id);
		$result = GetDatabase()->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . GetDatabase()->SQLError());
		}
	} else {
		die('Insufficient rights to remove location');
	}
}
