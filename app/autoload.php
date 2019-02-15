<?php

class Autoload
{
	public function __construct()
	{
		spl_autoload_register( array($this, 'loader') );
	}
	
	public function loader($className)
	{
		
	}
}