<?php
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/pool.functions.php';
$LAYOUT_ID = ADDSEASONPOOLS;
$template = 0;
$addmore = false;

$poolId = intval($_GET["pool"]);
$smarty->assign("pool_id", $poolId);
$info = PoolInfo($poolId);
$smarty->assign("info", $info);
$season = $info['season'];
$smarty->assign("season", $season);
$seriesId = $info['series'];
$smarty->assign("series_id", $seriesId);

//pool parameters
$pp = array(
	"name" => "",
	"ordering" => "A",
	"visible" => "0",
	"continuingpool" => "0",
	"placementpool" => "0",
	"teams" => "0",
	"mvgames" => "0",
	"timeoutlen" => "0",
	"halftime" => "0",
	"winningscore" => "0",
	"timecap" => "0",
	"timeslot" => "0",
	"scorecap" => "0",
	"played" => "0",
	"addscore" => "0",
	"halftimescore" => "0",
	"timeouts" => "0",
	"timeoutsper" => "game",
	"timeoutsovertime" => "0",
	"timeoutstimecap" => "0",
	"betweenpointslen" => "0",
	"series" => $seriesId,
	"type" => "0",
	"playoff_template" => "",
	"color" => "ffffff",
	"forfeitscore" => "0",
	"forfeitagainst" => "0",
	"drawsallowed" => "0"
);

$messages = array();
// Process itself on submit
if (!empty($_POST['add'])) {
	if (!empty($_POST['name'])) {
		$ordering = 'A';
		if (!empty($_POST['ordering'])) {
			$ordering = $_POST['ordering'];
		}
		$template = $_POST['template'];
		$poolId = PoolFromPoolTemplate($seriesId, $_POST['name'], $ordering, $template);
		$messages[] = array(
			"class" => "",
			"message" => _("Pool added") . ": " . utf8entities(U_($_POST['name']))
		);		$addmore = true;
	} else {
		$messages[] = array(
			"class" => "class='warning'",
			"message" => _("Pool name is mandatory!")
		);
	}
}
$smarty->assign("messages", $messages);

if (!empty($_POST['save'])) {
	$ok = true;
	$pp['name'] = $_POST['name'];
	$pp['series'] = $seriesId;
	/*$pp['teams']=intval($_POST['teams']);*/
	$pp['timeoutlen'] = intval($_POST['timeoutlength']);
	$pp['halftime'] = intval($_POST['halftimelength']);
	$pp['winningscore'] = intval($_POST['gameto']);
	$pp['timecap'] = intval($_POST['timecap']);
	$pp['timeslot'] = intval($_POST['timeslot']);
	$pp['scorecap'] = intval($_POST['pointcap']);
	$pp['addscore'] = intval($_POST['extrapoint']);
	$pp['halftimescore'] = intval($_POST['halftimepoint']);
	$pp['timeouts'] = intval($_POST['timeouts']);
	$pp['timeoutsper'] = $_POST['timeoutsfor'];
	$pp['timeoutsovertime'] = intval($_POST['timeoutsOnOvertime']);
	$pp['timeoutstimecap'] = intval($_POST['timeoutsOnOvertime']);
	$pp['betweenpointslen'] = intval($_POST['timebetweenPoints']);
	$pp['type'] = intval($_POST['type']);
	if (empty($_POST['playoff_template']))
		$pp['playoff_template'] = NULL;
	else
		$pp['playoff_template'] = $_POST['playoff_template'];
	$comment = $_POST['comment'];
	$pp['ordering'] = $_POST['ordering'];
	$pp['mvgames'] = intval($_POST['mvgames']);
	$pp['color'] = $_POST['color'];
	$pp['forfeitscore'] = intval($_POST['forfeitscore']);
	$pp['forfeitagainst'] = intval($_POST['forfeitagainst']);

	if (!empty($_POST['visible']))
		$pp['visible'] = 1;
	else
		$pp['visible'] = 0;

	if (!empty($_POST['played']))
		$pp['played'] = 1;
	else
		$pp['played'] = 0;

	if (!empty($_POST['continuationserie']))
		$pp['continuingpool'] = 1;
	else
		$pp['continuingpool'] = 0;

	if (!empty($_POST['placementpool']))
		$pp['placementpool'] = 1;
	else
		$pp['placementpool'] = 0;

	if (!empty($_POST['drawsallowed']))
		$pp['drawsallowed'] = 1;
	else
		$pp['drawsallowed'] = 0;

	if ($ok) {
		SetPoolDetails($poolId, $pp, $comment);
		session_write_close();
		header("location:?view=admin/seasonpools&season=$season");
	}
}
if ($poolId) {
	$info = PoolInfo($poolId);

	$pp['name'] = $info['name'];
	$pp['teams'] = $info['teams'];
	$pp['timeoutlen'] = $info['timeoutlen'];
	$pp['halftime'] = $info['halftime'];
	$pp['winningscore'] = $info['winningscore'];
	$pp['timecap'] = $info['timecap'];
	$pp['timeslot'] = $info['timeslot'];
	$pp['scorecap'] = $info['scorecap'];
	$pp['addscore'] = $info['addscore'];
	$pp['halftimescore'] = $info['halftimescore'];
	$pp['timeouts'] = $info['timeouts'];
	$pp['timeoutsper'] = $info['timeoutsper'];
	$pp['timeoutsovertime'] = $info['timeoutsovertime'];
	$pp['timeoutstimecap'] = $info['timeoutstimecap'];
	$pp['betweenpointslen'] = $info['betweenpointslen'];
	$pp['continuingpool'] = $info['continuingpool'];
	$pp['placementpool'] = $info['placementpool'];
	$pp['played'] = $info['played'];
	$pp['visible'] = $info['visible'];
	$pp['series'] = $info['series'];
	$pp['type'] = $info['type'];
	$pp['playoff_template'] = $info['playoff_template'];
	$pp['ordering'] = $info['ordering'];
	$pp['mvgames'] = $info['mvgames'];
	$pp['color'] = $info['color'];
	$pp['forfeitagainst'] = $info['forfeitagainst'];
	$pp['forfeitscore'] = $info['forfeitscore'];
	$pp['drawsallowed'] = $info['drawsallowed'];
}
$smarty->assign("pp", $pp);

$title = _("Edit");
$smarty->assign("title", $title);

include_once 'lib/yui.functions.php';
$smarty->assign("yui_load", yuiLoad(array("utilities", "slider", "colorpicker", "datasource", "autocomplete")));
$smarty->assign("body_functions", "onload=\"document.getElementById('name').focus();\"");

$smarty->assign("name_translated", TranslatedField("name", $pp['name']));

// If poolId is empty, then add new pool	
if (!$poolId || $addmore) {
	$templates = PoolTemplates();
	$smarty->assign("templates", $templates);
} else {
	$seriesname = SeriesName($pp['series']);
	$smarty->assign("seriesname", $seriesname);

	$frompool = PoolGetMoveFrom($info['pool_id'], 1);
	$frompoolinfo = PoolInfo($frompool['frompool']);
	$smarty->assign("frompoolinfo", $frompoolinfo);

	$teams = PoolTeams($poolId);
	$smarty->assign("teams", $teams);

	$comment = CommentRaw(3, $pool_id);
	$smarty->assign("comment", $comment);
}

$smarty->assign("name_translationscript", TranslationScript("name"));
