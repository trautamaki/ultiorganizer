{include file="header.tpl"}
{include file="leftmenu.tpl"}

<!-- TODO print -->
{$html}

<hr />
<div style='text-align:left;float:left;clear:left;'>
    <a href='{$back_url}'>{t}Return{/t}</a>
</div>
<div style='text-align:right'>
    <a href='?{$query_string}&amp;print=1'>{t}Printable version{/t}</a>
</div>

{include file="footer.tpl"}