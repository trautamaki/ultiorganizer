<?php

include_once 'classes/BaseObject.php';

class Game extends BaseObject
{
    static $tablename = "uo_game";

    private $homeTeamId;
    private $visitorTeamId;
    private $homeScore;
    private $visitorScore;
    private $reservationId;
    private $time;
    private $poolId;
    private $valid;
    private $halftime;
    private $official;
    private $respTeamId;
    private $respPers;
    private $isOngoing;
    private $schedulingNameHomeId;
    private $schedulingNameVisitorId;
    private $name;
    private $timeslot;
    private $homeDefenses;
    private $visitorDefenses;
    private $hasStarted;

    function Game($database, $id)
    {
        parent::__construct($database, $id);
        $query = sprintf("SELECT * FROM %s WHERE game_id=%d", static::$tablename, $this->id);
        $result = $this->database->DBQueryToRow($query);
        if (!$result) {
            throw new Exception('Country not found.');
        }

        $this->homeTeamId = (int) $result['hometeam']; // TODO class
        $this->visitorTeamId = (int) $result['visitorteam']; // TODO class
        $this->homeScore = (int) $result['homescore'];
        $this->visitorScore = (int) $result['visitorscore'];
        $this->reservationId = (int) $result['reservation']; // TODO class
        $this->time = $result['time'];
        $this->poolId = (int) $result['pool']; // TODO class
        $this->valid = (int) $result['valid'];
        $this->halftime = (int) $result['halftime'];
        $this->official = utf8entities($result['official']);
        $this->respTeamId = (int) $result['respteam'];
        $this->respPers = (int) $result['resppers'];
        $this->isOngoing = (int) $result['isongoing'];
        $this->schedulingNameHomeId = (int) $result['scheduling_name_home'];
        $this->schedulingNameVisitorId = (int) $result['scheduling_name_visitor'];
        $this->name = (int) $result['name'];
        $this->timeslot = (int) $result['timeslot'];
        $this->homeDefenses = (int) $result['homedefenses'];
        $this->visitorDefenses = (int) $result['visitordefenses'];
        $this->hasStarted = (int) $result['hasstarted'];
    }

    // TODO update to class
    function getHomeTeam()
    {
        return $this->homeTeamId;
    }

    // TODO update to class
    function getVisitorTeam()
    {
        return $this->visitorTeamId;
    }

    function getHomeScore()
    {
        return $this->homeScore;
    }

    function getVisitorScore()
    {
        return $this->visitorScore;
    }

    function getReservation()
    {
        return $this->reservationId;
    }

    function getTime()
    {
        return $this->time;
    }

    function getPool()
    {
        return $this->poolId;
    }

    function isValid()
    {
        return $this->valid;
    }

    function getHalftime()
    {
        return $this->halftime;
    }

    function getOfficial()
    {
        return $this->official;
    }

    function getRespTeam()
    {
        return $this->respTeamId;
    }

    function getRespPers()
    {
        return $this->respPers;
    }

    function isOngoing()
    {
        return $this->isOngoing;
    }

    function getSchedulingNameHomeId()
    {
        return $this->schedulingNameHomeId;
    }

    function getSchedulingNameVisitorId()
    {
        return $this->schedulingNameVisitorId;
    }

    function getHomeScheduleName()
    {
        $query = sprintf(
            "SELECT name FROM uo_scheduling_name WHERE scheduling_id=%d",
            $this->schedulingNameHomeId,
        );
        return utf8entities($this->database->DBQueryToValue($query));
    }

    function getVisitorScheduleName()
    {
        $query = sprintf(
            "SELECT name FROM uo_scheduling_name WHERE scheduling_id=%d",
            $this->schedulingNameVisitorId,
        );
        return utf8entities($this->database->DBQueryToValue($query));
    }

    function getScoresheet()
    {
        $query = sprintf(
            "SELECT COALESCE(COUNT(*),0) AS scoresheet FROM uo_goal WHERE game=%d",
            $this->id,
        );
        return (int) $this->database->DBQueryToValue($query);
    }

    function getType()
    {
        $query = sprintf("SELECT type FROM uo_series WHERE series_id=%d", $this->getSeries());
        return utf8entities($this->database->DBQueryToValue($query));
    }

    // TODO check
    function getName()
    {
        return $this->name;
    }

    // TODO check following
    function getScheduleName()
    {
        $query = sprintf(
            "SELECT sn.name AS gamename FROM uo_game g
            LEFT JOIN uo_scheduling_name sn ON(g.name=sn.scheduling_id)
            WHERE g.game_id=%d GROUP BY g.game_id",
            $this->id,
        );
        return utf8entities($this->database->DBQueryToValue($query));
    }

    // TODO convert to object?
    function getFieldName()
    {
        $query = sprintf(
            "SELECT game_id, res.fieldname FROM uo_game pp 
            left join uo_reservation res on (pp.reservation=res.id) 
            WHERE pp.game_id=%d",
            $this->id,
        );
        return utf8entities($this->database->DBQueryToValue($query));
    }
    // TODO end

