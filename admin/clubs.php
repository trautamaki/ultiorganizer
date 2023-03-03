<?php
include_once 'menufunctions.php';
include_once 'lib/club.functions.php';
include_once 'lib/country.functions.php';

if (isset($_POST['removeclub_x']) && isset($_POST['hiddenDeleteId'])) {
	$id = $_POST['hiddenDeleteId'];
	RemoveClub($id);
} elseif (isset($_POST['addclub']) && !empty($_POST['name'])) {
	AddClub(0, $_POST['name']);
} elseif (isset($_POST['saveclub']) && !empty($_POST['valid'])) {
	// Invalidate all valid clubs
	$clubs = ClubList(true);
	while ($row = GetDatabase()->FetchAssoc($clubs)) {
		SetClubValidity($row['club_id'], false);
	}
	// Revalidate
	foreach ($_POST["valid"] as $clubId) {
		SetClubValidity($clubId, true);
	}
} elseif (isset($_POST['removecountry_x']) && isset($_POST['hiddenDeleteId'])) {
	$id = $_POST['hiddenDeleteId'];
	RemoveCountry($id);
} elseif (isset($_POST['addcountry']) && !empty($_POST['name']) && !empty($_POST['abbreviation']) && !empty($_POST['flag'])) {
	AddCountry($_POST['name'], $_POST['abbreviation'], $_POST['flag']);
} elseif (isset($_POST['savecountry']) && !empty($_POST['valid'])) {
	// Invalidate all valid countries
	$countries = CountryList(true);
	foreach ($countries as $row) {
		SetCountryValidity($row['country_id'], false);
	}
	// Revalidate
	foreach ($_POST["valid"] as $countryId) {
		SetCountryValidity($countryId, true);
	}
}

$title = _("Clubs and Countries");
$smarty->assign("title", $title);
$LAYOUT_ID = CLUBS;
include 'script/common.js.inc';

$i = 0;
$clubs = ClubList();
$clubs_array = array();
while ($row = GetDatabase()->FetchAssoc($clubs)) {
	$row['can_delete'] = CanDeleteClub($row['club_id']);
	$row['num_of_teams'] = ClubNumOfTeams($row['club_id']);
	$clubs_array[] = $row;
}
$smarty->assign("clubs", $clubs_array);

$i = 0;
$countries = CountryList(false);
foreach ($countries as $key => $row) {
	$countries[$key]['can_delete'] = CanDeleteCountry($row['country_id']);
	$countries[$key]['num_of_teams'] = CountryNumOfTeams($row['country_id']);
}
$smarty->assign("countries", $countries);
