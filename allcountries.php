<?php
include_once 'lib/country.functions.php';

$title = _("Countries");
$smarty->assign("title", $title);

$maxcols = 5;
$smarty->assign("maxcols", $maxcols);
$countries = CountryList(true, true);
$smarty->assign("countries", $countries);
