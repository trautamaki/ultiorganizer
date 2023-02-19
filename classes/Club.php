<?php

include_once 'classes/BaseObject.php';

class Club extends BaseObject
{
    static $tablename = "uo_club";

    private $name;
    private $contacts; // TODO
    private $city;
    private $country;
    private $story;
    private $achievements;
    private $image;
    private $valid;
    private $profile_image;
    private $founded;

    function Club($database, $id)
    {
        parent::__construct($database, $id);
        $query = sprintf("SELECT * FROM %s WHERE club_id=%d", static::$tablename, (int) $id);
        $result = $this->database->DBQueryToRow($query);
        if (!$result) {
            throw new Exception('Club not found.');
        }

        $this->name = utf8entities($result['name']);
        $this->contacts = utf8entities($result['contacts']); // TODO
        $this->city = $result['city'];
        $this->country = $result['country'];
        $this->story = utf8entities($result['story']);
        $this->achievements = utf8entities($result['achievements']);
        $this->image = $result['image'];
        $this->valid = $result['valid'];
        $this->profile_image = $result['profile_image'];
        $this->founded = $result['founded'];
    }

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        if (!isSuperAdmin()) die('Insufficient rights to edit team');
        $query = sprintf(
            "UPDATE %s SET name='%s' WHERE club_id=%d",
            static::$tablename,
            $this->database->RealEscapeString($name),
            $this->id
        );

