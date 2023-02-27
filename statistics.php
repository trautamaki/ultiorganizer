<?php
include_once 'lib/season.functions.php';
include_once 'lib/team.functions.php';
include_once 'lib/statistical.functions.php';

$title = _("Statistics");
$smarty->assign("title", $title);

$list = "teamstandings";
if (iget("list")) {
  $list = iget("list");
}
$smarty->assign("list", $list);

// Content
$menutabs[_("Events' Standings")] = "?view=statistics&list=teamstandings";
$menutabs[_("Events' Scoreboards")] = "?view=statistics&list=playerscoreboard";
$menutabs[_("Alltime Scoreboards")] = "?view=statistics&list=playerscoresall";
$smarty->assign("menu_tabs", $menutabs);

$seasontypes = SeasonTypes();
$serietypes = SeriesTypes();
if ($list == "teamstandings" || $list == "playerscoreboard") {
  $countall = 0;

  $display_season_types;
  $display_series_types_per_season_type;
  $seasons_by_type;
  $standings_stats_by_type;
  $scores_by_type;

  foreach ($seasontypes as $seasontype) {
    $seasons = SeasonsByType($seasontype);
    if (count($seasons) < 1) {
      continue;
    }
    $display_season_types[] = $seasontype;
    $seasons_by_type[$seasontype]['seasons'] = $seasons;

    foreach ($serietypes as $seriestype) {
      if ($list == "teamstandings") {
        $serstats = SeriesStatisticsByType($seriestype, $seasontype);
        if (count($serstats) < 1) {
          continue;
        }
      }

      $add_serie = false;
      foreach ($seasons as $season) {
        if ($list == "teamstandings") {
          $standings = TeamStandings($season['season_id'], $seriestype);
          if (!count($standings)) {
            continue;
          }
          $add_serie = true;
          $standings_per_season_by_type[$season['season_id']][$seriestype] = $standings;
          ++$countall;
        } elseif ($list == "playerscoreboard") {
          $scores = AlltimeScoreboard($season['season_id'], $seriestype);
          if (!count($scores)) {
            continue;
          }
          $add_serie = true;
          $scores_per_season_by_type[$season['season_id']][$seriestype] = $scores;
        }
      }
      if ($add_serie) {
        $display_series_types_per_season_type[] = $seriestype;
      }
    }
  }
  $smarty->assign("season_types", $display_season_types);
  $smarty->assign("serie_types", $display_series_types_per_season_type);
  $smarty->assign("seasons_by_type", $seasons_by_type);
  $smarty->assign("standings_per_season_by_type", $standings_per_season_by_type);
  $smarty->assign("scores_per_season_by_type", $scores_per_season_by_type);
  $smarty->assign("countall", $countall);
} elseif ($list == "playerscoresall") {
  $scores_all = ScoreboardAllTime(100);

  $i = 1;
  foreach ($scores_all as $key => $row) {
    $scores_all[$key]['i'] = $i++;
    $scores_all[$key]['last_series_name'] = SeriesSeasonName($row['last_series']);
    $scores_all[$key]['last_team_name'] = TeamName($row['last_team']);
  }
  $smarty->assign("scores_all", $scores_all);

  $scores_by_seasontype_by_serietype;
  $display_series_types;
  $display_season_types;
  foreach ($seasontypes as $seasontype) {
    $display_season_type = false;
    $seasons = SeasonsByType($seasontype);
    if (count($seasons) < 1) {
      continue;
    }

    foreach ($serietypes as $seriestype) {
      $serstats = SeriesStatisticsByType($seriestype, $seasontype);
      if (count($serstats) < 1) {
        continue;
      }
      $display_series_types[$seasontype][] = $seriestype;

      $scores = ScoreboardAllTime(30, $seasontype, $seriestype);
      $i = 1;
      foreach ($scores as $key => $row) {
        $display_season_type = true;
        $scores_by_seasontype_by_serietype[$seasontype][$seriestype][$key]['i'] = $i++;
        $scores_by_seasontype_by_serietype[$seasontype][$seriestype][$key]['firstname'] = $row['firstname'];
        $scores_by_seasontype_by_serietype[$seasontype][$seriestype][$key]['lastname'] = $row['lastname'];
        $scores_by_seasontype_by_serietype[$seasontype][$seriestype][$key]['gamestotal'] = $row['gamestotal'];
        $scores_by_seasontype_by_serietype[$seasontype][$seriestype][$key]['goalstotal'] = $row['goalstotal'];
        $scores_by_seasontype_by_serietype[$seasontype][$seriestype][$key]['passestotal'] = $row['passestotal'];
        $scores_by_seasontype_by_serietype[$seasontype][$seriestype][$key]['total'] = $row['total'];
        $scores_by_seasontype_by_serietype[$seasontype][$seriestype][$key]['last_series_name'] = SeriesSeasonName($row['last_series']);
        $scores_by_seasontype_by_serietype[$seasontype][$seriestype][$key]['last_team_name'] = TeamName($row['last_team']);
      }
    }
    if ($display_season_type) {
      $display_season_types[] = $seasontype;
    }
  }
  $smarty->assign("season_types", $display_season_types);
  $smarty->assign("series_types", $display_series_types);
  $smarty->assign("scores_by_seasontype_by_serietype", $scores_by_seasontype_by_serietype);
}
