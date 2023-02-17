<?php
ob_start();
?>
<!--
[CLASSIFICATION]
category=database
type=import
format=csv
security=superadmin
customization=SLKL

[DESCRIPTION]
title = "Import CSV data exported from legacy Microsoft Access database."
description = "Reads data from CSV and writes it into ultiorganizer database."
-->
<?php
ob_end_clean();
if (!isSuperAdmin()) {
	die('Insufficient user rights');
}

include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';

$html = "";
$title = ("Import data from CSV file");

if (isset($_POST['import'])) {

	$utf8 = !empty($_POST['utf8']);
	$table_type = $_POST['table_type'];
	$separator = $_POST['separator'];



	if (is_uploaded_file($_FILES['file']['tmp_name'])) {
		$row = 1;
		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 0, $separator)) !== FALSE) {

				if ($table_type == "team") {
					$team = $utf8 ? trim($data[0]) : utf8_encode(trim($data[0]));
					$class = $utf8 ? trim($data[1]) : utf8_encode(trim($data[1]));
					$name = $utf8 ? trim($data[2]) : utf8_encode(trim($data[2]));
					$points = $utf8 ? trim($data[3]) : utf8_encode(trim($data[3]));
					$division = $utf8 ? trim($data[4]) : utf8_encode(trim($data[4]));
					$contactperson  = $utf8 ? trim($data[5]) : utf8_encode(trim($data[5]));
					$clubname = $utf8 ? trim($data[6]) : utf8_encode(trim($data[6]));
					$extra = $utf8 ? trim($data[7]) : utf8_encode(trim($data[7]));
					$rank = $utf8 ? trim($data[8]) : utf8_encode(trim($data[8]));
					$it_level = $utf8 ? trim($data[9]) : utf8_encode(trim($data[9]));
					$activerank = $utf8 ? trim($data[10]) : utf8_encode(trim($data[10]));
					$valid = $utf8 ? trim($data[11]) : utf8_encode(trim($data[11]));

					if (!intval($team)) {
						//$html .= "<p>Not team $team</p>";
						continue;
					}
					$teaminfo = TeamInfo($team);
					if ($teaminfo) {
						//$html .= "<p>Already exist $team</p>";
						continue;
					}

					$html .= "<p>New $name</p>";
				} elseif ($table_type == "division") {

					$divisionId = $utf8 ? trim($data[0]) : utf8_encode(trim($data[0]));
					$name = $utf8 ? trim($data[1]) : utf8_encode(trim($data[1]));
					$seasonId = $utf8 ? trim($data[2]) : utf8_encode(trim($data[2]));
					$classes = $utf8 ? trim($data[3]) : utf8_encode(trim($data[3]));
					$showteams = $utf8 ? trim($data[4]) : utf8_encode(trim($data[4]));
					$continuation  = $utf8 ? trim($data[5]) : utf8_encode(trim($data[5]));
					$initial = $utf8 ? trim($data[6]) : utf8_encode(trim($data[6]));
					$teams = $utf8 ? trim($data[7]) : utf8_encode(trim($data[7]));
					$mvgames = $utf8 ? trim($data[8]) : utf8_encode(trim($data[8]));
					$timeouts = $utf8 ? trim($data[9]) : utf8_encode(trim($data[9]));
					$halftime = $utf8 ? trim($data[10]) : utf8_encode(trim($data[10]));
					$gameto = $utf8 ? trim($data[11]) : utf8_encode(trim($data[11]));
					$timecap = $utf8 ? trim($data[12]) : utf8_encode(trim($data[12]));
					$pointcap = $utf8 ? trim($data[13]) : utf8_encode(trim($data[13]));
					$showserstat = $utf8 ? trim($data[14]) : utf8_encode(trim($data[14]));
					$type = $utf8 ? trim($data[15]) : utf8_encode(trim($data[15]));
					if (!intval($divisionId)) {
						continue;
					}

					$cutpos = strpos($name, ' ');
					$division_type = substr($name, 0, $cutpos);
					$division_name = substr($name, $cutpos);



					$series = SeasonSeries($seasonId);
					$found = false;
					foreach ($series as $ser) {

						if ($ser['type'] == $type) {
							$pools = SeriesPools($ser['series_id']);
							foreach ($pools as $pool) {
								// $html .= "<p>comp: $seasonId x ". $ser['name'] ." ".$pool['name']."</p>";
								if ($pool['name'] == $name) {
									//$html .= "<p>old: $seasonId x $division_type x $name</p>";
									$found = true;
									break;
								}
							}
							break;
						}
					}

					if ($found) {
						continue;
					}
					$html .= "<p>new: $seasonId x $type x $name</p>";
					if ($division_name) {
						continue;
					}

					$html .= "<p>New $name</p>";
				} elseif ($table_type == "game") {

					$gameId = $utf8 ? trim($data[0]) : utf8_encode(trim($data[0]));
					$hometeam = $utf8 ? trim($data[1]) : utf8_encode(trim($data[1]));
					$awayteam = $utf8 ? trim($data[2]) : utf8_encode(trim($data[2]));
					$homescores = $utf8 ? trim($data[3]) : utf8_encode(trim($data[3]));
					$awayscores = $utf8 ? trim($data[4]) : utf8_encode(trim($data[4]));
					$place  = $utf8 ? trim($data[5]) : utf8_encode(trim($data[5]));
					$time = $utf8 ? trim($data[6]) : utf8_encode(trim($data[6]));
					$division = $utf8 ? trim($data[7]) : utf8_encode(trim($data[7]));
					$valid = $utf8 ? trim($data[8]) : utf8_encode(trim($data[8]));
					$halftime = $utf8 ? trim($data[9]) : utf8_encode(trim($data[9]));
					$officials = $utf8 ? trim($data[10]) : utf8_encode(trim($data[10]));
					$respteam = $utf8 ? trim($data[11]) : utf8_encode(trim($data[11]));
					$resppers = $utf8 ? trim($data[12]) : utf8_encode(trim($data[12]));

					if (!intval($gameId)) {
						continue;
					}

					$game_result = GameInfo($gameId);
					if ($game_result) {
						//$html .= "<p>Already exist $team</p>";
						continue;
					}

					$home = TeamInfo($hometeam);
					$away = TeamInfo($awayteam);


					$query = sprintf(
						"INSERT INTO uo_game
        			(game_id, hometeam, visitorteam, homescore, visitorscore, reservation, time, pool, valid, respteam) 
        			VALUES ('%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
						mysql_real_escape_string($gameId),
						mysql_real_escape_string($hometeam),
						mysql_real_escape_string($awayteam),
						mysql_real_escape_string($homescores),
						mysql_real_escape_string($awayscores),
						mysql_real_escape_string($place),
						mysql_real_escape_string($time),
						mysql_real_escape_string($division),
						1,
						mysql_real_escape_string($respteam)
					); //FIXME update hasstarted?
					//$html .= "<p>$query</p>";
					DBQuery($query);
				} elseif ($table_type == "goal") {

					$gameId = $utf8 ? trim($data[0]) : utf8_encode(trim($data[0]));
					$i = $utf8 ? trim($data[1]) : utf8_encode(trim($data[1]));
					$pass = $utf8 ? trim($data[2]) : utf8_encode(trim($data[2]));
					$goal = $utf8 ? trim($data[3]) : utf8_encode(trim($data[3]));
					$time = $utf8 ? trim($data[4]) : utf8_encode(trim($data[4]));
					$home  = $utf8 ? trim($data[5]) : utf8_encode(trim($data[5]));
					$away = $utf8 ? trim($data[6]) : utf8_encode(trim($data[6]));
					$homegoal = $utf8 ? trim($data[7]) : utf8_encode(trim($data[7]));

					if (!intval($gameId)) {
						continue;
					}

					$query = sprintf(
						" SELECT *	FROM uo_goal WHERE game='%s' AND num='%s'",
						mysql_real_escape_string($gameId),
						mysql_real_escape_string($i)
					);

					$exist = DBQueryRowCount($query);
					if ($exist) {
						continue;
					}

					$query = sprintf(
						"INSERT INTO uo_goal
        			(game, num, assist, scorer, time, homescore, visitorscore, ishomegoal, iscallahan) 
        			VALUES ('%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
						mysql_real_escape_string($gameId),
						mysql_real_escape_string($i),
						mysql_real_escape_string($pass),
						mysql_real_escape_string($goal),
						mysql_real_escape_string($time),
						mysql_real_escape_string($home),
						mysql_real_escape_string($away),
						mysql_real_escape_string($homegoal),
						0
					);
					//$html .= "<p>$query</p>";
					DBQuery($query);
				} elseif ($table_type == "player") {

					$playerId = $utf8 ? trim($data[0]) : utf8_encode(trim($data[0]));
					$first = $utf8 ? trim($data[1]) : utf8_encode(trim($data[1]));
					$last = $utf8 ? trim($data[2]) : utf8_encode(trim($data[2]));
					$show = $utf8 ? trim($data[3]) : utf8_encode(trim($data[3]));
					$team = $utf8 ? trim($data[4]) : utf8_encode(trim($data[4]));
					$jersey  = $utf8 ? trim($data[5]) : utf8_encode(trim($data[5]));
					$info = $utf8 ? trim($data[6]) : utf8_encode(trim($data[6]));
					$pass = $utf8 ? trim($data[7]) : utf8_encode(trim($data[7]));
					$goal = $utf8 ? trim($data[8]) : utf8_encode(trim($data[8]));
					$accId = $utf8 ? trim($data[9]) : utf8_encode(trim($data[9]));
					$birth = $utf8 ? trim($data[10]) : utf8_encode(trim($data[10]));

					if (!intval($playerId)) {
						continue;
					}

					$playerinfo = PlayerInfo($playerId);
					if ($playerinfo) {
						continue;
					}

					$query = sprintf(
						"INSERT INTO uo_player
        			(player_id, firstname, lastname, team, num, accreditation_id, accredited, profile_id) 
        			VALUES ('%s','%s', '%s', '%s', '%s', '%s', '%s', '%s')",
						mysql_real_escape_string($playerId),
						mysql_real_escape_string($first),
						mysql_real_escape_string($last),
						mysql_real_escape_string($team),
						mysql_real_escape_string($jersey),
						mysql_real_escape_string($accId),
						mysql_real_escape_string(1),
						mysql_real_escape_string($accId)
					);
					//$html .= "<p>$query</p>";
					DBQuery($query);
				} elseif ($table_type == "played_player") {
					$playerId = $utf8 ? trim($data[0]) : utf8_encode(trim($data[0]));
					$gameId = $utf8 ? trim($data[1]) : utf8_encode(trim($data[1]));
					$jersey = $utf8 ? trim($data[2]) : utf8_encode(trim($data[2]));

					if (!intval($playerId)) {
						continue;
					}

					$query = sprintf(
						"SELECT * FROM uo_played WHERE player='%s' AND game='%s'",
						mysql_real_escape_string($playerId),
						mysql_real_escape_string($gameId)
					);

					$exist = DBQueryRowCount($query);
					if ($exist) {
						continue;
					}

					$query = sprintf(
						"INSERT INTO uo_played
        			(player, game, num, accredited) 
        			VALUES ('%s','%s', '%s', '%s')",
						mysql_real_escape_string($playerId),
						mysql_real_escape_string($gameId),
						mysql_real_escape_string($jersey),
						mysql_real_escape_string(1)
					);
					//$html .= "<p>$query</p>";
					DBQuery($query);
				}
			}
			fclose($handle);
			$html .= "<p>" . ("Data imported!") . "</p>";
		}
	} else {
		$html .= "<p>" . ("There was an error uploading the file, please try again!") . "</p>";
	}
}

