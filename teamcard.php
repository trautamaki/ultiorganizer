<?php
include_once 'lib/team.functions.php';
include_once 'lib/player.functions.php';
include_once 'lib/common.functions.php';
include_once 'lib/season.functions.php';
include_once 'lib/statistical.functions.php';
include_once 'lib/timetable.functions.php';

$teamId = intval(iget("team"));
$teaminfo = TeamInfo($teamId);
$profile = TeamProfile($teamId);

$smarty->assign("title", utf8entities($teaminfo['name']));
$smarty->assign("team_info", $teaminfo);
$smarty->assign("urls", GetUrlList("team", $teamId));
$smarty->assign("media_urls", GetMediaUrlList("team", $teamId));
$smarty->assign("season_name", SeasonName($teaminfo['season']));

$show_defense_stats = ShowDefenseStats();
$smarty->assign("show_defense_stats", $show_defense_stats);
$team_d_player_info = array();
if (ShowDefenseStats()) {
  $players_wiht_def = TeamScoreBoardWithDefenses($teamId, 0, "name", 0);
  while ($player = GetDatabase()->FetchAssoc($players_wiht_def)) {
    $team_d_player_info[$player['player_id']] = PlayerInfo($player['player_id']);
  }
}

$smarty->assign("players_with_def", $players_wiht_def);
$smarty->assign("team_d_player_info", $team_d_player_info);

$team_players = TeamScoreBoard($teamId, 0, "name", 0);
$team_player_info = array();
while ($player = GetDatabase()->FetchAssoc($team_players)) {
  $team_player_info[$player['player_id']] = PlayerInfo($player['player_id']);
}

$smarty->assign("team_players", $team_players);
$smarty->assign("team_player_info", $team_player_info);

$all_games = array();
$timetablegames = TimetableGames($teamId, "team", "all", "time");
$game_urls = array();
$xgames = array();
while ($game = GetDatabase()->FetchAssoc($timetablegames)) {
  $all_games[] = $game;
  $game_urls[$game['game_id']] = GetMediaUrlList("game", $game['game_id'], "live");

  $t1 = preg_replace('/\s*/m', '', $game['hometeamname']);
  $t2 = preg_replace('/\s*/m', '', $game['visitorteamname']);
  $x_result = GetAllPlayedGames($t1, $t2, $game['type'], "");
  while ($x_game = GetDatabase()->FetchAssoc($x_result)) {
    $xgames[$game['game_id']][] = $x_game;
  }
}
$smarty->assign("all_games", $all_games);
$smarty->assign("xgames", $xgames);
$smarty->assign("game_urls", $game_urls);

$seasons = TeamStatisticsByName($teaminfo['name'], $teaminfo['type']);
$smarty->assign("seasons", $seasons);

$stats = array();
foreach ($seasons as $season) {
  $pg = array(
    "season_type" => "",
    "games" => 0,
    "wins" => 0,
    "losses" => 0,
    "goals_made" => 0,
    "goals_against" => 0,
    "defenses" => 0
  );

  $pg['season_type'] = $season['seasontype'];
  $pg['season_name'] = $season['seasonname'];
  $pg['series_name'] = $season['seriesname'];

  $pg['goals_made'] = $season['goals_made'];
  $pg['goals_against'] = $season['goals_against'];
  $pg['wins'] = $season['wins'];
  $pg['losses'] = $season['losses'];
  $pg['games'] = $season['wins'] + $season['losses'];
  $pg['defenses'] = $season['defenses_total'];

  $pg['win_p'] = number_format((SafeDivide($pg['wins'], $pg['games']) * 100), 1);
  $pg['goals_per_game'] = number_format(SafeDivide($pg['goals_made'], $pg['games']), 1);
  $pg['goals_a_per_game'] = number_format(SafeDivide($pg['goals_against'], $pg['games']), 1);
  $pg['goals_diff'] = ($pg['goals_made'] - $pg['goals_against']);

  $stats[] = $pg;
}

