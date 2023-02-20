<?php

include_once 'classes/BaseObject.php';
include_once 'classes/Location.php';

class Reservation extends BaseObject
{
    static $tablename = "uo_reservation";

    private $location;
    private $fieldName;
    private $reservationGroup;
    private $startTime;
    private $endTime;
    private $season;
    private $timeSlots;
    private $date;

    function Reservation($database, $id)
    {
        parent::__construct($database, $id);
        $query = sprintf("SELECT * FROM %s WHERE id=%d", static::$tablename, $this->id);
        $result = $this->database->DBQueryToRow($query);
        if (!$result) {
            throw new Exception('Reservation not found.');
        }

        $this->location = $result['location'];
        $this->fieldName = $result['fieldname'];
        $this->reservationGroup = $result['reservationgroup'];
        $this->startTime = $result['starttime'];
        $this->endTime = $result['endtime'];
        $this->season = $result['season'];
        $this->timeSlots = $result['timeslots'];
        $this->date = $result['date'];
    }

    function getPrettyName()
    {
        return $this->getLocation()->getName() . " " . _("Field") . " " .
            $this->getFieldName() . " " .
            $this->getStartTime() . " " .
            $this->getEndTime();
    }

    function getLocation()
    {
        return new Location($this->database, $this->location);
    }

    function getFieldName()
    {
        return $this->fieldName;
    }

    function getReservationGroup()
    {
        return $this->reservationGroup;
    }

    function getStartTime()
    {
        return $this->startTime;
    }

    function getEndTime()
    {
        return $this->endTime;
    }

    function getSeason()
    {
        return $this->season;
    }

    function getTimeSlots()
    {
        return $this->timeSlots;
    }

    function getDate()
    {
        return $this->date;
    }

    function getGames()
    {
        $query = sprintf(
            "SELECT game_id, hometeam, kj.name as hometeamname, visitorteam,
            vj.name as visitorteamname, pp.pool as pool, time, homescore, visitorscore,
            pool.timecap, pool.timeslot, pp.timeslot as gametimeslot, pool.series, pool.color, 
			CONCAT(ser.name, ', ', pool.name) as seriespoolname, ser.name AS seriesname,
            pool.name AS poolname, CONCAT(loc.name, ' " . _("Field") . " ',
            res.fieldname) AS locationname, phome.name AS phometeamname, 
            pvisitor.name AS pvisitorteamname FROM uo_game pp left join uo_reservation 
            res on (pp.reservation=res.id) left join uo_pool pool on (pp.pool=pool.pool_id)
			left join uo_series ser on (pool.series=ser.series_id) left join uo_location loc
            on (res.location=loc.id) left join uo_team kj on (pp.hometeam=kj.team_id)
			left join uo_team vj on (pp.visitorteam=vj.team_id) LEFT JOIN uo_scheduling_name
            AS phome ON (pp.scheduling_name_home=phome.scheduling_id) LEFT JOIN uo_scheduling_name 
            AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id) WHERE res.id=%d",
            $this->id
        );

        if (!empty($seasonId)) {
            $query .= sprintf("	AND ser.season='%s'", GetDatabase()->RealEscapeString($seasonId));
        }

