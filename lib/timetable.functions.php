<?php
include_once $include_prefix . 'lib/configuration.functions.php';
include_once $include_prefix . 'lib/game.functions.php';

include_once $include_prefix . 'classes/Game.php';
include_once $include_prefix . 'classes/Url.php';

function TournamentView($games, $grouping = true)
{

  $ret = "";
  $prevTournament = "";
  $prevPlace = "";
  $prevSeries = "";
  $prevPool = "";
  $prevTeam = "";
  $prevDate = "";
  $prevTimezone = "";
  $isTableOpen = false;
  $rss = IsGameRSSEnabled();

  foreach ($games as $game) {
    $reservationgroup = $starttime = $locationid = $reservationId = "";
    $reservation = $game->getReservation();
    if ($reservation != NULL) {
      $reservationId = $reservation->getId();
      $reservationgroup = $reservation->getReservationGroup();
      $starttime = $reservation->getStartTime();
      $location = $reservation->getLocation();
      if ($location != NULL) {
        $locationid = $location->getId();
      }
    }
    
    $ret .= "\n<!-- res:" . $reservationgroup . " pool:" . $game->getPool() . " date:" . JustDate($starttime) . "-->\n";
    if ($reservationgroup != $prevTournament || (empty($reservationgroup) && !$isTableOpen)) {
      if ($isTableOpen) {
        $ret .= "</table>\n";
        $ret .= "<hr/>\n";
        $isTableOpen = false;
      }
      if ($grouping) {
        $ret .= "<h1>" . U_($reservationgroup) . "</h1>\n";
      }
      $prevPlace = "";
    }

    if (JustDate($starttime) != $prevDate || $locationid != $prevPlace) {
      if ($isTableOpen) {
        $ret .= "</table>\n";
        $isTableOpen = false;
      }
      $ret .= "<h3>";
      $ret .= DefWeekDateFormat($starttime);
      $ret .= " ";
      $ret .= "<a href='?view=reservationinfo&amp;reservation=" . $reservationId . "'>";
      $ret .= U_($game->getPlaceName());
      $ret .= "</a>";
      $ret .= "</h3>\n";
      $prevPool = "";
    }

    if ($game->getPool() != $prevPool) {
      if ($isTableOpen) {
        $ret .= "</table>\n";
        $isTableOpen = false;
      }
      $ret .= "<table cellpadding='2' border='0' cellspacing='0'>\n";
      $isTableOpen = true;
      $ret .= SeriesAndPoolHeaders($game);
    }

    if ($isTableOpen) {
      $ret .= GameRow($game, false, true, true, false, false, true, $rss);
    }

    $prevTournament = $reservationgroup;
    $prevPlace = $locationid;
    $prevPool = $game->getPool();
    $prevDate = JustDate($starttime);
    $prevTimezone = $game->getTimezone();
  }

  if ($isTableOpen) {
    $ret .= "</table>\n";
  }
  $ret .= PrintTimeZone($prevTimezone);
  return $ret;
}

function SeriesView($games, $date = true, $time = false)
{
  $ret = "";
  $prevSeries = "";
  $prevPool = "";
  $prevTimezone = "";
  $isTableOpen = false;
  $rss = IsGameRSSEnabled();

  foreach ($games as $game) {
    if (
      $game->getSeries() != $prevSeries
      || (empty($game->getSeries()) && !$isTableOpen)
    ) {
      if ($isTableOpen) {
        $ret .= "</table>\n";
        $ret .= "<hr/>\n";
        $isTableOpen = false;
      }
      $ret .= "<h1>" . SeriesName(U_($game->getSeries())) . "</h1>\n";
    }

    if ($game->getPool() != $prevPool) {
      if ($isTableOpen) {
        $ret .= "</table>\n";
        $isTableOpen = false;
      }
      $ret .= "<table cellpadding='2' border='0' cellspacing='0'>\n";
      $isTableOpen = true;
      $ret .= PoolHeaders($game);
    }

    $ret .= GameRow($game, true, true, true, false, false, true, $rss);

    $prevSeries = $game->getSeries();
    $prevPool = $game->getPool();
    $prevTimezone = $game->getTimezone();
  }

  if ($isTableOpen) {
    $ret .= "</table>\n";
  }
  $ret .= PrintTimeZone($prevTimezone);
  return $ret;
}

function PlaceView($games, $grouping = true)
{
  $ret = "";
  $prevTournament = "";
  $prevPlace = "";
  $prevDate = "";
  $prevField = "";
  $prevTimezone = "";
  $isTableOpen = false;
  $rss = IsGameRSSEnabled();

  foreach ($games as $game) {
    $reservationgroup = $locationid = $starttime = "";
    $reservation = $game->getReservation();
    if ($reservation != NULL) {
      $reservationgroup = $reservation->getReservationGroup();
      $location = $reservation->getLocation();
      $starttime = $reservation->getStartTime();
      if ($location != NULL) {
        $locationid = $location->getId();
      }
    }

    if ($reservationgroup != $prevTournament || (empty($reservationgroup) && !$isTableOpen)) {
      if ($isTableOpen) {
        $ret .= "</table>\n";
        $ret .= "<hr/>\n";
        $isTableOpen = false;
      }
      if ($grouping) {
        $ret .= "<h1>" . U_($reservationgroup) . "</h1>\n";
      }
      $prevDate = "";
    }

    if (JustDate($starttime) != $prevDate) {
      if ($isTableOpen) {
        $ret .= "</table>\n";
        $isTableOpen = false;
      }
      $ret .= "<h3>";
      $ret .= DefWeekDateFormat($starttime);
      $ret .= "</h3>\n";
    }

    if ($locationid != $prevPlace || $game->getFieldname() != $prevField || JustDate($starttime) != $prevDate) {
      if ($isTableOpen) {
        $ret .= "</table>\n";
        $isTableOpen = false;
      }
      $ret .= "<table cellpadding='2' border='0' cellspacing='0'>\n";
      $isTableOpen = true;
      $ret .= PlaceHeaders($game, true);
    }

    if ($isTableOpen) {
      //function GameRow($game, $date=false, $time=true, $field=true, $series=false,$pool=false,$info=true)
      $ret .= GameRow($game, false, true, false, true, true, true, $rss);
    }

    $prevTournament = $reservationgroup;
    $prevPlace = $locationid;
    $prevField = $game->getFieldName();
    $prevDate = JustDate($starttime);
    $prevTimezone = $game->getTimezone();
  }

  if ($isTableOpen) {
    $ret .= "</table>\n";
  }
  $ret .= PrintTimeZone($prevTimezone);
  return $ret;
}

