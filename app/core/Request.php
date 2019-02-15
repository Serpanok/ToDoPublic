<?php

class Request
{
	/**
     * Method of HTTP request(GET, POST etc).
     *
     * @var string
     */
	public	$method;
	
	/**
     * Purified URI of request. Without uri_prefix and GET vars.
     *
     * @var string
     */
	public	$uri;
	
	/**
     * List of input data.
     *
     * @var array
     */
	private $input = array();
	
	public function __construct()
	{
		// set http method
		$this->method = $_SERVER["REQUEST_METHOD"];
		
		// select target of input data
		$inputArray = array();
		switch( $this->method )
		{
			case 'GET':
				$inputArray = &$_GET;
				break;
			case 'POST':
				$inputArray = &$_POST;
				break;
		}
		
		// set the list of input data
		foreach($inputArray as $name => $value)
		{
			$this->input[$name] = $value;
		}
		
		// set URI
		$this->uri = $this->prepareUri($_SERVER["REQUEST_URI"]);
    }
	
	/**
     * Return input item by name.
     *
	 * @param  string  $name
     * @return string
     */
	public function input( $name )
	{
		return isset( $this->input[ $name ] ) ? $this->input[ $name ] : null;
	}
	
	/**
	 * Getter of input item.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function __get( $name )
	{
		return $this->input( $name );
	}
	
	/**
	 * Setter of input item.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function __set( $name, mixed $value )
	{
		// disabled change of input items
		return;
	}
	
	public function __isset( $name )
	{
		return isset( $this->input[ $name ] );
	}
	
	public function __unset( $name ) 
    {
        unset( $this->input[ $name ] );
    }
	
	/**
     * Remove unnecessary information from uri.
     *
	 * @param  string  $uri
     * @return string
     */
	protected function prepareUri( $uri )
	{
		$prefix = str_replace("/", "\/", CONFIG_WEB["uri_prefix"]);
		
		// remove uri_prefix
		$uri = preg_replace("/^$prefix/i", "", $uri);
		// remove GET vars
		$uri = preg_replace("/\?.*$/i", "", $uri);
		
		return $uri;
	}
}