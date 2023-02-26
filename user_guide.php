<?php
// TODO printable
$title = _("User Guide");
$smarty->assign("title", $title);

$html_file = 'locale/' . getSessionLocale() . '/LC_MESSAGES/user_guide.html';

if (is_file('cust/' . CUSTOMIZATIONS . '/' . $html_file)) {
  $guide_html = file_get_contents('cust/' . CUSTOMIZATIONS . '/' . $html_file);
} else {
  $guide_html = file_get_contents($html_file);
}
$smarty->assign("guide_html", $guide_html);
