<?php
$title = _("Logout");
$html = "";

$database = new Database();

ClearUserSessionData($database);

$html .= "<h1>" . _("You have logged out") . "</h1>";

if (IsFacebookEnabled()) {
	$html .= "<script type=\"text/javascript\">
<!--
window.onload = function() {
	FB.getLoginStatus($database, function(response) {
	  	if (response.session) {
	  		FB.logout(function(loresp) {});
		}
	});
};
//-->
</script>";
}

showPage($database, $title, $html);
