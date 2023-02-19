<?php
include_once 'classes/Game.php';

$html = "";

$gameId = isset($_GET['game']) ? $_GET['game'] : $_SESSION['game'];
$_SESSION['game'] = $gameId;

$game = new Game(GetDatabase(), $gameId);
$game_result = $game->getResult();

if (isset($_POST['save'])) {
	if (!empty($_POST['team'])) {
		$starting = $_POST['team'];
		$game->setStartingTeam($starting == "H");
	}
	header("location:?view=addscoresheet&game=" . $gameId);
}

//starting team
$hoffence = "";
$voffence = "";
$ishome = $game->getIsFirstOffenceHome();
if ($ishome == 1) {
	$hoffence = "checked='checked'";
} elseif ($ishome == 0) {
	$voffence = "checked='checked'";
}

$html .= "<div data-role='header'>\n";
$html .= "<h1>" . _("First Offence") . ": " . utf8entities($game_result['hometeamname']) . " - " . utf8entities($game_result['visitorteamname']) . "</h1>\n";
$html .= "</div><!-- /header -->\n\n";

$html .= "<div data-role='content'>\n";


$html .= "<form action='?view=addfirstoffence' method='post' data-ajax='false'>\n";
$html .= "<fieldset data-role='controlgroup' id='teamselection'>";
$html .= "<input type='radio' name='team' id='hstart' value='H' $hoffence />";
$html .= "<label for='hstart'>" . utf8entities($game_result['hometeamname']) . "</label>";
$html .= "<input type='radio' name='team' id='vstart' value='V' $voffence  />";
$html .= "<label for='vstart'>" . utf8entities($game_result['visitorteamname']) . "</label>";
$html .= "</fieldset>";
$html .= "<input type='submit' name='save' data-ajax='false' value='" . _("Save") . "'/>";
$html .= "<a href='?view=addscoresheet&amp;game=" . $gameId . "' data-role='button' data-ajax='false'>" . _("Back to score sheet") . "</a>";
$html .= "</form>";
$html .= "</div><!-- /content -->\n\n";

echo $html;
