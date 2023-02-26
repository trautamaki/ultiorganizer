<?php
include_once 'lib/player.functions.php';

$title = _("All players");
$smarty->assign("title", $title);

$filter = "A";
if (iget("list")) {
  $filter = strtoupper(iget("list"));
}
$smarty->assign("filter", $filter);

$players = PlayerListAll($filter);
$firstchar = " ";
$listletter = " ";
$validletters = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
$maxcols = 4;
$smarty->assign("maxcols", $maxcols);
$smarty->assign("valid_letters", $validletters);

$players_array = array();
while ($player = GetDatabase()->FetchAssoc($players)) {
  $player['show_letter'] = false;
  if ($filter == "ALL") {
    $firstchar = strtoupper(substr(utf8_decode($player['lastname']), 0, 1));
    if ($listletter != $firstchar && in_array($firstchar, $validletters)) {
      $listletter = $firstchar;
      $player['show_letter'] = true;
      $player['list_letter'] = $listletter;
    }
  }
  $players_array[] = $player;
}
$smarty->assign("players", $players_array);
