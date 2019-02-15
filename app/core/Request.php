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
    }
	
	/**
     * Return input item by name.
     *
	 * @param  string  $name
     * @return string
     */
	protected function input( $name )
	{
		return isset( $this->input[ $name ] ) ? $this->input[ $name ] : null;
	}
}