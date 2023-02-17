<?php

function GetAllSMS(){
	$query = sprintf("SELECT * FROM uo_sms");
	$result = DB()->DBQuery($query);
	if (!$result) { die('Invalid query: ' . DB()->SQLError()); }
	
	return $result;
}

function SendSMS($sms) {
	// expects an array containing 'msg','to1','to2' etc.
	$query = sprintf("INSERT INTO uo_sms 
		(msg, to1, to2, to3, to4, to5) 
		VALUES	('%s','%s',",
	DB()->RealEscapeString($sms['msg']),
	DB()->RealEscapeString($sms['to1']));
	
	if ($sms['to2']=="") {
		$query .= "NULL,";
	} else {
		$query .= DB()->RealEscapeString($sms['to2']).",";
	}
	if ($sms['to3']=="") {
		$query .= "NULL,";
	} else {
		$query .= DB()->RealEscapeString($sms['to3']).",";
	}
	if ($sms['to4']=="") {
		$query .= "NULL,";
	} else {
		$query .= DB()->RealEscapeString($sms['to4']).",";
	}
	if ($sms['to5']=="") {
		$query .= "NULL)";
	} else {
		$query .= DB()->RealEscapeString($sms['to5']).")";
	}
	
	$result = DB()->DBQuery($query);
	if (!$result) { die('Invalid query: ' . DB()->SQLError()); }
	
		
}
	 
?>