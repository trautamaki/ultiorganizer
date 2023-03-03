<?php
include_once $include_prefix . 'lib/common.functions.php';

if ((!empty($_GET["season"]) && !isSeasonAdmin($_GET["season"])) && !isSuperAdmin()) {
  die("Insufficient user rights");
}

$messages = array();
$mailsent = false;
if (!empty($_POST['save'])) {
  $newUsername = $_POST['UserName'];
  $newPassword = $_POST['Password'];
  $newName = $_POST['Name'];
  $newEmail = $_POST['Email'];
  $error = 0;
  $message = "";
  if (empty($newUsername) || strlen($newUsername) < 3 || strlen($newUsername) > 50) {
    $messages[] = _("Username is too short (min. 3 letters)") . ".</p>";
    $error = 1;
  }
  if (IsRegistered($newUsername)) {
    $html .=  "<p>" . _("The username is already in use") . ".</p>";
    $error = 1;
  }
  if (empty($newPassword) || strlen($newPassword) < 5 || strlen($newPassword) > 20) {
    $html .=  "<p>" . _("Password is too short (min. 5 letters).") . ".</p>";
    $error = 1;
  }
  if (empty($newName)) {
    $messages[] = _("Name can not be empty") . ".</p>";
    $error = 1;
  }

  if (empty($newEmail)) {
    $messages[] = _("Email can not be empty") . ".</p>";
    $error = 1;
  }

  if (!validEmail($newEmail)) {
    $messages[] = _("Invalid email address") . ".</p>";
    $error = 1;
  }

  $uidcheck = GetDatabase()->RealEscapeString($newUsername);

  if ($uidcheck != $newUsername || preg_match('/[ ]/', $newUsername) /*|| preg_match('/[^a-z0-9._]/i', $newUsername)*/) {
    $messages[] = _("User id may not have spaces or special characters") . ".</p>";
    $error = 1;
  }

  $pswcheck = GetDatabase()->RealEscapeString($newPassword);

  if ($pswcheck != $newPassword) {
    $messages[] = _("Illegal characters in the password") . ".</p>";
    $error = 1;
  }

  if ($error == 0) {
    if (AddRegisterRequest($newUsername, $newPassword, $newName, $newEmail)) {
      ConfirmRegisterUID($newUsername);
      AddEditSeason($newUsername, CurrentSeason());
      AddSeasonUserRole($newUsername, "teamadmin:" . $_POST["team"], CurrentSeason());
      $messages[] = _("Added new user") . "<br/>" . _("Username") . ": " . $newUsername . "<br/>" . _("Password") . ": " . $newPassword . "<br/>\n";
    }
  } else {
    $messages[] = _("Correct the errors and try again") . ".</p>\n";
  }
}
$smarty->assign("messages", $messages);

include_once 'script/disable_enter.js.inc';

if (isset($_POST['Password'])) {
  $password = $_POST['Password'];
} else {
  $password = UserCreateRandomPassword();
}
$smarty->assign("password", $password);

$LAYOUT_ID = REGISTER;
$title = _("Add new user");
$smarty->assign("title", $title);

$smarty->assign("teams", SeasonTeams(CurrentSeason()));
