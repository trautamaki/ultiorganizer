<?php

include_once 'classes/BaseObject.php';

class Location extends BaseObject
{
    static $tablename = "uo_location";

    private $name;
    private $fields;
    private $indoor;
    private $address;
    private $info_fi;
    private $info_en;
    private $lat;
    private $lng;

    function Location($database, $id)
    {
        parent::__construct($database, $id);
        $query = sprintf("SELECT * FROM %s WHERE id=%d", static::$tablename, $this->id);
        $result = $this->database->DBQueryToRow($query);
        if (!$result) {
            throw new Exception('Location not found.');
        }

        $this->name = utf8entities($result['name']);
        $this->fields = (int) $result['fields'];
        $this->indoor = (int) $result['indoor'];
        $this->address = utf8entities($result['address']);
        $this->info_fi = utf8entities($result['info_fi']);
        $this->info_en = utf8entities($result['info_en']);
        $this->lat = utf8entities($result['lat']);
        $this->lng = utf8entities($result['lng']);
    }

    function getName()
    {
        return $this->name;
    }

    function getFields()
    {
        return $this->fields;
    }

    function getIndoor()
    {
        return $this->indoor;
    }

    function getAddress()
    {
        return $this->address;
    }

    function getInfoFi()
    {
        return $this->info_fi;
    }

    function getInfoEn()
    {
        return $this->info_en;
    }

    function getLat()
    {
        return $this->lat;
    }

    function getLng()
    {
        return $this->lng;
    }

    function set($name, $address, $info, $fields, $indoor, $lat, $lng, $season)
    {
        if (!isSuperAdmin() && !isSeasonAdmin($season)) {
            die('Insufficient rights to change location');
        }
        $query = sprintf(
            "UPDATE uo_location SET name='%s', address='%s', fields=%d, indoor=%d,
            lat='%s', lng='%s' WHERE id=%d",
            $this->database->RealEscapeString($name),
            $this->database->RealEscapeString($address),
            (int) $fields,
            (int) $indoor,
            $this->database->RealEscapeString($lat),
            $this->database->RealEscapeString($lng),
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        $this->updateInfos($this->id, $info);
    }

    private function updateInfos($info)
    {
        foreach ($info as $locale => $infostr) {
            if (empty($infostr)) {
                $query = sprintf(
                    "DELETE FROM uo_location_info WHERE location_id=%d AND locale='%s'",
                    $this->id,
                    $this->database->RealEscapeString($locale)
                );
            } else {
                $query = sprintf(
                    "INSERT INTO uo_location_info (location_id, locale, info) VALUE (%d, '%s', '%s')
		            ON DUPLICATE KEY UPDATE info='%s'",
                    $this->id,
                    $this->database->RealEscapeString($locale),
                    $this->database->RealEscapeString($infostr),
                    $this->database->RealEscapeString($infostr)
                );
            }
            $result = $this->database->DBQuery($query);
            if (!$result) die('Invalid query: ' . $this->database->SQLError());
        }
    }

    function remove()
    {
        if (!isSuperAdmin()) die('Insufficient rights to remove location');
        $query = sprintf("DELETE FROM uo_location WHERE id=%d", (int) $id);
        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());

        $query = sprintf("DELETE FROM uo_location_info WHERE location_id=%d", (int) $id);
        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
    }

    static function add($name, $address, $info, $fields, $indoor, $lat, $lng, $season)
    {
        if (!isSuperAdmin() && !isSeasonAdmin($season)) {
            die('Insufficient rights to add location');
        }
        $query = sprintf(
            "INSERT INTO uo_location (name, address, fields, indoor, lat, lng)
	        VALUES ('%s', '%s', %d, %d, '%s', '%s')",
            GetDatabase()->RealEscapeString($name),
            GetDatabase()->RealEscapeString($address),
            (int) $fields,
            (int) $indoor,
            GetDatabase()->RealEscapeString($lat),
            GetDatabase()->RealEscapeString($lng)
        );

        $result = GetDatabase()->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . GetDatabase()->SQLError());
        }

        $location = new Location(GetDatabase(), GetDatabase()->InsertID());
        $location->updateInfos($info);
        return $location;
    }


    static function searchLocations()
    {
        $locale = str_replace(".", "_", getSessionLocale());
        if (isset($_GET['search']) || isset($_GET['query']) || isset($_GET['q'])) {
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
            } elseif (isset($_GET['query'])) {
                $search = $_GET['query'];
            } else {
                $search = $_GET['q'];
            }

            $query = sprintf(
                "SELECT loc.*, inf1.locale as locale, inf1.info as locale_info,  
                inf2.locale as default_locale, inf2.info as info
                FROM uo_location loc LEFT JOIN uo_location_info inf1
                ON (loc.id = inf1.location_id) LEFT JOIN uo_location_info inf2
                ON (loc.id = inf2.location_id and inf2.locale='%s')
                WHERE (name like '%%%s%%' OR address like '%%%s%%') ORDER BY name",
                $this->database->RealEscapeString($locale),
                $this->database->RealEscapeString($search),
                $this->database->RealEscapeString($search)
            );
        } elseif (isset($_GET['id'])) {
            $query = sprintf(
                "SELECT loc.*, inf1.locale as locale, inf1.info as locale_info,
                inf2.locale as default_locale, inf2.info as info
                FROM uo_location loc LEFT JOIN uo_location_info inf1 
                ON (loc.id = inf1.location_id)
                LEFT JOIN uo_location_info inf2
                ON (loc.id = inf2.location_id and inf2.locale='%s')
                WHERE id=%d ORDER BY name",
                $this->database->RealEscapeString($locale),
                (int) $_GET['id']
            );
        } else {
            $query1 = sprintf(
                "SELECT loc.*, inf1.locale as locale, inf1.info as locale_info,
                inf2.locale as default_locale, inf2.info as info
                FROM uo_location loc LEFT JOIN uo_location_info inf1
                ON (loc.id = inf1.location_id) LEFT JOIN uo_location_info inf2
                ON (loc.id = inf2.location_id and inf2.locale='%s')
                WHERE 1 ORDER BY name",
                $this->database->RealEscapeString($locale)
            );
        }
        $result = $this->database->DBQuery($query);

        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }
}
