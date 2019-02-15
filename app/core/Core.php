<?php

class Core
{
	public function __construct()
	{
		include __DIR__ . "/../config/global.php";
		include __DIR__ . "/../config/database.php";
		include __DIR__ . "/../config/routes.php";
		
		try
		{
			$this->request = new Request();

			print Router::handle( $this->request );
		}
		catch(Exception $e)
		{
			printf("Error: %s", $e->getMessage());
		}
	}
}