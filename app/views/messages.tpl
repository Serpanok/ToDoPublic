{foreach from=$_messages item=message}
	<div class="alert alert-{$message[1]}" role="alert">{$message[0]}</div>
{/foreach}