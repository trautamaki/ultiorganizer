<?php

function GetUrlById($database, $urlId)
{
	$query = sprintf(
		"SELECT * FROM uo_urls WHERE url_id=%d",
		(int)$urlId
	);
	return $database->DBQueryToRow($query);
}

function GetUrl($database, $owner, $ownerId, $type)
{
	$query = sprintf(
		"SELECT * FROM uo_urls WHERE owner='%s' AND owner_id='%s' AND type='%s'",
		$database->RealEscapeString($owner),
		$database->RealEscapeString($ownerId),
		$database->RealEscapeString($type)
	);
	return $database->DBQueryToRow($query);
}

function GetUrlList($database, $owner, $ownerId, $medialinks = false)
{
	if ($medialinks) {
		$query = sprintf(
			"SELECT * FROM uo_urls WHERE owner='%s' AND owner_id='%s' AND ismedialink=1",
			$database->RealEscapeString($owner),
			$database->RealEscapeString($ownerId)
		);
	} else {
		$query = sprintf(
			"SELECT * FROM uo_urls WHERE owner='%s' AND owner_id='%s' AND ismedialink=0",
			$database->RealEscapeString($owner),
			$database->RealEscapeString($ownerId)
		);
	}
	$query .= " ORDER BY ordering, type, name";
	return $database->DBQueryToArray($query);
}

function GetUrlListByTypeArray($database, $typearray, $ownerId)
{
	foreach ($typearray as $type) {
		$list[] = "'" . $database->RealEscapeString($type) . "'";
	}
	$liststring = implode(",", $list);
	$query = "SELECT * FROM uo_urls WHERE type IN($liststring) AND owner_id='" . $database->RealEscapeString($ownerId) . "' ORDER BY ordering,type, name";
	return $database->DBQueryToArray($query);
}

function GetMediaUrlList($database, $owner, $ownerId, $type = "")
{

	if ($owner == "game") {
		$query = sprintf(
			"SELECT urls.*, u.name AS publisher, e.time
			FROM uo_urls urls 
			LEFT JOIN uo_users u ON (u.id=urls.publisher_id)
			LEFT JOIN uo_gameevent e ON(e.info=urls.url_id)
			WHERE urls.owner='%s' AND urls.owner_id='%s' AND urls.ismedialink=1",
			$database->RealEscapeString($owner),
			$database->RealEscapeString($ownerId)
		);
	} else {
		$query = sprintf(
			"SELECT urls.*, u.name AS publisher FROM uo_urls urls 
			LEFT JOIN uo_users u ON (u.id=urls.publisher_id)
			WHERE urls.owner='%s' AND urls.owner_id='%s' AND urls.ismedialink=1",
			$database->RealEscapeString($owner),
			$database->RealEscapeString($ownerId)
		);
	}
	if (!empty($filter)) {
		$query .= sprintf(" AND type='%s'", $database->RealEscapeString($type));
	}

	return $database->DBQueryToArray($query);
}

function GetUrlTypes()
{
	$types = array();
	$dbtype = array("homepage", "forum", "twitter", "blogger", "facebook", "flickr", "picasa", "other");
	$translation = array(_("Homepage"), _("Forum"), _("Twitter"), _("Blogger"), _("Facebook"), _("Flickr"), _("Picasa"), _("Other"));
	$icon = array("homepage.png", "forum.png", "twitter.png", "blogger.png", "facebook.png", "flickr.png", "picasa.png", "other.png");

	for ($i = 0; $i < count($dbtype); $i++) {
		$types[] = array('type' => $dbtype[$i], 'name' => $translation[$i], 'icon' => $icon[$i]);
	}
	return $types;
}

function GetMediaUrlTypes()
{
	$types = array();
	$dbtype = array("image", "video", "live");
	$translation = array(_("Image"), _("Video"), _("Live video"));
	$icon = array("image.png", "video.png", "live.png");

	for ($i = 0; $i < count($dbtype); $i++) {
		$types[] = array('type' => $dbtype[$i], 'name' => $translation[$i], 'icon' => $icon[$i]);
	}
	return $types;
}