function TimeView($games, $grouping = true)
{
  $ret = "";
  $prevTournament = "";
  $prevTime = "";
  $isTableOpen = false;
  $rss = IsGameRSSEnabled();

  while ($game = GetDatabase()->FetchAssoc($games)) {
    if ($game->getTime() != $prevTime) {
      if ($isTableOpen) {
        $ret .= "</table>\n";
        //$ret .= "<hr/>\n";
        $isTableOpen = false;
      }
      $ret .= "<h3>" . DefWeekDateFormat($game->getTime()) . " " . DefHourFormat($game->getTime()) . "</h3>\n";
      $ret .= "<table cellpadding='2' border='0' cellspacing='0'>\n";
      $isTableOpen = true;
    }

    if ($isTableOpen) {
      //function GameRow($game, $date=false, $time=true, $field=true, $series=false,$pool=false,$info=true)
      $ret .= GameRow($game, false, false, true, true, true, true, $rss);
    }

    $prevTime = $game->getTime();
    $prevTimezone = $game->getTimezone();
  }

  if ($isTableOpen) {
    $ret .= "</table>\n";
  }
  $ret .= PrintTimeZone($prevTimezone);
  return $ret;
}

function ExtTournamentView($games)
{
  $ret = "";
  $prevTournament = "";
  $prevPlace = "";
  $prevDate = "";
  $prevField = "";
  $prevTimezone = "";
  $isTableOpen = false;
  $ret .= "<table width='95%'>";

  foreach ($games as $game) {
    $reservationgroup = $locationid = $starttime = "";
    $reservation = $game->getReservation();
    if ($reservation != NULL) {
      $reservationgroup = $reservation->getReservationGroup();
      $location = $reservation->getLocation();
      $starttime = $reservation->getStartTime();
      if ($location != NULL) {
        $locationid = $location->getId();
      }
    }

    if ($reservationgroup != $prevTournament || (empty($reservationgroup) && !$isTableOpen)) {
      if ($isTableOpen) {
        $ret .= "</table></td></tr>\n";
        $isTableOpen = false;
      }
      $ret .= "<tr><td><h1 class='pk_h1'>" . U_($reservationgroup) . "</h1></td></tr>\n";
    }

    if ($locationid != $prevPlace || $game->getFieldName() != $prevField || JustDate($starttime) != $prevDate) {
      if ($isTableOpen) {
        $ret .= "</table></td></tr>\n";
        $isTableOpen = false;
      }
      $ret .= "<tr><td style='width:100%'><table width='100%' class='pk_table'><tr><td class='pk_tournament_td1'>";
      $ret .= U_($game->getResetvation()->getLocation()->getName()) . " " . _("Field") . " " . $game->getFieldName() . "</td></tr></table></td></tr>\n";
      $ret .= "<tr><td><table width='100%' class='pk_table'>\n";
      $isTableOpen = true;
    }

    $ret .= "<tr><td style='width:10px' class='pk_tournament_td2'>" . DefHourFormat($game->getTime()) . "</td>";
    if (TeamName($game->getHomeTeam()) && TeamName($game->getVisitorTeam())) {
      $ret .= "<td style='width:100px' class='pk_tournament_td2'>" . TeamName($game->getHomeTeam()) . "</td>
			<td style='width:5px' class='pk_tournament_td2'>-</td>
			<td style='width:100px' class='pk_tournament_td2'>" . TeamName($game->getVisitorTeam()) . "</td>";

      if ($game->hasStarted())
        $ret .= "<td style='text-align: center;width:8px' class='pk_tournament_td2'>?</td>
					<td style='text-align: center;width:5px' class='pk_tournament_td2'>-</td>
					<td style='text-align: center;width:8px' class='pk_tournament_td2'>?</td>";
      else
        $ret .= "<td style='text-align: center;width:8px' class='pk_tournament_td2'>" . $game->getHomeScore() . "</td>
					<td style='text-align: center;width:5px' class='pk_tournament_td2'>-</td>
					<td style='text-align: center;width:8px' class='pk_tournament_td2'>" . $game->getVisitorScore() . "</td>";
    } else {
      $ret .= "<td style='width:100px' class='pk_tournament_td2'>" . $game->getSchedulingNameHome() . "</td>
			<td style='width:5px' class='pk_tournament_td2'>-</td>
			<td style='width:100px' class='pk_tournament_td2'>" . $game->getSchedulingNameVisitor() . "</td>";
      $ret .= "<td style='text-align: center;width:8px' class='pk_tournament_td2'>?</td>
					<td style='text-align: center;width:5px' class='pk_tournament_td2'>-</td>
					<td style='text-align: center;width:8px' class='pk_tournament_td2'>?</td>";
    }
    $ret .= "<td style='width:5px' class='pk_tournament_td2'></td>";
    $ret .= "<td style='width:50px' class='pk_tournament_td2'>" . SeriesName($game->getSeries()) . "</td>";
    $ret .= "<td style='width:100px' class='pk_tournament_td2'>" . PoolName($game->getPool()) . "</td>";
    $ret .= "</tr>\n";

    $prevTournament = $reservationgroup;
    $prevPlace = $locationid;
    $prevField = $game->getFieldName();
    $prevDate = JustDate($starttime);
    $prevTimezone = $game->getTimeZone();
  }

  if ($isTableOpen) {
    $ret .= "</table></td></tr>\n";
  }
  $ret .= "</table>\n";
  $ret .= PrintTimeZone($prevTimezone);
  return $ret;
}

