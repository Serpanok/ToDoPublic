<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
   
	<title>{$title}</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<link href="/css/styles.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	
	<div class="container">
		<div class="header clearfix">
			<nav>
				<ul class="nav nav-pills pull-right">
					<li role="presentation" class="active"><a href="/create">Create task</a></li>
					<li role="presentation"><a href="#">Admin panel</a></li>
				 </ul>
			</nav>
			<h3 class="text-muted"><a href="/">To Do Public</a></h3>
		</div>
		
		{if isset($promo) && $promo}
			<div class="jumbotron todolist">
				<h1>Public ToDo list</h1>
				<p class="lead">You can create a task for the author of this site. The author will execute it and you will see the result.</p>
				<p><a class="btn btn-lg btn-success" href="/create" role="button">Create task</a></p>
			</div>
		{/if}
		
		{include file='messages.tpl' messages=$_messages}
		 
		{$content}
		
		<footer class="footer">
     		<p>&copy; 2019 <a href="https://space-ship.xyz">space-ship.xyz</a></p>
		</footer>
		
	</div> <!-- /container -->
</body>
</html>