    /**
     * Returns game admins (scorekeepers) for given game.
     *
     * @param int $gameId uo_game.game_id
     * @return php array of users
     */
    function getAdmins()
    {
        $query = sprintf(
            "SELECT u.userid, u.name FROM uo_users u
            LEFT JOIN uo_userproperties up ON (u.userid=up.userid)
            WHERE SUBSTRING_INDEX(up.value, ':', -1)=%d ORDER BY u.name",
            $this->id
        );
        return $this->database->DBQueryToArray($query);
    }

    // TODO check
    function getAutoName()
    {
        return array(
            "hometeamname" => getTeamName($this->homeTeamId),
            "visitorteamname" => getTeamName($this->visitorTeamId),
        );
    }

    /**
     * Replaces the GameName function
     */
    function getPrettyName()
    {
        if (TeamName($this->homeTeamId) && TeamName($this->visitorTeamId)) {
            return ShortDate($this->time) . " " . DefHourFormat($this->time) . " " . TeamName($this->homeTeamId) . "-" . TeamName($this->visitorTeamId);
        } else {
            return ShortDate($this->time) . " " . DefHourFormat($this->time) . " " . $this->getHomeScheduleName() . "-" . $this->getVisitorScheduleName();
        }
    }

    function getTimeslot()
    {
        return $this->timeslot;
    }

    function getHomeDefenses()
    {
        return $this->homeDefenses;
    }

    function getVisitorDefenses()
    {
        return $this->visitorDefenses;
    }

    function hasStarted()
    {
        return $this->hasStarted;
    }

    // TODO improve
    function getResult()
    {
        $query = sprintf(
            "SELECT time, k.name As hometeamname, v.name As visitorteamname, 
                k.valid as homevalid, v.valid as visitorvalid, 
                p.*, hspirit.mode AS spiritmode, hspirit.sotg AS homesotg, vspirit.sotg AS visitorsotg, s.name AS gamename
            FROM uo_game AS p 
            LEFT JOIN (SELECT ssc.game_id, ssc.team_id, ssc.category_id, sct.mode, SUM(value*factor) AS sotg 
            FROM uo_spirit_score ssc 
            LEFT JOIN uo_spirit_category sct ON (ssc.category_id = sct.category_id) 
            GROUP BY game_id, team_id) AS hspirit
            ON (p.game_id = hspirit.game_id AND hspirit.team_id = p.hometeam)
            LEFT JOIN (SELECT ssc.game_id, ssc.team_id, ssc.category_id, sct.mode, SUM(value*factor) AS sotg 
            FROM uo_spirit_score ssc 
            LEFT JOIN uo_spirit_category sct ON (ssc.category_id = sct.category_id) 
            GROUP BY game_id, team_id ) AS vspirit
            ON (p.game_id = hspirit.game_id AND vspirit.team_id = p.visitorteam)
            LEFT JOIN uo_team As k ON (p.hometeam=k.team_id) 
            LEFT JOIN uo_team AS v ON (p.visitorteam=v.team_id)
            LEFT JOIN uo_scheduling_name s ON(s.scheduling_id=p.name)
            WHERE p.game_id='%d'",
            ($this->id)
        );
        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }

