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
	
	/**
     * Select & return all results.
     *
	 * @param  string  $query
	 * [ @param  mixed  ...$placeholders ]
     * @return PDOStatement
     */
	public static function select($query, ...$placeholders)
	{
		$STH = self::execute($query, $placeholders);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		
		return $STH->fetchAll();
	}
	
	/**
     * Select & return first(one) result.
     *
	 * @param  string  $query
	 * [ @param  mixed  ...$placeholders ]
     * @return PDOStatement
     */
	public static function selectOne($query, ...$placeholders)
	{
		$STH = self::execute($query, $placeholders);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		
		return $STH->fetch();
	}
	
	/**
     * Insert & return affected rows count(result).
     *
	 * @param  string  $query
	 * [ @param  mixed  ...$placeholders ]
     * @return PDOStatement
     */
	public static function insert($query, ...$placeholders)
	{
		$STH = self::execute($query, $placeholders);
		
		return $STH->rowCount();
	}
	
	/**
     * Update & return affected rows count(result).
     *
	 * @param  string  $query
	 * [ @param  mixed  ...$placeholders ]
     * @return PDOStatement
     */
	public static function update($query, ...$placeholders)
	{
		$STH = self::execute($query, $placeholders);
		
		return $STH->rowCount();
	}
	
	/**
     * Delete & return affected rows count(result).
     *
	 * @param  string  $query
	 * [ @param  mixed  ...$placeholders ]
     * @return PDOStatement
     */
	public static function delete($query, ...$placeholders)
	{
		$STH = self::execute($query, $placeholders);
		
		return $STH->rowCount();
	}
	
	/**
     * Prepare & execute query with placeholders by DBH.
     *
	 * @param  string  $query
	 * @param  array  $placeholders
     * @return PDOStatement
     */
	protected static function execute($query, $placeholders)
	{
		$STH = self::$DBH->prepare($query);
		$STH->execute($placeholders);
		
		return $STH;
	}
}