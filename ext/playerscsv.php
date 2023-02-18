<?php
include_once 'localization.php';
include_once '../lib/player.functions.php';

$season = iget("season");
$encoding = 'UTF-8';
$separator = ',';

if (iget('enc')) {
	$encoding = iget('enc');
}
if (iget('sep')) {
	$separator = iget('sep');
}

$data = PlayersToCsv($season, $separator);
$data = mb_convert_encoding($data, $encoding, 'UTF-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Length: " . strlen($data));
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=players.csv");
echo $data;
