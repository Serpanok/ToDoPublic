<div class="row marketing">
	<div class="col-lg-12">
		<form method="post">
			<div class="form-group">
				<label for="editFormUsername">Name</label>
				<input type="name" class="form-control" id="editFormUsername" placeholder="Name" value="{$task->username}" disabled required>
			</div>
			<div class="form-group">
				<label for="editFormEmail">Email address</label>
				<input type="email" class="form-control" id="editFormEmail" placeholder="Email" value="{$task->email}" disabled required>
			</div>
			<div class="form-group">
				<label for="editFormText">Task</label>
				<textarea class="form-control" name="text" id="editFormText" placeholder="Text" required>{$task->text}</textarea>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="status" value="3"{if $task->status eq 3} checked{/if} /> Completed
				</label>
			</div>
			<button type="submit" class="btn btn-default">Edit</button>
		</form>
	</div>
</div>