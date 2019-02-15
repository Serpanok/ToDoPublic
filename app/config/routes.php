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