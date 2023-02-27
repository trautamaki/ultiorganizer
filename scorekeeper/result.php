<?php
$errors = array();
$saved = isset($_GET['saved']) ? 1 : 0;
$smarty->assign("saved", $saved);
$game = isset($_GET['g']) ? $_GET['g'] : "";

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
    $ok = GameSetResult($gameId, $home, $away, true, false);
    if ($ok)
      header("location:?view=result&saved=1");
    else
      $errors[] = array("", _("Error: Could not save result."));
  }
}
$smarty->assign("errors", $errors);
$smarty->assign("home", $home);
$smarty->assign("away", $away);
$smarty->assign("game", $game);

if (!empty($_POST['save']) && empty($errors)) {
  $game_result = GameInfo($gameId);
  $game_result['time_shortdate'] = ShortDate($game_result['time']);
  $game_result['time_defhour'] = DefHourFormat($game_result['time']);
  $game_result['has_started'] = GameHasStarted($game_result);
  $smarty->assign("game_result", $game_result);
}

?>