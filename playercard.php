<?php
include_once 'lib/team.functions.php';
include_once 'lib/common.functions.php';
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/player.functions.php';
include_once 'lib/game.functions.php';
include_once 'lib/statistical.functions.php';

// TODO clean up

if (iget("profile")) {
  $playerId = PlayerLatestId(intval(iget("profile")));
} else {
  $playerId = intval(iget("player"));
}

$profile = "";

$player = PlayerInfo($playerId);
if (!empty($player['profile_id'])) {
  $profile = PlayerProfile($player['profile_id']);
} else {
  $profile = PlayerProfile($playerId);
}
$smarty->assign("player", $player);

$curseason = CurrentSeason();

if ($player['num']) {
  $title = "#" . $profile['num'] . " " . utf8entities($profile['firstname'] . " " . $profile['lastname']);
} else {
  $title = utf8entities($profile['firstname'] . " " . $profile['lastname']);
}
$smarty->assign("title", $title);

if ($profile) {
  $publicfields = explode("|", $profile['public']);
  $smarty->assign("public_fields", $publicfields);

  $profile['pretty_birthday'] = ShortDate($profile['birthdate']);
  $profile['pretty_story'] = someHTML($profile['story']);
  $profile['pretty_achievements'] = someHTML($profile['achievements']);
  $smarty->assign("profile", $profile);
}

$urls = GetUrlList("player", $player['profile_id']);
$smarty->assign("urls", $urls);

$urls = GetMediaUrlList("player", $player['profile_id']);
$smarty->assign("media_urls", $urls);

$games = PlayerSeasonPlayedGames($playerId, $curseason);
$smarty->assign("games", $games);

$smarty->assign("show_defence_stats", ShowDefenseStats());

if ($games) {
  $goals = PlayerSeasonGoals($playerId, $curseason);
  $passes = PlayerSeasonPasses($playerId, $curseason);
  $callahans = PlayerSeasonCallahanGoals($playerId, $curseason);
  $wins = PlayerSeasonWins($playerId, $player['team'], $curseason);
  $smarty->assign("goals", $goals);
  $smarty->assign("passes", $passes);
  $smarty->assign("callahans", $callahans);
  $smarty->assign("wins", $wins);

  $dblPassAvg = SafeDivide($passes, $games);
  $dblGoalAvg = SafeDivide($goals, $games);
  $dblScoreAvg = SafeDivide($total, $games);
  $dblWinsAvg = SafeDivide($wins, $games);
  if (ShowDefenseStats()) {
    $dblDefenAvg = SafeDivide($defenses, $games);
  }
  $smarty->assign("dblPassAvg", number_format($dblPassAvg, 2));
  $smarty->assign("dblGoalAvg", number_format($dblGoalAvg, 2));
  $smarty->assign("dblScoreAvg", number_format($dblScoreAvg, 2));
  $smarty->assign("dblWinsAvg", number_format($dblWinsAvg * 100, 1));
  $smarty->assign("dblDefenAvg", number_format($dblDefenAvg, 2));

  $smarty->assign("current_season_name", CurrentSeasonName());
}