        return $this->database->DBQuery($query);
    }

    function getContacts()
    {
        return $this->contacts;
    }

    function getCity()
    {
        return $this->city;
    }

    function getCountryId()
    {
        return $this->country;
    }

    function getCountry()
    {
        if ($this->country == NULL) {
            return NULL;
        }
        return new Country($this->database, $this->country);
    }

    function getStory()
    {
        return $this->story;
    }

    function getAchievements()
    {
        return $this->achievements;
    }

    function getImage()
    {
        return $this->image;
    }

    function isValid()
    {
        return $this->valid;
    }

    function getProfileImage()
    {
        return $this->profile_image;
    }

    function getFounded()
    {
        return $this->founded;
    }

    function getTeams($season = "")
    {
        $query = sprintf(
            "SELECT team.team_id, team.name, ser.name AS seriesname, ser.series_id FROM %s club
            LEFT JOIN uo_team team ON(team.club = club.club_id)
            LEFT JOIN uo_series ser ON(team.series = ser.series_id)
            WHERE team.club=%d AND ser.season='%s' ORDER BY ser.ordering, team.name",
            static::$tablename,
            $this->id,
            $this->database->RealEscapeString($season)
        );

        // TODO
        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }
        return $result;
    }

    function getTeamsHistory()
    {
        $curseason = CurrentSeason();
        $query = sprintf(
            "SELECT ser.season, team.team_id, team.name, ser.name AS seriesname, ser.series_id FROM %s club
            LEFT JOIN uo_team team ON(team.club = club.club_id)
            LEFT JOIN uo_series ser ON(team.series = ser.series_id)
            LEFT JOIN uo_season s ON(s.season_id = ser.season)
            WHERE team.club=%d AND ser.season!='%s' ORDER BY ser.type, s.starttime DESC, team.name",
            static::$tablename,
            $this->id,
            $this->database->RealEscapeString($curseason)
        );
        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }
        return $result;
    }

    function numOfTeams()
    {
        $query = sprintf(
            "SELECT count(team.team_id) FROM %s club
            LEFT JOIN uo_team team ON(team.club = club.club_id)
            WHERE club.club_id=%d",
            static::$tablename,
            $this->database->RealEscapeString($this->id)
        );
        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }

        if (!$this->database->NumRows($result))
            return 0;

        $row = $this->database->FetchRow($result);
        return $row[0];
    }

    function remove()
    {
        if ($this->canDelete() && isSuperAdmin()) {
            Log2("club", "delete", $this->name);
            $query = sprintf(
                "DELETE FROM %s WHERE club_id=%d",
                static::$tablename,
                $this->database->RealEscapeString($this->id)
            );
            $result = $this->database->DBQuery($query);
            if (!$result) {
                die('Invalid query: ' . $this->database->SQLError());
            }

            return $result;
        } else {
            die('Insufficient rights to remove player');
        }
    }

    function canDelete()
    {
        $query = sprintf(
            "SELECT count(*) FROM uo_team WHERE club='%s'",
            $this->database->RealEscapeString($this->id)
        );
        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }
        if (!$row = $this->database->FetchRow($result)) return false;
        return ($row[0] == 0);
    }

    function setProfile($teamId, $profile)
    {
        $teaminfo = TeamInfo($this->id);
        if (isSuperAdmin() || (hasEditPlayersRight($this->id) && $teaminfo['club'] == $profile['club_id'])) {
            $query = sprintf(
                "UPDATE %s
                SET name='%s', contacts='%s', country='%s', city='%s', founded='%s', story='%s', achievements='%s', valid=%d
                WHERE club_id=%d",
                static::$tablename,
                $this->database->RealEscapeString($profile['name']),
                $this->database->RealEscapeString($profile['contacts']),
                $this->database->RealEscapeString($profile['country']),
                $this->database->RealEscapeString($profile['city']),
                $this->database->RealEscapeString($profile['founded']),
                $this->database->RealEscapeString($profile['story']),
                $this->database->RealEscapeString($profile['achievements']),
                (int) $profile['valid'], $this->id
            );

            $result = $this->database->DBQuery($query);
            if (!$result) {
                die('Invalid query: ' . $this->database->SQLError());
            }

            return $result;
        } else {
            die('Insufficient rights to edit club profile');
        }
    }

    function uploadImage($teamId)
    {
        $teaminfo = TeamInfo($teamId);
        if (isSuperAdmin() || (hasEditPlayersRight($teamId) && $teaminfo['club'] == $this->id)) {
            $max_file_size = 5 * 1024 * 1024; //5 MB

            if ($_FILES['picture']['size'] > $max_file_size) {
                return "<p class='warning'>" . _("File is too large") . "</p>";
            }

            $imgType = $_FILES['picture']['type'];
            $type = explode("/", $imgType);
            $type1 = $type[0];
            if ($type1 != "image") {
                return "<p class='warning'>" . _("File is not supported image format") . "</p>";
            }

            if (!extension_loaded("gd")) {
                return "<p class='warning'>" . _("Missing gd extension for image handling.") . "</p>";
            }

            $file_tmp_name = $_FILES['picture']['tmp_name'];
            $imgname = time() . $this->id . ".jpg";
            $basedir = UPLOAD_DIR . "clubs/" . $this->id . "/";
            if (!is_dir($basedir)) {
                recur_mkdirs($basedir, 0775);
                recur_mkdirs($basedir . "thumbs/", 0775);
            }

            ConvertToJpeg($file_tmp_name, $basedir . $imgname);
            CreateThumb($basedir . $imgname, $basedir . "thumbs/" . $imgname, 160, 120);

            //currently removes old image, in future there might be a gallery of images
            $this->removeProfileImage($teamId);
            $this->setProfileImage($teamId, $imgname);

            return "";
        } else {
            die('Insufficient rights to upload image');
        }
    }

    function setProfileImage($teamId, $filename)
    {
        $teaminfo = TeamInfo($teamId);
        if (isSuperAdmin() || (hasEditPlayersRight($teamId) && $teaminfo['club'] == $this->id)) {
            $query = sprintf(
                "UPDATE %s SET profile_image='%s' WHERE club_id=%d",
                static::$tablename,
                $this->database->RealEscapeString($filename),
                $this->id
            );

            $this->database->DBQuery($query);
        } else {
            die('Insufficient rights to edit club profile');
        }
    }

    function removeProfileImage($teamId)
    {
        $teaminfo = TeamInfo($teamId);
        if (isSuperAdmin() || (hasEditPlayersRight($teamId) && $teaminfo['club'] == $this->id)) {
            if (!empty($this->getProfileImage())) {
                //thumbnail
                $file = "" . UPLOAD_DIR . "clubs/" . $this->id . "/thumbs/" . $this->profile_image;
                if (is_file($file)) {
                    unlink($file); //  remove old images if present
                }

                //image
                $file = "" . UPLOAD_DIR . "clubs/" . $this->id . "/" . $this->profile_image;

                if (is_file($file)) {
                    unlink($file); //  remove old images if present
                }

                $query = sprintf(
                    "UPDATE %s SET profile_image=NULL WHERE club_id=%d",
                    static::$tablename, $this->id
                );

                $this->database->DBQuery($query);
            }
        } else {
            die('Insufficient rights to edit player profile');
        }
    }

    function setValidity($valid)
    {
        if (!isSuperAdmin()) die('Insufficient rights to set club validity');
        $query = sprintf(
            "UPDATE %s SET valid=%d WHERE club_id=%d",
            static::$tablename, (int) $valid, $this->id
        );
        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }

        return  $result;
    }

    function addProfileUrl($teamId, $type, $url, $name)
    {
        $teaminfo = TeamInfo($teamId);
        if (isSuperAdmin() || (hasEditPlayersRight($teamId) && $teaminfo['club'] == $this->id)) {
            $url = SafeUrl($url);
            $query = sprintf(
                "INSERT INTO uo_urls (owner, owner_id, type, name, url)
                VALUES ('club', %d, '%s', '%s', '%s')",
                $this->id,
                $this->database->RealEscapeString($type),
                $this->database->RealEscapeString($name),
                $this->database->RealEscapeString($url)
            );
            return $this->database->DBQuery($query);
        } else {
            die('Insufficient rights to add url');
        }    
    }

    function removeClubProfileUrl($teamId, $urlId)
    {
        $teaminfo = TeamInfo($teamId);
        if (isSuperAdmin() || (hasEditPlayersRight($teamId) && $teaminfo['club'] == $this->id)) {
            $query = sprintf("DELETE FROM uo_urls WHERE url_id=%d", (int) $urlId);
            return $this->database->DBQuery($query);
        } else {
            die('Insufficient rights to remove url');
        }
    }

    static function add($database, $seriesId, $name)
    {
        if (hasEditTeamsRight($seriesId)) {
            $query = sprintf(
                "INSERT INTO " . static::$tablename . " (name) VALUES ('%s')",
                $database->RealEscapeString($name)
            );
            $result = $database->DBQuery($query);
            if (!$result) {
                die('Invalid query: ' . $database->SQLError());
            }
            $clubId = $database->InsertID();
            Log1("club", "add", $clubId);
            return $clubId;
        } else {
            die('Insufficient rights to add club');
        }
    }

    static function clubIdFromName($database, $name)
    {
        $query = sprintf(
            "SELECT club_id FROM " . static::$tablename . " WHERE lower(name) LIKE lower('%s')",
            $database->RealEscapeString($name)
        );
        $result = $database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $database->SQLError());
        }

        if (!$database->NumRows($result))
            return -1;

        $row = $database->FetchRow($result);
        return $row[0];
    }

    static function clubList($database, $onlyvalid = false, $namefilter = "")
    {
        $query = "SELECT club_id, name, valid, country FROM " . static::$tablename . "";

        if ($onlyvalid || (!empty($namefilter) && $namefilter != "ALL")) {
            $query .= " WHERE ";
        }

        if ($onlyvalid) {
            $query .= "valid=1";
        }

        if ($onlyvalid && (!empty($namefilter) && $namefilter != "ALL")) {
            $query .= " AND ";
        }

        if (!empty($namefilter) && $namefilter != "ALL") {
            if ($namefilter == "#") {
                $query .= "UPPER(name) REGEXP '^[0-9]'";
            } else {
                $query .= "UPPER(name) LIKE '" . $database->RealEscapeString($namefilter) . "%'";
            }
        }

        $query .= " ORDER BY valid DESC, name ASC";
        $result = $database->DBQueryToArray($query);
        $clubs = array();
        foreach ($result as $club) {
            array_push($clubs, new Club($database, $club['club_id']));
        }
        return $clubs;
    }
}
