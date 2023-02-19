<?php
include_once 'lib/team.functions.php';
include_once 'lib/url.functions.php';

include_once 'classes/Country.php';
include_once 'classes/Club.php';

$html = "";
$clubId = iget("club");
$club = new Club(GetDatabase(), $clubId);

$title = _("Club Card") . ": " . $club->getName();

$html .= "<h1>" . $club->getName() . "</h1>";

$html .= "<table style='width:100%'><tr>";

if (!empty($club->getProfileImage())) {
  $html .= "<td style='width:165px'><a href='" . UPLOAD_DIR . "clubs/$clubId/" . $club->getProfileImage() . "'>";
  $html .= "<img src='" . UPLOAD_DIR . "clubs/$clubId/thumbs/" . $club->getProfileImage() . "' alt='" . _("Profile image") . "'/></a></td>";
} else {
  $html .= "<td></td>";
}

$html .= "<td style='vertical-align:top;text-align:left'><table border='0'>";
$html .= "<tr><td></td></tr>";
$country = $club->getCountry();
if ($country->getId() > 0) {
  $html .= "<tr><td class='profileheader'>" . _("Country") . ":</td>";
  $html .= "<td style='white-space: nowrap;'><div style='float: left; clear: left;'>";
  $html .= "<a href='?view=countrycard&amp;country=" . $country->getId() . "'>" . $country->getName() . "</a>";
  $html .= "</div><div>&nbsp;<img src='images/flags/tiny/" . $country->getFlagfile() . "' alt=''/></div>";
  $html .= "</td></tr>\n";
}
if (!empty($club->getCity())) {
  $html .= "<tr><td class='profileheader'>" . _("City") . ":</td>";
  $html .= "<td>" . $club->getCity() . "</td></tr>\n";
}

if (!empty($club->getFounded())) {
  $html .= "<tr><td class='profileheader'>" . _("Founded") . ":</td>";
  $html .= "<td>" . $club->getFounded() . "</td></tr>\n";
}

if (!empty($club->getContacts())) {
  $contacts = $club->getContacts();
  $contacts = str_replace("\n", '<br/>', $contacts);
  $html .= "<tr><td class='profileheader' style='vertical-align:top'>" . _("Contacts") . ":</td>";
  $html .= "<td>" . $contacts . "</td></tr>\n";
}

$html .= "</table>";
$html .= "</td></tr>";

if (!empty($club->getStory())) {
  $story = $club->getStory();
  $story = str_replace("\n", '<br/>', $story);
  $html .= "<tr><td colspan='2'>" . $story . "</td></tr>\n";
}
if (!empty($club->getAchievements())) {
  $html .= "<tr><td colspan='2'>&nbsp;</td></tr>\n";
  $html .= "<tr><td class='profileheader' colspan='2'>" . _("Achievements") . ":</td></tr>\n";
  $html .= "<tr><td colspan='2'></td></tr>\n";
  $achievements = $club->getAchievements();
  $achievements = str_replace("\n", '<br/>', $achievements);
  $html .= "<tr><td colspan='2'>" . $achievements . "</td></tr>\n";
}
$urls = GetUrlList("club", $clubId);
if (count($urls)) {
  $html .= "<tr><td colspan='2' class='profileheader' style='vertical-align:top'>" . _("Club pages") . ":</td></tr>";
  $html .= "<tr><td colspan='2'><table>";
  foreach ($urls as $url) {
    $html .= "<tr>";
    $html .= "<td colspan='2'><img width='16' height='16' src='images/linkicons/" . $url['type'] . ".png' alt='" . $url['type'] . "'/> ";
    $html .= "</td><td>";
    if (!empty($url['name'])) {
      $html .= "<a href='" . $url['url'] . "'>" . $url['name'] . "</a>";
    } else {
      $html .= "<a href='" . $url['url'] . "'>" . $url['url'] . "</a>";
    }
    $html .= "</td>";
    $html .= "</tr>";
  }
  $html .= "</table>";
  $html .= "</td></tr>";
}

