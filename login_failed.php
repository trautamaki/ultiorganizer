<?php
if (IsRegistered($_SESSION['uid'])) {
  header("location:?view=frontpage");
}

$title = _("Login failed");
$smarty->assign("title", $title);
$userId = urldecode($_GET['user']);
$smarty->assign("user_id", $userId);

$smarty->assign("reset_password", isset($_POST['resetpassword']));
if (isset($_POST['resetpassword'])) {
  $ret = UserResetPassword(urldecode($userId));
  $smarty->assign("reset_password_success", $ret);
}

if (empty($html)) {
  $validuser = IsRegistered($userId);
  $smarty->assign("valid_user", $validuser);
}
