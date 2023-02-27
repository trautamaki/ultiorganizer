<?php
include_once 'lib/team.functions.php';
include_once 'lib/club.functions.php';
include_once 'lib/country.functions.php';
include_once 'lib/url.functions.php';

$clubId = iget("club");
$smarty->assign("club_id", $clubId);
$profile = ClubInfo($clubId);
$smarty->assign("profile", $profile);

$title = _("Club Card") . ": " . utf8entities($profile['name']);
$smarty->assign("title", $title);

if ($profile['country'] > 0) {
  $country_info = CountryInfo($profile['country']);
  $smarty->assign("country_info", $country_info);
}

if (!empty($profile['contacts'])) {
  $contacts = utf8entities($profile['contacts']);
  $contacts = explode("\n", $contacts);
  $smarty->assign("contacts", $contacts);
}

if (!empty($profile['story'])) {
  $story = utf8entities($profile['story']);
  $story = explode("\n", $story);
  $smarty->assign("story", $story);
}

if (!empty($profile['achievements'])) {
  $achievements = utf8entities($profile['achievements']);
  $achievements = explode("\n", $achievements);
  $smarty->assign("achievements", $achievements);
}
$urls = GetUrlList("club", $clubId);
$smarty->assign("urls", $urls);

$media_urls = GetMediaUrlList("club", $clubId);
$smarty->assign("media_urls", $media_urls);

$smarty->assign("current_season_name", CurrentSeasonName());
$smarty->assign("is_stats_data_available", IsStatsDataAvailable());

$teams = ClubTeams($clubId, CurrentSeason());
$teams_array = array();
if (GetDatabase()->NumRows($teams)) {
  while ($team = GetDatabase()->FetchAssoc($teams)) {
    $team['season_name'] = SeasonName($team['season']);
    $teams_array[] = $team;
  }
}
$smarty->assign("teams", $teams_array);

$teams = ClubTeamsHistory($clubId);
$teams_history_array = array();
if (GetDatabase()->NumRows($teams)) {
  while ($team = GetDatabase()->FetchAssoc($teams)) {
    $team['season_name'] = SeasonName($team['season']);
    $teams_history_array[] = $team;
  }
}
$smarty->assign("teams_history", $teams_history_array);
