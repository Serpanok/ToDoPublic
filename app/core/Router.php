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
		$route = self::prepareRoute($route);
		self::$GET_routes[$route] = self::prepareHandler($callback);
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
		$route = self::prepareRoute($route);
		self::$POST_routes[$route] = self::prepareHandler($callback);
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
	
	/**
     * Preparing the route path regexp. Replacing parameters with regular expressions.
     *
     * @param  string  $route
     * @return string
     */
	protected static function prepareRoute( $route )
	{
		$route = str_replace("/", "\/", $route);
		$route = preg_replace('/{[a-z_-]+}/i', '([^\/]+)', $route);
		
		return $route;
	}
	
	/**
     * Preparing the route heandler.
     *
     * @param  mixed  $callback
     * @return array
     */
	protected static function prepareHandler( $callback )
	{
		$handler = array();
		
		if( is_callable( $callback ) )
		{
			$handler["function"] = $callback;
		}
		// else by controller name
		else
		{
			// separate controller and method name
			// Ex input: BaseController@showAll
			$controller = explode("@", $callback);

			$handler["controller"] = $controller[0];
			// if callback without method -> use default render method
			$handler["method"] = isset($controller[1]) ? $controller[1] : "render";
		}
		
		return $handler;
	}
	
}