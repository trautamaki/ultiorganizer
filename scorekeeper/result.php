<?php
include_once "classes/Game.php";

$html = "";
$errors = "";
$saved = isset($_GET['saved']) ? 1 : 0;
$game_gid = isset($_GET['g']) ? $_GET['g'] : "";

if (!empty($_POST['save'])) {
  $game_gid = intval($_POST['game']);
  $home = intval($_POST['home']);
  $away = intval($_POST['away']);
  $gameId = (int) substr($game, 0, -1);
  $game = new Game(GetDatabase(), $gameId);
  $errors = $game->checkResult($home, $away);
}
if (!empty($_POST['confirm'])) {
  $game_gid = intval($_POST['game']);
  $home = intval($_POST['home']);
  $away = intval($_POST['away']);
  $gameId = (int) substr($game, 0, -1);
  $game = new Game(GetDatabase(), $gameId);
  $errors = $game->checkResult($home, $away);
  if (empty($errors)) {
    $ok = $game->setResult($home, $away, true, false);
    if ($ok)
      header("location:?view=result&saved=1");
    else
      $errors .= "<p>" . _("Error: Could not save result.") . "</p>\n";
  }
}


$html .= "<div data-role='header'>\n";
$html .= "<h1>" . _("Add result with game id") . "</h1>\n";
$html .= "</div><!-- /header -->\n\n";
$html .= "<div data-role='content'>\n";

$html .= $errors;

$html .= "<form action='?view=result' method='post' data-ajax='false'>\n";
if (!empty($_POST['cancel'])) {
  $html .= "<p class='warning'>" . _("Result not saved!") . "</p>";
}
if ($saved) {
  $html .= "<p>" . _("Result saved!") . "</p>";
}

if (!empty($_POST['save']) && empty($errors)) {
  $html .= "<p>";
  $html .= "<input class='input' type='hidden' id='game' name='game' value='$game_gid'/> ";
  $html .= "<input class='input' type='hidden' id='home' name='home' value='$home'/> ";
  $html .= "<input class='input' type='hidden' id='away' name='away' value='$away'/> ";
  $game = new Game(GetDatabase(), $gameId);
  $html .= "<p>";
  $html .= ShortDate($game->getTime()) . " " . DefHourFormat($game->getTime()) . " ";
  if (!empty($game->getFieldName())) {
    $html .=  _("on field") . " " . utf8entities($game->getFieldName());
  }
  $html .=  "<br/>";
  $html .=  U_(SeriesName($game->getSeries())) . ", " . U_(PoolName($game->getPool()));
  $html .=  "</p>";
  $html .= "<p>";
  $html .= utf8entities(TeamName($game->getHomeTeam()));
  $html .= " - ";
  $html .= utf8entities(TeamName($game->getVisitorTeam()));
  $html .=  " ";

  if ($game->hasStarted()) {
    $html .=  "<br/>";
    $html .= _("Game is already played. Result:") . " " . $game->getHomeScore() . " - " . $game->getVisitorScore() . ".";
    $html .=  "<br/><br/>";
    $html .=  "<span style='font-weight:bold'>" . _("Change result to") . " $home - $away?" . "</span>";
  } else {
    $html .=  "<span style='font-weight:bold'> $home - $away</span>";
  }

  $html .=  "<br/><br/>";
  $html .=  _("Winner is") . " <span style='font-weight:bold'>";
  if ($home > $away) {
    $html .= TeamName($game->getHomeTeam());
  } else {
    $html .= TeamName($game->getVisitorTeam());
  }
  $html .=  "?</span> ";
  $html .= "<br/><br/><input type='submit' name='confirm' data-ajax='false' value='" . _("Confirm") . "'/> ";
  $html .= "<input type='submit' name='cancel' data-ajax='false' value='" . _("Cancel") . "'/>";
  $html .=  "</p>";
} else {
  $html .= "<label for='game'>" . _("Game number from Scoresheet") . ":</label>";
  $html .= "<input type='number' id='game' name='game' size='6' maxlength='5' value='$game_gid' onkeyup='validNumber(this);'/> ";

  $html .= "<label for='home'>" . _("Home team goals") . ":</label>";
  $html .= "<input type='number' id='home' name='home' size='3' maxlength='3' onkeyup='validNumber(this);'/> ";

  $html .= "<label for='away'>" . _("Visitor team goals") . ":</label>";
  $html .= "<input type='number' id='away' name='away' size='3' maxlength='3' onkeyup='validNumber(this);'/> ";

  $html .= "<input type='submit' name='save' data-ajax='false' value='" . _("Save") . "'/>";
  $html .= "<a href='?view=login' data-role='button' data-ajax='false'>" . _("Games list") . "</a>";
}


$html .= "</form>";
$html .= "</div><!-- /content -->\n\n";
echo $html;
?>
<script type="text/javascript">
  <!--
  document.getElementById('game').setAttribute("autocomplete", "off");
  document.getElementById('home').setAttribute("autocomplete", "off");
  document.getElementById('away').setAttribute("autocomplete", "off");


  function validNumber(field) {
    field.value = field.value.replace(/[^0-9]/g, '');
  }
  //
  -->
</script>