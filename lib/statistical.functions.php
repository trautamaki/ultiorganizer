<?php
include_once $include_prefix . 'lib/season.functions.php';
include_once $include_prefix . 'lib/standings.functions.php';
include_once $include_prefix . 'lib/player.functions.php';
include_once $include_prefix . 'lib/series.functions.php';

function IsSeasonStatsCalculated($database, $season)
{
	$query = sprintf(
		"SELECT count(*) FROM uo_season_stats WHERE season='%s'",
		$database->RealEscapeString($season)
	);
	return $database->DBQueryToValue($query);
}

function IsStatsDataAvailable($database)
{
	return $database->DBQueryToValue("SELECT count(*) FROM uo_season_stats");
}

function SeriesStatistics($database, $season)
{
	$query = sprintf(
		"SELECT ss.*, ser.name AS seriesname FROM uo_series_stats ss 
		LEFT JOIN uo_series ser ON(ser.series_id=ss.series_id)
		WHERE ss.season='%s'
		ORDER BY ss.season, ss.series_id",
		$database->RealEscapeString($season)
	);
	return $database->DBQueryToArray($query);
}

function SeriesStatisticsByType($database, $seriestype, $seasontype)
{
	$query = sprintf(
		"SELECT ss.*, ser.name AS seriesname FROM uo_series_stats ss 
		LEFT JOIN uo_series ser ON(ser.series_id=ss.series_id)
		LEFT JOIN uo_season se ON(ss.season=se.season_id)
		WHERE ser.type='%s' AND se.type='%s'
		ORDER BY ss.season, ss.series_id",
		$database->RealEscapeString($seriestype),
		$database->RealEscapeString($seasontype)
	);
	return $database->DBQueryToArray($query);
}

