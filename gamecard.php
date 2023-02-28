<?php
include_once 'lib/team.functions.php';
include_once 'lib/common.functions.php';
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/player.functions.php';
include_once 'lib/game.functions.php';

$teamId1 = 0;
$teamId2 = 0;
$sorting = "series";

if (iget("team1")) {
  $teamId1 = intval(iget("team1"));
}
if (iget("team2")) {
  $teamId2 = intval(iget("team2"));
}
if (iget("sort")) {
  $sorting = iget("sort");
}
$smarty->assign("team_id1", $teamId1);
$smarty->assign("team_id2", $teamId2);

$team1 = TeamInfo($teamId1);
$team2 = TeamInfo($teamId2);
$smarty->assign("team1", $team1);
$smarty->assign("team2", $team2);

$title = _("Game card") . ": " . utf8entities($team1['name']) . " vs. " . utf8entities($team2['name']);
$smarty->assign("title", $title);

$nGames = 0;
$nT1GoalsMade = 0;
$nT1GoalsAgainst = 0;
$nT1Wins = 0;
$nT1Loses = 0;
$nT2GoalsMade = 0;
$nT2GoalsAgainst = 0;
$nT2Wins = 0;
$nT2Loses = 0;

// Ignore spaces from team name
$t1 = preg_replace('/\s*/m', '', $team1['name']);
$t2 = preg_replace('/\s*/m', '', $team2['name']);

$points = array(array());
$games_array = array();
$games = GetAllPlayedGames($t1, $t2, $team1['type'], $sorting);
while ($game = GetDatabase()->FetchAssoc($games)) {
  if (!GameHasStarted($game)) {
    continue;
  }

  $games_array[] = $game;
  $scores = GameScoreBoard($game['game_id']);
  if (strcasecmp($t1, $t2) == 0) {
    if (intval($game['homescore']) > intval($game['visitorscore'])) {
      $nT1Wins++;
      $nT2Loses++;
    } elseif (intval($game['homescore']) < intval($game['visitorscore'])) {
      $nT2Wins++;
      $nT1Loses++;
    }
    $nT1GoalsMade += intval($game['homescore']);
    $nT2GoalsAgainst += intval($game['homescore']);

    $nT2GoalsMade += intval($game['visitorscore']);
    $nT1GoalsAgainst += intval($game['visitorscore']);
  } else {
    if (intval($game['homescore']) < intval($game['visitorscore'])) {
      $nT1Wins++;
      $nT2Loses++;
    } elseif (intval($game['homescore']) > intval($game['visitorscore'])) {
      $nT2Wins++;
      $nT1Loses++;
    }

    $nT1GoalsMade += intval($game['visitorscore']);
    $nT2GoalsAgainst += intval($game['visitorscore']);

    $nT2GoalsMade += intval($game['homescore']);
    $nT1GoalsAgainst += intval($game['homescore']);
  }

  $i = 0;

  while ($row = GetDatabase()->FetchAssoc($scores)) {
    $bFound = false;
    for ($i = 0; ($i < 200) && !empty($points[$i][0]); $i++) {
      // Ignore spaces from team name
      $t1 = preg_replace('/\s*/m', '', $row['teamname']);
      $t2 = preg_replace('/\s*/m', '', $points[$i][2]);
      if (($points[$i][0] == $row['profile_id']) && (strcasecmp($t1, $t2) == 0)) {
        $points[$i][3]++;
        $points[$i][4] += intval($row['fedin']);
        $points[$i][5] += intval($row['done']);
        $points[$i][6] = $points[$i][4] + $points[$i][5];
        $bFound = true;
      }
    }

    if (!$bFound && $i < 200) {
      $points[$i][0] = $row['profile_id'];
      $points[$i][1] = $row['firstname'] . " " . $row['lastname'];
      $points[$i][2] = $row['teamname'];
      $points[$i][3] = 1;
      $points[$i][4] = intval($row['fedin']);
      $points[$i][5] = intval($row['done']);
      $points[$i][6] = $points[$i][4] + $points[$i][5];
      $points[$i][7] = $row['player_id'];
    }
  }

  $nGames++;
}
$smarty->assign("nT1GoalsMade", $nT1GoalsMade);
$smarty->assign("nT2GoalsAgainst", $nT2GoalsAgainst);
$smarty->assign("nT2GoalsMade", $nT2GoalsMade);
$smarty->assign("nT2Wins", $nT2Wins);
$smarty->assign("nT1Loses", $nT1Loses);
$smarty->assign("nT1Wins", $nT1Wins);
$smarty->assign("nT2Loses", $nT2Loses);
$smarty->assign("nGames", $nGames);
$smarty->assign("dblT1WinP", number_format((SafeDivide($nT1Wins, $nGames) * 100), 1));
$smarty->assign("dblT1ScoredPerGame", number_format(SafeDivide($nT1GoalsMade, $nGames), 1));
$smarty->assign("dblT1AgainstPerGame", number_format(SafeDivide($nT1GoalsAgainst, $nGames), 1));
$smarty->assign("dblT2WinP", number_format((SafeDivide($nT2Wins, $nGames) * 100), 1));
$smarty->assign("dblT2ScoredPerGame", number_format(SafeDivide($nT2GoalsMade, $nGames), 1));
$smarty->assign("dblT2AgainstPerGame", number_format(SafeDivide($nT2GoalsAgainst, $nGames), 1));

if ($nGames) {
  $smarty->assign("games", $games_array);

  $viewUrl = "?view=gamecard&amp;team1=$teamId1&amp;team2=$teamId2&amp;";
  $games_header = array(
    0 => array(
      "title" => _("Game"),
      "sort" => "team",
      "url" => $viewUrl . "sort=team",
      "options" => "",
    ),
    1 => array(
      "title" => _("Result"),
      "sort" => "result",
      "url" => $viewUrl . "sort=result",
      "options" => "",
    ),
    2 => array(
      "title" => _("Division"),
      "sort" => "series",
      "url" => $viewUrl . "sort=series",
      "options" => "",
    ),
  );
  $smarty->assign("games_header", $games_header);

  $sort_options = array(
    "pname" =>  _("Player"),
    "pteam" => _("Team"),
    "pgames" => _("Games"),
    "ppasses" => _("Assists"),
    "pgoals" => _("Goals"),
    "ptotal" => "Yht",
  );

  $scoreboard_header = array();
  foreach ($sort_options as $sort => $title) {
    $scoreboard_header[] = array(
      "title" => $title,
      "sort" => $sort,
      "url" => $viewUrl . "sort=" . $sort,
      "options" => "",
    );
  }
  $smarty->assign("scoreboard_header", $scoreboard_header);

  $smarty->assign("sorting", $sorting);

  if (array_key_exists($sorting, $sort_options)) {
    mergesort($points, "sort" . $sorting);
  } else {
    mergesort($points, "sortptotal");
  }
  $smarty->assign("points", $points);
}

function sortptotal($a, $b)
{
  return $a[6] == $b[6] ? 0 : ($a[6] > $b[6] ? -1 : 1);
}

function sortpgoals($a, $b)
{
  return $a[5] == $b[5] ? 0 : ($a[5] > $b[5] ? -1 : 1);
}

function sortppasses($a, $b)
{
  return $a[4] == $b[4] ? 0 : ($a[4] > $b[4] ? -1 : 1);
}

function sortpgames($a, $b)
{
  return $a[3] == $b[3] ? 0 : ($a[3] > $b[3] ? -1 : 1);
}

function sortpteam($a, $b)
{
  return strcmp($b[2], $a[2]);
}

function sortpname($a, $b)
{
  return strcmp($b[1], $a[1]);
}
