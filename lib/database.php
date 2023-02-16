<?php
include_once 'classes/Database.php';

$serverName = Database::GetServerName();
//include prefix can be used to locate root level of directory tree.
$include_prefix = "";
while (!(is_file($include_prefix.'conf/config.inc.php') || is_file($include_prefix.'conf/'.$serverName.".config.inc.php"))) {
  $include_prefix .= "../";
}

require_once $include_prefix.'lib/gettext/gettext.inc';
include_once $include_prefix.'lib/common.functions.php';

if (is_file($include_prefix.'conf/'.$serverName.".config.inc.php")) {
	require_once $include_prefix.'conf/'.$serverName.".config.inc.php";
} else {
	require_once $include_prefix.'conf/config.inc.php';
}

include_once $include_prefix.'sql/upgrade_db.php';

//When adding new update function into upgrade_db.php change this number
//Also when you change the database, please add a database definition into
// 'lib/table-definition-cache' with the database version in the file name.
// You can get it by getting ext/restful/show_tables.php
define('DB_VERSION', 76); //Database version matching to upgrade functions.
?>
