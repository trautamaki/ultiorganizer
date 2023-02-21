<?php

if (iget("hideseason")) {
  $propId = getPropId($user, 'editseason', iget("hideseason"));
  RemoveEditSeason($user, $propId);
  header("location:?view=frontpage");
  exit;
}

$welcomepage = 'locale/' . getSessionLocale() . '/LC_MESSAGES/welcome.html';
if (is_file('cust/' . CUSTOMIZATIONS . '/' . $welcomepage)) {
  $welcomepage = 'cust/' . CUSTOMIZATIONS . '/' . $welcomepage;
}

$smarty->assign("title",  _("Frontpage"));
$smarty->assign("welcome_message_page", $welcomepage);
$smarty->assign("frontpage_urls", GetUrlListByTypeArray(array("admin"), 0));
