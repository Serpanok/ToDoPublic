<?php

class UserModel extends Model
{
	protected static $table = "users";
	protected static $primaryKey = "user_id";
	
	/**
     * Check and get auth user by username & password
     *
     * @param  string  $username
     * @param  string  $password
     * @return int
     */
	public static function getAuthUser( $username, $password )
	{
		self::init();
		
		// Select one item by primary key in Database
		$result = Database::selectOne("SELECT `" . static::$primaryKey . "` FROM `" . static::$table . "` WHERE `username` = ? AND `password` = ?", $username, $password);		
		if( $result == null )
		{
			return null;
		}
		
		// Return usser id
		return $result[static::$primaryKey];
	}
}

