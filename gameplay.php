<?php
include_once 'lib/pool.functions.php';
include_once 'lib/game.functions.php';
include_once 'lib/common.functions.php';

$gameId = intval(iget("game"));
$smarty->assign("game_id", $gameId);

$game_result = GameResult($gameId);
$smarty->assign("game_result", $game_result);
$seasoninfo = SeasonInfo(GameSeason($gameId));
$homecaptain = GameCaptain($gameId, $game_result['hometeam']);
$smarty->assign("home_captain", $homecaptain);
$awaycaptain = GameCaptain($gameId, $game_result['visitorteam']);
$smarty->assign("away_captain", $awaycaptain);

$title = _("Game play") . ": " . utf8entities($game_result['hometeamname']) . " vs. " . utf8entities($game_result['visitorteamname']);
$smarty->assign("title", $title);

$home_team_score_board = GameTeamScoreBorad($gameId, $game_result['hometeam']);
$guest_team_score_board = GameTeamScoreBorad($gameId, $game_result['visitorteam']);

$poolinfo = PoolInfo($game_result['pool']);

$goals = GameGoals($gameId);
$gameevents = GameEvents($gameId);
$mediaevents = GameMediaEvents($gameId);
$smarty->assign("media_events", $mediaevents);
$game_has_started = GameHasStarted($game_result);
$smarty->assign("game_has_started", $game_has_started);

