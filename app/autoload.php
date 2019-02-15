<?php

class Autoload
{
	/**
     * Static autoload list. Contains global classes.
     *
     * @var array
     */
	private $autoloadMap = array(
		
	);
	
	public function __construct()
	{
		spl_autoload_register( array($this, 'loader') );
	}
	
	public function loader($className)
	{
		if( isset( $this->autoloadMap[$className] ) )
		{
			include __DIR__ . '/' . $this->autoloadMap[$className] . '.php';
			return;
		}
	}
}