function ExtGameView($games)
{
  $ret = "";
  $prevTournament = "";
  $prevPlace = "";
  $prevSeries = "";
  $prevPool = "";
  $prevTeam = "";
  $prevDate = "";
  $prevField = "";
  $prevTimezone = "";
  $isTableOpen = false;
  $ret .= "<table style='white-space: nowrap' width='95%'>";

  foreach ($games as $game) {    
    $reservationgroup = $locationid = $starttime = "";
    $reservation = $game->getReservation();
    if ($reservation != NULL) {
      $reservationgroup = $reservation->getReservationGroup();
      $location = $reservation->getLocation();
      $starttime = $reservation->getStartTime();
      if ($location != NULL) {
        $locationid = $location->getId();
      }
    }

    if ($reservationgroup != $prevTournament || (empty($reservationgroup) && !$isTableOpen)) {
      if ($isTableOpen) {
        $ret .= "</table></td></tr>\n";
        $isTableOpen = false;
      }
      $ret .= "<tr><td><h1 class='pk_h1'>" . U_($reservationgroup) . "</h1></td></tr>\n";
    }

    if ($locationid != $prevPlace || $game->getFieldname() != $prevField || JustDate($starttime) != $prevDate) {
      if ($isTableOpen) {
        $ret .= "</table></td></tr>\n";
        $isTableOpen = false;
      }
      $ret .= "<tr><td><table width='100%' class='pk_table'>";
      $ret .= "<tr><th class='pk_teamgames_th' colspan='12'>";
      $ret .= DefWeekDateFormat($starttime) . " " . U_($game->getPlaceName()) . " " . _("Field") . " " . $game->getFieldname();
      $ret .= "</th></tr>\n";
      $isTableOpen = true;
    }

    $ret .= "<tr><td style='width:15%' class='pk_teamgames_td'>" . DefHourFormat($game->getTime()) . "</td>";
    if ($game->getHomeTeam() && $game->getVisitorTeam()) {
      $ret .= "<td style='width:36%' class='pk_teamgames_td'>" . TeamName($game->getHomeTeam()) . "</td>
			<td style='width:3%' class='pk_teamgames_td'>-</td>
			<td style='width:36%' class='pk_teamgames_td'>" . TeamName($game->getVisitorTeam()) . "</td>";
      if ($game->hasStarted()) {
        $ret .= "<td style='text-align: center;width:4%' class='pk_teamgames_td'>?</td>
					<td style='text-align: center;width:2%' class='pk_teamgames_td'>-</td>
					<td style='text-align: center;width:4%' class='pk_teamgames_td'>?</td>";
      } else {
        $ret .= "<td style='text-align: center;width:4%' class='pk_teamgames_td'>" . intval($game->getHomeScore()) . "</td>
					<td style='text-align: center;width:2%' class='pk_teamgames_td'>-</td>
					<td style='text-align: center;width:4%' class='pk_teamgames_td'>" . intval($game->getVisitorScore()) . "</td>";
      }
    } else {
      $ret .= "<td style='width:36%' class='pk_teamgames_td'>" . $game->getHomeScheduleName() . "</td>
			<td style='width:3%' class='pk_teamgames_td'>-</td>
			<td style='width:36%' class='pk_teamgames_td'>" . $game->getVisitorScheduleName() . "</td>";
    }
    $ret .= "</tr>\n";

    $prevTournament = $reservationgroup;
    $prevPlace = $locationid;
    $prevField = $game->getFieldname();
    $prevDate = JustDate($starttime);
    $prevTimezone = $game->getTimezone();
  }

  if ($isTableOpen) {
    $ret .= "</table></td></tr>\n";
  }
  $ret .= "</table>\n";
  $ret .= PrintTimeZone($prevTimezone);
  return $ret;
}

function PlaceHeaders($info, $field = false)
{
  $ret = "<tr>\n";
  $ret .= "<th align='left' colspan='13'>";
  $ret .= "<a class='thlink' href='?view=reservationinfo&amp;reservation=" . $info['reservation_id'] . "'>";
  $ret .= utf8entities($info['placename']);
  $ret .= "</a>";
  if ($field) {
    $ret .= " " . _("Field") . " " . utf8entities($info['fieldname']);
  }

  $ret .= "</th>\n";
  $ret .= "</tr>\n";

  return $ret;
}

function PoolHeaders($info)
{
  $ret = "<tr style='width:100%'>\n";
  $ret .= "<th align='left' colspan='13'>";
  $ret .= utf8entities(U_($info['poolname']));
  $ret .= "</th>\n";
  $ret .= "</tr>\n";
  return $ret;
}

