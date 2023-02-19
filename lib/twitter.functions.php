<?php
include_once $include_prefix . 'lib/configuration.functions.php';
include_once $include_prefix . 'lib/twitteroauth/twitteroauth.php';
include_once $include_prefix . 'lib/game.functions.php';
include_once $include_prefix . 'lib/player.functions.php';

include_once $include_prefix . 'classes/Game.php';

function TweetGameResult($gameId)
{

	if (!IsTwitterEnabled()) {
		return;
	}

	if (!isset($_SESSION['TwitterConsumerKey'])) {
		$twitterconf = GetTwitterConf();
		$_SESSION['TwitterConsumerKey'] = $twitterconf['TwitterConsumerKey'];
		$_SESSION['TwitterConsumerSecret'] = $twitterconf['TwitterConsumerSecret'];
		$_SESSION['TwitterOAuthCallback'] = $twitterconf['TwitterOAuthCallback'];
	}

	$game = new Game(GetDatabase(), $gameId);

	$text = SeriesName($game->getSeries()) . ", " . PoolName($game->getPool()) . ": ";
	$text .= TeamName($game->getHomeTeam()) . " - " . TeamName($game->getVisitorTeam());
	$text .= " " . intval($game->getHomeScore()) . " - " . intval($game->getVisitorScore());
	$text = TweetTextCheck($text);

	$purpose = "season results";
	$key = GetTwitterKey($game->getSeason(), $purpose);

	if ($key) {
		$twitter = new TwitterOAuth($_SESSION['TwitterConsumerKey'], $_SESSION['TwitterConsumerSecret'], $key['keystring'], $key['secrets']);
		$twitter->post('statuses/update', array(
			'status' => $text,
			'in_reply_to_status_id' => $gameId
		));
	}

	$purpose = "series results";
	$key = GetTwitterKey($game->getSeries(), $purpose);
	if ($key) {
		$twitter = new TwitterOAuth($_SESSION['TwitterConsumerKey'], $_SESSION['TwitterConsumerSecret'], $key['keystring'], $key['secrets']);
		$twitter->post('statuses/update', array('status' => $text, 'in_reply_to_status_id' => $gameId));
	}
}

function TweetText($gameId, $text)
{

	if (!IsTwitterEnabled()) {
		return;
	}

	if (!isset($_SESSION['TwitterConsumerKey'])) {
		$twitterconf = GetTwitterConf();
		$_SESSION['TwitterConsumerKey'] = $twitterconf['TwitterConsumerKey'];
		$_SESSION['TwitterConsumerSecret'] = $twitterconf['TwitterConsumerSecret'];
		$_SESSION['TwitterOAuthCallback'] = $twitterconf['TwitterOAuthCallback'];
	}

	$game = new Game(GetDatabase(), $gameId);

	$text = TweetTextCheck($text);

	$purpose = "series results";
	$key = GetTwitterKey($game->getSeries(), $purpose);
	if ($key) {
		$twitter = new TwitterOAuth($_SESSION['TwitterConsumerKey'], $_SESSION['TwitterConsumerSecret'], $key['keystring'], $key['secrets']);
		$twitter->post('statuses/update', array('status' => $text, 'in_reply_to_status_id' => $gameId));
	}
}

function TweetGameScores($gameId)
{
	if (!IsTwitterEnabled()) {
		return;
	}

	$game = new Game(GetDatabase(), $gameId);

	if (!isset($_SESSION['TwitterConsumerKey'])) {
		$twitterconf = GetTwitterConf();
		$_SESSION['TwitterConsumerKey'] = $twitterconf['TwitterConsumerKey'];
		$_SESSION['TwitterConsumerSecret'] = $twitterconf['TwitterConsumerSecret'];
		$_SESSION['TwitterOAuthCallback'] = $twitterconf['TwitterOAuthCallback'];
	}

	$game = new Game(GetDatabase(), $gameId);
	$lastscore = $game->getLastGoal();
	$text = SeriesName($game->getSeries()) . ", " . PoolName($game->getPool()) . ": ";
	$text .= TeamName($game->getHomeTeam()) . " - " . TeamName($game->getVisitorTeam());
	$text .= ". " . _("Last score") . ": ";

	if (!empty($lastscore['time'])) {
		$text .= $lastscore['homescore'] . " - " . $lastscore['visitorscore'];
		$text .= " [" . SecToMin($lastscore['time']) . "]";
		if (intval($lastscore['iscallahan'])) {
			$lastpass = "xx";
		} else {
			$lastpass = $lastscore['assistfirstname'] . " " . $lastscore['assistlastname'];
		}
		$lastgoal = $lastscore['scorerfirstname'] . " " . $lastscore['scorerlastname'];
		if (!empty($lastpass) || !empty($lastgoal)) {
			$text .= " " . $lastpass . " --> " . $lastgoal;
		}
	}

	$text = TweetTextCheck($text);

	$purpose = "series results";
	$key = GetTwitterKey($game->getSeries(), $purpose);
	if ($key) {
		$twitter = new TwitterOAuth($_SESSION['TwitterConsumerKey'], $_SESSION['TwitterConsumerSecret'], $key['keystring'], $key['secrets']);
		$twitter->post('statuses/update', array('status' => $text, 'in_reply_to_status_id' => $gameId));
	}
}

function TweetTextCheck($text)
{
	//$text = utf8_encode($text);
	return substr($text, 0, 140);
}
