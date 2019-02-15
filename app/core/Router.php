<?php

abstract class Router
{
	/**
     * List of registered GET routes.
     *
     * @var array
     */
	private static $GET_routes 	= array();
	
	/**
     * List of registered POST routes.
     *
     * @var array
     */
	private static $POST_routes	= array();	
	
	/**
     * Register a new GET route.
     *
     * @param  string  $route
     * @param  mixed  $callback
     * @return void
     */
	public static function get( $route, $callback )
	{
		
	}
	
	/**
     * Register a new POST route.
     *
     * @param  string  $route
     * @param  mixed  $callback
     * @return void
     */
	public static function post( $route, $callback )
	{
		
	}
	
	/**
     * Handles the request by the desired controller.
     *
     * @param  Request  $request
     * @return string
     */
	public static function handle( $request )
	{
		$response = "";
		
		return $response;
	}
	
}