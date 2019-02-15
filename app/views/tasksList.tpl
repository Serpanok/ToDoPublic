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
	
		{foreach from=$tasks item=task}
			<h4>{$task->username}</h4>
			<p>{$task->text}</p>
		{foreachelse}
			Ничего не найдено
		{/foreach}
	</div>
</div>