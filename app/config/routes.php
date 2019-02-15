<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
|	Router::get( string $route, mixed $callback ) 		- Register a new GET route
|
|	Router::post( string $route, mixed $callback ) 		- Register a new POST route
|
|	Router::redirect( string $route, string $target )	- Register a new redirect
|
*/

Router::get("/", "TaskController@page");

Router::get("/create", function() {
	return View::main( [
		"tpl" => "taskCreate", 
		"attributes" => [ 
			"username" => Session::get("username", ""),
			"email" => Session::get("email", ""),
			"allowableTags" => htmlspecialchars(CONFIG_WEB["allowable_tags"]),
		]
	] , [ "title" => "Create a new task" ]);
});

Router::post("/create", "TaskController@create");


Router::get("/signin", "AuthController@signinPage");
Router::post("/signin", "AuthController@signin");
Router::get("/signout", "AuthController@signout", [ "middlewares" => [ "AuthMiddleware" ] ]);

Router::get("/edit/{id}", "TaskController@editPage", [ "middlewares" => [ "AuthMiddleware" ] ]);
Router::post("/edit/{id}", "TaskController@edit", [ "middlewares" => [ "AuthMiddleware" ] ]);

