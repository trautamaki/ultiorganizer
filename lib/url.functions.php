<?php

function GetUrlById($urlId)
{
	$query = sprintf(
		"SELECT * FROM uo_urls WHERE url_id=%d",
		(int)$urlId
	);
	return GetDatabase()->DBQueryToRow($query);
}

function GetUrl($owner, $ownerId, $type)
{
	$query = sprintf(
		"SELECT * FROM uo_urls WHERE owner='%s' AND owner_id='%s' AND type='%s'",
		GetDatabase()->RealEscapeString($owner),
		GetDatabase()->RealEscapeString($ownerId),
		GetDatabase()->RealEscapeString($type)
	);
	return GetDatabase()->DBQueryToRow($query);
}

function GetUrlList($owner, $ownerId, $medialinks = false)
{
	if ($medialinks) {
		$query = sprintf(
			"SELECT * FROM uo_urls WHERE owner='%s' AND owner_id='%s' AND ismedialink=1",
			GetDatabase()->RealEscapeString($owner),
			GetDatabase()->RealEscapeString($ownerId)
		);
	} else {
		$query = sprintf(
			"SELECT * FROM uo_urls WHERE owner='%s' AND owner_id='%s' AND ismedialink=0",
			GetDatabase()->RealEscapeString($owner),
			GetDatabase()->RealEscapeString($ownerId)
		);
	}
	$query .= " ORDER BY ordering, type, name";
	return GetDatabase()->DBQueryToArray($query);
}

function GetUrlListByTypeArray($typearray, $ownerId)
{
	foreach ($typearray as $type) {
		$list[] = "'" . GetDatabase()->RealEscapeString($type) . "'";
	}
	$liststring = implode(",", $list);
	$query = "SELECT * FROM uo_urls WHERE type IN($liststring) AND owner_id='" . GetDatabase()->RealEscapeString($ownerId) . "' ORDER BY ordering,type, name";
	return GetDatabase()->DBQueryToArray($query);
}

function GetMediaUrlList($owner, $ownerId, $type = "")
{

	if ($owner == "game") {
		$query = sprintf(
			"SELECT urls.*, u.name AS publisher, e.time
			FROM uo_urls urls 
			LEFT JOIN uo_users u ON (u.id=urls.publisher_id)
			LEFT JOIN uo_gameevent e ON(e.info=urls.url_id)
			WHERE urls.owner='%s' AND urls.owner_id='%s' AND urls.ismedialink=1",
			GetDatabase()->RealEscapeString($owner),
			GetDatabase()->RealEscapeString($ownerId)
		);
	} else {
		$query = sprintf(
			"SELECT urls.*, u.name AS publisher FROM uo_urls urls 
			LEFT JOIN uo_users u ON (u.id=urls.publisher_id)
			WHERE urls.owner='%s' AND urls.owner_id='%s' AND urls.ismedialink=1",
			GetDatabase()->RealEscapeString($owner),
			GetDatabase()->RealEscapeString($ownerId)
		);
	}
	if (!empty($filter)) {
		$query .= sprintf(" AND type='%s'", GetDatabase()->RealEscapeString($type));
	}

	return GetDatabase()->DBQueryToArray($query);
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

function AddUrl($urlparams)
{
	if (isSuperAdmin()) {
		$url = SafeUrl($urlparams['url']);

		$query = sprintf(
			"INSERT INTO uo_urls (owner,owner_id,type,name,url,ordering)
				VALUES('%s','%s','%s','%s','%s','%s')",
			GetDatabase()->RealEscapeString($urlparams['owner']),
			GetDatabase()->RealEscapeString($urlparams['owner_id']),
			GetDatabase()->RealEscapeString($urlparams['type']),
			GetDatabase()->RealEscapeString($urlparams['name']),
			GetDatabase()->RealEscapeString($url),
			GetDatabase()->RealEscapeString($urlparams['ordering'])
		);

		return GetDatabase()->DBQuery($query);
	} else {
		die('Insufficient rights to add url');
	}
}

function AddMail($urlparams)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"INSERT INTO uo_urls (owner,owner_id,type,name,url,ordering)
				VALUES('%s','%s','%s','%s','%s','%s')",
			GetDatabase()->RealEscapeString($urlparams['owner']),
			GetDatabase()->RealEscapeString($urlparams['owner_id']),
			GetDatabase()->RealEscapeString($urlparams['type']),
			GetDatabase()->RealEscapeString($urlparams['name']),
			GetDatabase()->RealEscapeString($urlparams['url']),
			GetDatabase()->RealEscapeString($urlparams['ordering'])
		);
		return GetDatabase()->DBQuery($query);
	} else {
		die('Insufficient rights to add url');
	}
}

