<?php

/*

--
-- MySql for create table in DB
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` smallint(5) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `users`
  MODIFY `user_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

*/

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

