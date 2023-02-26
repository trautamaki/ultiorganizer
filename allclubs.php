<?php
include_once 'lib/club.functions.php';

$title = _("All clubs");
$smarty->assign("title", $title);

$filter = "A";
if (iget("list")) {
  $filter = strtoupper(iget("list"));
}
$smarty->assign("filter", $filter);

$validletters = array("#", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
$maxcols = 3;
$smarty->assign("maxcols", $maxcols);
$smarty->assign("valid_letters", $validletters);

$clubs = ClubList(true, $filter);

$firstchar = " ";
$listletter = " ";
$counter = 0;

$clubs_array = array();
while ($club = GetDatabase()->FetchAssoc($clubs)) {
  if ($filter == "ALL") {
    $club['show_letter'] = false;
    $firstchar = strtoupper(substr(utf8_decode($club['name']), 0, 1));
    if ($listletter != $firstchar && in_array($firstchar, $validletters)) {
      $listletter = $firstchar;
      $counter = 0;
      $club['show_letter'] = true;
      $club['list_letter'] = $listletter;
    }
  }
  $clubs_array[] = $club;
}
$smarty->assign("clubs", $clubs_array);
