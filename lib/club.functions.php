<?php

function ClubName($database, $clubId)
{
	$query = sprintf(
		"SELECT name FROM uo_club WHERE club_id='%s'",
		$database->RealEscapeString($clubId)
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	$row = $database->FetchAssoc($result);
	$name = $row["name"];
	$database->FreeResult($result);

	return $name;
}

function ClubInfo($database, $clubId)
{
	$query = sprintf(
		"SELECT club.name, club.club_id, club.country, c.name as countryname, 
		club.city, club.contacts, club.story, club.achievements, club.profile_image, club.valid,
		club.founded
		FROM uo_club club 
		LEFT JOIN uo_country c ON(club.country=c.country_id)
		WHERE club.club_id = '%s'",
		$database->RealEscapeString($clubId)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return  $database->FetchAssoc($result);
}

function ClubList($database, $onlyvalid = false, $namefilter = "")
{

	$query = "SELECT club.club_id, club.name, club.valid, club.country, c.flagfile 
		FROM uo_club club
		LEFT JOIN uo_country c ON (club.country=c.country_id)";

	if ($onlyvalid || (!empty($namefilter) && $namefilter != "ALL")) {
		$query .= " WHERE ";
	}

	if ($onlyvalid) {
		$query .= "club.valid=1";
	}

	if ($onlyvalid && (!empty($namefilter) && $namefilter != "ALL")) {
		$query .= " AND ";
	}

	if (!empty($namefilter) && $namefilter != "ALL") {
		if ($namefilter == "#") {
			$query .= "UPPER(club.name) REGEXP '^[0-9]'";
		} else {
			$query .= "UPPER(club.name) LIKE '" . $database->RealEscapeString($namefilter) . "%'";
		}
	}

	$query .= " ORDER BY club.valid DESC, club.name ASC";
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	return  $result;
}


function SetClubName($database, $clubId, $name)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"
			UPDATE uo_club SET name='%s' WHERE club_id='%s'",
			$database->RealEscapeString($name),
			$database->RealEscapeString($clubId)
		);

		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to edit team');
	}
}

function ClubTeams($database, $clubId, $season = "")
{
	$query = sprintf(
		"SELECT team.team_id, team.name, ser.name AS seriesname, ser.series_id FROM uo_club club
		LEFT JOIN uo_team team ON(team.club = club.club_id)
		LEFT JOIN uo_series ser ON(team.series = ser.series_id)
		WHERE team.club='%s' AND ser.season='%s' ORDER BY ser.ordering, team.name",
		$database->RealEscapeString($clubId),
		$database->RealEscapeString($season)
	);

	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	return $result;
}