mergesort($stats, 'cmp_seasons');
function cmp_seasons($b, $a)
{
  return strcmp($b['season_type'], $a['season_type']);
}

$smarty->assign("stats_per_season", $stats);

$stats_total = array();
$stats_per_season_type = array();
for ($i = 0; $i < count($stats);) {
  $season_type = $stats[$i]['season_type'];
  $games = $stats[$i]['games'];
  $wins = $stats[$i]['wins'];
  $losses = $stats[$i]['losses'];
  $goals_made = $stats[$i]['goals_made'];
  $goals_against = $stats[$i]['goals_against'];
  $defenses = $stats[$i]['defenses'];

  for ($i = $i + 1; $i < count($stats) && $season_type == $stats[$i]['season_type']; $i++) {
    $stats_per_season_type[$stats[$i]['season_type']]['games'] += $stats[$i]['games'];
    $stats_per_season_type[$stats[$i]['season_type']]['wins'] += $stats[$i]['wins'];
    $stats_per_season_type[$stats[$i]['season_type']]['losses'] += $stats[$i]['losses'];
    $stats_per_season_type[$stats[$i]['season_type']]['goals_made'] += $stats[$i]['goals_made'];
    $stats_per_season_type[$stats[$i]['season_type']]['goals_against'] += $stats[$i]['goals_against'];
    $stats_per_season_type[$stats[$i]['season_type']]['defenses'] += $stats[$i]['defenses'];
  }

  foreach ($stats_per_season_type as $type => $stat) {
    $stats_per_season_type[$type]['win_p'] = number_format((SafeDivide(
      $stats_per_season_type[$type]['wins'],
      $stats_per_season_type[$type]['games']
    ) * 100), 1);

    $stats_per_season_type[$type]['goals_per_game'] = number_format(SafeDivide(
      $stats_per_season_type[$type]['goals_made'],
      $stats_per_season_type[$type]['games']
    ), 1);

    $stats_per_season_type[$type]['goals_a_per_game'] = number_format(SafeDivide(
      $stats_per_season_type[$type]['goals_against'],
      $stats_per_season_type[$type]['games']
    ), 1);

    $stats_per_season_type[$type]['goals_diff'] =
      $stats_per_season_type[$type]['goals_made'] -
      $stats_per_season_type[$type]['goals_against'];
  }

  $stats_total['total_games'] += $games;
  $stats_total['total_wins'] += $wins;
  $stats_total['total_losses'] += $losses;
  $stats_total['total_goals_made'] += $goals_made;
  $stats_total['total_goals_against'] += $goals_against;
  $stats_total['total_defenses'] += $defenses;
}

$stats_total['total_win_p'] = number_format((SafeDivide(
  $stats_total['total_wins'],
  $stats_total['total_games']
) * 100), 1);

$stats_total['total_goals_per_game'] = number_format(SafeDivide(
  $stats_total['total_goals_made'],
  $stats_total['total_games']
), 1);

$stats_total['total_goals_a_per_game'] = number_format(SafeDivide(
  $stats_total['total_goals_against'],
  $stats_total['total_games']
), 1);

$stats_total['total_goals_diff'] =
  $stats_total['total_goals_made'] -
  $stats_total['total_goals_against'];

$smarty->assign("stats_per_season_type", $stats_per_season_type);
$smarty->assign("stats_total", $stats_total);

$sort = iget("sort");
if (empty($sort)) {
  $sort = "serie";
}

$played = TeamPlayedGames($teaminfo['name'], $teaminfo['type'], $sort);
$played_array = array();
if (GetDatabase()->NumRows($played)) {
  $curSeason = Currentseason();
  while ($row = GetDatabase()->FetchAssoc($played)) {
    if ($row['season_id'] == $curSeason || !GameHasStarted($row)) {
      continue;
    }
    $row['season_name'] = SeasonName($row['season_id']);
    $played_array[] = $row;
  }
}

$smarty->assign("played", $played_array);
