<div class="row marketing">
	<div class="col-lg-12">
		{foreach from=$tasks item=task}
			<h4>{$task->username}</h4>
			<p>{$task->text}</p>
		{foreachelse}
			Ничего не найдено
		{/foreach}
	</div>
</div>