$stats = array();
if (ShowDefenseStats()) {
  if (!empty($player['profile_id'])) {
    $playedSeasons = PlayerStatistics($player['profile_id']);
    $smarty->assign("played_seasons", $playedSeasons);
    $season_stats = array();
    if (count($playedSeasons)) {
      foreach ($playedSeasons as $season) {

        //played series
        $pp = array(
          "season_type" => "",
          "series_type" => "",
          "games" => 0,
          "goals" => 0,
          "passes" => 0,
          "callahans" => 0,
          "defenses" => 0,
          "wins" => 0
        );
        $pp['season_type'] = $season['seasontype'];
        $pp['series_type'] = $season['seriestype'];
        $pp['games'] = $season['games'];
        $pp['passes'] = $season['passes'];
        $pp['goals'] = $season['goals'];
        $pp['callahans'] = $season['callahans'];
        $pp['defenses'] = $season['defenses'];
        $pp['wins'] = $season['wins'];

        $stats[] = $pp;
        $season_stats[$season['seasonname']][$season['seriesname']] = $pp;

        $total = $pp['goals'] + $pp['passes'];
        $season_stats[$season['seasonname']][$season['seriesname']]['total'] = $total;

        $dblPassAvg = SafeDivide($pp['passes'], $pp['games']);
        $dblGoalAvg = SafeDivide($pp['goals'], $pp['games']);
        $dblScoreAvg = SafeDivide($total, $pp['games']);
        $dblWinAvg = SafeDivide($pp['wins'], $pp['games']);
        $dblDefAvg = SafeDivide($pp['defenses'], $pp['games']);
        $season_stats[$season['seasonname']][$season['seriesname']]['dblPassAvg'] = number_format($dblPassAvg, 2);
        $season_stats[$season['seasonname']][$season['seriesname']]['dblGoalAvg'] = number_format($dblGoalAvg, 2);
        $season_stats[$season['seasonname']][$season['seriesname']]['dblScoreAvg'] = number_format($dblScoreAvg, 2);
        $season_stats[$season['seasonname']][$season['seriesname']]['dblWinAvg'] = number_format($dblWinAvg * 100, 1);
        $season_stats[$season['seasonname']][$season['seriesname']]['dblDefAvg'] = number_format($dblDefAvg, 2);
      }
      $smarty->assign("stats", $stats);
      $smarty->assign("season_stats", $season_stats);
    }
  }
  // Sort results according season and pool type
  if (count($stats)) {
    foreach ($stats as $key => $row) {
      $s[$key]  = $row['season_type'];
      $p[$key] = $row['series_type'];
    }
    array_multisort($s, SORT_DESC, $p, SORT_DESC, $stats);

    $total_games = 0;
    $total_goals = 0;
    $total_cal = 0;
    $total_passes = 0;
    $total_wins = 0;
    $total_defenses = 0;

    $per_season_and_series_stats = array();
    for ($i = 0; $i < count($stats);) {
      $season_type = $stats[$i]['season_type'];
      $series_type = $stats[$i]['series_type'];
      $games = $stats[$i]['games'];
      $goals = $stats[$i]['goals'];
      $cal = $stats[$i]['callahans'];
      $passes = $stats[$i]['passes'];
      $wins = $stats[$i]['wins'];
      $defenses = $stats[$i]['defenses'];

      for ($i = $i + 1; $i < count($stats) && $season_type == $stats[$i]['season_type'] && $series_type == $stats[$i]['series_type']; $i++) {
        $games += $stats[$i]['games'];
        $goals += $stats[$i]['goals'];
        $passes += $stats[$i]['passes'];
        $wins += $stats[$i]['wins'];
        $cal += $stats[$i]['callahans'];
        $defenses += $stats[$i]['defenses'];
      }

      $total_games += $games;
      $total_passes += $passes;
      $total_goals += $goals;
      $total_cal += $cal;
      $total_wins += $wins;
      $total_defenses += $defenses;

      $per_season_and_series_stats[$season_type . "_" . $series_type]['season_type'] = $season_type;
      $per_season_and_series_stats[$season_type . "_" . $series_type]['series_type'] = $series_type;
      $per_season_and_series_stats[$season_type . "_" . $series_type]['games'] = $games;
      $per_season_and_series_stats[$season_type . "_" . $series_type]['goals'] = $goals;
      $per_season_and_series_stats[$season_type . "_" . $series_type]['passes'] = $passes;
      $per_season_and_series_stats[$season_type . "_" . $series_type]['wins'] = $wins;
      $per_season_and_series_stats[$season_type . "_" . $series_type]['cal'] = $cal;
      $per_season_and_series_stats[$season_type . "_" . $series_type]['defenses'] = $defenses;

      $total = $passes + $goals;
      $dblPassAvg = SafeDivide($passes, $games);
      $dblGoalAvg = SafeDivide($goals, $games);
      $dblScoreAvg = SafeDivide($total, $games);
      $dblWinsAvg = SafeDivide($wins, $games);
      $dblDefsAvg = SafeDivide($defenses, $games);

      $per_season_and_series_stats[$season_type . "_" . $series_type]['dblPassAvg'] = number_format($dblPassAvg, 2);
      $per_season_and_series_stats[$season_type . "_" . $series_type]['dblGoalAvg'] = number_format($dblGoalAvg, 2);
      $per_season_and_series_stats[$season_type . "_" . $series_type]['dblScoreAvg'] = number_format($dblScoreAvg, 2);
      $per_season_and_series_stats[$season_type . "_" . $series_type]['dblWinsAvg'] = number_format($dblWinsAvg * 100, 1);
      $per_season_and_series_stats[$season_type . "_" . $series_type]['dblDefsAvg'] = number_format($dblDefsAvg, 2);
      $per_season_and_series_stats[$season_type . "_" . $series_type]['total'] = $total;
    }
    $smarty->assign("per_season_and_series_stats", $per_season_and_series_stats);

    $smarty->assing("total_games", $total_games);
    $smarty->assing("total_passes", $total_passes);
    $smarty->assing("total_goals", $total_goals);
    $smarty->assing("total_cal", $total_cal);
    $smarty->assing("total_wins", $total_wins);
    $smarty->assing("total_defenses", $total_defenses);

    $total = $total_passes + $total_goals;
    $total_dblPassAvg = SafeDivide($total_passes, $total_games);
    $total_dblGoalAvg = SafeDivide($total_goals, $total_games);
    $total_dblScoreAvg = SafeDivide($total, $total_games);
    $total_dblWinsAvg = SafeDivide($total_wins, $total_games);
    $total_dblDefsAvg = SafeDivide($total_defenses, $total_games);
    $smarty->assing("total_dblPassAvg", $total);
    $smarty->assing("total_dblGoalAvg", number_format($total_dblGoalAvg, 2));
    $smarty->assing("total_dblScoreAvg", number_format($total_dblScoreAvg, 2));
    $smarty->assing("total_dblWinsAvg", number_format($total_dblWinsAvg * 100, 1));
    $smarty->assing("total_dblDefsAvg", number_format($total_dblDefsAvg, 2));
  }
}

// Current season stats
$games = PlayerSeasonGames($playerId, $curseason);
$smarty->assign("player_season_games", $games);

if (count($games)) {
  $smarty->assign("current_season_name", CurrentSeasonName());
  $game_results = array();

  foreach ($games as $game) {
    $result = GameResult($game['game_id']);
    $game_results[$game['game_id']]['result'] = $result;
    $game_results[$game['game_id']]['result']['pretty_time'] = ShortDate($result['time']);
    $pretty_events = array();

    $events = PlayerGameEvents($playerId, $game['game_id']);
    foreach ($events as $event) {
      $event['pretty_time'] = SecToMin($event['time']);

      if ($event['assist'] != $playerId) {
        if (!intval($event['iscallahan'])) {
          $event['goal_assist'] = PlayerInfo($event['assist']);
        }
      }

      if ($event['scorer'] != $playerId) {
        $event['assist_goal'] = PlayerInfo($event['scorer']);
      }
      $pretty_events[] = $event;
    }

    $game_results[$game['game_id']]['events'] = $pretty_events;
  }
  $smarty->assign("game_results", $game_results);
}