function ClubTeamsHistory($database, $clubId)
{
	$curseason = CurrentSeason($database);
	$query = sprintf(
		"SELECT ser.season, team.team_id, team.name, ser.name AS seriesname, ser.series_id FROM uo_club club
			LEFT JOIN uo_team team ON(team.club = club.club_id)
			LEFT JOIN uo_series ser ON(team.series = ser.series_id)
			LEFT JOIN uo_season s ON(s.season_id = ser.season)
			WHERE team.club='%s' AND ser.season!='%s' ORDER BY ser.type, s.starttime DESC, team.name",
		$database->RealEscapeString($clubId),
		$database->RealEscapeString($curseason)
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	return $result;
}

function ClubNumOfTeams($database, $clubId)
{
	$query = sprintf(
		"SELECT count(team.team_id) FROM uo_club club
		LEFT JOIN uo_team team ON(team.club = club.club_id)
		WHERE club.club_id='%s'",
		$database->RealEscapeString($clubId)
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}

	if (!$database->NumRows($result))
		return 0;

	$row = $result->fetch_row();
	return $row[0];
}

function ClubId($database, $name)
{
	$query = sprintf(
		"SELECT club_id FROM uo_club WHERE lower(name) LIKE lower('%s')",
		$database->RealEscapeString($name)
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

function RemoveClub($database, $clubId)
{
	if (CanDeleteClub($database, $clubId) && isSuperAdmin()) {
		Log2($database, "club", "delete", ClubName($database, $clubId));
		$query = sprintf(
			"DELETE FROM uo_club WHERE club_id='%s'",
			$database->RealEscapeString($clubId)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to remove player');
	}
}

function AddClub($database, $seriesId, $name)
{
	if (hasEditTeamsRight($database, $seriesId)) {
		$query = sprintf(
			"INSERT INTO uo_club (name) VALUES ('%s')",
			$database->RealEscapeString($name)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}
		$clubId = $database->GetConnection()->insert_id;
		Log1($database, "club", "add", $clubId);
		return $clubId;
	} else {
		die('Insufficient rights to add club');
	}
}

function CanDeleteClub($database, $clubId)
{
	$query = sprintf(
		"SELECT count(*) FROM uo_team WHERE club='%s'",
		$database->RealEscapeString($clubId)
	);
	$result = $database->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . $database->GetConnection()->error());
	}
	if (!$row = $result->fetch_row()) return false;
	return ($row[0] == 0);
}

function SetClubProfile($database, $teamId, $profile)
{
	$teaminfo = TeamInfo($database, $teamId);
	if (isSuperAdmin() || (hasEditPlayersRight($database, $teamId) && $teaminfo['club'] == $profile['club_id'])) {

		$query = sprintf(
			"UPDATE uo_club SET name='%s', contacts='%s', 
				country='%s', city='%s', founded='%s', story='%s',
				achievements='%s', valid=%d WHERE club_id='%s'",
			$database->RealEscapeString($profile['name']),
			$database->RealEscapeString($profile['contacts']),
			$database->RealEscapeString($profile['country']),
			$database->RealEscapeString($profile['city']),
			$database->RealEscapeString($profile['founded']),
			$database->RealEscapeString($profile['story']),
			$database->RealEscapeString($profile['achievements']),
			(int)$profile['valid'],
			$database->RealEscapeString($profile['club_id'])
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return $result;
	} else {
		die('Insufficient rights to edit club profile');
	}
}

function UploadClubImage($database, $teamId, $clubId)
{
	$teaminfo = TeamInfo($database, $teamId);
	if (isSuperAdmin() || (hasEditPlayersRight($database, $teamId) && $teaminfo['club'] == $clubId)) {
		$max_file_size = 5 * 1024 * 1024; //5 MB

		if ($_FILES['picture']['size'] > $max_file_size) {
			return "<p class='warning'>" . _("File is too large") . "</p>";
		}

		$imgType = $_FILES['picture']['type'];
		$type = explode("/", $imgType);
		$type1 = $type[0];
		$type2 = $type[1];
		if ($type1 != "image") {
			return "<p class='warning'>" . _("File is not supported image format") . "</p>";
		}

		if (!extension_loaded("gd")) {
			return "<p class='warning'>" . _("Missing gd extension for image handling.") . "</p>";
		}

		$file_tmp_name = $_FILES['picture']['tmp_name'];
		$imgname = time() . $clubId . ".jpg";
		$basedir = UPLOAD_DIR . "clubs/$clubId/";
		if (!is_dir($basedir)) {
			recur_mkdirs($basedir, 0775);
			recur_mkdirs($basedir . "thumbs/", 0775);
		}

		ConvertToJpeg($file_tmp_name, $basedir . $imgname);
		CreateThumb($basedir . $imgname, $basedir . "thumbs/" . $imgname, 160, 120);

		//currently removes old image, in future there might be a gallery of images
		RemoveClubProfileImage($database, $teamId, $clubId);
		SetClubProfileImage($database, $teamId, $clubId, $imgname);

		return "";
	} else {
		die('Insufficient rights to upload image');
	}
}


function SetClubProfileImage($database, $teamId, $clubId, $filename)
{
	$teaminfo = TeamInfo($database, $teamId);
	if (isSuperAdmin() || (hasEditPlayersRight($database, $teamId) && $teaminfo['club'] == $clubId)) {

		$query = sprintf(
			"UPDATE uo_club SET profile_image='%s' WHERE club_id='%s'",
			$database->RealEscapeString($filename),
			$database->RealEscapeString($clubId)
		);

		$database->DBQuery($query);
	} else {
		die('Insufficient rights to edit club profile');
	}
}

function RemoveClubProfileImage($database, $teamId, $clubId)
{
	$teaminfo = TeamInfo($database, $teamId);
	if (isSuperAdmin() || (hasEditPlayersRight($database, $teamId) && $teaminfo['club'] == $clubId)) {

		$profile = ClubInfo($database, $clubId);

		if (!empty($profile['profile_image'])) {

			//thumbnail
			$file = "" . UPLOAD_DIR . "clubs/$clubId/thumbs/" . $profile['profile_image'];
			if (is_file($file)) {
				unlink($file); //  remove old images if present
			}

			//image
			$file = "" . UPLOAD_DIR . "clubs/$clubId/" . $profile['profile_image'];

			if (is_file($file)) {
				unlink($file); //  remove old images if present
			}

			$query = sprintf(
				"UPDATE uo_club SET profile_image=NULL WHERE club_id='%s'",
				$database->RealEscapeString($clubId)
			);

			$database->DBQuery($query);
		}
	} else {
		die('Insufficient rights to edit player profile');
	}
}

function SetClubValidity($database, $clubId, $valid)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"UPDATE uo_club SET valid=%d WHERE club_id='%s'",
			(int)($valid),
			$database->RealEscapeString($clubId)
		);
		$result = $database->DBQuery($query);
		if (!$result) {
			die('Invalid query: ' . $database->GetConnection()->error());
		}

		return  $result;
	} else {
		die('Insufficient rights to set club validity');
	}
}

function AddClubProfileUrl($database, $teamId, $clubId, $type, $url, $name)
{
	$teaminfo = TeamInfo($database, $teamId);
	if (isSuperAdmin() || (hasEditPlayersRight($database, $teamId) && $teaminfo['club'] == $clubId)) {
		$url = SafeUrl($url);
		$query = sprintf(
			"INSERT INTO uo_urls (owner,owner_id,type,name,url)
				VALUES('club',%d,'%s','%s','%s')",
			(int)$clubId,
			$database->RealEscapeString($type),
			$database->RealEscapeString($name),
			$database->RealEscapeString($url)
		);
		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to add url');
	}
}

function RemoveClubProfileUrl($database, $teamId, $clubId, $urlId)
{
	$teaminfo = TeamInfo($database, $teamId);
	if (isSuperAdmin() || (hasEditPlayersRight($database, $teamId) && $teaminfo['club'] == $clubId)) {
		$query = sprintf(
			"DELETE FROM uo_urls WHERE url_id=%d",
			(int)$urlId
		);
		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to remove url');
	}
}
