<?php

class TaskModel extends Model
{	
	protected static $table = "tasks";
	protected static $primaryKey = "task_id";
	
	/**
     * Return Collection of paggination items
     *
     * @param  int  $page
     * @return Collection
     */
	public static function pageItems( $page = 1, $perPage = 3 )
	{
		$start = ($page - 1) * $perPage;
		$result = DataBase::select("SELECT * FROM `" . static::$table . "` LIMIT $start, $perPage");
		
		return self::newCollection($result);
	}
}

