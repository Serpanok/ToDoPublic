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
     * List of registered redirects.
     *
     * @var array
     */
	private static $redirects	= array();
	
	/**
     * Register a new redirect.
     *
     * @param  string  $route
     * @param  string  $target
     * @return void
     */
	public static function redirect( $route, $target )
	{
		self::$redirects[$route] = $target;
	}
	
	/**
     * Register user.
     *
     * @param  string  $target
     * @return void
     */
	public static function redirectNow( $target )
	{
		header('Location: ' . CONFIG_WEB["url"] . $target, true, 303);
		exit();
	}
	
	/**
     * Register a new GET route.
     *
     * @param  string  $route
     * @param  mixed  $callback
     * @param  array  $settings
     * @return void
     */
	public static function get( $route, $callback, $settings = array() )
	{
		$route = self::prepareRoute($route);
		self::$GET_routes[$route] = self::prepareHandler($callback, $settings);
	}
	
	/**
     * Register a new POST route.
     *
     * @param  string  $route
     * @param  mixed  $callback
     * @param  array  $settings
     * @return void
     */
	public static function post( $route, $callback, $settings = array() )
	{
		$route = self::prepareRoute($route);
		self::$POST_routes[$route] = self::prepareHandler($callback, $settings);
	}
	
	/**
     * Handles the request by the desired controller.
     *
     * @param  Request  $request
     * @return string
     */
	public static function handle( $request )
	{
		// Check for redirect
		if( isset( self::$redirects[ $request->uri ] ) )
		{
			header('Location: ' . CONFIG_WEB["url"] . self::$redirects[ $request->uri ], true, 302);
			return;
		}
		
		$response = "";
		
		// Select routes list by request method
		$routes = array();
		switch( $request->method )
		{
			case 'GET':
				$routes = &self::$GET_routes;
				break;
			case 'POST':
				$routes = &self::$POST_routes;
				break;
		}
		
		// Searching the right route by patterns 
		$route = null;
		$callbackParameters;
		foreach( $routes as $routePattern => $routeData )
		{
			if( preg_match("/^$routePattern$/i", $request->uri, $callbackParameters) )
			{
				$route = $routeData;
				break;
			}
		}
		
		// Check found route
		if( $route === null )
		{
			self::terminate(404);
		}
		
		// Check middlewares
		foreach( $route["middlewares"] as $middlewareName )
		{
			$middleware = new $middlewareName;
			
			$handle = $middleware->handle( $request );
			if( $handle !== 200 )
			{
				self::terminate($handle);
			}
		}
		
		// Set the Request object to first callback parameter
		$callbackParameters[0] = $request;
		
		// if the route have closure callback
		if( isset( $route["function"] ) )
		{
			$response = call_user_func_array($route["function"], $callbackParameters );
		}
		else
		{
			// check for existence of route controller
			if( !class_exists($route["controller"]) )
			{
				self::terminate(500);
			}
			
			// create handler controller
			$controller = new $route["controller"]();
			
			// check for existence of route method
			if( !method_exists( $controller, $route["method"] ) )
			{
				self::terminate(500);
			}
			
			$response = call_user_func_array( [$controller, $route["method"] ], $callbackParameters );
		}
		
		return $response;
	}
	
	/**
     * Terminate with http error
     *
     * @param  int  $errorCode
     * @return void
     */
	public static function terminate( $errorCode )
	{
		http_response_code($errorCode);
		
		//temporary solution
		exit("ERROR $errorCode");
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
     * @param  array  $settings
     * @return array
     */
	protected static function prepareHandler( $callback, $settings = array() )
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
		
		$handler["middlewares"] = isset( $settings["middlewares"] ) ? $settings["middlewares"] : array();
		
		return $handler;
	}
	
}