function SeriesAndPoolHeaders($info)
{
  $ret = "<tr style='width:100%'>\n";
  $ret .= "<th align='left' colspan='12'>";
  $ret .= SeriesName(U_($info->getSeries()));
  $ret .= " ";
  $ret .= PoolName(U_($info->getPool()));
  $ret .= "</th>\n";
  $ret .= "</tr>\n";
  return $ret;
}

function GameRow($game, $date = false, $time = true, $field = true, $series = false, $pool = false, $info = true, $rss = false, $media = true)
{
  $datew = 'width:60px';
  $timew = 'width:40px';
  $fieldw = 'width:60px';
  $teamw = 'width:120px';
  $againstmarkw = 'width:5px';
  $seriesw = 'width:80px';
  $poolw = 'width:130px';
  $scoresw = 'width:15px';
  $infow = 'width:80px';
  $gamenamew = 'width:50px';
  $mediaw = 'width:40px';

  $ret = "<tr style='width:100%'>\n";

  if ($date) {
    $ret .= "<td style='$datew'><span>" . ShortDate($game->getTime()) . "</span></td>\n";
  }

  if ($time) {
    $ret .= "<td style='$timew'><span>" . DefHourFormat($game->getTime()) . "</span></td>\n";
  }

  if ($field) {
    if (!empty($game->getFieldname()))
      $ret .= "<td style='$fieldw'><span>" . _("Field") . " " . $game->getFieldname() . "</span></td>\n";
    else
      $ret .= "<td style='$fieldw'></td>\n";
  }

  if ($game->getHomeTeam()) {
    $ret .= "<td style='$teamw'><span>" . TeamName($game->getHomeTeam()) . "</span></td>\n";
  } else {
    $ret .= "<td style='$teamw'><span class='schedulingname'>" . U_($game->getHomeScheduleName()) . "</span></td>\n";
  }

  $ret .= "<td style='$againstmarkw'>-</td>\n";

  if ($game->getVisitorTeam()) {
    $ret .= "<td style='$teamw'><span>" . TeamName($game->getVisitorTeam()) . "</span></td>\n";
  } else {
    $ret .= "<td style='$teamw'><span class='schedulingname'>" . U_($game->getVisitorScheduleName()) . "</span></td>\n";
  }

  if ($series) {
    $ret .= "<td style='$seriesw'><span>" . SeriesName(U_($game->getSeries())) . "</span></td>\n";
  }

  if ($pool) {
    $ret .= "<td style='$poolw'><span>" . PoolName(U_($game->getPool())) . "</span></td>\n";
  }

  if (!$game->hasStarted()) {
    $ret .= "<td style='$scoresw'><span>?</span></td>\n";
    $ret .= "<td style='$againstmarkw'><span>-</span></td>\n";
    $ret .= "<td style='$scoresw'><span>?</span></td>\n";
  } else {
    if ($game->isOngoing()) {
      $ret .= "<td style='$scoresw'><span><em>" . $game->getHomeScore() . "</em></span></td>\n";
      $ret .= "<td style='$againstmarkw'><span>-</span></td>\n";
      $ret .= "<td style='$scoresw'><span><em>" . $game->getVisitorScore() . "</em></span></td>\n";
    } else {
      $ret .= "<td style='$scoresw'><span>" . $game->getHomeScore() . "</span></td>\n";
      $ret .= "<td style='$againstmarkw'><span>-</span></td>\n";
      $ret .= "<td style='$scoresw'><span>" . $game->getVisitorScore() . "</span></td>\n";
    }
  }

  if ($game->getScheduleName()) {
    $ret .= "<td style='$gamenamew'><span>" . U_($game->getScheduleName()) . "</span></td>\n";
  } else {
    $ret .= "<td style='$gamenamew'></td>\n";
  }

  if ($media) {
    $urls = Url::getMediaUrlList("game", $game->getId(), "live");
    $ret .= "<td style='$mediaw;white-space: nowrap;'>";
    if (count($urls) && ($game->isOngoing() || !$game->hasStarted())) {
      foreach ($urls as $url) {
        $title = $url['name'];
        if (empty($title)) {
          $title = _("Live Broadcasting");
        }
        $ret .= "<a href='" . $url['url'] . "'>" . "<img border='0' width='16' height='16' title='" . utf8entities($title) . "' src='images/linkicons/" . $url['type'] . ".png' alt='" . $url['type'] . "'/></a>";
      }
    }
    $ret .= "</td>\n";
  }

  if ($info) {
    if (!$game->hasStarted()) {
      if ($game->getHomeTeam() && $game->getVisitorTeam()) {
        $t1 = preg_replace('/\s*/m', '', TeamName($game->getHomeTeam()));
        $t2 = preg_replace('/\s*/m', '', TeamName($game->getVisitorTeam()));

        $xgames = GetAllPlayedGames($t1, $t2, $game->getType(), "");
        if (count($xgames)) {
          $ret .= "<td class='right' style='$infow'><span style='white-space: nowrap'>";
          $ret .= "<a href='?view=gamecard&amp;team1=" . $game->getHomeTeam() . "&amp;team2=" . $game->getVisitorTeam() . "'>";
          $ret .=  _("Game history") . "</a></span></td>\n";
        } else {
          $ret .= "<td class='left' style='$infow'></td>\n";
        }
      } else {
        $ret .= "<td class='left' style='$infow'></td>\n";
      }
    } else {
      $scoresheet = $game->getScoresheet();
      if (!$game->isOngoing()) {
        if ($scoresheet) {
          $ret .= "<td class='right' style='$infow'><span>&nbsp;<a href='?view=gameplay&amp;game=" . $game->getId() . "'>";
          $ret .= _("Game play") . "</a></span></td>\n";
        } else {
          $ret .= "<td class='left' style='$infow'></td>\n";
        }
      } else {
        if ($scoresheet) {
          $ret .= "<td class='right' style='$infow'><span>&nbsp;&nbsp;<a href='?view=gameplay&amp;game=" . $game->getId() . "'>";
          $ret .= _("Ongoing") . "</a></span></td>\n";
        } else {
          $ret .= "<td class='right' style='$infow'>&nbsp;&nbsp;" . _("Ongoing") . "</td>\n";
        }
      }
    }
    if ($rss) {
      $ret .= "<td class='feed-list'><a style='color: #ffffff;' href='ext/rss.php?feed=game&amp;id1=" . $game->getId() . "'>";
      $ret .= "<img src='images/feed-icon-14x14.png' width='10' height='10' alt='RSS'/></a></td>";
    }
  }
  $ret .=  "</tr>\n";
  return $ret;
}

