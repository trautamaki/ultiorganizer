<?php
include_once $include_prefix . 'lib/configuration.functions.php';
include_once $include_prefix . 'lib/facebook.functions.php';
include_once $include_prefix . 'lib/url.functions.php';

$LAYOUT_ID = ADDSEASONLINKS;
$title = _("Event links");
$smarty->assign("title", $title);
$seasonId = $_GET["season"];
$smarty->assign("season_id", $seasonId);

if (!empty($_POST['save'])) {
	$settings = array();
	$setting = array();
	$setting['name'] = "FacebookUpdatePage";
	$setting['value'] = $_POST['FacebookUpdatePage'];
	$settings[] = $setting;

	SetServerConf($settings);

	for ($i = 0; !empty($_POST["urlid$i"]); $i++) {
		$url = array(
			"url_id" => $_POST["urlid$i"],
			"owner" => "ultiorganizer",
			"owner_id" => $seasonId,
			"type" => $_POST["urltype$i"],
			"ordering" => $_POST["urlorder$i"],
			"url" => $_POST["url$i"],
			"ismedialink" => 0,
			"name" => $_POST["urlname$i"],
			"mediaowner" => "",
			"publisher_id" => ""
		);

		if ($_POST["urltype$i"] == "menumail") {
			SetMail($url);
		} else {
			SetUrl($url);
		}
	}
	if (!empty($_POST["newurl"])) {
		$url = array(
			"owner" => "ultiorganizer",
			"owner_id" => $seasonId,
			"type" => $_POST["newurltype"],
			"ordering" => $_POST["newurlorder"],
			"url" => $_POST["newurl"],
			"ismedialink" => 0,
			"name" => $_POST["newurlname"],
			"mediaowner" => "",
			"publisher_id" => ""
		);

		if ($_POST["newurltype"] == "menumail") {
			AddMail($url);
		} else {
			AddUrl($url);
		}
	}
	$serverConf = GetSimpleServerConf();
} elseif (!empty($_POST['remove_x'])) {
	$id = $_POST['hiddenDeleteId'];
	RemoveUrl($id);
}

$settings = GetServerConf();
$settings_array = array();
foreach ($settings as $setting) {
	if ($setting['name'] == "FacebookUpdatePage") {
		$settings_array[] = $setting;
	}
}

$urls = GetUrlListByTypeArray(array("menulink", "menumail"), $seasonId);
$smarty->assign("urls", $urls);
