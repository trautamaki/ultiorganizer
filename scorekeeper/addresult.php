<?php

$html = "";
$info = "";

$gameId = isset($_GET['game']) ? $_GET['game'] : $_SESSION['game'];
$_SESSION['game'] = $gameId;

if (isset($_POST['save'])) {
	$home = intval($_POST['home']);
	$away = intval($_POST['away']);
	$ok = GameSetResult($database, $gameId, $home, $away);
	if ($ok) {
		$game_result = GameResult($database, $gameId);
		$info = "<p>" . sprintf(_("Game result %s - %s saved!"), $home, $away) . "</p>";
	}
} elseif (isset($_POST['update'])) {
	$home = intval($_POST['home']);
	$away = intval($_POST['away']);
	$ok = GameUpdateResult($database, $gameId, $home, $away);
	$info = "<p>" . sprintf(_("Game result %s - %s updated!"), $home, $away) . "</p>";
}

$html .= "<div data-role='header'>\n";
$html .= "<h1>" . _("Result") . "</h1>\n";
$html .= "</div><!-- /header -->\n\n";

$html .= "<div data-role='content'>\n";

$result = GameResult($database, $gameId);

$html .= "<form action='?view=addresult' method='post' data-ajax='false'>\n";

$html .= "<label for='home'>" . utf8entities($result['hometeamname']) . ":</label>";

$html .= "<div class='ui-grid-b'>";
$html .= "<div class='ui-block-a'>\n";
$html .= "<input type='number' id='home' name='home' value='" . intval($result['homescore']) . "' maxlength='4' size='5'/>";
$html .= "</div>";
$html .= "<div class='ui-block-b'>\n";
$html .= "<a href='#' data-role='button' id='homeplus' data-icon='plus'>+1</a>";
$html .= "</div>";
$html .= "<div class='ui-block-c'>\n";
$html .= "<a href='#' data-role='button' id='homeminus' data-icon='minus'>-1</a>";
$html .= "</div>";
$html .= "</div>";

$html .= "<label for='away'>" . utf8entities($result['visitorteamname']) . ":</label>";
$html .= "<div class='ui-grid-b'>";
$html .= "<div class='ui-block-a'>\n";
$html .= "<input type='number' id='away' name='away' value='" . intval($result['visitorscore']) . "' maxlength='4' size='5'/>";
$html .= "</div>";
$html .= "<div class='ui-block-b'>\n";
$html .= "<a href='#' data-role='button' id='awayplus' data-icon='plus'>+1</a>";
$html .= "</div>";
$html .= "<div class='ui-block-c'>\n";
$html .= "<a href='#' data-role='button' id='awayminus' data-icon='minus'>-1</a>";
$html .= "</div>";
$html .= "</div>";

$html .= $info;

if (isset($_POST['save'])) {
	$html .= "<input type='submit' name='save'  data-ajax='false' value='" . _("Save again") . "'/>";
	$html .= "<a href='?view=addplayerlists&game=" . $gameId . "&team=" . $game_result['hometeam'] . "' data-role='button' data-ajax='false'>" . _("Fill Playerlists") . "</a>";
} else {
	$html .= "<input type='submit' name='update' data-ajax='false' value='" . _("Game ongoing, update scores") . "'/>";
	$html .= "<input type='submit' name='save' data-ajax='false' value='" . _("Save as final result") . "'/>";
}
$html .= "<a href='?view=respgames' data-role='button' data-ajax='false'>" . _("Back to game responsibilities") . "</a>";
$html .= "</form>";
$html .= "</div><!-- /content -->\n\n";

echo $html;

?>
<script type="text/javascript">
	$("#homeplus").bind("click", function(event, ui) {
		var goals = parseInt($('input[id=home]').val());
		if (isNaN(goals)) {
			goals = 0;
		}
		goals = goals + 1;
		$('input[id=home]').val(goals);
	});

	$("#homeminus").bind("click", function(event, ui) {
		var goals = parseInt($('input[id=home]').val());
		if (isNaN(goals)) {
			goals = 0;
		}
		goals = goals - 1;
		$('input[id=home]').val(goals);
	});
	$("#awayplus").bind("click", function(event, ui) {
		var goals = parseInt($('input[id=away]').val());
		if (isNaN(goals)) {
			goals = 0;
		}
		goals = goals + 1;
		$('input[id=away]').val(goals);
	});

	$("#awayminus").bind("click", function(event, ui) {
		var goals = parseInt($('input[id=away]').val());
		if (isNaN(goals)) {
			goals = 0;
		}
		goals = goals - 1;
		$('input[id=away]').val(goals);
	});
</script>