function ALLSeriesStatistics($database)
{
	$query = sprintf("SELECT ss.*, ser.name AS seriesname, 
		ser.type AS seriestype, s.name AS seasonname, s.type AS seasontype 
		FROM uo_series_stats ss 
		LEFT JOIN uo_series ser ON(ser.series_id=ss.series_id)
		LEFT JOIN uo_season s ON(ser.season=s.season_id)
		ORDER BY ser.type, s.type, ss.series_id");
	return $database->DBQueryToArray($query);
}

function SeasonStatistics($database, $season)
{
	$query = sprintf(
		"SELECT ss.*, s.name AS seasonname, s.type AS seasontype 
		FROM uo_season_stats ss 
		LEFT JOIN uo_season s ON(s.season_id=ss.season)
		WHERE ss.season='%s'
		ORDER BY ss.season",
		$database->RealEscapeString($season)
	);
	return $database->DBQueryToRow($query);
}

function AllSeasonStatistics($database)
{
	$query = sprintf("SELECT ss.*, s.name AS seasonname, s.type AS seasontype 
		FROM uo_season_stats ss 
		LEFT JOIN uo_season s ON(s.season_id=ss.season)
		ORDER BY s.type, s.name");
	return $database->DBQueryToArray($query);
}

function SeasonTeamStatistics($database, $season)
{
	$query = sprintf(
		"SELECT ts.*, ser.name AS seriesname, t.name AS teamname,
		s.name AS seasonname, s.type AS seasontype, ser.type AS seriestype 
		FROM uo_team_stats ts 
		LEFT JOIN uo_series ser ON(ser.series_id=ts.series)
		LEFT JOIN uo_season s ON(s.season_id=ts.season)
		LEFT JOIN uo_team t ON(t.team_id=ts.team_id)
		WHERE ts.season='%s'
		ORDER BY ts.series,ts.standing",
		$database->RealEscapeString($season)
	);
	return $database->DBQueryToArray($query);
}

function TeamStatistics($database, $team)
{
	$query = sprintf(
		"SELECT ts.*, ser.name AS seriesname, t.name AS teamname,
		s.name AS seasonname, s.type AS seasontype, ser.type AS seriestype
		FROM uo_team_stats ts 
		LEFT JOIN uo_series ser ON(ser.series_id=ts.series)
		LEFT JOIN uo_season s ON(s.season_id=ts.season)
		LEFT JOIN uo_team t ON(t.team_id=ts.team_id)
		WHERE ts.team_id='%s'
		ORDER BY ts.series,ts.standing",
		$database->RealEscapeString($team)
	);
	return $database->DBQueryToArray($query);
}

function TeamStandings($database, $season, $seriestype)
{
	$query = sprintf(
		"SELECT ts.*, ser.name AS seriesname, t.name AS teamname,
		s.name AS seasonname, s.type AS seasontype, ser.type AS seriestype,
		t.country, c.flagfile
		FROM uo_team_stats ts 
		LEFT JOIN uo_series ser ON(ser.series_id=ts.series)
		LEFT JOIN uo_season s ON(s.season_id=ts.season)
		LEFT JOIN uo_team t ON(t.team_id=ts.team_id)
		LEFT JOIN uo_country c ON(t.country=c.country_id)
		WHERE ts.season='%s' AND ser.type='%s'
		ORDER BY ts.series,ts.standing",
		$database->RealEscapeString($season),
		$database->RealEscapeString($seriestype)
	);
	return $database->DBQueryToArray($query);
}

function TeamStatisticsByName($database, $teamname, $seriestype)
{
	$query = sprintf(
		"SELECT ts.*, ser.name AS seriesname, t.name AS teamname,
		s.name AS seasonname, s.type AS seasontype, ser.type AS seriestype
		FROM uo_team_stats ts 
		LEFT JOIN uo_series ser ON(ser.series_id=ts.series)
		LEFT JOIN uo_season s ON(s.season_id=ts.season)
		LEFT JOIN uo_team t ON(t.team_id=ts.team_id)
		WHERE t.name='%s' AND ser.type='%s'
		ORDER BY s.starttime DESC, ts.series,ts.standing",
		$database->RealEscapeString($teamname),
		$database->RealEscapeString($seriestype)
	);
	return $database->DBQueryToArray($query);
}

function PlayerStatistics($database, $profile_id)
{
	$query = sprintf(
		"SELECT ps.*, ser.name AS seriesname, t.name AS teamname,
		s.name AS seasonname, s.type AS seasontype, ser.type AS seriestype
		FROM uo_player_stats ps 
		LEFT JOIN uo_series ser ON(ser.series_id=ps.series)
		LEFT JOIN uo_season s ON(s.season_id=ps.season)
		LEFT JOIN uo_team t ON(t.team_id=ps.team)
		WHERE ps.profile_id='%s'
		ORDER BY s.starttime DESC, ps.season,ps.series",
		$database->RealEscapeString($profile_id)
	);
	return $database->DBQueryToArray($query);
}

function AlltimeScoreboard($database, $season, $seriestype)
{
	$query = sprintf(
		"SELECT ps.*, ser.name AS seriesname, t.name AS teamname,
		(COALESCE(ps.goals,0) + COALESCE(ps.passes,0)) AS total,
		p.firstname, p.lastname,
		s.name AS seasonname, s.type AS seasontype, ser.type AS seriestype
		FROM uo_player_stats ps 
		LEFT JOIN uo_series ser ON(ser.series_id=ps.series)
		LEFT JOIN uo_season s ON(s.season_id=ps.season)
		LEFT JOIN uo_team t ON(t.team_id=ps.team)
		LEFT JOIN uo_player p ON(p.player_id=ps.player_id)
		WHERE ps.season='%s' AND ser.type='%s'
		ORDER BY total DESC, ps.games ASC, lastname ASC LIMIT 5",
		$database->RealEscapeString($season),
		$database->RealEscapeString($seriestype)
	);
	return $database->DBQueryToArray($query);
}

function ScoreboardAllTime($database, $limit, $seasontype = "", $seriestype = "")
{

	$query = "SELECT ps.*, ser.name AS seriesname, t.name AS teamname,
			SUM(ps.goals) as goalstotal, SUM(passes) as passestotal,
			SUM(ps.games) as gamestotal, MAX(ser.series_id) as last_series,
			 MAX(t.team_id) as last_team,
			SUM(COALESCE(ps.goals,0) + COALESCE(ps.passes,0)) AS total,
			pp.firstname, pp.lastname,
			s.name AS seasonname, s.type AS seasontype, ser.type AS seriestype
			FROM uo_player_stats ps 
			LEFT JOIN uo_series ser ON(ser.series_id=ps.series)
			LEFT JOIN uo_season s ON(s.season_id=ps.season)
			LEFT JOIN uo_team t ON(t.team_id=ps.team)
			LEFT JOIN uo_player p ON(p.player_id=ps.player_id)
			LEFT JOIN uo_player_profile pp ON(pp.profile_id=ps.profile_id) ";

	if (!empty($seasontype) && !empty($seriestype)) {
		$query .= sprintf(
			"WHERE s.type='%s' AND ser.type='%s' ",
			$database->RealEscapeString($seasontype),
			$database->RealEscapeString($seriestype)
		);
	} elseif (!empty($seasontype)) {
		$query .= sprintf(
			"WHERE s.type='%s' ",
			$database->RealEscapeString($seasontype)
		);
	} elseif (!empty($seriestype)) {
		$query .= sprintf(
			"WHERE ser.type='%s' ",
			$database->RealEscapeString($seriestype)
		);
	}

	$query .= sprintf(
		"GROUP BY ps.profile_id 
			ORDER BY total DESC, ps.games ASC, lastname ASC 
			LIMIT %d",
		(int)$limit
	);

	return $database->DBQueryToArray($query);
}


function SetTeamSeasonStanding($database, $teamId, $standing)
{
	$teaminfo = TeamInfo($database, $teamId);
	if (isSeasonAdmin($teaminfo['season'])) {
		$query = sprintf(
			"UPDATE uo_team_stats SET
						standing='%d' 
						WHERE team_id='%d'",
			(int)($standing),
			(int)($teamId)
		);

		$database->DBQuery($query);
	} else {
		die('Insufficient rights to archive season');
	}
}


function CalcSeasonStats($database, $season)
{
	if (isSeasonAdmin($season)) {
		$season_info = SeasonInfo($database, $season);
		$teams = SeasonTeams($database, $season);
		$teams_total = count($teams);
		$allgames = SeasonAllGames($database, $season);
		$games_total = count($allgames);
		$goals_total = 0;
		$defenses_total = 0;
		$home_wins = 0;
		$home_draws = 0;
		$home_losses = 0;

		$players = SeasonAllPlayers($database, $season);
		$played_players = 0;
		foreach ($players as $player) {
			$playedgames = PlayerSeasonPlayedGames($database, $player['player_id'], $season_info['season_id']);
			if ($playedgames) {
				$played_players++;
			}
		}

		foreach ($allgames as $game_info) {
			$goals_total += $game_info['homescore'] + $game_info['visitorscore'];
			if ($game_info['homescore'] > $game_info['visitorscore']) {
				$home_wins++;
			} elseif ($game_info['homescore'] == $game_info['visitorscore']) {
				$home_draws++;
			} elseif ($game_info['homescore'] < $game_info['visitorscore']) {
				$home_losses++;
			}

			if (ShowDefenseStats()) {
				$defenses_total += $game_info['homedefenses'] + $game_info['visitordefenses'];
			}
		}
		//save season stats
		$query = sprintf(
			"INSERT IGNORE INTO uo_season_stats (season) VALUES ('%s')",
			$database->RealEscapeString($season)
		);

		$database->DBQuery($query);
		$defense_str = " ";
		if (ShowDefenseStats()) {
			$defense_str = ",defenses_total=$defenses_total ";
		}
		// FIXME update draws, losses
		$query = "UPDATE uo_season_stats SET
				teams=$teams_total, 
				games=$games_total, 
				goals_total=$goals_total, 
				home_wins=$home_wins, 
				players=$played_players" . $defense_str .
			"WHERE season='" . $season_info['season_id'] . "'";
		$database->DBQuery($query);
	} else {
		die('Insufficient rights to archive season');
	}
}

function CalcSeriesStats($database, $season)
{
	if (isSeasonAdmin($season)) {
		$season_info = SeasonInfo($database, $season);
		$series_info = SeasonSeries($database, $season);

		foreach ($series_info as $series) {

			$teams = SeriesTeams($database, $series['series_id']);
			$teams_total = count($teams);
			$allgames = SeriesAllGames($database, $series['series_id']);
			$games_total = count($allgames);
			$goals_total = 0;
			$home_wins = 0;
			$defenses_total = 0;

			$players = SeriesAllPlayers($database, $series['series_id']);
			$played_players = 0;
			foreach ($players as $player) {
				$playedgames = PlayerSeasonPlayedGames($database, $player['player_id'], $season_info['season_id']);
				if ($playedgames) {
					$played_players++;
				}
			}

			foreach ($allgames as $game) {
				$game_info = GameResult($database, $game['game']);
				$goals_total += $game_info['homescore'] + $game_info['visitorscore'];
				if ($game_info['homescore'] > $game_info['visitorscore']) {
					$home_wins++;
				}
				if (ShowDefenseStats()) {
					$defenses_total += $game_info['homedefenses'] + $game_info['visitordefenses'];
				}
			}
			//save season stats
			$query = sprintf(
				"INSERT IGNORE INTO uo_series_stats (series_id) VALUES ('%s')",
				$database->RealEscapeString($series['series_id'])
			);

			$database->DBQuery($query);
			$defense_str = " ";
			if (ShowDefenseStats()) {
				$defense_str = ",defenses_total=$defenses_total ";
			}
			$query = "UPDATE uo_series_stats SET
					season='" . $season_info['season_id'] . "',
					teams=$teams_total, 
					games=$games_total, 
					goals_total=$goals_total, 
					home_wins=$home_wins, 
					players=$played_players" . $defense_str .
				"WHERE series_id=" . $series['series_id'];
			$database->DBQuery($query);
		}
	} else {
		die('Insufficient rights to archive season');
	}
}

function CalcPlayerStats($database, $season)
{
	if (isSeasonAdmin($season)) {
		$season_info = SeasonInfo($database, $season);
		$players = SeasonAllPlayers($database, $season);

		foreach ($players as $player) {
			$player_info = PlayerInfo($database, $player['player_id']);
			$allgames = PlayerSeasonPlayedGames($database, $player['player_id'], $season_info['season_id']);

			if ($allgames) {
				$games = $allgames;
				$goals = PlayerSeasonGoals($database, $player['player_id'], $season_info['season_id']);
				$passes = PlayerSeasonPasses($database, $player['player_id'], $season_info['season_id']);
				$wins = PlayerSeasonWins($database, $player['player_id'], $player_info['team'], $season_info['season_id']);
				if (ShowDefenseStats()) {
					$defenses = PlayerSeasonDefenses($database, $player['player_id'], $season_info['season_id']);
				}
				$callahans = PlayerSeasonCallahanGoals($database, $player['player_id'], $season_info['season_id']);
				$breaks = 0;
				$offence_turns = 0;
				$defence_turns = 0;
				$offence_time = 0;
				$defence_time = 0;

				//save player stats
				$query = "INSERT IGNORE INTO uo_player_stats (player_id) VALUES (" . $player['player_id'] . ")";

				$database->DBQuery($query);
				$defense_str = " ";
				if (ShowDefenseStats()) {
					$defense_str = ",defenses=$defenses ";
				}
				$query = "UPDATE uo_player_stats SET
						profile_id=" . intval($player_info['profile_id']) . ", 
						team=" . $player_info['team'] . ", 
						season='" . $season_info['season_id'] . "', 
						series=" . $player_info['series'] . ", 
						games=$games, 
						wins=$wins,
						goals=$goals, 
						passes=$passes, 
						callahans=$callahans, 
						breaks=$breaks, 
						offence_turns=$offence_turns,
						defence_turns=$defence_turns,
						offence_time=$offence_time,
						defence_time=$defence_time" . $defense_str .
					"WHERE player_id=" . $player['player_id'];
				$database->DBQuery($query);
			}
		}
	} else {
		die('Insufficient rights to archive season');
	}
}

function CalcTeamStats($database, $season)
{
	if (isSeasonAdmin($season)) {
		$season_info = SeasonInfo($database, $season);
		$series_info = SeasonSeries($database, $season);

		foreach ($series_info as $series) {
			$teams = SeriesTeams($database, $series['series_id']);

			foreach ($teams as $team) {
				$team_info = TeamFullInfo($database, $team['team_id']);
				$goals_made = 0;
				$goals_against = 0;
				$wins = 0;
				$losses = 0;
				$defenses_total = 0;
				$standing = TeamSeriesStanding($database, $team['team_id']);
				$allgames = TeamGames($database, $team['team_id']);

				while ($game = $database->FetchAssoc($allgames)) {
					if (!is_null($game['homescore']) && !is_null($game['visitorscore'])) {

						if ($team['team_id'] == $game['hometeam']) {
							$goals_made += intval($game['homescore']);
							$goals_against += intval($game['visitorscore']);

							if (intval($game['homescore']) > intval($game['visitorscore'])) {
								$wins++;
							} else {
								$losses++;
							}
							if (ShowDefenseStats()) {
								$defenses_total += $game['homedefenses'];
							}
						} else {
							$goals_made += intval($game['visitorscore']);
							$goals_against += intval($game['homescore']);
							if (intval($game['homescore']) < intval($game['visitorscore'])) {
								$wins++;
							} elseif (intval($game['homescore']) > intval($game['visitorscore'])) {
								$losses++;
							}
							if (ShowDefenseStats()) {
								$defenses_total += $game['visitordefenses'];
							}
						}
					}
				}

				//save team stats
				$query = "INSERT IGNORE INTO uo_team_stats (team_id) VALUES (" . $team['team_id'] . ")";

				$database->DBQuery($query);
				$defense_str = " ";
				if (ShowDefenseStats()) {
					$defense_str = ",defenses_total=$defenses_total ";
				}
				$query = "UPDATE uo_team_stats SET
						season='" . $season_info['season_id'] . "', 
						series=" . $team_info['series'] . ", 
						goals_made=$goals_made, 
						goals_against=$goals_against, 
						standing=$standing, 
						wins=$wins, 
						losses=$losses" . $defense_str .
					"WHERE team_id=" . $team['team_id'];
				$database->DBQuery($query);
			}
		}
	} else {
		die('Insufficient rights to archive season');
	}
}
