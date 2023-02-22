<?php
include_once $include_prefix . 'lib/season.functions.php';
include_once $include_prefix . 'lib/series.functions.php';
include_once $include_prefix . 'lib/pool.functions.php';
include_once $include_prefix . 'lib/statistical.functions.php';

$season = iget("season");
if (empty($season)) {
  $season = CurrentSeason();
}

$seasonInfo = SeasonInfo($season);
$smarty->assign("season_info",  $seasonInfo);

$list = iget("list");
if (empty($list)) {
  $list = "allteams";
}

$cols = 2;
if (!intval($seasonInfo['isnationalteams'])) {
  $cols++;
}
if (intval($seasonInfo['isinternational'])) {
  $cols++;
}
if ($list == "byseeding") {
  $cols++;
}
$smarty->assign("cols", $cols);

$menutabs[_("By division")] = "?view=teams&season=$season&list=allteams";
$menutabs[_("By pool")] = "?view=teams&season=$season&list=bypool";
$menutabs[_("By seeding")] = "?view=teams&season=$season&list=byseeding";
$menutabs[_("By result")] = "?view=teams&season=$season&list=bystandings";

$menu_str = "";
foreach ($menutabs as $name => $url) {
  $menu_str .= utf8entities($name);
  $menu_str .= " - ";
}

$smarty->assign("title",  _("Teams"));
$smarty->assign("menu_tabs",  $menutabs);
$smarty->assign("menu_length", strlen($menu_str));
$smarty->assign("menu_current", "");
$smarty->assign("server_request_uri", strlen($_SERVER["REQUEST_URI"]));
$smarty->assign("list_type", $list);

$series = SeasonSeries($season, true);
$teams_array = array();
$pools_array = array();
$teams_pool_array = array();
$playoff_pools = array();
$series_results = array();
$max_placements = 0;
foreach ($series as $serie) {
  $teams = SeriesTeams($serie['series_id'], $list == "byseeding");
  $teams_ranking = SeriesRanking($ser['series_id']);
  $pools = SeriesPools($serie['series_id'], true);
  $teams_array[$serie['series_id']] = $teams;
  $pools_array[$serie['series_id']] = $pools;

  $max_placements = max(count($teams), $max_placements);

  foreach ($pools as $pool) {
    $teams_pool = PoolTeams($pool['pool_id']);
    $teams_pool_array[$pool['pool_id']] = $teams_pool;

    if ($pool['type'] == 2) {
      $sub_pools = array();
      $sub_pools[] = $pool['pool_id'];
      $followers = PoolFollowersArray($pool['pool_id']);
      $sub_pools = array_merge($sub_pools, $followers);
      $playoff_pools[$pool['pool_id']] = implode(",", $sub_pools);
    }
  }

  $team_results = array();
  $teams_ranking  = SeriesRanking($serie['series_id']);
  foreach ($teams_ranking as $team) {
    if ($team) {
      $tmp = array();
      $tmp['flagfile'] = $team['flagfile'];
      $tmp['team_id'] = $team['team_id'];
      $tmp['name'] = $team['name'];
      $team_results[] = $tmp;
    } else {
      $team_results[] = "&nbsp;";
    }
  }
  $series_results[] = $team_results;
}

$smarty->assign("series", $series);
$smarty->assign("teams", $teams_array);
$smarty->assign("teams_pool", $teams_pool_array);
$smarty->assign("pools", $pools_array);
$smarty->assign("playoff_pools", $playoff_pools);
$smarty->assign("max_placements", $max_placements);
$smarty->assign("series_results", $series_results);

$smarty->assign("is_stat_data", $isstatdata = IsStatsDataAvailable());
