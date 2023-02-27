<?php
$html = "";
global $include_prefix;
$print = iget("print");

$title = _("Privacy Policy");
$smarty->assign("title", $title);

$htmlfile = 'locale/' . getSessionLocale() . '/LC_MESSAGES/privacy.html';

if (is_file('cust/' . CUSTOMIZATIONS . '/' . $htmlfile)) {
  $html = file_get_contents('cust/' . CUSTOMIZATIONS . '/' . $htmlfile);
} else {
  $html = file_get_contents($htmlfile);
}
$smarty->assign("html", $html);

$backurl = utf8entities($_SERVER['HTTP_REFERER']);
$smarty->assign("back_url", $backurl);

$querystring = $_SERVER['QUERY_STRING'];
$querystring = preg_replace("/&Print=[0-1]/", "", $querystring);
$smarty->assign("query_string", $querystring);

if ($print) {
  $html .= "<hr/><div style='text-align:right'><a href='?" . utf8entities($querystring) . "'>" . _("Return") . "</a></div>";
  showPrintablePage($title, $html);
}
