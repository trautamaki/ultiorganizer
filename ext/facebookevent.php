<?php
while (ob_get_level()) {
	ob_end_clean();
}
header('Connection: close');
ignore_user_abort();
ob_start();
echo ('Connection Closed');
$size = ob_get_length();
header("Content-Length: $size");
ob_end_flush();
flush();

include '../lib/database.php';

include_once $include_prefix . 'localization.php';
include_once $include_prefix . 'lib/user.functions.php';
include_once $include_prefix . 'lib/common.functions.php';
include_once $include_prefix . 'lib/facebook.functions.php';
include_once $include_prefix . 'lib/game.functions.php';
include_once $include_prefix . 'lib/configuration.functions.php';

include_once 'classes/Game.php';

if (IsFacebookEnabled() && !empty($_GET['game']) && !empty($_GET['event'])) {
	$game = new Game(GetDatabase(), $_GET['game']);
	if ($_GET['event'] == "game" && ($game->hasStarted())
			&& ($game->isOngoing() == 0)) {
		if ($game->getHomeScore() >= $game->getVisitorScore()) { // FIXME handle draws
			$wonTeamId = $game->getHomeTeam();
			$wonTeamName = TeamName($game->getHomeTeam());
			$wonTeamScore = $game->getHomeScore();
			$lostTeamId = $game->getVisitorTeam();
			$lostTeamName = TeamName($game->getVisitorTeam());
			$lostTeamScore = $game->getVisitorScore();
		} else {
			$lostTeamId = $game->getHomeTeam();
			$lostTeamName = TeamName($game->getHomeTeam());
			$lostTeamScore = $game->getHomeScore();
			$wonTeamId = $game->getVisitorTeam();;
			$wonTeamName = TeamName($game->getVisitorTeam());
			$wonTeamScore = $game->getVisitorScore();
		}
		$users = GetGameFacebookUsers($wonTeamId, "won");
		$wonTeamPlayers = TeamPlayerAccreditationArray($wonTeamId);
		foreach ($users as $user) {
			$fb_props = getFacebookUserProperties($user);
			foreach ($fb_props['facebookplayer'] as $accrId => $conf) {
				if (isset($wonTeamPlayers[$accrId])) {
					$message = str_replace(
						array('$teamscore', '$team', '$opponentscore', '$opponent'),
						array($wonTeamScore, $wonTeamName, $lostTeamScore, $lostTeamName),
						$conf['wonmessage']
					);
					$params = array(
						"link" => GetUrlBase() . "?view=gameplay&game=" . $game->getId(),
						"message" => $message,
						"name" => $title
					);
					FacebookFeedPost($fb_props, $params);
				}
			}
		}
		$users = GetGameFacebookUsers($lostTeamId, "lost");
		$lostTeamPlayers = TeamPlayerAccreditationArray($lostTeamId);
		foreach ($users as $user) {
			$fb_props = getFacebookUserProperties($user);
			foreach ($fb_props['facebookplayer'] as $accrId => $conf) {
				if (isset($lostTeamPlayers[$accrId])) {
					$message = str_replace(
						array('$teamscore', '$team', '$opponentscore', '$opponent'),
						array($lostTeamScore, $lostTeamName, $wonTeamScore, $wonTeamName),
						$conf['lostmessage']
					);
					$params = array(
						"link" => GetUrlBase() . "?view=gameplay&game=" . $game->getId(),
						"message" => $message,
						"name" => $title
					);
					FacebookFeedPost($fb_props, $params);
				}
			}
		}
		// Post to app feed
		global $serverConf;
		$message = str_replace(
			array('$pool', '$winner', '$loser', '$winnerscore', '$loserscore'),
			array(PoolName($game->getPool()), $wonTeamName, $lostTeamName, $wonTeamScore, $lostTeamScore),
			$serverConf['FacebookGameMessage']
		);
		if (
			isset($serverConf['FacebookUpdatePage']) && (strlen($serverConf['FacebookUpdatePage']) > 0)
			&& isset($serverConf['FacebookUpdateToken']) && (strlen($serverConf['FacebookUpdateToken']))
		) {
			$params = array(
				"link" => GetUrlBase() . "?view=gameplay&game=" . $game->getId(),
				"message" => $message,
				"name" => $title
			);
			$app_fb = array("facebooktoken" => $serverConf['FacebookUpdateToken'], "facebookuid" => $serverConf['FacebookUpdatePage']);
			FacebookFeedPost($app_fb, $params);
		}
	} elseif ($_GET['event'] == "goal" && ($game->isOngoing() == 1) && isset($_GET['num'])) {
		$goalInfo = $game->getGoalInfo($_GET['num']);
		if ($goalInfo) {
			if ($goalInfo['ishomegoal'] == 1) {
				$team = TeamName($game->getHomeTeam());
				$opponent = TeamName($game->getVisitorTeam());
				$teamscore = $goalInfo['homescore'];
				$opponentscore = $goalInfo['visitorscore'];
			} else {
				$opponent = TeamName($game->getHomeTeam());
				$team = TeamName($game->getVisitorTeam());
				$opponentscore = $goalInfo['homescore'];
				$teamscore = $goalInfo['visitorscore'];
			}
		}
		$passerName = $goalInfo['assistfirstname'] . " " . $goalInfo['assistlastname'];
		$scorerName = $goalInfo['scorerfirstname'] . " " . $goalInfo['scorerlastname'];
		$passer = $goalInfo['assist_accrid'];
		$scorer = $goalInfo['scorer_accrid'];
		$users = GetScoreFacebookUsers($passer, $scorer);
		if (isset($users[$passer])) {
			$fb_props = getFacebookUserProperties($users[$passer]);
			$message = str_replace(
				array('$teamscore', '$team', '$opponentscore', '$opponent', '$passername', '$scorername'),
				array($teamscore, $team, $opponentscore, $opponent, $passerName, $scorerName),
				$fb_props['facebookplayer'][$passer]['passedmessage']
			);
			$params = array(
				"link" => GetUrlBase() . "?view=gameplay&game=" . $game->getId(),
				"message" => $message,
				"name" => $title
			);
			FacebookFeedPost($fb_props, $params);
		}
		if (isset($users[$scorer])) {
			$fb_props = getFacebookUserProperties($users[$scorer]);
			$message = str_replace(
				array('$teamscore', '$team', '$opponentscore', '$opponent', '$passername', '$scorername'),
				array($teamscore, $team, $opponentscore, $opponent, $passerName, $scorerName),
				$fb_props['facebookplayer'][$scorer]['scoredmessage']
			);
			$params = array(
				"link" => GetUrlBase() . "?view=gameplay&game=" . $game->getId(),
				"message" => $message,
				"name" => $title
			);
			FacebookFeedPost($fb_props, $params);
		}
	}
}
