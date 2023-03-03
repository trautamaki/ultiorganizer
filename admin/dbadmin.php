<?php
include_once 'menufunctions.php';
include_once 'lib/club.functions.php';
include_once 'lib/reservation.functions.php';
include_once 'lib/plugin.functions.php';

$title = _("Database administration");
$smarty->assign("title", $title);
$LAYOUT_ID = DBADMIN;

if (isSuperAdmin()) {
	$types = array("import", "updater", "simulator", "generator");
	$plugins_per_type = array();
	foreach ($types as $type) {
		$plugins = GetPluginList("database", $type);
		$plugins_per_type[$type] = $plugins;
	}
	$smarty->assign("types", $types);
	$smarty->assign("plugins_per_type", $plugins_per_type);
	$total_size = 0;
	$result = GetDatabase()->DBQuery("SHOW TABLE STATUS");
	$table_statuses = array();
	while ($row = GetDatabase()->FetchAssoc($result)) {
		if (substr($row['Name'], 0, 3) == 'uo_') {
			$row['sql'] = urlencode("SELECT * FROM " . $row['Name']);
			$table_statuses[] = $row;
			$total_size += intval($row['Data_length']) + intval($row['Index_length']);
		}
	}
	$smarty->assign("table_statuses", $table_statuses);
	$smarty->assign("total_size", $total_size);

	$mysql_stat = GetDatabase()->Stat();
	$tot_count = preg_match_all('/([a-z ]+):\s*([0-9.]+)/i', $mysql_stat, $matches);
	$stat_array = array();
	for ($i = 0; $i < $tot_count; $i++) {
		$info1 = trim($matches[1][$i]);
		$info2 = trim($matches[2][$i]);
		$stat_array[] = $info1 . ": " . $info2;
	}
	$smarty->assign("stat_array", $stat_array);

	$smarty->assign("client_info", GetDatabase()->GetClientInfo());
	$smarty->assign("host_info", GetDatabase()->GetHostInfo());
	$smarty->assign("protocol_version", GetDatabase()->GetProtocolVersion());
	$smarty->assign("server_info", GetDatabase()->GetServerInfo());

	$result = GetDatabase()->DBQuery("SHOW VARIABLES LIKE 'character_set\_%';");
	$char_set_array = array();
	while ($row = GetDatabase()->FetchAssoc($result)) {
		$char_set_array[] = $row;
	}
	$smarty->assign("char_set_array", $char_set_array);

	$result = GetDatabase()->DBQuery("SHOW VARIABLES LIKE 'collation\_%';");
	$collation_array = array();
	while ($row = GetDatabase()->FetchAssoc($result)) {
		$collation_array[] = $row;
	}
	$smarty->assign("collation_array", $collation_array);
}
