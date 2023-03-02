<?php
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/common.functions.php';

$LAYOUT_ID = SEASONS;
$seasonId = "";
$backurl = utf8entities($_SERVER['HTTP_REFERER']);
$smarty->assign("backurl", $backurl);

// Season parameters
$sp = array(
	"season_id" => "",
	"name" => "",
	"type" => "",
	"starttime" => "",
	"starttime_shortdate" => "",
	"istournament" => 0,
	"isinternational" => 0,
	"organizer" => "",
	"category" => "",
	"isnationalteams" => 0,
	"endtime" => "",
	"endtime_shortdate" => "",
	"spiritmode" => 0,
	"showspiritpoints" => 0,
	"iscurrent" => 0,
	"enrollopen" => 0,
	"enroll_deadline" => "",
	"enroll_deadline_shortdate" => "",
	"timezone" => GetDefTimeZone()
);

if (!empty($_GET["season"]))
	$seasonId = $_GET["season"];

$smarty->assign("season_id", $seasonId);

// Process itself on submit
$warnings = array();
if (!empty($_POST['add'])) {
	$backurl = utf8entities($_POST['backurl']);
	$sp['season_id'] = $_POST['season_id'];
	$sp['name'] = $_POST['seasonname'];
	$sp['type'] = $_POST['type'];
	$sp['istournament'] = !empty($_POST['istournament']);
	$sp['isinternational'] = !empty($_POST['isinternational']);
	$sp['organizer'] = $_POST['organizer'];
	$sp['category'] = $_POST['category'];
	$sp['isnationalteams'] = !empty($_POST['isnationalteams']);
	$sp['timezone'] = $_POST['timezone'];
	$sp['starttime'] = ToInternalTimeFormat($_POST['seasonstarttime']);
	$sp['starttime_shortdate'] = ShortDate($sp['starttime']);
	$sp['endtime'] = ToInternalTimeFormat($_POST['seasonendtime']);
	$sp['endtime_shortdate'] = ShortDate($sp['endtime']);
	$sp['enrollopen'] = !empty($_POST['enrollopen']);
	$sp['enroll_deadline'] = isset($_POST['enrollendtime']) ? ToInternalTimeFormat($_POST['enrollendtime']) : ToInternalTimeFormat($_POST['seasonstarttime']);
	$sp['enroll_deadline_shortdate'] = ShortDate($sp['enroll_deadline']);
	$sp['iscurrent'] = !empty($_POST['iscurrent']);
	$sp['spiritmode'] = $_POST['spiritmode'];
	$sp['showspiritpoints'] = !empty($_POST['showspiritpoints']);
	$comment = $_POST['comment'];

	if (empty($_POST['season_id'])) {
		$warnings[] = _("Event id can not be empty");
	} else if (preg_match('/[ ]/', $_POST['season_id']) || !preg_match('/[a-z0-9.]/i', $_POST['season_id'])) {
		$warnings[] = _("Event id may not have spaces or special characters");
	} else if (empty($_POST['seasonname'])) {
		$warnings[] = _("Name can not be empty");
	} else if (empty($_POST['type'])) {
		$warnings[] = _("Type can not be empty");
	} else {
		AddSeason($sp['season_id'], $sp, $comment);
		$seasonId = $sp['season_id'];
		// Add rights for season creator
		AddEditSeason($_SESSION['uid'], $sp['season_id']);
		AddUserRole($_SESSION['uid'], 'seasonadmin:' . $sp['season_id']);

		if ($sp['istournament']) {
			$_SESSION['title'] = _("New tournament added") . ":";
		} else {
			$_SESSION['title'] = _("New season added") . ":";
		}
		/* FIXME Does anybody need this? I don't get it ... */
		$_SESSION["var0"] = _("Name") . ": " . utf8entities($sp['name']);
		$_SESSION["var1"] = _("Type") . ": " . utf8entities($sp['type']);
		$_SESSION["var2"] = _("Starts") . ": " . ShortDate($sp['starttime']);
		$_SESSION["var3"] = _("Ends") . ": " . ShortDate($sp['endtime']);
		$_SESSION["var4"] = _("Enrollment open") . ": " . (intval($sp['enrollopen']) ? _("yes") : _("no"));
		$_SESSION['backurl'] = "?view=admin/seasons";
		session_write_close();
		header("location:?view=admin/seasonadmin&season=$seasonId");
	}
} else if (!empty($_POST['save'])) {
	$backurl = utf8entities($_POST['backurl']);
	if (empty($_POST['seasonname'])) {
		$warnings[] = _("Name can not be empty");
	} else {
		$sp['season_id'] = $seasonId;
		$sp['name'] = $_POST['seasonname'];
		$sp['type'] = $_POST['type'];
		$sp['istournament'] = !empty($_POST['istournament']);
		$sp['isinternational'] = !empty($_POST['isinternational']);
		$sp['isnationalteams'] = !empty($_POST['isnationalteams']);
		$sp['organizer'] = $_POST['organizer'];
		$sp['category'] = $_POST['category'];
		$sp['starttime'] = ToInternalTimeFormat($_POST['seasonstarttime']);
		$sp['starttime_shortdate'] = ShortDate($sp['starttime']);
		$sp['endtime'] = ToInternalTimeFormat($_POST['seasonendtime']);
		$sp['endtime_shortdate'] = ShortDate($sp['endtime']);
		$sp['enrollopen'] = !empty($_POST['enrollopen']);
		$sp['enroll_deadline'] = ToInternalTimeFormat($_POST['enrollendtime']);
		$sp['enroll_deadline_shortdate'] = ShortDate($sp['enroll_deadline']);
		$sp['iscurrent'] = !empty($_POST['iscurrent']);
		$sp['spiritmode'] = $_POST['spiritmode'];
		$sp['showspiritpoints'] = !empty($_POST['showspiritpoints']);
		$sp['timezone'] = $_POST['timezone'];
		$comment = $_POST['comment'];
		SetSeason($sp['season_id'], $sp, $comment);
	}
}

