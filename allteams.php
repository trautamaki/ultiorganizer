<?php
include_once 'lib/team.functions.php';

$title = _("All teams");
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

$teams = TeamListAll(true, true, $filter);

$firstchar = " ";
$listletter = " ";

$teams_array = array();
while ($team = GetDatabase()->FetchAssoc($teams)) {
  if ($filter == "ALL") {
    $team['show_letter'] = false;
    $firstchar = strtoupper(substr(utf8_decode($team['name']), 0, 1));
    if ($listletter != $firstchar && in_array($firstchar, $validletters)) {
      $listletter = $firstchar;
      $team['show_letter'] = true;
    }
  }
  $teams_array[] = $team;
}
$smarty->assign("teams", $teams_array);
