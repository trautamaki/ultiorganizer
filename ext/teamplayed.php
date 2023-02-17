<?php
include_once 'localization.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='fi' lang='fi'>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="-1" />
	<?php

	$style = iget("style");
	if (empty($style))
		$style = 'pelikone.css';

	echo "<link rel='stylesheet' href='$style' type='text/css' />";
	?>
	<title><?php echo _("Ultiorganizer"); ?></title>
</head>

<body>

	<?php
	include_once '../lib/team.functions.php';
	include_once '../lib/common.functions.php';
	include_once '../lib/timetable.functions.php';

	$teamId = intval(iget("team"));
	$season = iget("season");


	if ($teamId) {
		$games = TimetableGames($teamId, "team", "past", "tournaments");
		if (!GetDatabase()->NumRows($games)) {
			echo "\n<p>" . _("No games") . ".</p>\n";
		} else {
			echo ExtGameView($games);
		}
	}
	?>
</body>

</html>