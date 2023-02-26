{include file="header.tpl"}
{include file="leftmenu.tpl"}

<h1>{t}You have logged out{/t}</h1>

{if $is_facebook_enabled}
script type=\"text/javascript\">
<!--
window.onload = function() {
	FB.getLoginStatus(function(response) {
	  	if (response.session) {
	  		FB.logout(function(loresp) {});
		}
	});
};
//-->
</script>
{/if}

{include file="footer.tpl"}