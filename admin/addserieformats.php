<?php
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/pool.functions.php';

$LAYOUT_ID = ADDSERIEFORMATS;

$title = _("Edit");
$smarty->assign("title", $title);

$poolId = 0;
//pool parameters
$pp = array(
	"name" => "",
	"season_id" => "",
	"type" => "0",
	"ordering" => "A",
	"visible" => "0",
	"continuingpool" => "0",
	"alkupoolt" => "",
	"teams" => "0",
	"mvgames" => "1",
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
	"forfeitscore" => "0",
	"forfeitagainst" => "0",
	"drawsallowed" => "0"
);

$poolId = intval($_GET["template"]);

//process itself on submit
if (!empty($_POST['save']) || !empty($_POST['add'])) {
	$pp['name'] = empty($_POST['name']) ? "no name" : $_POST['name'];
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

	if (!empty($_POST['drawsallowed']))
		$pp['drawsallowed'] = 1;
	else
		$pp['drawsallowed'] = 0;

	if (!empty($_POST['add'])) {
		$poolId = AddPoolTemplate($pp);
	} else {
		SetPoolTemplate($poolId, $pp);
	}
}
$smarty->assign("pool_id", $poolId);

include_once 'script/disable_enter.js.inc';
include_once 'lib/yui.functions.php';
$smarty->assign("yui_load", yuiLoad(array("utilities", "datasource", "autocomplete")));

if ($poolId) {
	$info = PoolTemplateInfo($poolId);
	$pp['name'] = $info['name'];
	$pp['type'] = $info['type'];
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
	$pp['mvgames'] = $info['mvgames'];
	$pp['forfeitagainst'] = $info['forfeitagainst'];
	$pp['forfeitscore'] = $info['forfeitscore'];
	$pp['drawsallowed'] = $info['drawsallowed'];
}
$smarty->assign("pp", $pp);