        return $this->database->FetchAssoc($result);
    }

    function getGoalInfo($num)
    {
        $query = sprintf(
            "SELECT m.*, s.profile_id AS assist_accrid, s.firstname AS assistfirstname,
            s.lastname AS assistlastname, t.profile_id AS scorer_accrid,
            t.firstname AS scorerfirstname, t.lastname AS scorerlastname
            FROM (uo_goal AS m LEFT JOIN uo_player AS s ON (m.assist = s.player_id)) 
            LEFT JOIN uo_player AS t ON (m.scorer=t.player_id) WHERE m.game=%d AND m.num=%d",
            $this->id,
            (int) $num
        );

        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }
        if ($row = $this->database->FetchAssoc($result)) {
            return $row;
        } else return false;
    }

    function getSeries()
    {
        $query = sprintf(
            "SELECT s.series FROM uo_game p left join uo_pool s on (p.pool=s.pool_id)
            WHERE game_id=%d",
            $this->id
        );
        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }

        return $this->database->FetchRow($result)[0];
    }

    function getIsFirstOffenceHome()
    {
        $query = sprintf(
            "SELECT ishome FROM uo_gameevent WHERE game=%d",
            $this->id
        );
        $result = $this->database->DBQuery($query);

        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        if (!$this->database->NumRows($result)) return -1;
        return $this->database->FetchRow($result)[0];
    }

    // TODO update
    function getSeason()
    {
        $query = sprintf(
            "SELECT ser.season FROM uo_game p LEFT JOIN uo_pool s on (p.pool=s.pool_id)
            LEFT JOIN uo_series ser ON (s.series=ser.series_id) WHERE game_id=%d",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $this->database->FetchRow($result)[0];
    }

    function getPlayers($teamId)
    {
        $query = sprintf(
            "SELECT p.player_id, pg.num, p.firstname, p.lastname FROM uo_played AS pg
            LEFT JOIN uo_player AS p ON(pg.player=p.player_id)
            WHERE pg.game=%d AND p.team=%d",
            $this->id,
            (int) $teamId
        );

        return $this->database->DBQueryToArray($query);
    }

    function getCaptain($teamId)
    {
        $query = sprintf(
            "SELECT pg.player, pg.num FROM uo_played AS pg 
            LEFT JOIN uo_player AS p ON(pg.player=p.player_id)
            WHERE pg.captain=1 AND pg.game=%d AND p.team=%d",
            $this->id,
            (int) $teamId
        );

        return $this->database->DBQueryToValue($query);
    }

    // TODO return a player
    function getPlayerFromNumber($teamId, $number)
    {
        $query = sprintf(
            "SELECT p.player_id FROM uo_player AS p 
            INNER JOIN (SELECT player, num FROM uo_played WHERE game=%d)
            AS pel ON (p.player_id=pel.player) 
            WHERE p.team=%d AND pel.num=%d",
            $this->id,
            (int) $teamId,
            (int) $number
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        if (!$this->database->NumRows($result)) return -1;

        $row = $this->database->FetchRow($result);

        if ($row && $row[0]) {
            return intval($row[0]);
        }

        return -1;
    }

    function getTeamScoreboard($teamId)
    {
        $query = sprintf(
            "SELECT p.player_id, p.firstname, p.lastname, p.profile_id, COALESCE(t.done,0) AS done, COALESCE(s.fedin,0) AS fedin, 
            (COALESCE(t.done,0) + COALESCE(s.fedin,0)) AS total, pel.num AS num FROM uo_player AS p 
            LEFT JOIN (SELECT m.scorer AS scorer, COUNT(*) AS done 
            FROM uo_goal AS m WHERE m.game=%d AND m.scorer IS NOT NULL GROUP BY scorer) AS t ON (p.player_id=t.scorer) 
            LEFT JOIN (SELECT m2.assist AS assist, COUNT(*) AS fedin FROM uo_goal AS m2 
            WHERE m2.game=%d AND m2.assist IS NOT NULL GROUP BY assist) AS s ON (p.player_id=s.assist) 
            RIGHT JOIN (SELECT player, num FROM uo_played WHERE game=%d) as pel ON (p.player_id=pel.player) 
            WHERE p.team=%d ORDER BY total DESC, done DESC, fedin DESC, lastname ASC, firstname ASC",
            $this->id,
            $this->id,
            $this->id,
            (int) $teamId
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function getTeamDefenceBoard($teamId)
    {
        $query = sprintf(
            "SELECT p.player_id, p.firstname, p.lastname, p.profile_id, COALESCE(t.done,0) AS done, pel.num AS num FROM uo_player AS p
            LEFT JOIN (SELECT m.author AS author, COUNT(*) AS done
            FROM uo_defense AS m WHERE m.game=%d AND m.author IS NOT NULL GROUP BY author) AS t ON (p.player_id=t.author)
            RIGHT JOIN (SELECT player, num FROM uo_played WHERE game=%d) as pel ON (p.player_id=pel.player)
            WHERE p.team=%d
            ORDER BY done DESC, lastname ASC, firstname ASC",
            $this->id,
            $this->id,
            (int) $teamId
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function getScoreboard()
    {
        $query = sprintf(
            "SELECT p.profile_id, p.player_id, p.firstname, p.lastname, pj.name AS teamname,
            COALESCE(t.done,0) AS done, COALESCE(s.fedin,0) AS fedin,
            (COALESCE(t.done,0) + COALESCE(s.fedin,0)) AS total
            FROM uo_player AS p LEFT JOIN (SELECT m.scorer AS scorer, COUNT(*) AS done
            FROM uo_goal AS m WHERE m.game=%d AND m.scorer IS NOT NULL
            GROUP BY scorer) AS t ON (p.player_id=t.scorer)
            LEFT JOIN (SELECT m2.assist AS assist, COUNT(*) AS fedin
            FROM uo_goal AS m2 WHERE m2.game=%d AND m2.assist IS NOT NULL
            GROUP BY assist) AS s ON (p.player_id=s.assist)
            RIGHT JOIN (SELECT player, num FROM uo_played
            WHERE game=%d) as pel ON (p.player_id=pel.player)
            LEFT JOIN uo_team pj ON (pj.team_id=p.team)
            WHERE p.profile_id IS NOT NULL AND p.lastname IS NOT NULL
            ORDER BY p.profile_id",
            $this->id,
            $this->id,
            $this->id,
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function getGoals()
    {
        $query = sprintf(
            "SELECT m.*, s.firstname AS assistfirstname, s.lastname AS assistlastname,
            t.firstname AS scorerfirstname, t.lastname AS scorerlastname 
            FROM (uo_goal AS m LEFT JOIN uo_player AS s ON (m.assist = s.player_id)) 
            LEFT JOIN uo_player AS t ON (m.scorer=t.player_id) WHERE m.game=%d ORDER BY m.num",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function getDefences()
    {
        $query = sprintf(
            "SELECT m.*, s.firstname AS defenderfirstname, s.lastname AS defenderlastname
            FROM (uo_defense AS m LEFT JOIN uo_player AS s ON (m.author = s.player_id))
            WHERE m.game=%d ORDER BY m.num",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    // TODO class Goal
    function getLastGoal()
    {
        $query = sprintf(
            "SELECT m.*, s.firstname AS assistfirstname, s.lastname AS assistlastname,
            t.firstname AS scorerfirstname, t.lastname AS scorerlastname 
            FROM (uo_goal AS m LEFT JOIN uo_player AS s ON (m.assist = s.player_id)) 
            LEFT JOIN uo_player AS t ON (m.scorer=t.player_id) 
            WHERE m.game=%d ORDER BY m.num DESC",
            $this->id
        );

        return $this->database->DBQueryToRow($query);
    }

    // TODO class Goal
    function getAllGoals()
    {
        $query = sprintf(
            "SELECT num, time, ishomegoal FROM uo_goal WHERE game=%d ORDER BY time",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function getEvents()
    {
        $query = sprintf(
            "SELECT time, ishome, type FROM (SELECT time, ishome, 'timeout' AS type
            FROM `uo_timeout` WHERE game=%d UNION ALL SELECT time, ishome, type
            FROM uo_gameevent WHERE game=%d) AS tapahtuma WHERE type!='media' ORDER BY time",
            $this->id,
            $this->id
        );

        return $this->database->DBQueryToArray($query);
    }

    function getMediaEvents()
    {
        $query = sprintf(
            "SELECT u.time, u.ishome, u.type as eventtype, u.info, urls.*
            FROM uo_gameevent u LEFT JOIN uo_urls urls ON(u.info=urls.url_id)
            WHERE u.game=%d AND u.type='media' ORDER BY time ",
            $this->id
        );

        return $this->database->DBQueryToArray($query);
    }

    function addMediaEvent($time, $urlId)
    {
        if (!hasAddMediaRight()) die('Insufficient rights to add media');

        $lastnum = $this->database->DBQueryToValue(
            "SELECT MAX(num) FROM uo_gameevent WHERE game=" . $this->id
        );

        $lastnum = intval($lastnum) + 1;
        $query = sprintf(
            "INSERT INTO uo_gameevent (game, num, ishome, time, type, info)
            VALUES(%d, $lastnum, 0, %d, 'media', %d)",
            $this->id,
            (int) $time,
            (int) $urlId
        );

        $this->database->DBQuery($query);
        return $this->database->InsertID();
    }

    function removeMediaEvent($urlId)
    {
        if (!hasAddMediaRight()) die('Insufficient rights to remove media');
        $query = sprintf(
            "DELETE FROM uo_gameevent WHERE game=%d AND info=%d",
            $this->id,
            (int) $urlId
        );
        return $this->database->DBQuery($query);
    }

    function getTimeouts()
    {
        $query = sprintf(
            "SELECT num, time, ishome FROM uo_timeout WHERE game=%d ORDER BY time",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function getTurnovers()
    {
        $query = sprintf(
            "SELECT time, ishome FROM uo_gameevent 
            WHERE game=%d AND type='turnover' ORDER BY time",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function updateResult($home, $away)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "UPDATE uo_game SET homescore=%d, visitorscore=%d, isongoing='1', hasstarted='1'
            WHERE game_id=%d",
            (int) $home,
            (int) $away,
            $this->id
        );
        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }


    function setResult($home, $away, $updatePools = true, $checkRights = true)
    {
        if ($checkRights && !hasEditGameEventsRight($this->id)) {
            die('Insufficient rights to edit game');
        }
        LogGameUpdate($this->id, "result: $home - $away");
        $query = sprintf(
            "UPDATE uo_game SET homescore=%d, visitorscore=%d, isongoing='0', hasstarted='2'
            WHERE game_id=%d",
            (int) $home,
            (int) $away,
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());

        if ($updatePools) {
            $poolId = $this->poolId;
            ResolvePoolStandings($poolId);
            PoolResolvePlayed($poolId);
        }

        if (IsTwitterEnabled()) {
            TweetGameResult($this->id);
        }

        if (IsFacebookEnabled()) {
            TriggerFacebookEvent($this->id, "game", 0);
        }

        return $result;
    }

    function checkResult($home, $away)
    {
        $errors = "";
        $pool = $this->poolId;
        if (!$pool) {
            $errors .= "<p class='warning'>" . _("Game has no pool.") . "</p>";
        } else {
            if (IsPoolLocked($pool)) {
                $errors .= "<p class='warning'>" . _("Pool is locked.") . "</p>";
            }
        }

        if (IsSeasonStatsCalculated($this->getSeason())) {
            $errors .= "<p class='warning'>" . _("Event played.") . "</p>";
        }

        if (!($home + $away)) {
            $errors .= "<p class='warning'>" . _("No goals.") . "</p>";
        }

        return $errors;
    }

    function clearResult($updatepools = true)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        LogGameUpdate($this->id, "result cleared");
        $query = sprintf(
            "UPDATE uo_game SET homescore=NULL, visitorscore=NULL, isongoing='0', hasstarted='0'
            WHERE game_id='%s'",
            $this->database->RealEscapeString($this->id)
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());

        if ($updatepools) {
            $poolId = $this->poolId;
            ResolvePoolStandings($poolId);
            PoolResolvePlayed($poolId);
        }

        if (IsTwitterEnabled()) {
            TweetGameResult($this->id);
        }

        if (IsFacebookEnabled()) {
            TriggerFacebookEvent($this->id, "game", 0);
        }

        return $result;
    }

    function setDefenses($home, $visitor)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "UPDATE uo_game SET homedefenses=%d, visitordefenses=%d WHERE game_id=%d",
            (int) $home,
            (int) $visitor,
            $this->id
        );

        $this->homeDefenses = (int) $home;
        $this->visitorDefenses = (int) $visitor;

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());

        if (IsFacebookEnabled()) {
            TriggerFacebookEvent($this->id, "game", 0);
        }

        return $result;
    }

    function addPlayer($playerId, $number)
    {
        if (!hasEditGamePlayersRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "INSERT INTO uo_played (game, player, num, accredited)
            VALUES ('%s', '%s', '%s', %d) ON DUPLICATE KEY UPDATE num=%d",
            $this->id,
            (int) $playerId,
            (int) $number,
            (int) isAccredited($playerId),
            (int) $number
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());

        $query = sprintf(
            "UPDATE uo_player SET num=%d WHERE player_id=%d",
            (int) $number,
            (int) $playerId
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function removePlayer($playerId)
    {
        if (!hasEditGamePlayersRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "DELETE FROM uo_played WHERE game=%d AND player=%d",
            $this->id,
            (int) $playerId
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function removeAllPlayers()
    {
        if (!hasEditGamePlayersRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf("DELETE FROM uo_played WHERE game=%d", $this->id);

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function setPlayerNumber($playerId, $number)
    {
        if (!hasEditGamePlayersRight($this->id)) {
            die('Invalid query: ' . $this->database->SQLError());
        }
        $query = sprintf(
            "UPDATE uo_played SET num=%d, accredited=%d WHERE game=%d AND player=%d",
            (int) $number,
            (int) isAccredited($playerId),
            $this->id,
            (int) $playerId
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function removeAllScores()
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "DELETE FROM uo_goal WHERE game=%d",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function removeAllDefenses()
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf("DELETE FROM uo_defense WHERE game=%d", $this->id);

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function removeScore($num)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf("DELETE FROM uo_goal WHERE game=%d AND num=%d", $this->id, $num);

        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }

        return $result;
    }


    /**
     * Add goal to game. Does not update game result!
     * 
     */
    function addScore($pass, $goal, $time, $number, $hscores, $ascores, $home, $iscallahan)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "INSERT INTO uo_goal 
            (game, num, assist, scorer, time, homescore, visitorscore, ishomegoal, iscallahan) 
            VALUES (%d, %d, %d, %d, '%s', %d, %d, %d, %d) ON DUPLICATE KEY UPDATE 
            assist=%d, scorer=%d, time='%s', homescore=%d, visitorscore=%d, ishomegoal=%d, iscallahan=%d",
            $this->id,
            (int) ($number),
            (int) ($pass),
            (int) ($goal),
            $this->database->RealEscapeString($time),
            (int) ($hscores),
            (int) ($ascores),
            (int) ($home),
            (int) ($iscallahan),
            (int) ($pass),
            (int) ($goal),
            $this->database->RealEscapeString($time),
            (int) ($hscores),
            (int) ($ascores),
            (int) ($home),
            (int) $iscallahan
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        if (IsFacebookEnabled()) {
            TriggerFacebookEvent($this->id, "goal", $number);
        }
        return $result;
    }

    function addScoreEntry($uo_goal)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "INSERT INTO uo_goal 
            (game, num, assist, scorer, time, homescore, visitorscore, ishomegoal, iscallahan) 
            VALUES (%d, %d, %d, %d, '%s', %d, %d, %d', %d)",
            $this->id,
            (int) $uo_goal['num'],
            (int) $uo_goal['assist'],
            (int) $uo_goal['scorer'],
            $this->database->RealEscapeString($uo_goal['time']),
            (int) $uo_goal['homescore'],
            (int) $uo_goal['visitorscore'],
            (int) $uo_goal['ishomegoal'],
            (int) $uo_goal['iscallahan']
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());

        if (IsFacebookEnabled()) {
            TriggerFacebookEvent($this->id, "goal", $uo_goal['scorer']);
        }
        return $result;
    }

    function removeAllTimeouts()
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf("DELETE FROM uo_timeout WHERE game=%d", $this->id);
        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function addTimeout($number, $time, $home)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "INSERT INTO uo_timeout (game, num, time, ishome) VALUES (%d, %d, '%s', %d)",
            $this->id,
            (int) $number,
            $this->database->RealEscapeString($time),
            (int) $home
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    // TODO break to seperate class?
    function getSpiritPoints($teamId)
    {
        $query = sprintf(
            "SELECT * FROM uo_spirit_score WHERE game_id=%d AND team_id=%d",
            $this->id,
            (int) $teamId
        );
        $scores = $this->database->DBQueryToArray($query);
        $points = array();
        foreach ($scores as $score) {
            $points[$score['category_id']] = $score['value'];
        }
        return $points;
    }

    function setSpiritPoints($teamId, $home, $points, $categories)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "DELETE FROM uo_spirit_score WHERE game_id=%d AND team_id=%d",
            $this->id,
            (int) $teamId
        );

        $this->database->DBQuery($query);

        foreach ($points as $cat => $value) {
            if (!is_null($value)) {
                $query = sprintf(
                    "INSERT INTO uo_spirit_score (`game_id`, `team_id`, `category_id`, `value`)
                    VALUES (%d, %d, %d, %d)",
                    $this->id,
                    (int) $teamId,
                    (int) $cat,
                    (int) $value
                );
                $this->database->DBQuery($query);
            }
        }
    }

    function addDefense($player, $home, $caught, $time, $iscallahan, $number)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = sprintf(
            "INSERT INTO uo_defense (game, num, author, time, iscallahan, iscaught, ishomedefense)
            VALUES (%d, %d, %d, '%s', %d, %d, %d) ON DUPLICATE KEY UPDATE
            author=%d, time='%s', iscallahan=%d, iscaught=%d, ishomedefense=%d",
            $this->id,
            (int) $number,
            (int) $player,
            $this->database->RealEscapeString($time),
            (int) $iscallahan,
            (int) $caught,
            (int) $home,
            (int) $player,
            $this->database->RealEscapeString($time),
            (int) $iscallahan,
            (int) $caught,
            (int) $home
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function setOfficial($name)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        if (isset($name)) {
            $query = sprintf(
                "UPDATE uo_game SET official='%s' WHERE game_id=%d",
                $this->database->RealEscapeString($name),
                $this->id
            );
        } else {
            $query = sprintf("UPDATE uo_game SET official=NULL WHERE game_id=%d", $this->id);
        }

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        $this->official = $name;
        return $result;
    }

    function setHalftime($time)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        if (isset($time)) {
            $query = sprintf(
                "UPDATE uo_game SET halftime='%s' WHERE game_id=%d",
                $this->database->RealEscapeString($time),
                $this->id
            );
        } else {
            $query = sprintf("UPDATE uo_game SET halftime=NULL WHERE game_id=%d", $this->id);
        }

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        $this->halftime = $time;
        return $result;
    }

    function setCaptain($teamId, $playerId)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $captain = $this->getCaptain($teamId);
        if ($captain != $playerId) {
            $query = sprintf(
                "UPDATE uo_played SET captain=0 WHERE game=%d AND player=%d",
                $this->id,
                (int) $captain
            );
            $this->database->DBQuery($query);

            $query = sprintf(
                "UPDATE uo_played SET captain=1 WHERE game=%d AND player=%d",
                $this->id,
                (int) $playerId
            );
            $this->database->DBQuery($query);
        }
    }

    function setStartingTeam($home)
    {
        if (!hasEditGameEventsRight($this->id)) die('Insufficient rights to edit game');
        $query = "";
        if ($home == NULL) {
            $query = sprintf(
                "DELETE FROM uo_gameevent WHERE game=%d AND type='offence'",
                $this->id
            );
        } else {
            $query = sprintf(
                "INSERT INTO uo_gameevent (game, num, time, type, ishome)
                VALUES (%d, 0, 0, 'offence', %d) ON DUPLICATE KEY UPDATE ishome='%d'",
                $this->id,
                (int) $home,
                (int) $home
            );
        }

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function set($params)
    {
        $poolinfo = PoolInfo($params['pool']);
        if (!hasEditGamesRight($poolinfo['series'])) die('Insufficient rights to edit game');

        foreach ($params as $key => $param) {
            if (!empty($param)) {
                $query = sprintf(
                    "UPDATE uo_game SET %s='%s' WHERE game_id=%d",
                    $key,
                    $this->database->RealEscapeString($param),
                    $this->id
                );
                $result = $this->database->DBQuery($query);
            }
        }

        if (!empty($params['respteam'])) {
            $query = sprintf(
                "UPDATE uo_game SET respteam=%d WHERE game_id=%d",
                (int) $params['respteam'],
                $this->id
            );
        } else {
            $query = sprintf(
                "UPDATE uo_game SET respteam=NULL WHERE game_id=%d",
                $this->id
            );
        }
        $this->database->DBQuery($query);

        if (!empty($params['name'])) {
            $query = sprintf(
                "INSERT INTO uo_scheduling_name (name) VALUES ('%s')",
                $this->database->RealEscapeString($params['name'])
            );
            $nameId = $this->database->DBQueryInsert($query);

            $query = sprintf(
                "UPDATE uo_game SET name=%d	WHERE game_id=%d",
                (int) $nameId,
                $this->id
            );
            $this->database->DBQuery($query);
        }

        return $result;
    }

    /**
     * Swap home and visitor teams and results.
     */
    function changeHome()
    {
        $series = $this->getSeries();
        if (!hasEditGamesRight($series)) die('Insufficient rights to delete game');

        $query = sprintf(
            "SELECT hometeam, visitorteam, respteam, homescore, visitorscore,
            scheduling_name_home, scheduling_name_visitor FROM uo_game WHERE game_id=%d",
            $this->id
        );
        $game = $this->database->DBQueryToRow($query);

        $query = sprintf(
            "UPDATE uo_game SET hometeam=%d, visitorteam=%d, homescore=%d, visitorscore=%d,
            scheduling_name_home=%d, scheduling_name_visitor=%d WHERE game_id=%d",
            $this->visitorTeamId,
            $this->homeTeamId,
            $this->visitorScore,
            $this->homeScore,
            $this->schedulingNameVisitorId,
            $this->schedulingNameHomeId,
            $this->id
        );
        $this->database->DBQuery($query);

        if ($game->getHomeTeam() == $game->getRespTeam()) {
            $query = sprintf(
                "UPDATE uo_game SET respteam=%d	WHERE game_id=%d",
                $this->visitorTeamId,
                $this->id
            );
            $this->database->DBQuery($query);
        }

        [$this->visitorTeamId, $this->homeTeamId] = 
                [$this->visitorTeamId, $this->homeTeamId];
        [$this->visitorScore, $this->homeScore] =
                [$this->visitorScore, $this->homeScore];
        [$this->schedulingNameVisitorId, $this->schedulingNameHomeId] =
                [$this->schedulingNameVisitorId, $this->schedulingNameHomeId];
    }

    function remove()
    {
        $game = new Game($this->database, $this->id);
        $series = $game->getSeries();
        if (!hasEditGamesRight($series)) die('Insufficient rights to delete game');
        Log2("game", "delete", $this->getPrettyName());
        $query = sprintf(
            "DELETE FROM uo_game WHERE game_id=%d",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        $query = sprintf(
            "DELETE FROM uo_game_pool WHERE game=%d AND timetable=1",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function deleteMoved($poolId)
    {
        $series = $this->getSeries();
        if (!hasEditGamesRight($series)) die('Insufficient rights to delete game');
        Log1("game", "delete", $this->id, $poolId, "Delete moved game");
        $query = sprintf(
            "DELETE FROM uo_game_pool WHERE (game=%d AND pool=%d AND timetable=0)",
            $this->id,
            (int) $poolId
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        return $result;
    }

    function setSchedule($epoc, $reservation)
    {
        if (!hasEditGamesRight($this->getSeries())) die('Insufficient rights to schedule game');
        $query = sprintf(
            "UPDATE uo_game SET time='%s', reservation=%d WHERE game_id=%d",
            EpocToMysql($epoc),
            (int) $reservation,
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }
    }

    function removeSchedule()
    {
        if (!hasEditGamesRight($this->getSeries())) die('Insufficient rights to schedule game');
        $query = sprintf(
            "UPDATE uo_game SET time=NULL, reservation=NULL WHERE game_id=%d",
            $this->id
        );

        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
    }

    function canDelete()
    {
        $query = sprintf(
            "SELECT count(*) FROM uo_goal WHERE game=%d",
            $this->id
        );
        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        $row = $this->database->FetchRow($result);
        if (!$row || $row[0] != 0) return false;

        $query = sprintf(
            "SELECT count(*) FROM uo_played WHERE game=%d",
            (int) $this->id
        );
        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        $row = $this->database->FetchRow($result);
        if (!$row || $row[0] != 0) return false;

        $query = sprintf(
            "SELECT count(*) FROM uo_gameevent WHERE game=%d",
            (int) $this->id
        );
        $result = $this->database->DBQuery($query);
        if (!$result) die('Invalid query: ' . $this->database->SQLError());
        $row = $this->database->FetchRow($result);
        if (!$row || $row[0] != 0) return false;

        $query = sprintf(
            "SELECT homescore,visitorscore FROM uo_game WHERE game_id=%d",
            (int) $this->id
        );
        $result = $this->database->DBQuery($query);
        if (!$result) {
            die('Invalid query: ' . $this->database->SQLError());
        }
        if (!$row = $this->database->FetchRow($result)) return false;

        return (intval($row[0]) + intval($row[1])) == 0;
    }

    static function processMassInput($post)
    {
        $html = "";
        $scores = array();
        $changed = array();
        $ok_clear = 0;
        $ok_set = 0;
        $error_set = 0;
        $error_clear = 0;

        foreach ($post['scoreId'] as $key => $value) {
            $scores[$key]['gameid'] = $value;
        }
        foreach ($post['homescore'] as $key => $value) {
            $scores[$key]['home'] = $value;
        }
        foreach ($post['visitorscore'] as $key => $value) {
            $scores[$key]['visitor'] = $value;
        }
        foreach ($scores as $score) {
            $gameId = $score['gameid'];
            $game = new Game(GetDatabase(), $gameId);
            if ($game->getHomeScore() !== $score['home'] ||
                    $game->getVisitorScore() !== $score['visitor']) {
                if ($score['home'] === "" && $score['visitor'] === "" &&
                        (!is_null($game->getHomeScore()) ||
                        !is_null($game->getVisitorScore()))) {
                    $ok = $game->clearResult(false);
                    if ($ok) {
                        $ok_clear++;
                        $changed[$game->getPool()] = 1;
                    } else {
                        $error_clear++;
                    }
                } else if ($score['home'] !== "" && $score['visitor'] !== "") {
                    $ok = $game->setResult($score['home'], $score['visitor'], false);
                    if ($ok) {
                        $ok_set++;
                        $changed[$game->getPool()] = 1;
                    } else {
                        $error_set++;
                    }
                }
            }
        }

        if ($ok_clear > 0)
            $html .= "<p>" . sprintf(_("Results cleared: %s."), $ok_clear) . "</p>";
        if ($ok_set > 0)
            $html .= "<p>" . sprintf(_("Results changed: %s."), $ok_set) . "</p>";
        if ($error_clear + $error_set > 0)
            $html .= "<p>" . sprintf(_("Errors: %s."), ($error_clear + $error_set)) . "</p>";

        foreach ($changed as $poolId => $ok) {
            if ($ok > 0) {
                ResolvePoolStandings($poolId);
                PoolResolvePlayed($poolId);
            }
        }

        return $html;
    }


    static function getAll($limit)
    {
        $limit = intval($limit);
        //common game query
        $query =
            "SELECT pp.game_id, pp.time, pp.hometeam, pp.visitorteam, pp.homescore, 
            pp.visitorscore, pp.pool AS pool, pool.name AS poolname, pool.timeslot,
            ps.series_id, ps.name AS seriesname, ps.season, s.name AS seasonname, ps.type,
            pr.fieldname, pr.reservationgroup, pr.id AS reservation_id, pr.starttime,
            pr.endtime, pl.id AS place_id, pl.name AS placename, pl.address, pp.isongoing,
            pp.hasstarted, home.name AS hometeamname, visitor.name AS visitorteamname,
            phome.name AS phometeamname, pvisitor.name AS pvisitorteamname, pool.color,
            pgame.name AS gamename, home.abbreviation AS homeshortname, visitor.abbreviation
            AS visitorshortname, homec.country_id AS homecountryid, homec.name AS homecountry,
            visitorc.country_id AS visitorcountryid, visitorc.name AS visitorcountry,
            s.timezone FROM uo_game pp 
            LEFT JOIN uo_pool pool ON (pool.pool_id=pp.pool) 
            LEFT JOIN uo_series ps ON (pool.series=ps.series_id)
            LEFT JOIN uo_season s ON (s.season_id=ps.season)
            LEFT JOIN uo_reservation pr ON (pp.reservation=pr.id)
            LEFT JOIN uo_location pl ON (pr.location=pl.id)
            LEFT JOIN uo_team AS home ON (pp.hometeam=home.team_id)
            LEFT JOIN uo_team AS visitor ON (pp.visitorteam=visitor.team_id)
            LEFT JOIN uo_country AS homec ON (homec.country_id=home.country)
            LEFT JOIN uo_country AS visitorc ON (visitorc.country_id=visitor.country)
            LEFT JOIN uo_scheduling_name AS pgame ON (pp.name=pgame.scheduling_id)
            LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
            LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)
            WHERE pp.valid=true AND pp.hasstarted>0 AND pp.isongoing=0  ORDER BY pp.time
            DESC, ps.ordering, pool.ordering, pp.game_id
            LIMIT $limit";
        return GetDatabase()->DBQuery($query);
    }

    static function getHomeTeamResults($teamId, $poolId)
    {
        $query = sprintf(
            "SELECT g.game_id, g.homescore, g.visitorscore, g.hasstarted, g.visitorteam,
            COALESCE(pm.goals,0) AS scoresheet, sn.name AS gamename, g.isongoing, g.hasstarted
            FROM uo_game g LEFT JOIN (SELECT COUNT(*) AS goals, game FROM uo_goal
            GROUP BY game) AS pm ON (g.game_id=pm.game) LEFT JOIN uo_scheduling_name sn
            ON(g.name=sn.scheduling_id) WHERE g.hometeam=%d AND g.pool=%d GROUP BY g.game_id",
            (int) $teamId,
            (int) $poolId
        );
        return GetDatabase()->DBQueryToArray($query);
    }

    static function getHomePseudoTeamResults($schedulingId, $poolId)
    {
        $query = sprintf(
            "SELECT g.game_id, g.homescore, g.visitorscore, g.hasstarted, g.visitorteam, 
            sn.name AS gamename, g.isongoing, g.hasstarted FROM uo_game g 
            LEFT JOIN uo_scheduling_name sn ON(g.name=sn.scheduling_id)
            WHERE g.scheduling_name_home=%d AND g.pool=%d GROUP BY g.game_id",
            (int) $schedulingId,
            (int) $poolId
        );
        return GetDatabase()->DBQueryToArray($query);
    }

    static function getVisitorTeamResults($teamId, $poolId)
    {
        $query = sprintf(
            "SELECT g.game_id, g.homescore, g.visitorscore, g.hasstarted, g.hometeam,
            COALESCE(pm.goals,0) AS scoresheet FROM uo_game g 
            LEFT JOIN (SELECT COUNT(*) AS goals, game FROM uo_goal GROUP BY game)
            AS pm ON (g.game_id=pm.game) WHERE g.visitorteam=%d AND g.pool=%d
            AND g.hasstarted>0 AND g.valid=1 AND isongoing=0 GROUP BY g.game_id",
            (int) $teamId,
            (int) $poolId
        );
        return GetDatabase()->DBQueryToArray($query);
    }
}
