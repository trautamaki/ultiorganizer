<?php
include_once 'lib/common.functions.php';
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/team.functions.php';
include_once 'lib/timetable.functions.php';

if (is_file('cust/' . CUSTOMIZATIONS . '/pdfprinter.php')) {
  include_once 'cust/' . CUSTOMIZATIONS . '/pdfprinter.php';
} else {
  include_once 'cust/default/pdfprinter.php';
}

$filter = 'tournaments';
$baseurl = "?view=games";
$id = 0;
$print = 0;
$gamefilter = "season";
$format = "html";
$group = "";
$groupheader = true;
$games;

if (iget("series")) {
  $id = iget("series");
  $baseurl .= "&series=$id";
  $gamefilter = "series";
  $title = _("Schedule") . " " . utf8entities(U_(SeriesName($id)));
} elseif (iget("pool")) {
  $id = iget("pool");
  $baseurl .= "&pool=$id";
  $gamefilter = "pool";
  $title = _("Schedule") . " " . utf8entities(U_(PoolSeriesName($id)) . ", " . U_(PoolName($id)));
} elseif (iget("pools")) {
  $id = iget("pools");
  $baseurl .= "&pools=$id";
  $gamefilter = "poolgroup";
  $title = _("Schedule") . " " . utf8entities(U_(PoolSeriesName($id)) . ", " . U_(PoolName($id)));
} elseif (iget("team")) {
  $id = iget("team");
  $baseurl .= "&team=$id";
  $gamefilter = "team";
  $filter = 'places';
  $title = _("Schedule") . " " . utf8entities(TeamName($id));
} elseif (iget("season")) {
  $id = iget("season");
  $baseurl .= "&season=$id";
  $gamefilter = "season";
  $title = _("Schedule") . " " . utf8entities(U_(SeasonName($id)));
  $comment = CommentHTML(1, $id);
} else {
  $id = CurrentSeason();
  $baseurl .= "&season=$id";
  $gamefilter = "season";
  $title = _("Schedule") . " " . utf8entities(U_(SeasonName($id)));
}

$smarty->assign("title", $title);

$filter  = iget("filter");
if (empty($filter)) {
  $filter = 'tournaments';
}

$group  = iget("group");
if (empty($group)) {
  $group = "all";
}

if (iget("print")) {
  $print = intval(iget("print"));
  $format = "paper";
}

$singleview = 0;

if (iget("singleview")) {
  $singleview = intval(iget("singleview"));
}

$timefilter = "all";
$order = "tournaments";

switch ($filter) {
  case "today":
    $timefilter = "today";
    $order = "series";
    break;
  case "tomorrow":
    $timefilter = "tomorrow";
    $order = "series";
    break;
  case "yesterday":
    $timefilter = "yesterday";
    $order = "series";
    break;
  case "next":
    $order = "tournaments";
    $order = "series";
    break;
  case "tournaments":
    $timefilter = "all";
    $order = "tournaments";
    break;
  case "series":
    $timefilter = "all";
    $order = "series";
    break;
  case "places":
    $timefilter = "all";
    $order = "places";
    break;
  case "season":
    $timefilter = "all";
    $order = "places";
    $format = "pdf";
    break;
  case "onepage":
    $timefilter = "all";
    $order = "onepage";
    $format = "pdf";
    break;
  case "timeslot":
    $timefilter = "all";
    $order = "time";
    break;
  default:
    $timefilter = "all";
    $order = "tournaments";
    break;
}

$smarty->assign("filter", $filter);
$smarty->assign("baseurl", $baseurl);
$smarty->assign("id", $id);
$smarty->assign("group", $group);

$games = TimetableGames($id, $gamefilter, $timefilter, $order, $group);
$games_array = array();
if (GetDatabase()->NumRows($games)) {
  while ($game = GetDatabase()->FetchAssoc($games)) {
    $game['starttime_justdate'] = JustDate($game['starttime']);
    $game['starttime_defweekdate'] = DefWeekDateFormat($game['starttime']);
    $game['time_defour'] = DefHourFormat($game['time']);
    $game['time_defweekdate'] = DefWeekDateFormat($game['time']);
    $games_array[] = $game;
  }
}
$smarty->assign("games", $games_array);

if ($format == "pdf") {
  $pdf = new PDF();
  if ($filter == "onepage") {
    $pdf->PrintOnePageSchedule($gamefilter, $id, $games);
  } else {
    $pdf->PrintSchedule($gamefilter, $id, $games);
  }
  $pdf->Output();
}

$menutabs[_("By grouping")] = ($baseurl) . "&filter=tournaments&group=$group";
$menutabs[_("By timeslot")] = ($baseurl) . "&filter=timeslot&group=$group";
$menutabs[_("By division")] = ($baseurl) . "&filter=series&group=$group";
$menutabs[_("By location")] = ($baseurl) . "&filter=places&group=$group";
$menutabs[_("Today")] = ($baseurl) . "&filter=today&group=$group";
$menutabs[_("Tomorrow")] = ($baseurl) . "&filter=tomorrow&group=$group";
$menutabs[_("Yesterday")] = ($baseurl) . "&filter=yesterday&group=$group";
$smarty->assign("menu_tabs", $menutabs);

$groups = TimetableGrouping($id, $gamefilter, $timefilter);
$smarty->assign("groups", $groups);

if (!empty($group) && $group != "all") {
  $groupheader = false;
}
$smarty->assign("group_header", $groupheader);

if (!empty($games_array)) {
  $timezone = end($games_array)['timezone'];
  $smarty->assign("display_datetime", (class_exists("DateTime") && !empty($timezone)));
  $smarty->assign("timezone", $timezone);
  $smarty->assign("datetime",
      DefTimeFormat((new DateTime("now", new DateTimeZone($timezone)))->format("Y-m-d H:i:s")));
}

$querystring = $_SERVER['QUERY_STRING'];
$querystring = preg_replace("/&Print=[0-1]/", "", $querystring);
$smarty->assign("query_string", $querystring);
