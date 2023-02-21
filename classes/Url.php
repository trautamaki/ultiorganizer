<?php

class Url extends BaseObject
{
    static $tablename = "uo_urls";

    private $owner;
    private $ownerId;
    private $type;
    private $name;
    private $url;
    private $ordering;
    private $isMediaLink;
    private $mediaOwner;
    private $publisherId;

    function Url($database, $id)
    {
        parent::__construct($database, $id);
        $query = sprintf("SELECT * FROM %s WHERE url_id=%d", static::$tablename, $this->id);
        $result = $this->database->DBQueryToRow($query);
        if (!$result) {
            throw new Exception('URL not found.');
        }

        $this->owner = utf8entities($result['owner']);
        $this->ownerId = utf8entities($result['ownerid']);
        $this->type = utf8entities($result['type']);
        $this->name = utf8entities($result['name']);
        $this->url = utf8entities($result['url']);
        $this->ordering = utf8entities($result['ordering']);
        $this->isMediaLink = utf8entities($result['ismedialink']);
        $this->mediaOwner = utf8entities($result['mediaowner']);
        $this->publisherId = utf8entities($result['publisherid']);
    }

    function getOwner()
    {
        return $this->owner;
    }

    function getOwnerId()
    {
        return $this->ownerId;
    }

    function getType()
    {
        return $this->type;
    }

    function getName()
    {
        return $this->name;
    }

    function getUrl()
    {
        return $this->url;
    }

    function getOrdering()
    {
        return $this->ordering;
    }

    function isMediaLink()
    {
        return $this->isMediaLink;
    }

    function getMediaOwner()
    {
        return $this->mediaOwner;
    }

    function getPublisherId()
    {
        return $this->publisherId;
    }

    function set($urlparams)
    {
        if (!isSuperAdmin()) die('Insufficient rights to add url');
        $url = SafeUrl($urlparams['url']);

        $query = sprintf(
            "UPDATE uo_urls SET owner='%s', owner_id=%d, type='%s', name='%s', url='%s', ordering='%s'
			WHERE url_id=%d",
            GetDatabase()->RealEscapeString($urlparams['owner']),
            (int) $urlparams['owner_id'],
            GetDatabase()->RealEscapeString($urlparams['type']),
            GetDatabase()->RealEscapeString($urlparams['name']),
            GetDatabase()->RealEscapeString($url),
            GetDatabase()->RealEscapeString($urlparams['ordering']),
            $this->id
        );
        return GetDatabase()->DBQuery($query);
    }

    function setMail($urlparams)
    {
        if (!isSuperAdmin()) die('Insufficient rights to add url');
        $query = sprintf(
            "UPDATE uo_urls SET owner='%s', owner_id='%s', type='%s', name='%s',url='%s', ordering='%s'
			WHERE url_id=%d",
            GetDatabase()->RealEscapeString($urlparams['owner']),
            GetDatabase()->RealEscapeString($urlparams['owner_id']),
            GetDatabase()->RealEscapeString($urlparams['type']),
            GetDatabase()->RealEscapeString($urlparams['name']),
            GetDatabase()->RealEscapeString($urlparams['url']),
            GetDatabase()->RealEscapeString($urlparams['ordering']),
            $this->id
        );
        return GetDatabase()->DBQuery($query);
    }

    static function add($urlparams)
    {
        if (!isSuperAdmin()) die('Insufficient rights to add url');
        $url = SafeUrl($urlparams['url']);

        $query = sprintf(
            "INSERT INTO uo_urls (owner, owner_id, type, name, url, ordering)
            VALUES('%s', '%s', '%s', '%s', '%s', '%s')",
            GetDatabase()->RealEscapeString($urlparams['owner']),
            GetDatabase()->RealEscapeString($urlparams['owner_id']),
            GetDatabase()->RealEscapeString($urlparams['type']),
            GetDatabase()->RealEscapeString($urlparams['name']),
            GetDatabase()->RealEscapeString($url),
            GetDatabase()->RealEscapeString($urlparams['ordering'])
        );

        return GetDatabase()->DBQuery($query);
    }

    static function addMail($urlparams)
    {
        if (!isSuperAdmin()) die('Insufficient rights to add url');
        $query = sprintf(
            "INSERT INTO uo_urls (owner, owner_id, type, name, url,ordering)
				VALUES('%s', '%s', '%s', '%s', '%s', '%s')",
            GetDatabase()->RealEscapeString($urlparams['owner']),
            GetDatabase()->RealEscapeString($urlparams['owner_id']),
            GetDatabase()->RealEscapeString($urlparams['type']),
            GetDatabase()->RealEscapeString($urlparams['name']),
            GetDatabase()->RealEscapeString($urlparams['url']),
            GetDatabase()->RealEscapeString($urlparams['ordering'])
        );
        return GetDatabase()->DBQuery($query);
    }

    static function addMediaUrl($urlparams)
    {
        if (!hasAddMediaRight()) die('Insufficient rights to add media');

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
    }


    static function getUrlByOwnerAndType($owner, $ownerId, $type)
    {
        $query = sprintf(
            "SELECT * FROM uo_urls WHERE owner='%s' AND owner_id='%s' AND type='%s'",
            GetDatabase()->RealEscapeString($owner),
            GetDatabase()->RealEscapeString($ownerId),
            GetDatabase()->RealEscapeString($type)
        );
        return GetDatabase()->DBQueryToRow($query);
    }

    static function getUrlListByOwner($owner, $ownerId, $medialinks = false)
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

    static function getUrlListByTypeArray($typearray, $ownerId)
    {
        foreach ($typearray as $type) {
            $list[] = "'" . GetDatabase()->RealEscapeString($type) . "'";
        }
        $liststring = implode(",", $list);
        $query = "SELECT * FROM uo_urls WHERE type IN($liststring) AND owner_id='" . GetDatabase()->RealEscapeString($ownerId) . "' ORDER BY ordering,type, name";
        return GetDatabase()->DBQueryToArray($query);
    }

    static function getMediaUrlList($owner, $ownerId, $type = "")
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

    static function getTypes()
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

    static function getMediaTypes()
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
}
