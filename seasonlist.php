<?php
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';

$title = _("Old events");
$smarty->assign("title", $title);
$smarty->assign("maxcols", 3);

$seasons = Seasons();
$seasons_array = array();
while ($season = GetDatabase()->FetchAssoc($seasons)) {
  if (!IsSeasonStatsCalculated($season['season_id'])) {
    continue;
  }

  $seasonName = SeasonName($season['season_id']);
  $series = SeasonSeries($season['season_id'], true);
  $season['season_name'] = $seasonName;
  $season['series'] = $series;
  $seasons_array[] = $season;
}
$smarty->assign("seasons", $seasons_array);
