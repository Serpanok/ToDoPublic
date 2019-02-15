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

Router::get("/", function(){
	return "work!";
});

Router::get("/ping", "UserController@ping");

Router::get("/users", "UserController@usersPage");
Router::get("/user/{id}", "UserController@userPage");

Router::redirect("/users/", "/users");