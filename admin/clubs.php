<?php
include_once 'menufunctions.php';

include_once 'classes/Country.php';
include_once 'classes/Club.php';

$html = "";
if (isset($_POST['removeclub_x']) && isset($_POST['hiddenDeleteId'])) {
	$id = $_POST['hiddenDeleteId'];
	(new Club(GetDatabase(), $id))->remove($id);
} elseif (isset($_POST['addclub']) && !empty($_POST['name'])) {
	Club::add(GetDatabase(), 0, $_POST['name']);
} elseif (isset($_POST['saveclub']) && !empty($_POST['valid'])) {
	//invalidate all valid clubs
	$clubs = Club::clubList(GetDatabase(), true);
	foreach ($clubs as $club) {
		$club->setValidity(false);
	}
	//revalidate
	foreach ($_POST["valid"] as $clubId) {
		$club->setValidity(true);
	}
} elseif (isset($_POST['removecountry_x']) && isset($_POST['hiddenDeleteId'])) {
	$id = $_POST['hiddenDeleteId'];
	(new Country(GetDatabase(), $id))->remove();
} elseif (isset($_POST['addcountry']) && !empty($_POST['name']) && !empty($_POST['abbreviation']) && !empty($_POST['flag'])) {
	Country::create(
		GetDatabase(),
		array('name', 'abbreviation', 'flagfile'),
		array($_POST['name'], $_POST['abbreviation'], $_POST['flag'])
	);
} elseif (isset($_POST['savecountry']) && !empty($_POST['valid'])) {
	//invalidate all valid countries
	$countries = Country::countryList(GetDatabase(), true);
	foreach ($countries as $row) {
		$row->setValidity(false);
	}
	//revalidate
	foreach ($_POST["valid"] as $countryId) {
		$row->setValidity(true);
	}
}

//common page
$title = _("Clubs and Countries");
$LAYOUT_ID = CLUBS;
pageTopHeadOpen($title);
include 'script/common.js.inc';
pageTopHeadClose($title, false);
leftMenu($LAYOUT_ID);
contentStart();

$html .= "<form method='post' action='?view=admin/clubs'>";
$html .= "<h1>" . _("All Clubs") . "</h1>";
$html .= "<p>" . _("Add new") . ": ";
$html .= "<input class='input' maxlength='50' size='40' name='name'/> ";
$html .= "<input class='button' type='submit' name='addclub' value='" . _("Add") . "'/></p>";

$html .= "<table border='0'>\n";
$html .= "<tr><th>" . _("Id") . "</th> <th>" . _("Name") . "</th><th>" . _("Teams") . "</th><th>" . _("Valid") . "</th><th></th></tr>\n";

$i = 0;
$clubs = Club::clubList(GetDatabase());
foreach ($clubs as $club) {
	$html .= "<tr>";
	$html .= "<td>" . $club->getId() . "&#160;</td>";
	$html .=  "<td><a href='?view=user/clubprofile&amp;club=" . $club->getId() . "'>" . $club->getName() . "</a></td>";

	$html .= "<td class='center'>" . $club->numOfTeams() . "</td>";
	if (intval($club->getValid())) {
		$html .= "<td class='center'><input class='input' type='checkbox' name='valid[]' value='" . $club->getId() . "' checked='checked'/></td>";
	} else {
		$html .= "<td class='center'><input class='input' type='checkbox' name='valid[]' value='" . $club->getId() . "'/></td>";
	}

	if ($club->canDelete()) {
		$html .=  "<td class='center'><input class='deletebutton' type='image' src='images/remove.png' alt='X' name='removeclub' value='" . _("X") . "' onclick=\"setId('" . $club->getId() . "');\"/></td>";
	}

	$html .= "</tr>\n";
	$i++;
}

$html .= "</table>";
$html .= "<p><input class='button' type='submit' name='save' value='" . _("Save") . "'/></p>";

$html .= "<h1>" . _("All Countries") . "</h1>";
$html .= "<p>" . _("Add new") . "<br/>";
$html .= _("Name") . ": <input class='input' maxlength='50' size='40' name='name'/><br/>";
$html .= _("Abbreviation") . ": <input class='input' maxlength='50' size='40' name='abbreviation'/><br/>";
$html .= _("Flag filename") . ": <input class='input' maxlength='50' size='40' name='flag'/><br/>";
$html .= "<input class='button' type='submit' name='addcountry' value='" . _("Add") . "'/></p>";

$html .= "<table border='0'>\n";
$html .= "<tr><th>" . _("Id") . "</th> <th>" . _("Name") . "</th><th>" . _("Abbreviation") . "</th><th>" . _("Teams") . "</th><th>" . _("Valid") . "</th><th></th></tr>\n";

$i = 0;
$countries = Country::countryList(GetDatabase(), false);
foreach ($countries as $row) {

	$html .= "<tr>";
	$html .= "<td>" . $row->getId() . "&#160;</td>";
	$html .=  "<td>" . $row->getName() . "</td>";
	$html .=  "<td class='center'>" . $row->getAbbreviation() . "</td>";

	$html .= "<td class='center'>" . $row->getNumOfTeams() . "</td>";
	if (intval($row->getValid())) {
		$html .= "<td class='center'><input class='input' type='checkbox' name='valid[]' value='" . $row->getId() . "' checked='checked'/></td>";
	} else {
		$html .= "<td class='center'><input class='input' type='checkbox' name='valid[]' value='" . $row->getId() . "'/></td>";
	}

	if ($row->canDelete()) {
		$html .=  "<td class='center'><input class='deletebutton' type='image' src='images/remove.png' alt='X' name='removecountry' value='" . _("X") . "' onclick=\"setId('" . $row->getId() . "');\"/></td>";
	}

	$html .= "</tr>\n";
	$i++;
}

$html .= "</table>";
$html .= "<p><input class='button' type='submit' name='savecountry' value='" . _("Save") . "'/></p>";

$html .= "<p><input type='hidden' id='hiddenDeleteId' name='hiddenDeleteId'/></p>";
$html .= "</form>\n";

echo $html;
contentEnd();
pageEnd();
