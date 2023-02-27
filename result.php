<?php
include_once 'lib/common.functions.php';
include_once 'lib/game.functions.php';
include_once 'lib/statistical.functions.php';
include_once 'lib/configuration.functions.php';

if (version_compare(PHP_VERSION, '5.0.0', '>')) {
  include_once 'lib/twitter.functions.php';
}

$errors = array();
if (!empty($_POST['save'])) {
  $game = intval($_POST['game']);
  $home = intval($_POST['home']);
  $away = intval($_POST['away']);
  $errors = CheckGameResult($game, $home, $away);
  $gameId = (int) substr($game, 0, -1);
}
if (!empty($_POST['confirm'])) {
  $game = intval($_POST['game']);
  $home = intval($_POST['home']);
  $away = intval($_POST['away']);
  $errors = CheckGameResult($game, $home, $away);
  if (empty($errors)) {
    $gameId = (int) substr($game, 0, -1);
    GameSetResult($gameId, $home, $away, true, false);
    header("location:?" . $_SERVER['QUERY_STRING']);
  }
}
$smarty->assign("errors", $errors);
$smarty->assign("home", $home);
$smarty->assign("away", $away);
$smarty->assign("game", $game);

$smarty->assign("query_string", $_SERVER['QUERY_STRING']);

if (!empty($_POST['save']) && empty($errors)) {
  $game_result = GameInfo($gameId);
  $game_result['time_shortdate'] = ShortDate($game_result['time']);
  $game_result['time_defhour'] = DefHourFormat($game_result['time']);
  $game_result['has_started'] = GameHasStarted($game_result);
  $smarty->assign("game_result", $game_result);
}
?>
