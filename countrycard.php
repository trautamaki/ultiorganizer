<?php
include_once 'lib/team.functions.php';
include_once 'lib/country.functions.php';

$countryId = intval(iget("country"));
$profile = CountryInfo($countryId);
$smarty->assign("profile", $profile);

$title = utf8entities(_($profile['name']));
$smarty->assign("title", $title);

$season = CurrentSeason();
if (!empty($season)) {
  $teams = CountryTeams($countryId, $season);
  $smarty->assign("current_season_teams", $teams);
}
$smarty->assign("season", $season);
$smarty->assign("is_stats_data_available", IsStatsDataAvailable());
$smarty->assign("current_season_name", CurrentSeasonName());

$club_array = array();
$national_array = array();
$teams = CountryTeams($countryId);
if (count($teams)) {
  foreach ($teams as $team) {
    // Do not list club ids here
    if ($team['club'] > 0) {
      $club_array[] = $team;
    } else {
      $national_array[] = $team;
    }
  }
}
$smarty->assign("club_teams", $club_array);
$smarty->assign("national_teams", $national_array);