function PrintTimeZone($timezone)
{
  $ret = "<p class='timezone'>" . _("Timezone") . ": " . utf8entities($timezone) . ". ";
  if (class_exists("DateTime") && !empty($timezone)) {
    $dateTime = new DateTime("now", new DateTimeZone($timezone));
    $ret .= _("Local time") . ": " . DefTimeFormat($dateTime->format("Y-m-d H:i:s"));
  }
  $ret .= "</p>";
  return $ret;
}

// TODO test
function NextGameDay($id, $gamefilter, $order)
{
  $games = TimetableGames($id, $gamefilter, "coming", "time");
  $game = $games[0];
  $next = ShortEnDate($game->getTime());
  $games = TimetableGames($id, $gamefilter, $next, $order);
  return $games;
}

function PrevGameDay($id, $gamefilter, $order)
{
  $games = TimetableGames($id, $gamefilter, "past", "timedesc");
  $game = $games[0];
  $prev = ShortEnDate($game->getTime());
  $games = TimetableGames($id, $gamefilter, $prev, $order);
  return $games;
}


function TimetableGames($id, $gamefilter, $timefilter, $order, $groupfilter = "")
{
  //common game query
  $query = "SELECT pp.game_id, pp.time, pp.hometeam, pp.visitorteam, pp.homescore,
			pp.visitorscore, pp.pool AS pool, pool.name AS poolname, pool.timeslot,
			ps.series_id, ps.name AS seriesname, ps.season, ps.type, pr.fieldname, pr.reservationgroup,
			pr.id AS reservation_id, pr.starttime, pr.endtime, pl.id AS place_id, COALESCE(pm.goals,0) AS scoresheet,
			pl.name AS placename, pl.address, pp.isongoing, pp.hasstarted, home.name AS hometeamname, visitor.name AS visitorteamname,
			phome.name AS phometeamname, pvisitor.name AS pvisitorteamname, pool.color, pgame.name AS gamename,
			home.abbreviation AS homeshortname, visitor.abbreviation AS visitorshortname, homec.country_id AS homecountryid, 
			homec.name AS homecountry, visitorc.country_id AS visitorcountryid, visitorc.name AS visitorcountry, 
			homec.flagfile AS homeflag, visitorc.flagfile AS visitorflag, s.timezone
			FROM uo_game pp 
			LEFT JOIN (SELECT COUNT(*) AS goals, game FROM uo_goal GROUP BY game) AS pm ON (pp.game_id=pm.game)
			LEFT JOIN uo_pool pool ON (pool.pool_id=pp.pool) 
			LEFT JOIN uo_series ps ON (pool.series=ps.series_id)
			LEFT JOIN uo_season s ON (s.season_id=ps.season)
			LEFT JOIN uo_reservation pr ON (pp.reservation=pr.id)
			LEFT JOIN uo_location pl ON (pr.location=pl.id)
			LEFT JOIN uo_team AS home ON (pp.hometeam=home.team_id)
			LEFT JOIN uo_team_pool AS homepool ON (pp.hometeam=homepool.team AND pp.pool=homepool.pool)
			LEFT JOIN uo_team AS visitor ON (pp.visitorteam=visitor.team_id)
			LEFT JOIN uo_country AS homec ON (homec.country_id=home.country)
			LEFT JOIN uo_country AS visitorc ON (visitorc.country_id=visitor.country)
			LEFT JOIN uo_scheduling_name AS pgame ON (pp.name=pgame.scheduling_id)
			LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
			LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)";

  switch ($gamefilter) {
    case "season":
      $query .= " WHERE pp.valid=true AND ps.season='" . GetDatabase()->RealEscapeString($id) . "'";
      break;

    case "series":
      $query .= " WHERE pp.valid=true AND ps.series_id='" . (int)$id . "'";
      break;

    case "pool":
      $query .= " WHERE pp.valid=true AND pp.pool='" . (int)$id . "'";
      break;

    case "poolgroup":
      //keep pool filter as it is to give better performance for single pool query
      //extra explode needed to make parameters safe
      $pools = explode(",", GetDatabase()->RealEscapeString($id));
      $query .= " WHERE pp.valid=true AND pp.pool IN(" . implode(",", $pools) . ")";
      break;

    case "team":
      $query .= " WHERE pp.valid=true AND (pp.visitorteam='" . (int)$id . "' OR pp.hometeam='" . (int)$id . "')";
      break;

    case "game":
      $query .= " WHERE pp.game_id=" . (int)$id;
      break;
  }

  switch ($timefilter) {
    case "coming":
      $query .= " AND pp.time IS NOT NULL AND ((pp.homescore IS NULL AND pp.visitorscore IS NULL) OR (pp.hasstarted=0) OR pp.isongoing=1)";
      break;

    case "past":
      $query .= " AND ((pp.hasstarted > 0) )";
      break;

    case "played":
      $query .= " AND ((pp.hasstarted > 0) )";
      break;

    case "ongoing":
      $query .= " AND pp.isongoing=1";
      break;

    case "comingNotToday":
      $query .= " AND pp.time >= Now()";
      break;

    case "pastNotToday":
      $query .= " AND pp.time <= Now()";
      break;

    case "today":
      $query .= " AND DATE_FORMAT(pp.time,'%Y-%m-%d') = DATE_SUB(CURRENT_DATE(), INTERVAL 0 DAY)";
      break;

    case "tomorrow":
      $query .= " AND DATE_FORMAT(pp.time,'%Y-%m-%d') = DATE_ADD(CURRENT_DATE(), INTERVAL 1 DAY)";
      break;

    case "yesterday":
      $query .= " AND DATE_FORMAT(pp.time,'%Y-%m-%d') = DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)";
      break;

    case "all":
      break;

    default:
      $query .= " AND DATE_FORMAT(pp.time,'%Y-%m-%d') = '" . GetDatabase()->RealEscapeString($timefilter) . "'";
      break;
  }

  if (!empty($groupfilter) && $groupfilter != "all") {
    $query .= "AND pr.reservationgroup='" . GetDatabase()->RealEscapeString($groupfilter) . "'";
  }

  switch ($order) {
    case "tournaments":
      $query .= " ORDER BY pr.starttime, pr.reservationgroup, pl.id, ps.ordering, pool.ordering, pp.time ASC, pr.fieldname + 0, pp.game_id ASC";
      break;

    case "series":
      $query .= " ORDER BY ps.ordering, pool.ordering, pp.time ASC, pr.starttime, pr.fieldname + 0, pp.game_id ASC";
      break;

    case "places":
      $query .= " ORDER BY pr.starttime, pr.reservationgroup, pl.id, pr.fieldname +0,  pp.time ASC, pp.game_id ASC";
      break;

    case "tournamentsdesc":
      $query .= " ORDER BY pr.starttime DESC, pr.reservationgroup, pl.id, ps.ordering, pool.ordering, pp.time ASC, pp.game_id ASC";
      break;

    case "placesdesc":
      $query .= " ORDER BY pr.starttime DESC, pr.reservationgroup, pl.id, pr.fieldname + 0, pp.time ASC, pp.game_id ASC";
      break;

    case "onepage":
      $query .= " ORDER BY pr.reservationgroup, pr.starttime, pl.id, pr.fieldname +0, pp.time ASC, pp.game_id ASC";
      break;

    case "time":
      $query .= " ORDER BY pp.time ASC, pr.fieldname +0, game_id ASC";
      break;

    case "timedesc":
      $query .= " ORDER BY pp.time DESC, game_id ASC";
      break;

    case "crossmatch":
      $query .= " ORDER BY homepool.rank ASC, game_id ASC";
      break;
  }

  $result = GetDatabase()->DBQueryToArray($query);
  $games = array();
  foreach ($result as $game) {
    $tmp = new Game(GetDatabase(), $game['game_id']);
    array_push($games, $tmp);
  }
  return $games;
}

