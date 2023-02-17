<?php

function GetAllSMS()
{
	$query = sprintf("SELECT * FROM uo_sms");
	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}

	return $result;
}

function SendSMS($sms)
{
	// expects an array containing 'msg','to1','to2' etc.
	$query = sprintf(
		"INSERT INTO uo_sms 
		(msg, to1, to2, to3, to4, to5) 
		VALUES	('%s','%s',",
		GetDatabase()->RealEscapeString($sms['msg']),
		GetDatabase()->RealEscapeString($sms['to1'])
	);

	if ($sms['to2'] == "") {
		$query .= "NULL,";
	} else {
		$query .= GetDatabase()->RealEscapeString($sms['to2']) . ",";
	}
	if ($sms['to3'] == "") {
		$query .= "NULL,";
	} else {
		$query .= GetDatabase()->RealEscapeString($sms['to3']) . ",";
	}
	if ($sms['to4'] == "") {
		$query .= "NULL,";
	} else {
		$query .= GetDatabase()->RealEscapeString($sms['to4']) . ",";
	}
	if ($sms['to5'] == "") {
		$query .= "NULL)";
	} else {
		$query .= GetDatabase()->RealEscapeString($sms['to5']) . ")";
	}

	$result = GetDatabase()->DBQuery($query);
	if (!$result) {
		die('Invalid query: ' . GetDatabase()->SQLError());
	}
}