function AddUrl($database, $urlparams)
{
	if (isSuperAdmin()) {
		$url = SafeUrl($urlparams['url']);

		$query = sprintf(
			"INSERT INTO uo_urls (owner,owner_id,type,name,url,ordering)
				VALUES('%s','%s','%s','%s','%s','%s')",
			$database->RealEscapeString($urlparams['owner']),
			$database->RealEscapeString($urlparams['owner_id']),
			$database->RealEscapeString($urlparams['type']),
			$database->RealEscapeString($urlparams['name']),
			$database->RealEscapeString($url),
			$database->RealEscapeString($urlparams['ordering'])
		);

		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to add url');
	}
}

function AddMail($database, $urlparams)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"INSERT INTO uo_urls (owner,owner_id,type,name,url,ordering)
				VALUES('%s','%s','%s','%s','%s','%s')",
			$database->RealEscapeString($urlparams['owner']),
			$database->RealEscapeString($urlparams['owner_id']),
			$database->RealEscapeString($urlparams['type']),
			$database->RealEscapeString($urlparams['name']),
			$database->RealEscapeString($urlparams['url']),
			$database->RealEscapeString($urlparams['ordering'])
		);
		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to add url');
	}
}

function SetUrl($database, $urlparams)
{
	if (isSuperAdmin()) {
		$url = SafeUrl($urlparams['url']);

		$query = sprintf(
			"UPDATE uo_urls SET owner='%s',owner_id='%s',type='%s',name='%s',url='%s', ordering='%s'
			WHERE url_id=%d",
			$database->RealEscapeString($urlparams['owner']),
			$database->RealEscapeString($urlparams['owner_id']),
			$database->RealEscapeString($urlparams['type']),
			$database->RealEscapeString($urlparams['name']),
			$database->RealEscapeString($url),
			$database->RealEscapeString($urlparams['ordering']),
			(int)$urlparams['url_id']
		);
		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to add url');
	}
}

function SetMail($database, $urlparams)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"UPDATE uo_urls SET owner='%s',owner_id='%s',type='%s',name='%s',url='%s', ordering='%s'
			WHERE url_id=%d",
			$database->RealEscapeString($urlparams['owner']),
			$database->RealEscapeString($urlparams['owner_id']),
			$database->RealEscapeString($urlparams['type']),
			$database->RealEscapeString($urlparams['name']),
			$database->RealEscapeString($urlparams['url']),
			$database->RealEscapeString($urlparams['ordering']),
			(int)$urlparams['url_id']
		);
		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to add url');
	}
}

function RemoveUrl($database, $urlId)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"DELETE FROM uo_urls WHERE url_id=%d",
			(int)$urlId
		);
		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to remove url');
	}
}

function AddMediaUrl($database, $urlparams)
{
	if (hasAddMediaRight()) {

		$url = SafeUrl($urlparams['url']);

		$query = sprintf(
			"INSERT INTO uo_urls (owner,owner_id,type,name,url,ismedialink,mediaowner,publisher_id)
				VALUES('%s','%s','%s','%s','%s',1,'%s','%s')",
			$database->RealEscapeString($urlparams['owner']),
			$database->RealEscapeString($urlparams['owner_id']),
			$database->RealEscapeString($urlparams['type']),
			$database->RealEscapeString($urlparams['name']),
			$database->RealEscapeString($url),
			$database->RealEscapeString($urlparams['mediaowner']),
			$database->RealEscapeString($urlparams['publisher_id'])
		);
		Log2($database, "Media", "Add", $urlparams['url']);
		$database->DBQuery($query);
		return $database->GetConnection()->insert_id;
	} else {
		die('Insufficient rights to add media');
	}
}

function RemoveMediaUrl($database, $urlId)
{
	if (hasAddMediaRight()) {
		$query = sprintf(
			"DELETE FROM uo_urls WHERE url_id=%d",
			(int)$urlId
		);
		Log2($database, "Media", "Remove", $urlId);
		return $database->DBQuery($query);
	} else {
		die('Insufficient rights to remove url');
	}
}
