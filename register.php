<?php
include_once $include_prefix . 'lib/common.functions.php';

$messages = array();
$title = _("Register");
$smarty->assign("title", $title);

$mailsent = false;
if (!empty($_POST['save'])) {
  $newUsername = $_POST['UserName'];
  $newPassword = $_POST['Password'];
  $newName = $_POST['Name'];
  $newEmail = $_POST['Email'];
  $error = false;
  $messages = array();
  if (empty($newUsername) || strlen($newUsername) < 3 || strlen($newUsername) > 20) {
    $messages[] = _("Username is too short (min. 3 letters)");
    $error = true;
  }
  if (IsRegistered($newUsername)) {
    $messages[] = _("The username is already in use");
    $error = true;
  }
  if (empty($newPassword) || strlen($newPassword) < 5 || strlen($newPassword) > 20) {
    $messages[] = _("Password is too short (min. 5 letters).");
    $error = true;
  }
  if (empty($newName)) {
    $messages[] = _("Name can not be empty");
    $error = true;
  }

  if (empty($newEmail)) {
    $messages[] = _("Email can not be empty");
    $error = true;
  }

  if (!validEmail($newEmail)) {
    $messages[] = _("Invalid email address");
    $error = true;
  }

  $uidcheck = GetDatabase()->RealEscapeString($newUsername);

  if ($uidcheck != $newUsername || preg_match('/[ ]/', $newUsername) || preg_match('/[^a-z0-9._]/i', $newUsername)) {
    $messages[] = _("User id may not have spaces or special characters");
    $error = true;
  }

  $pswcheck = GetDatabase()->RealEscapeString($newPassword);

  if ($pswcheck != $newPassword) {
    $messages[] = _("Illegal characters in the password");
    $error = true;
  }
  if ($pswcheck != $_POST['Password2']) {
    $messages[] = _("Passwords do not match");
    $error = true;
  }

  if ($error == false) {
    if (AddRegisterRequest($newUsername, $newPassword, $newName, $newEmail)) {
      $messages[] =_("Confirmation e-mail has been sent to the email address provided. You have to follow the link in the mail to finalize registration, before you can use the account.") . "\n";
      $mailsent = true;
    }
  } else {
    $messages[] = _("Correct the errors and try again") . ".\n";
  }
}

$confirmed = false;
if (!empty($_GET['token'])) {
  $userid = RegisterUIDByToken($_GET['token']);
  if (ConfirmRegister($_GET['token'])) {
    SetUserSessionData($userid);
    AddEditSeason($userid, CurrentSeason());
    $messages[] = _("Registration was confirmed successfully");
    $confirmed = true;
  } else {
    $messages[] = _("Confirming registration failed");
  }
}
$smarty->assign("messages", $messages);

$smarty->assign("show_register_form", !$confirmed && !$mailsent);
