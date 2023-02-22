{include file="header.tpl"}
{include file="leftmenu.tpl"}

{include file="page_menu.tpl"}

<h1>{t}Teams{/t}</h1>

{if $list_type == "allteams" || $list_type == "byseeding"}
{include file="teams/teams_allteams_byseeding.tpl"}
{elseif $list_type == "bypool"}
{include file="teams/teams_bypool.tpl"}
{elseif $list_type == "bystandings"}
{include file="teams/teams_bystandings.tpl"}
{/if}

{include file="footer.tpl"}