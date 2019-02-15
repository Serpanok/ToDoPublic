<?php

abstract class Session
{
	protected static $storage = array();
	
	/**
     * Start working with Session
     *
     * @return void
     */
	public static function init()
	{
		session_start();
		
		static::$storage = &$_SESSION;
	}
	
	/**
     * Register a new session var.
     *
     * @param  string  $name
     * @param  mixed  $value
     * @return void
     */
	public static function set( $name, $value )
	{
		static::$storage[$name] = $value;
	}
	
	/**
     * Check if a variable is set and is not NULL.
     *
     * @param  string  $name
     * @return boolean
     */
	public static function has( $name )
	{
		return isset(static::$storage[$name]);
	}
	
	/**
     * Return a session var.
     *
     * @param  string  $name
     * @param  mixed  $default
     * @return mixed
     */
	public static function get( $name, $default = null )
	{
		return self::has($name) ? static::$storage[$name] : $default;
	}
	
	/**
     * Return a session var & delete it.
     *
     * @param  string  $name
     * @param  mixed  $default
     * @return mixed
     */
	public static function pull( $name, $default = null )
	{
		$value = self::get( $name, $default );
		self::delete( $name );
		
		return $value;
	}
	
	/**
     * Delete session var.
     *
     * @param  string  $name
     * @return void
     */
	public static function delete( $name )
	{
		unset( static::$storage[$name] );
	}
}