$title = _("Edit event");
if (strlen($sp['name']) > 0) {
	$title .= ": " . $sp['name'];
}
$smarty->assign("title", $title);

if ($seasonId) {
	$info = SeasonInfo($seasonId);
	$sp['season_id'] = $info['season_id'];
	$sp['name'] = $info['name'];
	$sp['type'] = $info['type'];
	$sp['starttime'] = $info['starttime'];
	$sp['starttime_shortdate'] = ShortDate($sp['starttime']);
	$sp['endtime'] = $info['endtime'];
	$sp['endtime_shortdate'] = ShortDate($sp['endtime']);
	$sp['iscurrent'] = $info['iscurrent'];
	$sp['enrollopen']  = $info['enrollopen'];
	$sp['enroll_deadline'] = $info['enroll_deadline'];
	$sp['enroll_deadline_shortdate'] = ShortDate($sp['enroll_deadline']);
	$sp['istournament'] = $info['istournament'];
	$sp['isinternational'] = $info['isinternational'];
	$sp['organizer'] = $info['organizer'];
	$sp['category'] = $info['category'];
	$sp['isnationalteams'] = $info['isnationalteams'];
	$sp['spiritmode'] = $info['spiritmode'];
	$sp['showspiritpoints'] = $info['showspiritpoints'];
	$sp['timezone'] = $info['timezone'];
	$comment = CommentRaw(1, $info['season_id']);
} else {
	$comment = "";
}
$smarty->assign("sp", $sp);

include_once 'lib/yui.functions.php';
$smarty->assign("yuiload", yuiLoad(array("utilities", "calendar", "datasource", "autocomplete")));

if (empty($seasonId)) {
	$season_id_disabled = "";
} else {
	$season_id_disabled = "disabled='disabled'";
}
$smarty->assign("season_id_disabled", $season_id_disabled);

$smarty->assign("types", SeasonTypes());
$smarty->assign("spiritmodes", SpiritModes());
$smarty->assign("dateTimeZone", GetTimeZoneArray());
