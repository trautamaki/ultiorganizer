<?php
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
$LAYOUT_ID = ADDSEASONSERIES;

$seriesId = 0;
$season = 0;

if (!empty($_GET["series"]))
	$seriesId = intval($_GET["series"]);

if (!empty($_GET["season"]))
	$season = $_GET["season"];

$title = _("Edit");
$smarty->assign("title", $title);

// Series parameters
$sp = array(
	"series_id" => "",
	"name" => "",
	"type" => "",
	"ordering" => "A",
	"season" => "",
	"valid" => "1"
);

$warnings = array();
// Process itself on submit
if (!empty($_POST['add'])) {
	if (!empty($_POST['name'])) {
		$sp['name'] = $_POST['name'];
		$sp['type'] = $_POST['type'];
		$sp['ordering'] = $_POST['ordering'];
		$sp['season'] = $season;
		if (!empty($_POST['valid']))
			$sp['valid'] = 1;
		else
			$sp['valid'] = 0;

		$seriesId = AddSeries($sp);
		session_write_close();
		header("location:?view=admin/seasonseries&Season=$season");
	} else {
		$warnings[] = _("Division name is mandatory!");
	}
} else if (!empty($_POST['save'])) {
	if (!empty($_POST['name'])) {
		$sp['series_id'] = $seriesId;
		$sp['name'] = $_POST['name'];
		$sp['type'] = $_POST['type'];
		$sp['ordering'] = $_POST['ordering'];
		$sp['season'] = $season;
		if (!empty($_POST['valid']))
			$sp['valid'] = 1;
		else
			$sp['valid'] = 0;

		SetSeries($sp);
		session_write_close();
		header("location:?view=admin/seasonseries&Season=$season");
	} else {
		$warnings[] = _("Division name is mandatory!");
	}
}
$smarty->assign("warnings", $warnings);
$smarty->assign("series_id", $seriesId);

include_once 'script/disable_enter.js.inc';
include_once 'lib/yui.functions.php';
$smarty->assign("yui_load", yuiLoad(array("utilities", "datasource", "autocomplete")));

// Retrieve values if series id known
if ($seriesId) {
	$info = SeriesInfo($seriesId);
	$sp['series_id'] = $info['series_id'];
	$sp['name'] = $info['name'];
	$sp['type'] = $info['type'];
	$sp['ordering'] = $info['ordering'];
	$sp['season'] = $info['season'];
	$sp['valid'] = $info['valid'];
}
$smarty->assign("sp", $sp);

$types = SeriesTypes();
$smarty->assign("types", $types);