function TimetableGrouping($id, $gamefilter, $timefilter)
{
  //common game query
  $query = "SELECT pool.name AS poolname, ps.name AS seriesname, pr.fieldname, pr.reservationgroup,
			pl.name AS placename
			FROM uo_game pp 
			LEFT JOIN (SELECT COUNT(*) AS goals, game FROM uo_goal GROUP BY game) AS pm ON (pp.game_id=pm.game)
			LEFT JOIN uo_pool pool ON (pool.pool_id=pp.pool) 
			LEFT JOIN uo_series ps ON (pool.series=ps.series_id)
			LEFT JOIN uo_reservation pr ON (pp.reservation=pr.id)
			LEFT JOIN uo_location pl ON (pr.location=pl.id)
			LEFT JOIN uo_team AS home ON (pp.hometeam=home.team_id)
			LEFT JOIN uo_team AS visitor ON (pp.visitorteam=visitor.team_id)
			LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
			LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)";

  switch ($gamefilter) {
    case "season":
      $query .= " WHERE pp.valid=true AND ps.season='" . GetDatabase()->RealEscapeString($id) . "'";
      break;

    case "series":
      $query .= " WHERE pp.valid=true AND ps.series_id='" . (int)$id . "'";
      break;

    case "pool":
      $query .= " WHERE pp.valid=true AND pp.pool='" . (int)$id . "'";
      break;

    case "poolgroup":
      //keep pool filter as it is to give better performance for single pool query
      //extra explode needed to make parameters safe
      $pools = explode(",", GetDatabase()->RealEscapeString($id));
      $query .= " WHERE pp.valid=true AND pp.pool IN(" . implode(",", $pools) . ")";
      break;

    case "team":
      $query .= " WHERE pp.valid=true AND (pp.visitorteam='" . (int)$id . "' OR pp.hometeam='" . (int)$id . "')";
      break;
  }

  switch ($timefilter) {
    case "coming":
      $query .= " AND pp.time IS NOT NULL AND ((pp.homescore IS NULL AND pp.visitorscore IS NULL) OR (pp.hasstarted = 0) OR pp.isongoing=1)";
      break;

    case "past":
      $query .= " AND ((pp.hasstarted >0))";
      break;

    case "played":
      $query .= " AND ((pp.hasstarted >0))";
      break;

    case "ongoing":
      $query .= " AND pp.isongoing=1";
      break;

    case "comingNotToday":
      $query .= " AND pp.time >= Now()";
      break;

    case "pastNotToday":
      $query .= " AND pp.time <= Now()";
      break;

    case "today":
      $query .= " AND DATE_FORMAT(pp.time,'%Y-%m-%d') = DATE_SUB(CURRENT_DATE(), INTERVAL 0 DAY)";
      break;

    case "tomorrow":
      $query .= " AND DATE_FORMAT(pp.time,'%Y-%m-%d') = DATE_ADD(CURRENT_DATE(), INTERVAL 1 DAY)";
      break;

    case "yesterday":
      $query .= " AND DATE_FORMAT(pp.time,'%Y-%m-%d') = DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)";
      break;

    case "all":
      break;

    default:
      $query .= " AND DATE_FORMAT(pp.time,'%Y-%m-%d') = '" . GetDatabase()->RealEscapeString($timefilter) . "'";
      break;
  }
  $query .= " GROUP BY pr.reservationgroup ORDER BY pp.time ASC, ps.ordering, pr.reservationgroup";

  return GetDatabase()->DBQueryToArray($query);
}

