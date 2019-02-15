<div class="row marketing">
	<div class="col-lg-12">
		<form class="row" method="GET" id="sortForm">
			<div class="col-lg-3">
				<div class="input-group-btn">
					<select class=" btn btn-default dropdown-toggle" name="sortBy" onChange="document.getElementById('sortForm').submit();">
						{html_options values=$sortByValues output=$sortByNames selected=$sortBySelected}
					</select>
				</div>
				<div class="input-group-btn">
					<select class=" btn btn-default dropdown-toggle" name="sortDir" onChange="document.getElementById('sortForm').submit();">
						{html_options values=$sortDirValues output=$sortDirNames selected=$sortDirSelected}
					</select>
				</div>
			</div>
		</form>
	
		<p>
			{foreach from=$tasks item=task}
				<div class="panel panel-{$task->statusClass}">
					<div class="panel-heading">
						<h3 class="panel-title">{$task->username}</h3>
					</div>
					<div class="panel-body">{$task->text}</div>
					<div class="panel-footer">
						<b>Email:</b> <a href="mailto:{$task->email}" target="_blank">{$task->email}</a>
						<b>Status:</b> {$task->statusName}
						{if $_auth}
							<b>Controll:</b> <a href="/edit/{$task->task_id}">Edit</a>
						{/if}
					</div>
				</div>
			{foreachelse}
				<p>Ничего не найдено</p>
			{/foreach}
		</p>
	</div>
</div>