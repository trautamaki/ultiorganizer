<?php
include_once 'lib/reservation.functions.php';
include_once 'lib/season.functions.php';
include_once 'lib/series.functions.php';
include_once 'lib/configuration.functions.php';

$title = _("Reservation") . ": " . utf8entities($place['name']) . " " . _("Field") . " " . utf8entities($place['fieldname']);
$smarty->assign("title", $title);

$reservationId = intval(iget("reservation"));
$place = ReservationInfo($reservationId);
$place['starttime_deftime'] = DefTimeFormat($place['starttime']);
$place['endtime_deftime'] = DefTimeFormat($place['endtime']);
$smarty->assign("place", $place);