function SetUrl($urlparams)
{
	if (isSuperAdmin()) {
		$url = SafeUrl($urlparams['url']);

		$query = sprintf(
			"UPDATE uo_urls SET owner='%s',owner_id='%s',type='%s',name='%s',url='%s', ordering='%s'
			WHERE url_id=%d",
			GetDatabase()->RealEscapeString($urlparams['owner']),
			GetDatabase()->RealEscapeString($urlparams['owner_id']),
			GetDatabase()->RealEscapeString($urlparams['type']),
			GetDatabase()->RealEscapeString($urlparams['name']),
			GetDatabase()->RealEscapeString($url),
			GetDatabase()->RealEscapeString($urlparams['ordering']),
			(int)$urlparams['url_id']
		);
		return GetDatabase()->DBQuery($query);
	} else {
		die('Insufficient rights to add url');
	}
}

function SetMail($urlparams)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"UPDATE uo_urls SET owner='%s',owner_id='%s',type='%s',name='%s',url='%s', ordering='%s'
			WHERE url_id=%d",
			GetDatabase()->RealEscapeString($urlparams['owner']),
			GetDatabase()->RealEscapeString($urlparams['owner_id']),
			GetDatabase()->RealEscapeString($urlparams['type']),
			GetDatabase()->RealEscapeString($urlparams['name']),
			GetDatabase()->RealEscapeString($urlparams['url']),
			GetDatabase()->RealEscapeString($urlparams['ordering']),
			(int)$urlparams['url_id']
		);
		return GetDatabase()->DBQuery($query);
	} else {
		die('Insufficient rights to add url');
	}
}

function RemoveUrl($urlId)
{
	if (isSuperAdmin()) {
		$query = sprintf(
			"DELETE FROM uo_urls WHERE url_id=%d",
			(int)$urlId
		);
		return GetDatabase()->DBQuery($query);
	} else {
		die('Insufficient rights to remove url');
	}
}

function AddMediaUrl($urlparams)
{
	if (hasAddMediaRight()) {

		$url = SafeUrl($urlparams['url']);

		$query = sprintf(
			"INSERT INTO uo_urls (owner,owner_id,type,name,url,ismedialink,mediaowner,publisher_id)
				VALUES('%s','%s','%s','%s','%s',1,'%s','%s')",
			GetDatabase()->RealEscapeString($urlparams['owner']),
			GetDatabase()->RealEscapeString($urlparams['owner_id']),
			GetDatabase()->RealEscapeString($urlparams['type']),
			GetDatabase()->RealEscapeString($urlparams['name']),
			GetDatabase()->RealEscapeString($url),
			GetDatabase()->RealEscapeString($urlparams['mediaowner']),
			GetDatabase()->RealEscapeString($urlparams['publisher_id'])
		);
		Log2("Media", "Add", $urlparams['url']);
		GetDatabase()->DBQuery($query);
		return GetDatabase()->InsertID();
	} else {
		die('Insufficient rights to add media');
	}
}

function RemoveMediaUrl($urlId)
{
	if (hasAddMediaRight()) {
		$query = sprintf(
			"DELETE FROM uo_urls WHERE url_id=%d",
			(int)$urlId
		);
		Log2("Media", "Remove", $urlId);
		return GetDatabase()->DBQuery($query);
	} else {
		die('Insufficient rights to remove url');
	}
}