$urls = GetMediaUrlList("club", $clubId);
if (count($urls)) {
  $html .= "<tr><td colspan='2' class='profileheader' style='vertical-align:top'>" . _("Photos and Videos") . ":</td></tr>";
  $html .= "<tr><td colspan='2'><table>";
  foreach ($urls as $url) {
    $html .= "<tr>";
    $html .= "<td colspan='2'><img width='16' height='16' src='images/linkicons/" . $url['type'] . ".png' alt='" . $url['type'] . "'/> ";
    $html .= "</td><td>";
    if (!empty($url['name'])) {
      $html .= "<a href='" . $url['url'] . "'>" . $url['name'] . "</a>";
    } else {
      $html .= "<a href='" . $url['url'] . "'>" . $url['url'] . "</a>";
    }
    if (!empty($url['mediaowner'])) {
      $html .= " " . _("from") . " " . $url['mediaowner'];
    }

    $html .= "</td>";
    $html .= "</tr>";
  }
  $html .= "</table>";
  $html .= "</td></tr>";
}

$html .= "</table>";

$teams = $club->getTeams();
if (GetDatabase()->NumRows($teams)) {
  $html .= "<h2>" . U_(CurrentSeasonName()) . ":</h2>\n";
  $html .= "<table style='white-space: nowrap;' border='0' cellspacing='0' cellpadding='2' width='90%'>\n";
  $html .= "<tr><th>" . _("Team") . "</th><th>" . _("Division") . "</th><th colspan='3'></th></tr>\n";

  while ($team = GetDatabase()->FetchAssoc($teams)) {
    $html .= "<tr>\n";
    $html .= "<td style='width:30%'><a href='?view=teamcard&amp;team=" . $team['team_id'] . "'>" . utf8entities($team['name']) . "</a></td>";
    $html .=  "<td  style='width:30%'><a href='?view=poolstatus&amp;series=" . $team['series_id'] . "'>" . utf8entities(U_($team['seriesname'])) . "</a></td>";
    if (IsStatsDataAvailable()) {
      $html .=  "<td class='right' style='width:15%'><a href='?view=playerlist&amp;team=" . $team['team_id'] . "'>" . _("Roster") . "</a></td>";
      $html .=  "<td class='right' style='width:15%'><a href='?view=scorestatus&amp;team=" . $team['team_id'] . "'>" . _("Scoreboard") . "</a></td>";
    } else {
      $html .=  "<td class='right' style='width:30%'><a href='?view=scorestatus&amp;team=" . $team['team_id'] . "'>" . _("Players") . "</a></td>";
    }
    $html .=  "<td class='right' style='width:10%'><a href='?view=games&amp;team=" . $team['team_id'] . "'>" . _("Games") . "</a></td>";
    $html .= "</tr>\n";
  }
  $html .= "</table>\n";
}

$teams = $club->getTeamsHistory();
if (GetDatabase()->NumRows($teams)) {
  $html .= "<h2>" . _("History") . ":</h2>\n";
  $html .= "<table style='white-space: nowrap;' border='0' cellspacing='0' cellpadding='2' width='90%'>\n";
  $html .= "<tr><th>" . _("Event") . "</th><th>" . _("Team") . "</th><th>" . _("Division") . "</th><th colspan='3'></th></tr>\n";

  while ($team = GetDatabase()->FetchAssoc($teams)) {
    $html .= "<tr>\n";
    $html .= "<td style='width:20%'>" . utf8entities(U_(SeasonName($team['season']))) . "</td>";
    $html .= "<td style='width:30%'><a href='?view=teamcard&amp;team=" . $team['team_id'] . "'>" . utf8entities($team['name']) . "</a></td>";
    $html .=  "<td style='width:20%'><a href='?view=poolstatus&amp;series=" . $team['series_id'] . "'>" . utf8entities(U_($team['seriesname'])) . "</a></td>";

    if (IsStatsDataAvailable()) {
      $html .=  "<td style='width:15%'><a href='?view=playerlist&amp;team=" . $team['team_id'] . "'>" . _("Roster") . "</a></td>";
      $html .=  "<td style='width:15%'><a href='?view=scorestatus&amp;team=" . $team['team_id'] . "'>" . _("Scoreboard") . "</a></td>";
    } else {
      $html .=  "<td style='width:30%'><a href='?view=scorestatus&amp;team=" . $team['team_id'] . "'>" . _("Players") . "</a></td>";
    }
    $html .=  "<td style='width:10%'><a href='?view=games&amp;team=" . $team['team_id'] . "'>" . _("Games") . "</a></td>";

    $html .= "</tr>\n";
  }
  $html .= "</table>\n";
}

if ($_SESSION['uid'] != 'anonymous') {
  $html .= "<div style='float:left;'><hr/><a href='?view=user/addmedialink&amp;club=$clubId'>" . _("Add media") . "</a></div>";
}

showPage($title, $html);
