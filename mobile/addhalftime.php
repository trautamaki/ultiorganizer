<?php
include_once 'lib/common.functions.php';
include_once 'lib/game.functions.php';
include_once 'lib/team.functions.php';
include_once 'lib/player.functions.php';

include_once 'classes/Game.php';

$html = "";

$gameId = intval(iget("game"));
$game = new Game(GetDatabase(), $gameId);
$game_result = $game->getResult();

if (isset($_POST['save'])) {
	$time = "0.0";
	$time_delim = array(",", ";", ":", "#", "*");

	if (isset($_POST['halftime']))
		$time = $_POST['halftime'];

	$time = str_replace($time_delim, ".", $time);
	$htime = TimeToSec($time);
	$game->setHalftime($htime);

	header("location:?view=mobile/addscoresheet&game=" . $gameId);
}

mobilePageTop(_("Score&nbsp;sheet"));

$html .= "<form action='?" . utf8entities($_SERVER['QUERY_STRING']) . "' method='post'>\n";
$html .= "<table cellpadding='2'>\n";
$html .= "<tr><td>\n";
$html .= _("Half time") . ":";
$html .= "</td></tr><tr><td>\n";
$html .= "<input class='input' maxlength='8' type='text' name='halftime' id='halftime' value='" . SecToMin($game_result['halftime']) . "'/>";
$html .= "</td></tr><tr><td>\n";
$html .= "<input class='button' type='submit' name='save' value='" . _("Save") . "'/>";
$html .= "</td></tr><tr><td>\n";
$html .= "<a href='?view=mobile/addscoresheet&amp;game=" . $gameId . "'>" . _("Back to score sheet") . "</a>";
$html .= "</td></tr>\n";
$html .= "</table>\n";
$html .= "</form>";

echo $html;

pageEnd();
