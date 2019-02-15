<?php

class TaskModel extends Model
{	
	protected static $table = "tasks";
	protected static $primaryKey = "task_id";
	protected static $default = [ "status" => 1 ];
	
	/**
     * Return Collection of paggination items
     *
     * @param  int  $page
     * @param  array  $sortType
     * @param  int  $perPage
     * @return Collection
     */
	public static function pageItems( $page = 1, $sort = [0, 0], $perPage = 3 )
	{
		$orderBy = static::$primaryKey;
		switch( $sort[0] )
		{
			case 1:
				$orderBy = 'username';
				break;
			case 2:
				$orderBy = 'email';
				break;
			case 3:
				$orderBy = 'status';
				break;
		}
		$orderDir = $sort[1] == 0 ? 'ASC' : 'DESC';
		
		$start = ($page - 1) * $perPage;
		$result = DataBase::select("SELECT * FROM `" . static::$table . "` ORDER BY `$orderBy` $orderDir LIMIT $start, $perPage");
		
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

