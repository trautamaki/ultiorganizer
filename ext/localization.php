<?php
include_once '../lib/database.php';

global $include_prefix;
$include_prefix = "../";
include_once '../lib/translation.functions.php';
include_once '../lib/gettext/gettext.inc';
//include_once '../lib/configuration.functions.php';
include_once '../localization.php';

//session_start();
setSessionLocale();