function TimetableFields($reservationgroup, $season)
{
  $query = "SELECT COUNT(*) as games
			FROM uo_game pp 
			LEFT JOIN (SELECT COUNT(*) AS goals, game FROM uo_goal GROUP BY game) AS pm ON (pp.game_id=pm.game)
			LEFT JOIN uo_pool pool ON (pool.pool_id=pp.pool) 
			LEFT JOIN uo_series ps ON (pool.series=ps.series_id)
			LEFT JOIN uo_reservation pr ON (pp.reservation=pr.id)";

  $query .= " WHERE pp.valid=true AND ps.season='" . GetDatabase()->RealEscapeString($season) . "' AND pr.reservationgroup='" . GetDatabase()->RealEscapeString($reservationgroup) . "'";
  $query .= " GROUP BY pr.location, pr.fieldname";
  $result = GetDatabase()->DBQuery($query);
  return GetDatabase()->NumRows($result);
}

function TimetableTimeslots($reservationgroup, $season)
{
  $query = "SELECT pp.time
			FROM uo_game pp 
			LEFT JOIN uo_pool pool ON (pool.pool_id=pp.pool) 
			LEFT JOIN uo_series ps ON (pool.series=ps.series_id)
			LEFT JOIN uo_reservation pr ON (pp.reservation=pr.id)";

  $query .= " WHERE pp.valid=true AND ps.season='" . GetDatabase()->RealEscapeString($season) . "' AND pr.reservationgroup='" . GetDatabase()->RealEscapeString($reservationgroup) . "'";
  $query .= " GROUP BY pp.time";
  return GetDatabase()->DBQueryToArray($query);
}

function TimetableIntraPoolConflicts($season)
{
  $query = "SELECT g1.game_id as game1, g2.game_id as game2, g1.pool as pool1, g2.pool as pool2,  
      g1.hometeam as home1, g1.visitorteam as visitor1, g2.hometeam as home2, g2.visitorteam as visitor2, 
      g1.scheduling_name_home as scheduling_home1, g1.scheduling_name_visitor as scheduling_visitor1, 
      g2.scheduling_name_home as scheduling_home2, g2.scheduling_name_visitor as scheduling_visitor2, 
      g1.reservation as reservation1, g2.reservation as reservation2, g1.time as time1, g2.time as time2, 
      p1.timeslot as slot1, p2.timeslot as slot2, 
      res1.location location1, res1.fieldname as field1, res2.location as location2, res2.fieldname as field2  
      FROM uo_game as g1
      LEFT JOIN uo_game as g2 ON ((g1.hometeam=g2.hometeam OR g1.visitorteam = g2.visitorteam OR g1.hometeam=g2.visitorteam OR g1.visitorteam = g2.hometeam) AND g1.game_id != g2.game_id )
      LEFT JOIN uo_pool as p1 ON (p1.pool_id = g1.pool)
      LEFT JOIN uo_pool as p2 ON (p2.pool_id = g2.pool)
      LEFT JOIN uo_reservation as res1 ON (res1.id = g1.reservation)
      LEFT JOIN uo_reservation as res2 ON (res2.id = g2.reservation)
      LEFT JOIN uo_series as ser1 ON (ser1.series_id = p1.series)
      LEFT JOIN uo_series as ser2 ON (ser2.series_id = p2.series)
      WHERE g1.reservation IS NOT NULL AND g2.reservation IS NOT NULL AND ser1.season = '" . $season . "' AND ser2.season = '" . $season . "' AND g1.time <= g2.time
      ORDER BY time2 ASC, time1 ASC";
  return GetDatabase()->DBQueryToArray($query);
}

