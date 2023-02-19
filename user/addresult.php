<?php
include_once $include_prefix . 'lib/common.functions.php';
include_once $include_prefix . 'lib/game.functions.php';
include_once $include_prefix . 'lib/standings.functions.php';
include_once $include_prefix . 'lib/pool.functions.php';
include_once $include_prefix . 'lib/configuration.functions.php';

if (version_compare(PHP_VERSION, '5.0.0', '>')) {
	include_once 'lib/twitter.functions.php';
}

include_once 'classes/Game.php';

$html = "";
$html2 = "";
$gameId = intval($_GET["game"]);
$game = new Game(GetDatabase(), $gameId);
$seasoninfo = SeasonInfo($game->getSeason());

$LAYOUT_ID = ADDRESULT;
$title = _("Result");

//process itself if save button was pressed
if (!empty($_POST['save'])) {
	$home = intval($_POST['home']);
	$away = intval($_POST['away']);
	$ok = $game->setResult($home, $away);
	if ($ok) {
		$html2 .= "<p>" . sprintf(_("Final result saved: %s - %s."), $home, $away) . " ";
		if ($home > $away) {
			$html2 .=  sprintf(_("Winner is <span style='font-weight:bold'>%s</span>."), TeamName($game->getHomeTeam()));
		} elseif ($away > $home) {
			$html2 .=  sprintf(_("Winner is <span style='font-weight:bold'>%s</span>."), TeamName($game->getVisitorTeam()));
		}
		$html2 .= "</p>";
	}
} elseif (isset($_POST['update'])) {
	$home = intval($_POST['home']);
	$away = intval($_POST['away']);
	$ok = $game->updateResult($home, $away);
	$html2 .= "<p>" . sprintf(_("Game ongoing. Current score: %s - %s."), $home, $away) . "</p>";
} elseif (isset($_POST['clear'])) {
	$ok = $game->clearResult();
	if ($ok) {
		$html2 .= "<p>" . _("Game reset") . ".</p>";
	}
}

//common page
pageTopHeadOpen($title);
include_once 'script/disable_enter.js.inc';
pageTopHeadClose($title);
leftMenu($LAYOUT_ID);
contentStart();
//content
$menutabs[_("Result")] = "?view=user/addresult&game=$gameId";
$menutabs[_("Players")] = "?view=user/addplayerlists&game=$gameId";
$menutabs[_("Score sheet")] = "?view=user/addscoresheet&game=$gameId";
if ($seasoninfo['spiritmode'] > 0 && isSeasonAdmin($seasoninfo['season_id'])) {
	$menutabs[_("Spirit points")] = "?view=user/addspirit&game=$gameId";
}
if (ShowDefenseStats()) {
	$menutabs[_("Defense sheet")] = "?view=user/adddefensesheet&game=$gameId";
}


pageMenu($menutabs);

$html .= "<form  method='post' action='?view=user/addresult&amp;game=" . $gameId . "'>
<table cellpadding='2'>
<tr><td><b>" . TeamName($game->getHomeTeam()) . "</b></td><td><b> - </b></td><td><b>" . TeamName($game->getVisitorTeam()) . "</b></td></tr>";

$html .= "<tr><td>";
if ($game->isOngoing())
	$html .= _("Game is running.");
else if ($game->hasStarted())
	$html .= _("Game is finished.");
$html .= "<tr><td>";

$html .= "<tr>
<td><input class='input' name='home' value='" . $game->getHomeScore() . "' maxlength='4' size='5'/></td>
<td> - </td>
<td><input class='input' name='away' value='" . $game->getVisitorScore() . "' maxlength='4' size='5'/></td></tr>
</table>";

if (TeamInfo($game->getHomeTeam())['valid'] == 2) {
	$poolInfo = PoolInfo($game->getPool());
	$html .= "<p>" . "The home team is the BYE team. You should use the suggested result: " . $poolInfo['forfeitagainst'] . " - " . $poolInfo['forfeitscore'] . "</p>";
} elseif (TeamInfo($game->getVisitorTeam())['valid'] == 2) {
	$poolInfo = PoolInfo($game->getPool());
	$html .= "<p>" . "The visitor team is the BYE team. You should use the suggested result: " . $poolInfo['forfeitscore'] . " - " . $poolInfo['forfeitagainst'] . "</p>";
}

$html .= "<p>" . _("If game ongoing, update as current result: ") . "    
	<input class='button' type='submit' name='update' value='" . _("update") . "'/></p>";

$html .= "<p>" . _("If this is all wrong, clear the result: ") . "    
	<input class='button' type='submit' name='clear' value='" . _("Clear") . "'/></p>";

$html .= $html2;

$html .= "<p>    
		<input class='button' type='submit' name='save' value='" . _("Save as final result") . "'/>
	</p></form>";


echo $html;

//common end
contentEnd();
pageEnd();
