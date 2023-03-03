<?php
include_once 'lib/reservation.functions.php';
include_once 'lib/location.functions.php';

$LAYOUT_ID = ADDRESERVATION;
$addmore = false;
$allfields = "";
$reservationId = 0;
$season = "";

if (isset($_GET['reservation'])) {
  $reservationId = $_GET['reservation'];
}

if (!empty($_GET['season'])) {
  $season = $_GET['season'];
}
$smarty->assign("season", $season);

// Reservation parameters
$res = array(
  "id" => $reservationId,
  "location" => "",
  "fieldname" => "",
  "reservationgroup" => "",
  "date" => "",
  "starttime" => "",
  "endtime" => "",
  "season" => $season,
  "timeslots" => ""
);

if (isset($_POST['save']) || isset($_POST['add'])) {
  $res['id'] = isset($_POST['id']) ? $_POST['id'] : 0;
  $res['location'] = isset($_POST['location']) ? $_POST['location'] : 0;
  $res['fieldname'] = isset($_POST['fieldname']) ? $_POST['fieldname'] : "";
  $res['reservationgroup'] = isset($_POST['reservationgroup']) ? $_POST['reservationgroup'] : "";
  $res['date'] = isset($_POST['date']) ? $_POST['date'] : "1.1.19710";
  $res['starttime'] = isset($_POST['starttime']) ? ToInternalTimeFormat($res['date'] . " " . $_POST['starttime']) : ToInternalTimeFormat("1.1.1971 00:00");
  $res['endtime'] = isset($_POST['endtime']) ? ToInternalTimeFormat($res['date'] . " " . $_POST['endtime']) : ToInternalTimeFormat("1.1.1971 00:00");
  $res['date'] = ToInternalTimeFormat($res['date']);
  $res['timeslots'] = isset($_POST['timeslots']) ? $_POST['timeslots'] : "";
  $res['season'] = isset($_POST['resseason']) ? $_POST['resseason'] : $season;

  $reservation_messages = "";
  if ($res['id'] > 0) {
    SetReservation($res['id'], $res);
  } else {
    // Check if adding more than 1 field
    $fields = array();
    $tmpfields = explode(",", $res['fieldname']);
    foreach ($tmpfields as $field) {
      $morefields = explode("-", $field);
      if (count($morefields) > 1) {
        for ($i = $morefields[0]; $i <= $morefields[1]; $i++) {
          $fields[] = $i;
        }
      } else {
        $fields[] = $morefields[0];
      }
    }
    if (count($fields) == 0) {
      $fields[] = $res['fieldname'];
    }
    $i = 0;
    $reservation_messages .= "<p>" . _("Reservations added") . ":</p>";
    $reservation_messages .= "<ul>";
    $locinfo = LocationInfo($res['location']);
    $allfields = $res['fieldname'];
    foreach ($fields as $field) {
      $res['fieldname'] = $field;
      $reservationId = AddReservation($res);
      $reservation_messages .= "<li>" . $res['reservationgroup'] . ": " . DefWeekDateFormat($res['date']) . " ";
      if (!empty($res['timeslots'])) {
        $reservation_messages .= $res['timeslots'] . " ";
      } else {
        $reservation_messages .=  DefHourFormat($res['starttime']) . "-" . DefHourFormat($res['endtime']) . " ";
      }
      $reservation_messages .=  $locinfo['name'] . " " . _("field") . " " . $field;
      $reservation_messages .= "</li>";
    }
    $reservation_messages .= "</ul><hr/>";
    $addmore = true;
  }
}
$smarty->assign("reservation_messages", $reservation_messages);
$smarty->assign("add_more", $addmore);

$title = _("Add field reservation");
$smarty->assign("title", $title);

include_once 'lib/yui.functions.php';
$smarty->assign("yuiload", yuiLoad(array("utilities", "datasource", "autocomplete", "calendar")));
$smarty->assign("body_functions", "OnLoad=\"document.getElementById('date').focus();\"");

if ($reservationId > 0) {
  $reservationInfo = ReservationInfo($reservationId);
  $res['id'] = $reservationId;
  $res['location'] = $reservationInfo['location'];
  $res['fieldname'] = $reservationInfo['fieldname'];
  $res['reservationgroup'] = $reservationInfo['reservationgroup'];
  $res['date'] = ShortDate($reservationInfo['date']);
  $res['starttime'] = DefHourFormat($reservationInfo['starttime']);
  $res['endtime'] = DefHourFormat($reservationInfo['endtime']);
  $res['season'] = $reservationInfo['season'];
  $res['timeslots'] = $reservationInfo['timeslots'];
  if (!empty($allfields)) {
    $res['fieldname'] = $allfields;
  }
}

if ($res['location'] > 0) {
  $location_info = LocationInfo($res['location']);
  $res['location_name'] = utf8entities($location_info['name']);
}

if (isSuperAdmin()) {
  $seasons = Seasons();
  $seasons_array = array();
  while ($row = GetDatabase()->FetchAssoc($seasons)) {
    if ($res['season'] == $row['season_id'] || $season == $row['season_id']) {
      $row['selected'] = "selected='selected'";
    } else {
      $row['selected'] = "";
    }
  }
  $smarty->assign("seasons", $seasons);
}

$smarty->assign("res", $res);