        $query .= " ORDER BY pp.time ASC";
        $result = GetDatabase()->DBQueryToArray($query);
        $games = array();
        foreach ($result as $game) {
            array_push($countries, new Game(GetDatabase(), $game['game_id']));
        }
        return $games;
    }

    static function fields($seasonId)
    {
        $query = sprintf(
            "SELECT loc.name, res.fieldname FROM uo_game pp left join uo_reservation res
            on (pp.reservation=res.id) 
			left join uo_pool pool on (pp.pool=pool.pool_id)
			left join uo_series ser on (pool.series=ser.series_id)
			left join uo_location loc on (res.location=loc.id)
			left join uo_team kj on (pp.hometeam=kj.team_id)
			left join uo_team vj on (pp.visitorteam=vj.team_id)
			LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
			LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)
            WHERE ser.season='%s' GROUP BY res.fieldname",
            GetDatabase()->RealEscapeString($seasonId)
        );

        $result = GetDatabase()->DBQueryToArray($query);
        $locations = array();
        foreach ($result as $location) {
            array_push($locations, new Location(GetDatabase(), $location['id']));
        }
        return $locations;
    }

    /**
     * Set reservation data.
     *
     * Access level: eventadmin
     * 
     * @param array $data: Field data for uo_reservation
     */
    function set($data)
    {
        if (!hasEditSeasonSeriesRight($data['season'])) die('Insufficient rights to change reservation');
        $query = sprintf(
            "UPDATE uo_reservation SET location=%d, fieldname='%s', reservationgroup='%s', 
			    date='%s', starttime='%s', endtime='%s', timeslots='%s', season='%s' WHERE id=%d",
            (int)$data['location'],
            GetDatabase()->RealEscapeString($data['fieldname']),
            GetDatabase()->RealEscapeString($data['reservationgroup']),
            GetDatabase()->RealEscapeString($data['date']),
            GetDatabase()->RealEscapeString($data['starttime']),
            GetDatabase()->RealEscapeString($data['endtime']),
            GetDatabase()->RealEscapeString($data['timeslots']),
            GetDatabase()->RealEscapeString($data['season']),
            $this->id
        );
        GetDatabase()->DBQuery($query);
    }

    function removeFromSeason($id, $season)
    {
        if (!isSuperAdmin() && !isSeasonAdmin($season)) {
            die('Insufficient rights to remove location');
        }
        $query = sprintf("DELETE FROM uo_reservation WHERE id=%d", (int)$id);
        $result = GetDatabase()->DBQuery($query);
        if (!$result) die('Invalid query: ' . GetDatabase()->SQLError());
    }
    
    static function infoArray($reservations)
    {
        $fetch = array();
        foreach ($reservations as $reservation) {
            $fetch[] = (int)$reservation;
        }

        $fetchStr = implode(",", $fetch);
        $query = "SELECT DATE_FORMAT(starttime, '%Y%m%d') as gameday, id
                FROM uo_reservation WHERE id IN (" . $fetchStr . ") 
		        ORDER BY starttime ASC, location, fieldname +0, id";

        $result = GetDatabase()->DBQuery($query);
        if (!$result) die('Invalid query: ' . GetDatabase()->SQLError());
        $ret = array();

        while ($row = GetDatabase()->FetchRow($result)) {
            if (!isset($ret[$row[0]])) {
                $ret[$row[0]] = array();
            }
            
            $next = $ret[$row[0]];
            $nextInfo = new Reservation(GetDatabase(), $row[1]);
            $nextGames = array();
            $gameResults = $nextInfo->getGames($row[1]);
            foreach ($gameResults as $game) {
                $nextGames["" . $game->getId()] = $game;
            }
            $nextInfo['games'] = $nextGames;
            $next["" . $row[1]] = $nextInfo;
            $ret[$row[0]] = $next;
        }
        return $ret;
    }

    /**
     * Add a reservation.
     *
     * Access level: eventadmin
     * 
     * @param array $data: Field data for uo_reservation
     */
    static function add($data)
    {

        if (!hasEditSeasonSeriesRight($data['season'])) die('Insufficient rights to add reservation');
        $query = sprintf(
            "INSERT INTO uo_reservation (location, fieldname, reservationgroup, date, 
			starttime, endtime, timeslots, season)
            VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            (int) $data['location'],
            GetDatabase()->RealEscapeString($data['fieldname']),
            GetDatabase()->RealEscapeString($data['reservationgroup']),
            GetDatabase()->RealEscapeString($data['date']),
            GetDatabase()->RealEscapeString($data['starttime']),
            GetDatabase()->RealEscapeString($data['endtime']),
            GetDatabase()->RealEscapeString($data['timeslots']),
            GetDatabase()->RealEscapeString($data['season'])
        );
        return GetDatabase()->DBQueryInsert($query);
    }

    static function gamesByField($fieldname, $seasonId = "")
    {
        $query = sprintf(
            "SELECT game_id
		    FROM uo_game pp left join uo_reservation res on (pp.reservation=res.id) 
			left join uo_pool pool on (pp.pool=pool.pool_id)
			left join uo_series ser on (pool.series=ser.series_id)
			left join uo_location loc on (res.location=loc.id)
			left join uo_team kj on (pp.hometeam=kj.team_id)
			left join uo_team vj on (pp.visitorteam=vj.team_id)
			LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
			LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)
		    WHERE res.fieldname='%s'",
            GetDatabase()->RealEscapeString($fieldname)
        );

        if (!empty($seasonId)) {
            $query .= sprintf("	AND ser.season='%s'", GetDatabase()->RealEscapeString($seasonId));
        }
        $query .= " ORDER BY pp.time ASC";
        $result = GetDatabase()->DBQueryToArray($query);
        $games = array();
        foreach ($result as $game) {
            array_push($games, new Game(GetDatabase(), $game['game_id']));
        }
        return $games;
    }
}
