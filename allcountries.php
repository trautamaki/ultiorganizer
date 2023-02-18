<?php
include_once 'classes/Country.php';

$title = _("Countries");
$html = "";
$counter = 0;
$maxcols = 5;
$countries = Country::countryList(getDatabase(), true, true);
$html .= "<h1>" . _("Countries") . "</h1>\n";
$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='2'>\n";
foreach ($countries as $country) {

  if ($counter == 0) {
    $html .= "<tr>\n";
  }

  $html .= "<td style='width:20%'>";
  $html .= "<a href='?view=countrycard&amp;country=" . $country->getId() . "'>";
  $html .= "<img src='images/flags/small/" . $country->getFlagFile() . "' alt=''/><br/>";
  $html .= $country->getName() . "</a></td>";

  $counter++;
  if ($counter >= $maxcols) {
    $html .= "</tr>\n";
    $counter = 0;
  }
}
if ($counter > 0 && $counter <= $maxcols) {
  $html .= "</tr>\n";
};
$html .= "</table>\n";

showPage($title, $html);
