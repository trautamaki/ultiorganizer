<?php
$serverConf = GetSimpleServerConf();
$locales = getAvailableLocalizations();

$twitterConfKeys = array("TwitterConsumerKey", "TwitterConsumerSecret", "TwitterOAuthCallback");
$facebookConfKeys = array("FacebookEnabled", "FacebookAppId", "FacebookAppSecret", "FacebookAppKey", "FacebookGameMessage", "FacebookUpdatePage", "FacebookUpdateId", "FacebookUpdateToken");

function SetTwitterKey($access_token, $purpose, $id)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"SELECT key_id	FROM uo_keys 
				WHERE type='twitter' AND purpose='%s' AND id='%s'",
			GetDatabase()->RealEscapeString($purpose),
			GetDatabase()->RealEscapeString($id)
		);

		$key_id = GetDatabase()->DBQueryToValue($query);

		if ($key_id >= 0) {
			$query = sprintf(
				"UPDATE uo_keys SET
				purpose='%s',id='%s',keystring='%s',secrets='%s'
				WHERE key_id=$key_id",
				GetDatabase()->RealEscapeString($purpose),
				GetDatabase()->RealEscapeString($id),
				GetDatabase()->RealEscapeString($access_token['oauth_token']),
				GetDatabase()->RealEscapeString($access_token['oauth_token_secret'])
			);
		} else {
			$query = sprintf(
				"INSERT INTO uo_keys 
				(type,purpose,id,keystring,secrets)
				VALUES ('twitter','%s','%s','%s','%s')",
				GetDatabase()->RealEscapeString($purpose),
				GetDatabase()->RealEscapeString($id),
				GetDatabase()->RealEscapeString($access_token['oauth_token']),
				GetDatabase()->RealEscapeString($access_token['oauth_token_secret'])
			);
		}
		return GetDatabase()->DBQuery($query);
	} else {
		die('Insufficient rights to configure twitter');
	}
}

function GetTwitterKey($season, $purpose)
{
	$query = sprintf(
		"SELECT key_id, keystring, secrets
				FROM uo_keys 
				WHERE type='twitter' AND purpose='%s' AND id='%s'",
		GetDatabase()->RealEscapeString($purpose),
		GetDatabase()->RealEscapeString($season)
	);

	return GetDatabase()->DBQueryToRow($query);
}

function GetTwitterKeyById($keyId)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"SELECT key_id, keystring, secrets, purpose, id
				FROM uo_keys 
				WHERE key_id='%s'",
			GetDatabase()->RealEscapeString($keyId)
		);

		return GetDatabase()->DBQueryToRow($query);
	} else {
		die('Insufficient rights to configure twitter');
	}
}

function DeleteTwitterKey($keyId)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"DELETE FROM uo_keys WHERE key_id='%s'",
			GetDatabase()->RealEscapeString($keyId)
		);

		return GetDatabase()->DBQuery($query);
	} else {
		die('Insufficient rights to configure twitter');
	}
}

function GetTwitterConf()
{
	global $serverConf;
	global $twitterConfKeys;
	$conf = array();
	foreach ($twitterConfKeys as $key) {
		$conf[$key] = $serverConf[$key];
	}
	return $conf;
}

function IsTwitterEnabled()
{
	global $serverConf;
	return ($serverConf['TwitterEnabled'] == "true");
}

function GetPageTitle()
{
	global $serverConf;
	return utf8entities($serverConf['PageTitle']);
}

function GetDefaultLocale()
{
	global $serverConf;
	return $serverConf['DefaultLocale'];
}

function GetDefTimeZone()
{
	global $serverConf;
	return $serverConf['DefaultTimezone'];
}


function GetFacebookConf()
{
	global $serverConf;
	global $facebookConfKeys;
	$conf = array();
	foreach ($facebookConfKeys as $key) {
		$conf[$key] = $conf[$key];
	}
	return $conf;
}

function IsFacebookEnabled()
{
	global $serverConf;
	return ($serverConf['FacebookEnabled'] == "true");
}

function IsGameRSSEnabled()
{
	global $serverConf;
	return ($serverConf['GameRSSEnabled'] == "true");
}

function ShowDefenseStats()
{
	global $serverConf;
	return ($serverConf['ShowDefenseStats'] == "true");
}

function GetServerConf()
{
	$query = "SELECT * FROM uo_setting ORDER BY setting_id";
	return GetDatabase()->DBQueryToArray($query);
}

function GetSimpleServerConf()
{
	$query = "SELECT * FROM uo_setting ORDER BY setting_id";
	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ("' . $query . '")' . "<br/>\n" . GetDatabase()->SQLError());
	}

	$retarray = array();
	while ($row = GetDatabase()->FetchAssoc($result)) {
		$retarray[$row['name']] = $row['value'];
	}
	return $retarray;
}

function SetServerConf($settings)
{
	if (isSuperAdmin()) {
		foreach ($settings as $setting) {
			$query = sprintf(
				"SELECT setting_id FROM uo_setting WHERE name='%s'",
				GetDatabase()->RealEscapeString($setting['name'])
			);
			$result = GetDatabase()->DBQuery($query);
			if (!$result) {
				die('Invalid query: ' . GetDatabase()->SQLError());
			}
			if ($row = GetDatabase()->FetchRow($result)) {
				$query = sprintf(
					"UPDATE uo_setting SET value='%s' WHERE setting_id=%d",
					GetDatabase()->RealEscapeString($setting['value']),
					(int)$row[0]
				);
				$result = GetDatabase()->DBQuery($query);
				if (!$result) {
					die('Invalid query: ' . GetDatabase()->SQLError());
				}
			} else {
				$query = sprintf(
					"INSERT INTO uo_setting (name, value) VALUES ('%s', '%s')",
					GetDatabase()->RealEscapeString($setting['name']),
					GetDatabase()->RealEscapeString($setting['value'])
				);
				$result = GetDatabase()->DBQuery($query);
				if (!$result) {
					die('Invalid query: ' . GetDatabase()->SQLError());
				}
			}
		}
	} else {
		die('Insufficient rights to configure server');
	}
}

function GetGoogleMapsAPIKey()
{
	global $serverConf;
	return $serverConf['GoogleMapsAPIKey'];
}

function isRespTeamHomeTeam()
{
	$query = "SELECT value FROM uo_setting WHERE name = 'HomeTeamResponsible'";
	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}

	if (!$row = GetDatabase()->FetchRow($result)) {
		return false;
	} else {
		return $row[0] == 'yes';
	}
}

/**
 * Scans directory /cust/* and returns list of customizations avialable.
 * 
 */
function getAvailableCustomizations()
{
	global $include_prefix;
	$customizations = array();
	$temp = scandir($include_prefix . "cust/");

	foreach ($temp as $fh) {
		if (is_dir($include_prefix . "cust/$fh") && $fh != '.' && $fh != '..') {
			$customizations[] = $fh;
		}
	}

	return $customizations;
}

/**
 * Scans directory /locale/* and returns list of localizations avialable.
 * 
 */
function getAvailableLocalizations()
{
	global $include_prefix;
	$localizations = array();
	$temp = scandir($include_prefix . "locale/");

	foreach ($temp as $fh) {
		if (is_dir($include_prefix . "locale/$fh") && $fh != '.' && $fh != '..') {
			$localizations[$fh] = $fh;
		}
	}

	return $localizations;
}