//season selection
$html .= "<form method='post' enctype='multipart/form-data' action='?view=plugins/import_slkl_old_data'>\n";

$html .= "<p>Select table type: <select class='dropdown' name='table_type'>\n";
$html .= "<option class='dropdown' value='team'>Team</option>";
$html .= "<option class='dropdown' value='player'>Player</option>";
$html .= "<option class='dropdown' value='goal'>Goal</option>";
$html .= "<option class='dropdown' value='game'>Game</option>";
$html .= "<option class='dropdown' value='division'>Division</option>";
$html .= "<option class='dropdown' value='played_player'>Played player</option>";
$html .= "</select></p>\n";

$html .= "<p>" . ("CSV separator") . ": <input class='input' maxlength='1' size='1' name='separator' value=','/></p>\n";

$html .= "<p>" . ("Select file to import") . ":<br/>\n";
$html .= "<input class='input' type='file' size='50' name='file'/><br/>\n";
$html .= "<input class='input' type='checkbox' name='utf8' /> " . ("File in UTF-8 format") . "</p>";
$html .= "<p><input class='button' type='submit' name='import' value='" . ("Import") . "'/></p>";
$html .= "<div>";
$html .= "<input type='hidden' name='MAX_FILE_SIZE' value='50000000' />\n";
$html .= "</div>\n";
$html .= "</form>";

showPage($title, $html);
?>