{include file="header.tpl"}
{include file="leftmenu.tpl"}

{include file=$welcome_message_page}

<p><a href='?view=user_guide'>{t}User Guide{/t}</a></p>

{if count($frontpage_urls)}
<p>
  {t}In case of feedback, improvement ideas or any other questions, please contact:{/t}
  {foreach $frontpage_urls as $url}
  <br><a href='mailto:{$url.url}'>{u}$url.name{/u}</a>
  {/foreach}
</p>
{/if}

{include file="footer.tpl"}