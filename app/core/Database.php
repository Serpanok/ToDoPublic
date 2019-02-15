<?php

abstract class DataBase
{
	protected static $DBH = null;
	
	public static function init()
	{
		if( self::$DBH === null )
		{
			self::$DBH = new PDO(
				sprintf("mysql:host=%s;port=%d;dbname=%s;charset=%s", CONFIG_DB["host"], CONFIG_DB["port"], CONFIG_DB["database"], CONFIG_DB["charset"]), 
				CONFIG_DB["username"], 
				CONFIG_DB["password"]
			); 
			
			self::$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
	}
}