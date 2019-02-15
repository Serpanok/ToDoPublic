<div class="row marketing">
	<div class="col-lg-12">
		<form method="post">
			<div class="form-group">
				<label for="createFromUsername">Your name</label>
				<input type="name" class="form-control" name="username" id="createFromUsername" placeholder="Name" value="{$username|default:''}" required>
			</div>
			<div class="form-group">
				<label for="createFromEmail">Email address</label>
				<input type="email" class="form-control" name="email" id="createFromEmail" placeholder="Email" value="{$email|default:''}" required>
			</div>
			<div class="form-group">
				<label for="createFromText">Task</label>
				<textarea class="form-control" name="text" id="createFromText" placeholder="Text" required></textarea>
			</div>
			<button type="submit" class="btn btn-default">Create!</button>
		</form>
	</div>
</div>