function TimetableInterPoolConflicts($season)
{
  $query = "SELECT  g1.game_id as game1, g2.game_id as game2, g1.pool as pool1, g2.pool as pool2,  
      g1.hometeam as home1, g1.visitorteam as visitor1, g2.hometeam as home2, g2.visitorteam as visitor2, 
      g1.scheduling_name_home as scheduling_home1, g1.scheduling_name_visitor as scheduling_visitor1, 
      g2.scheduling_name_home as scheduling_home2, g2.scheduling_name_visitor as scheduling_visitor2, 
      g1.reservation as reservation1, g2.reservation as reservation2, g1.time as time1, g2.time as time2, 
      p1.timeslot as slot1, p2.timeslot as slot2, 
      res1.location location1, res1.fieldname as field1, res2.location as location2, res2.fieldname as field2
      FROM uo_moveteams as mv
      LEFT JOIN uo_game as g1 ON (g1.pool = mv.frompool)
      LEFT JOIN uo_game as g2 ON (g2.pool = mv.topool AND g1.game_id != g2.game_id )
      LEFT JOIN uo_pool as p1 ON (p1.pool_id = g1.pool)
      LEFT JOIN uo_pool as p2 ON (p2.pool_id = g2.pool)
      LEFT JOIN uo_reservation as res1 ON (res1.id = g1.reservation)
      LEFT JOIN uo_reservation as res2 ON (res2.id = g2.reservation)
      LEFT JOIN uo_series as ser1 ON (ser1.series_id = p1.series)
      LEFT JOIN uo_series as ser2 ON (ser2.series_id = p2.series)
      WHERE ser1.season = '" . $season . "' AND ser2.season = '" . $season . "'
        AND (g1.hometeam IS NULL OR g1.visitorteam IS NULL OR g2.hometeam IS NULL OR g2.visitorteam IS NULL OR
          (g1.hometeam=g2.hometeam OR g1.visitorteam = g2.visitorteam OR g1.hometeam=g2.visitorteam OR g1.visitorteam = g2.hometeam))
      ORDER BY time2 ASC, time1 ASC";
  return GetDatabase()->DBQueryToArray($query);
}

function TimeTableMoveTimes($season)
{
  $query = sprintf("SELECT * FROM uo_movingtime
            WHERE season = '%s'
            ORDER BY fromlocation, fromfield+0, tolocation, tofield+0", $season);

  $result = GetDatabase()->DBQuery($query);
  if (!$result) {
    die('Invalid query: ' . GetDatabase()->SQLError());
  }
  $ret = array();
  while ($row = GetDatabase()->FetchAssoc($result)) {
    $ret[$row['fromlocation']][$row['fromfield']][$row['tolocation']][$row['tofield']] = $row['time'];
  }
  return $ret;
}

function TimeTableMoveTime($movetimes, $location1, $field1, $location2, $field2)
{
  if (!isset($movetimes[$location1][$field1][$location2][$field2]))
    return 0;
  $time = $movetimes[$location1][$field1][$location2][$field2];
  if (empty($time))
    return 0;
  else
    return $time * 60;
}

function TimeTableSetMoveTimes($season, $times)
{
  if (isSuperAdmin() || isSeasonAdmin($season)) {
    for ($from = 0; $from < count($times); $from++) {
      for ($to = 0; $to < count($times); $to++) {
        $query = sprintf(
          " 
          INSERT INTO uo_movingtime
          (season, fromlocation, fromfield, tolocation, tofield, time) 
          VALUES ('%s', '%d', '%d', '%d', '%d', '%d') ON DUPLICATE KEY UPDATE time='%d'",
          GetDatabase()->RealEscapeString($season),
          (int) $times[$from]['location'],
          (int) $times[$from]['field'],
          (int) $times[$to]['location'],
          (int) $times[$to]['field'],
          (int) $times[$from][$to],
          (int) $times[$from][$to]
        );
        GetDatabase()->DBQuery($query);
      }
    }
  } else {
    die('Insufficient rights to edit moving times');
  }
}

function IsGamesScheduled($id, $gamefilter, $timefilter)
{
  $result = TimetableGames($id, $gamefilter, $timefilter, "");

  return (count($result) > 0);
}

function TimetableToCsv($season, $separator)
{

  $query = sprintf(
    "SELECT pp.time AS Time, phome.name AS HomeSchedulingName, pvisitor.name AS AwaySchedulingName,
			home.name AS HomeTeam, visitor.name AS AwayTeam, pp.homescore AS HomeScores, 
			pp.visitorscore AS VisitorScores, pool.name AS Pool, ps.name AS Division, 
			pr.fieldname AS Field, pr.reservationgroup AS ReservationGroup,
			pl.name AS Place, pp.name AS GameName
			FROM uo_game pp 
			LEFT JOIN (SELECT COUNT(*) AS goals, game FROM uo_goal GROUP BY game) AS pm ON (pp.game_id=pm.game)
			LEFT JOIN uo_pool pool ON (pool.pool_id=pp.pool) 
			LEFT JOIN uo_series ps ON (pool.series=ps.series_id)
			LEFT JOIN uo_reservation pr ON (pp.reservation=pr.id)
			LEFT JOIN uo_location pl ON (pr.location=pl.id)
			LEFT JOIN uo_team AS home ON (pp.hometeam=home.team_id)
			LEFT JOIN uo_team AS visitor ON (pp.visitorteam=visitor.team_id)
			LEFT JOIN uo_scheduling_name AS pgame ON (pp.name=pgame.scheduling_id)
			LEFT JOIN uo_scheduling_name AS phome ON (pp.scheduling_name_home=phome.scheduling_id)
			LEFT JOIN uo_scheduling_name AS pvisitor ON (pp.scheduling_name_visitor=pvisitor.scheduling_id)
			WHERE pp.valid=true AND ps.season='%s'
			ORDER BY pr.starttime, pr.reservationgroup, pl.id, pr.fieldname +0, pp.time ASC, pp.game_id ASC",
    GetDatabase()->RealEscapeString($season)
  );

  // Gets the data from the database
  $result = GetDatabase()->DBQuery($query);
  return ResultsetToCsv($result, $separator);
}
