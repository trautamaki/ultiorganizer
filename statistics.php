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
  <!-- TODO -->
  $html .= "<h1>" . _("All time scoreboard TOP 100") . "</h1>\n";
  $scores = ScoreboardAllTime(100);
  $html .= "<table border='1' width='100%'><tr>
				<th>#</th><th>" . _("Name") . "</th><th>" . _("Latest event / team") . "</th><th class='center'>" . _("Games") . "</th>
				<th class='center'>" . _("Passes") . "</th><th class='center'>" . _("Goals") . "</th><th class='center'>" . _("Total") . "</th></tr>\n";
  $i = 1;
  foreach ($scores as $row) {
    $html .= "<tr>\n";
    $html .= "<td>" . $i++ . ".</td>";
    $html .= "<td>";
    $html .= "<a href='?view=playercard&amp;profile=" . $row['profile_id'] . "'>";
    $html .= utf8entities($row['firstname'] . " " . $row['lastname']) . "</a>";
    $html .= "</td>";
    $html .= "<td>" . utf8entities(SeriesSeasonName($row['last_series'])) . " / " . utf8entities(TeamName($row['last_team'])) . "</td>";
    $html .= "<td class='center'>" . $row['gamestotal'] . "</td>";
    $html .= "<td class='center'>" . $row['goalstotal'] . "</td>";
    $html .= "<td class='center'>" . $row['passestotal'] . "</td>";
    $html .= "<td class='center'>" . $row['total'] . "</td>";
    $html .= "</tr>\n";
  }

  $html .= "</table>\n";

  $seasontypes = SeasonTypes();
  $serietypes = SeriesTypes();

  foreach ($seasontypes as $seasontype) {
    $seasons = SeasonsByType($seasontype);
    if (count($seasons) < 1) {
      continue;
    }
    $html .= "<h2>" . U_($seasontype) . "</h2>\n";

    foreach ($serietypes as $seriestype) {
      $serstats = SeriesStatisticsByType($seriestype, $seasontype);
      if (count($serstats) < 1) {
        continue;
      }
      $html .= "<h3>" . U_($seriestype) . "</h3>\n";

      $scores = ScoreboardAllTime(30, $seasontype, $seriestype);
      $html .= "<table border='1' width='100%'><tr>
						<th>#</th><th>" . _("Name") . "</th><th>" . _("Latest event / team") . "</th><th class='center'>" . _("Games") . "</th>
						<th class='center'>" . _("Passes") . "</th><th class='center'>" . _("Goals") . "</th><th class='center'>" . _("Total") . "</th></tr>\n";
      $i = 1;
      foreach ($scores as $row) {
        $html .= "<tr>\n";
        $html .= "<td>" . $i++ . ".</td>";
        $html .= "<td>";
        $html .= "<a href='?view=playercard&amp;player=" . $row['player_id'] . "'>";
        $html .= utf8entities($row['firstname'] . " " . $row['lastname']) . "</a>";
        $html .= "</td>";
        $html .= "<td>" . utf8entities(SeriesSeasonName($row['last_series'])) . " / " . utf8entities(TeamName($row['last_team'])) . "</td>";
        $html .= "<td class='center'>" . $row['gamestotal'] . "</td>";
        $html .= "<td class='center'>" . $row['goalstotal'] . "</td>";
        $html .= "<td class='center'>" . $row['passestotal'] . "</td>";
        $html .= "<td class='center'>" . $row['total'] . "</td>";
        $html .= "</tr>\n";
      }
      $html .= "</table>\n";
    }
  }
}
