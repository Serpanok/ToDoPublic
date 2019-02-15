<?php

class Core
{
	public function __construct()
	{
		include __DIR__ . "/../config/global.php";
		include __DIR__ . "/../config/routes.php";
		
	}
}