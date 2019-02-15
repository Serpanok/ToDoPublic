<?php

class TaskModel extends Model
{	
	protected static $table = "tasks";
	protected static $primaryKey = "task_id";
	
	/**
     * Return Collection of paggination items
     *
     * @param  int  $page
     * @param  int  $perPage
     * @return Collection
     */
	public static function pageItems( $page = 1, $perPage = 3 )
	{
		$start = ($page - 1) * $perPage;
		$result = DataBase::select("SELECT * FROM `" . static::$table . "` LIMIT $start, $perPage");
		
		return self::newCollection($result);
	}
	
	/**
     * Return pages count
     *
     * @param  int  $perPage
     * @return int
     */
	public static function pagesCount( $perPage = 3 )
	{
		$result = DataBase::selectOne("SELECT COUNT(`" . static::$primaryKey . "`) AS `tasks_count` FROM `" . static::$table . "`");
		
		return ceil($result["tasks_count"] / $perPage);
	}
}

