<?php
include_once 'lib/common.functions.php';
include_once 'lib/game.functions.php';
include_once 'lib/statistical.functions.php';
include_once 'lib/configuration.functions.php';

if (version_compare(PHP_VERSION, '5.0.0', '>')) {
  include_once 'lib/twitter.functions.php';
}

include_once 'classes/Game.php';

$home = intval($_POST['home']);
$away = intval($_POST['away']);
$game_num = intval($_POST['game']);
$gameId = (int) substr($game, 0, -1);
$game = new Game(GetDatabase(), $gameId);

$html = "";

$errors = "";
if (!empty($_POST['save'])) {
	if ($gameId == 0 || !checkChkNum($game)) {
		$errors .= "<p class='warning'>" . _("Erroneous scoresheet number:") . " " . $game . "</p>";
  }

  $errors .= $game->checkResult($home, $away);
}

if (!empty($_POST['confirm'])) {
	if ($gameId == 0 || !checkChkNum($game)) {
		$errors .= "<p class='warning'>" . _("Erroneous scoresheet number:") . " " . $game . "</p>";
  }

  $errors .= $game->checkResult($home, $away);
  if (empty($errors)) {
    $game->setResult($home, $away, true, false);
    header("location:?" . $_SERVER['QUERY_STRING']);
  }
}

if (!empty($_POST['cancel'])) {
  $html .= "<p class='warning'>" . _("Result not saved!") . "</p>";
}

PageTop(_("Add result"));

$html .= $errors;

$html .= "<div style='font-size:14px;'>";

$html .= "<form action='?" . utf8entities($_SERVER['QUERY_STRING']) . "' method='post'>\n";
if (!empty($_POST['save']) && empty($errors)) {
  $html .= "<p>";
  $html .= "<input class='input' type='hidden' id='game' name='game' value='$game'/> ";
  $html .= "<input class='input' type='hidden' id='home' name='home' value='$home'/> ";
  $html .= "<input class='input' type='hidden' id='away' name='away' value='$away'/> ";
  $html .= "<p>";
  $html .= ShortDate($game->getTime()) . " " . DefHourFormat($game->getTime()) . " ";
  if (!empty($game->getFieldName())) {
    $html .=  _("on field") . " " . $game->getFieldName();
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
    $html .= _("Game is already played. Result:") . " " . intval($game->getHomeScore()) . " - " . $game->getVisitorScore() . ".";
    $html .=  "<br/><br/>";
    $html .=  "<span style='font-weight:bold'>" . _("Change result to") . " $home - $away?" . "</span>";
  } else {
    $html .=  "<span style='font-weight:bold'> $home - $away</span>";
  }

  $html .=  "<br/><br/>";
  $html .=  _("Winner is") . " <span style='font-weight:bold'>";
  if ($home > $away) {
    $html .= utf8entities(TeamName($game->getHomeTeam()));
  } else {
    $html .= utf8entities(TeamName($game->getVisitorTeam()));
  }
  $html .=  "?</span> ";
  $html .= "<br/><br/><input class='button' type='submit' name='confirm' value='" . _("Confirm") . "'/> ";
  $html .= "<input class='button' type='submit' name='cancel' value='" . _("Cancel") . "'/>";
  $html .=  "</p>";
} else {
  $html .= "<table cellpadding='2'>\n";
  $html .= "<tr><td class='infocell'>\n";
  $html .= _("Scoresheet #") . ":";
  $html .= "</td><td>\n";
  $html .= "<input class='input' type='text' id='game' name='game' size='6' maxlength='5' onkeyup='validNumber(this);'/> ";
  $html .= "</td></tr><tr><td class='infocell'>\n";
  $html .= _("Home Goals") . ":";
  $html .= "</td><td>\n";
  $html .= "<input class='input' type='text' id='home' name='home' size='3' maxlength='3' onkeyup='validNumber(this);'/> ";
  $html .= "</td></tr><tr><td class='infocell'>\n";
  $html .= _("Away Goals") . ":";
  $html .= "</td><td>\n";
  $html .= "<input class='input' type='text' id='away' name='away' size='3' maxlength='3' onkeyup='validNumber(this);'/> ";
  $html .= "</td></tr><tr><td style='padding-top:15px' colspan='2'>\n";
  $html .= "<input style='width:100%;' class='button' type='submit' name='save' value='" . _("Save") . "'/>";
  $html .= "</td></tr>\n";
  $html .= "</table>\n";
}
$html .= "</form>";
$html .= "<p><a href='?view=played'>" . _("Played games") . "</a></p>";
$html .= "</div>";
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
<?php
pageEnd();
?>