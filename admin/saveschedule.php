<?php
include_once 'lib/reservation.functions.php';
include_once 'lib/game.functions.php';
include_once 'lib/timetable.functions.php';

include_once 'classes/Game.php';

$body = @file_get_contents('php://input');
//alternative way for IIS if above command fail
//set in php.ini: always_populate_raw_post_data = On
//$body = $HTTP_RAW_POST_DATA; 

$season = "";
$response = "";

$places = explode("|", $body);
foreach ($places as $placeGameStr) {
  $games = explode(":", $placeGameStr);
  if (intval($games[0]) != 0) {
    $reservation = new Reservation(GetDatabase(), $games[0]);
    ClearReservation($reservation);
    $firstStart = strtotime($reservation->getStartTime());
    $resEnd = strtotime($reservation->getEndTime());
    for ($i = 1; $i < count($games); $i++) {
      $gameArr = explode("/", $games[$i]);
      $game = new Game(GetDatabase(), $gameArr[0]);
      $season = $game->getSeason();
      $time = $firstStart + (60 * $gameArr[1]);
      if (!empty($game->getGametimeslot())) {
        $gameEnd = $time + ($game->getGametimeslot() * 60);
      } else {
        $gameEnd = $time + ($game->getTimeslot() * 60);
      }
      if ($gameEnd > $resEnd) {
        $response .= "<p>" . sprintf(_("Game %s exceeds reserved time %s."), $game->getPrettyName(), ShortTimeFormat($resInfo->getEndTime())) . "</p>";
      }
      $game->setSchedule($time, $games[0]);
    }
  } else {
    for ($i = 1; $i < count($games); $i++) {
      $gameArr = explode("/", $games[$i]);
      $game = new Game(GetDatabase(), $gameArr[0]);
      $season = $game->getSeason();
      $game->removeSchedule();
    }
  }
}

if ($season) {

  $movetimes = TimetableMoveTimes($season);
  $conflicts = TimetableIntraPoolConflicts($season);

  foreach ($conflicts as $conflict) {
    if (!empty($conflict['time2']) && !empty($conflict['time1'])) {
      if (strtotime($conflict['time1']) + $conflict['slot1'] * 60 + TimetableMoveTime($movetimes, $conflict['location1'], $conflict['field1'], $conflict['location2'], $conflict['field2']) > strtotime($conflict['time2'])) {
        $game1 = new Game(getDatabase(), $conflict['game1']);
        $game2 = new Game(getDatabase(), $conflict['game2']);
        $response .= "<p>" .
          sprintf(
            _("Warning: Game %s (%d, pool %d) has a scheduling conflict with %s (%d, pool %d)."),
            $game2->getPrettyName(),
            (int) $game2->getId(),
            (int) $game2->getPool(),
            $game1->getPrettyName(),
            (int) $game1->getId(),
            (int) $game1->getPool()
          ) . "</p>";
        break;
      }
    }
  }

  if (empty($response)) {
    $conflicts = TimetableInterPoolConflicts($season);

    foreach ($conflicts as $conflict) {
      if (!empty($conflict['time2']) && !empty($conflict['time1'])) {
        if (strtotime($conflict['time1']) + $conflict['slot1'] * 60 + TimetableMoveTime($movetimes, $conflict['location1'], $conflict['field1'], $conflict['location2'], $conflict['field2']) > strtotime($conflict['time2'])) {
          $game1 = new Game(getDatabase(), $conflict['game1']);
          $game2 = new Game(getDatabase(), $conflict['game2']);
          $response .= "<p>" . sprintf(
            _("Warning: Game %s has a scheduling conflict with %s."),
            $game2->getPrettyName(),
            $game1->getPrettyName(),
          ) . "</p>";
          break;
        }
      }
    }
  }
} else {
  $response .= "<p>" . _("Error, unknown season!") . "</p>";
}

if (!empty($response))
  echo "<p>" . _("Schedule saved with errors:") . "</p>\n" . $response;
else
  echo _("Schedule saved and checked.");