if ($game_has_started) {
  $game_not_fed_in = GetDatabase()->NumRows($goals) <= 0;
  $smarty->assign("game_not_fed_in", $game_not_fed_in);
  if (!$game_not_fed_in) {

    $home_players_stats = array();
    while ($row = GetDatabase()->FetchAssoc($home_team_score_board)) {
      $home_players_stats[] = $row;
    }
    $smarty->assign("home_players_stats", $home_players_stats);

    $away_players_stats = array();
    while ($row = GetDatabase()->FetchAssoc($guest_team_score_board)) {
      $away_players_stats[] = $row;
    }
    $smarty->assign("away_players_stats", $away_players_stats);

    // Timeline
    $points = array(array());
    $i = 0;
    $lprev = 0;
    $htAt = intval($poolinfo['winningscore']);
    $htAt = intval(($htAt / 2) + 0.5);
    $bHt = false;
    $total = 0;

    while ($goal = GetDatabase()->FetchAssoc($goals)) {
      if (!$bHt && $goal['time'] > $game_result['halftime']) {
        $points[$i][0] = (intval($game_result['halftime']) - $lprev);
        $points[$i][4] = intval($game_result['halftime']);
        $lprev = intval($game_result['halftime']);
        $points[$i][1] = -2;
        $total += $points[$i][0];
        $bHt = 1;
        $i++;
      }

      if (intval($goal['time']) > 0) {
        $ptLen = intval($goal['time']) - $lprev;
      } else {
        $ptLen = 1;
      }

      $points[$i][0] = $ptLen;
      $points[$i][1] = intval($goal['ishomegoal']);
      $points[$i][2] = utf8entities($goal['scorerlastname'] . " " . $goal['scorerfirstname']);
      $points[$i][3] = utf8entities($goal['assistlastname'] . " " . $goal['assistfirstname']);
      $points[$i][4] = intval($goal['time']);
      $points[$i][5] = $goal['homescore'];
      $points[$i][6] = $goal['visitorscore'];

      $lprev = intval($goal['time']);
      $total += $points[$i][0];

      $i++;
    }

    $maxlength = 600;
    $latestHomeGoalTime = 0;
    $latestGuestGoalTime = 0;
    $offset = $maxlength / $total;
    $timeline_array = array();
    for ($i = 0; $i < 50 && !empty($points[$i][0]); $i++) {
      if ($points[$i][1] == 1) {
        $color = "home";
        $latestHomeGoalTime = $points[$i][4];
      } elseif ($points[$i][1] == -2) {
        $color = "halftime";
      } else {
        $color = "guest";
        $latestGuestGoalTime = $points[$i][4];
      }

      $timeSinceLastGuestGoal = $points[$i][4] - $latestGuestGoalTime;
      $timeSinceLastHomeGoal = $points[$i][4] - $latestHomeGoalTime;

      $width_a = $points[$i][0] * $offset;

      if ($points[$i][1] == -2) {
        $td_title = SecToMin($points[$i][4]) . " " . _("halftime");
      } else {
        $td_title = SecToMin($points[$i][4]) . " " . $points[$i][5] . "-" . $points[$i][6] . " " . $points[$i][3] . " -> " . $points[$i][2];
      }

      $item['width_a'] = $width_a;
      $item['td_title'] = $td_title;
      $item['color'] = $color;
      $timeline_array[] = $item;
    }
    $smarty->assign("timeline_items", $timeline_array);

    $bHt = false;
    $prevgoal = 0;
    GetDatabase()->DataSeek($goals, 0);
    $game_goals = array();
    $has_media_events = false;
    $has_game_events = false;
    while ($goal = GetDatabase()->FetchAssoc($goals)) {
      $goal['halftime'] = false;
      if (!$bHt && $game_result['halftime'] > 0 && $goal['time'] > $game_result['halftime']) {
        $goal['halftime'] = true;
        $bHt = 1;
        $prevgoal = intval($game_result['halftime']);
      }

      $goal['pretty_time'] = SecToMin($goal['time']);
      $goal['pretty_duration'] = SecToMin($goal['time'] - $prevgoal);

      if (count($gameevents) || count($mediaevents)) {
        // Game events
        $game_events_array = array();
        foreach ($gameevents as $event) {
          if ((intval($event['time']) >= $prevgoal) &&
            (intval($event['time']) < intval($goal['time']))
          ) {
            $has_game_events = true;
            if ($event['type'] == "timeout") {
              $gameevent = _("Time-out");
            } elseif ($event['type'] == "turnover") {
              $gameevent = _("Turnover");
            } elseif ($event['type'] == "offence") {
              $gameevent = _("Offence");
            }

            // Hack to not show timeouts not correctly marked into scoresheet
            $event['skip_timeout_hack'] = $event['type'] == "timeout" && ($event['time'] == 0 || $event['time'] == 60);
            $event['game_event'] = $gameevent;
            $event['pretty_time'] = SecToMin($event['time']);
            $game_events_array[] = $event;
          }
          $goal['game_events'] = $game_events_array;
        }

        // Media events
        $media_events_array = array();
        foreach ($mediaevents as $event) {
          if ((intval($event['time']) >= $prevgoal) &&
            (intval($event['time']) < intval($goal['time']))
          ) {
            $has_media_events = true;
            $media_events_array[] = $event;
          }
        }
        $goal['media_events'] = $media_events_array;
      }
      $prevgoal = intval($goal['time']);
      $game_goals[] = $goal;
    }
    $smarty->assign("game_goals", $game_goals);
    $smarty->assign("has_game_events", $has_game_events);
    $smarty->assign("has_media_events", $has_media_events);

    $urls = GetMediaUrlList("game", $gameId);
    $smarty->assign("urls", $urls);

    if (!intval($game_result['isongoing'])) {
      //statistics
      $html .= "<h2>" . _("Game statistics") . "</h2>\n";

      $allgoals = GameAllGoals($gameId);

      $bHOffence = 0;
      $nHOffencePoint = 0;
      $nVOffencePoint = 0;
      $nHBreaks = 0;
      $nVBreaks = 0;
      $nHTotalTime = 0;
      $nVTotalTime = 0;
      $nHGoals = 0;
      $nVGoals = 0;
      $nClockTime = 0;
      $nDuration = 0;
      $bHStartTheGame = 0;
      $nHTO = 0;
      $nVTO = 0;
      $nHLosesDisc = 0;
      $nVLosesDisc = 0;

      $turnovers = GameTurnovers($gameId);

      $goal = GetDatabase()->FetchAssoc($allgoals);
      $turnover = GetDatabase()->FetchAssoc($turnovers);

      //who start the game?
      $ishome = GameIsFirstOffenceHome($gameId);
      if ($ishome == 1) {
        $bHStartTheGame = true;
      } elseif ($ishome == 0) {
        $bHStartTheGame = false;
      } else {
        //make some wild guess
        if ($turnover) {
          //If turnover before goal
          if (intval($turnover['time']) < intval($goal['time'])) {
            //If home lose disc Then home was starting the game
            if (intval($turnover['ishome'])) {
              $bHStartTheGame = true;
              //visitor starts but loses the disc
            } else {
              $bHStartTheGame = false;
            }
            //no turnovers before goal, the team scored was starting the game
          } else {
            if (intval($goal['ishomegoal'])) {
              $bHStartTheGame = true;
            } else {
              $bHStartTheGame = false;
            }
          }
          //no turnovers in database
        } else {
          //team scored was starting (just wild guess)
          if (intval($goal['ishomegoal'])) {
            $bHStartTheGame = true;
          } else {
            $bHStartTheGame = false;
          }
        }
      }
      //whom start the game, starts offence
      $bHOffence = $bHStartTheGame;

      //return internal pointers to first row
      GetDatabase()->DataSeek($allgoals, 0);

      //loop all goals
      while ($goal = GetDatabase()->FetchAssoc($allgoals)) {
        //halftime passed
        if (($nClockTime <= intval($game_result['halftime'])) && (intval($goal['time']) >= intval($game_result['halftime']))) {
          $nClockTime = intval($game_result['halftime']);

          if ($bHStartTheGame) {
            $bHOffence = false;
          } else {
            $bHOffence = true;
          }
        }

        //track offence turns
        if ($bHOffence) {
          $nHOffencePoint++;
        } else {
          $nVOffencePoint++;
        }

        //If turnovers before goal
        if (GetDatabase()->NumRows($turnovers)) {
          $turnovers = GameTurnovers($gameId);
        }
        while ($turnover = GetDatabase()->FetchAssoc($turnovers)) {
          if ((intval($turnover['time']) > $nClockTime) &&
            (intval($turnover['time']) < intval($goal['time']))
          ) {
            if (intval($turnover['ishome'])) {
              $nHLosesDisc++;
            } else {
              $nVLosesDisc++;
            }
          }
        }

        //If a break goal
        if (intval($goal['ishomegoal']) && $bHOffence == false) {
          $nHBreaks++;
        } elseif (intval($goal['ishomegoal']) == 0 && $bHOffence == true) {
          $nVBreaks++;
        }

        //point duration
        $nDuration = intval($goal['time']) - $nClockTime;
        $nClockTime = intval($goal['time']);
        if ($bHOffence) {
          $nHTotalTime += $nDuration;
        } else {
          $nVTotalTime += $nDuration;
        }

        //If home goal
        if (intval($goal['ishomegoal'])) {
          $nHGoals++;
          $bHOffence = false;
        } else {
          $nVGoals++;
          $bHOffence = true;
        }
      }

      //timeouts
      $timeouts = GameTimeouts($gameId);
      while ($timeout = GetDatabase()->FetchAssoc($timeouts)) {
        if (intval($timeout['ishome'])) {
          $nHTO++;
        } else {
          $nVTO++;
        }
      }
      $dblHAvg = 0.0;
      $dblVAvg = 0.0;

      $smarty->assign("nHGoals", $nHGoals);
      $smarty->assign("nVGoals", $nVGoals);
      $smarty->assign("nHOffencePoint", $nHOffencePoint);
      $smarty->assign("nVOffencePoint", $nVOffencePoint);
      $smarty->assign("dblHAvgTimeOnOffence", number_format(SafeDivide($nHTotalTime, ($nHTotalTime + $nVTotalTime)) * 100, 1));
      $smarty->assign("dblVAvgTimeOnOffence", number_format(SafeDivide($nVTotalTime, ($nHTotalTime + $nVTotalTime)) * 100, 1));
      $smarty->assign("nHTotalTime", SecToMin($nHTotalTime));
      $smarty->assign("nVTotalTime", SecToMin($nVTotalTime));
      $smarty->assign("nHTotalTime", SecToMin($nHTotalTime));
      $smarty->assign("dlbHTimeOnOffence", SecToMin(SafeDivide($nHTotalTime, $nHGoals)));
      $smarty->assign("dlbVTimeOnOffence", SecToMin(SafeDivide($nVTotalTime, $nVGoals)));
      $smarty->assign("dblHAvgGoalsFromOffence", number_format(SafeDivide(abs($nHGoals - $nHBreaks), $nHOffencePoint) * 100, 1));
      $smarty->assign("dblVAvgGoalsFromOffence", number_format(SafeDivide(abs($nVGoals - $nVBreaks), $nVOffencePoint) * 100, 1));
      $smarty->assign("nHBreaks", $nHBreaks);
      $smarty->assign("nVBreaks", $nVBreaks);
      $smarty->assign("nHLosesDisc", $nHLosesDisc);
      $smarty->assign("nVLosesDisc", $nVLosesDisc);
      $smarty->assign("nHTO", $nHTO);
      $smarty->assign("nVTO", $nVTO);
      $smarty->assign("dblHAvgGoalsFromDefense", number_format(SafeDivide($nHBreaks, $nVOffencePoint) * 100, 1));
      $smarty->assign("dblVAvgGoalsFromDefense", number_format(SafeDivide($nHBreaks, $nVOffencePoint) * 100, 1));
      $smarty->assign("is_season_admin", isSeasonAdmin($seasoninfo['season_id']));
    }

    $smarty->assign("show_defense_stats", ShowDefenseStats());
    // Defense board
    if (ShowDefenseStats()) {
      $home_team_defense_board = GameTeamDefenseBoard($gameId,  $game_result['hometeam']);
      $guest_team_defense_board = GameTeamDefenseBoard($gameId,  $game_result['visitorteam']);
      $defenses = GameDefenses($gameId);

      $home_defenses_array = array();
      while ($row = GetDatabase()->FetchAssoc($home_team_defense_board)) {
        $defenses_array[] = $row;
      }
      $smarty->assign("home_defenses", $defenses_array);

      $visitor_defenses_array = array();
      while ($row = GetDatabase()->FetchAssoc($guest_team_defense_board)) {
        $visitor_defenses_array[] = $row;
      }
      $smarty->assign("visitor_defenses", $defenses_array);

      $prevdefense = 0;
      GetDatabase()->DataSeek($defenses, 0);
      $all_defenses_array = array();
      while ($defense = GetDatabase()->FetchAssoc($defenses)) {
        $all_defenses_array[] = $defense;
      }
      $smarty->assign("all_defenses", $all_defenses_array);
    }
  }
} else {
  $smarty->assign("shortdate_game_result_time", ShortDate($game_result['time']));
  $smarty->assign("hourformat_game_result_time", DefHourFormat($game_result['time']));
}
