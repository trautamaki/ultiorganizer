<?php
function logo()
{
  global $include_prefix;
  return "<div><a href='http://www.ultimate.fi/'><img class='logo' src='" . $include_prefix . "cust/slkl/logo.png' alt='" . _("Ultimate.fi") . "'/></a></div>";
}
