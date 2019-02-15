<?php

class Autoload
{
	/**
     * Static autoload list. Contains global classes.
     *
     * @var array
     */
	private $autoloadMap = array(
		'Core'     		=> 'core/Core',
		'Request'     	=> 'core/Request',
		'Router'     	=> 'core/Router',
		'Controller'	=> 'core/Controller',
		'Database'		=> 'core/Database',
		'Model'			=> 'core/Model',
		'Collection'	=> 'core/Collection',
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
		
		// parse class name by pattern
		preg_match("/([a-zA-Z]{1,})(Controller|Model)$/", $className, $structure);
		
		// if its Controller or Model
		if( isset($structure[2]) )
		{
			$file = null;
			switch($structure[2])
			{
				case 'Controller':
					$file = __DIR__ . "/controllers/" . $structure[0] . ".php";
					break;
				case 'Model':
					$file = __DIR__ . "/models/" . $structure[0] . ".php";
					break;
			}
			if( $file !== null && file_exists($file) )
			{
				include $file;
			}
			return;
		}
	}
}