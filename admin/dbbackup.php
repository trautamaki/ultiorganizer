<?php
include_once 'menufunctions.php';
include_once 'lib/club.functions.php';
include_once 'lib/reservation.functions.php';

if (isset($_POST['backup']) && !empty($_POST['tables']) && isSuperAdmin()) {
	$tables = $_POST["tables"];
	$return = "SET NAMES 'utf8';\n\n";
	if (count($tables) == 1) {
		$filename = 'db-backup-' . date('Y-m-d-Hi') . '-' . $tables[0] . '.sql';
	} else {
		$filename = 'db-backup-' . date('Y-m-d-Hi') . '-' . (md5(implode(',', $tables))) . '.sql';
	}

	foreach ($tables as $table) {
		set_time_limit(120);
		$result = GetDatabase()->DBQuery('SELECT * FROM ' . $table);
		$num_fields = GetDatabase()->NumFields($result);

		$return .= 'DROP TABLE IF EXISTS ' . $table . ';';
		$row2 = GetDatabase()->FetchRow(GetDatabase()->DBQuery('SHOW CREATE TABLE ' . $table));
		$return .= "\n\n" . $row2[1] . ";\n\n";

		for ($i = 0; $i < $num_fields; $i++) {
			while ($row = GetDatabase()->FetchRow($result)) {
				$return .= 'INSERT INTO ' . $table . ' VALUES(';
				for ($j = 0; $j < $num_fields; $j++) {
					if (GetDatabase()->FieldType($result, $j) == 'blob' && $table == 'uo_image') {
						if (isset($row[$j]) && ($row[$j] != NULL)) {
							$return .= '0x' . bin2hex($row[$j]);
						} else {
							$return .= 'NULL';
						}
					} elseif (GetDatabase()->FieldType($result, $j) == 'int') {
						if (isset($row[$j]) && ($row[$j] != NULL)) {
							$return .= intval($row[$j]);
						} else {
							$return .= 'NULL';
						}
					} else {
						$row[$j] = addslashes($row[$j]);
						$row[$j] = preg_replace("/\n/", "\\n", $row[$j]);

						if (isset($row[$j]) && ($row[$j] != NULL)) {
							$return .= '"' . $row[$j] . '"';
						} else {
							$return .= 'NULL';
						}
					}
					if ($j < ($num_fields - 1)) {
						$return .= ',';
					}
				}
				$return .= ");\n";
			}
		}
		$return .= "\n\n\n";
	}

	$gzipoutput = gzencode($return);

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header('Content-Type: application/x-download');
	header('Content-Encoding: binary');
	header('Content-Length: ' . strlen($gzipoutput));
	header("Content-Disposition: attachment; filename=$filename.gz;");

	echo $gzipoutput;
}

$title = _("Database backup");
$smarty->assign("title", $title);
$LAYOUT_ID = DBBACKUP;
include 'script/common.js.inc';

if (isSuperAdmin()) {
	$total_size = 0;
	$result = GetDatabase()->DBQuery("SHOW TABLE STATUS");
	$statuses_array = array();
	while ($row = GetDatabase()->FetchAssoc($result)) {
		if (substr($row['Name'], 0, 3) == 'uo_') {
			$statuses_array[] = $row;
			$total_size += intval($row['Data_length']) + intval($row['Index_length']);
		}
	}
	$smarty->assign("statuses", $statuses_array);
	$smarty->assign("total_size", $total_size);
}
