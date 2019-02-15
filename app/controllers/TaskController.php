<?php

class TaskController extends Controller
{
	/**
     * Render tasks list page.
     *
	 * @param  Request  $request
	 * @param  string  $page
     * @return object
     */
	public function page( Request $request )
	{
		$pagesCount = TaskModel::pagesCount();
		
		// set page number and check for correct interval
		$page = isset($request->page) ? $request->page : 1;
		if( $page <= 0 )
		{
			$page = 1;
		}
		else if( $page > $pagesCount )
		{
			$page = $pagesCount;
		}
		
		// set sort type and check for correct value
		$sortBy = isset($request->sortBy) ? $request->sortBy : 0;
		if( $sortBy < 0 )
		{
			$sortBy = 0;
		}
		else if( $sortBy > 3 )
		{
			$sortBy = 3;
		}
		// set sort type and check for correct value
		$sortDir = isset($request->sortDir) && $request->sortDir == 1 ? 1 : 0;
		
		// select tasks on this page
		$tasks = TaskModel::pageItems($page, [$sortBy, $sortDir]);
		
		$pagination = View::render("pagination", [
			"pagesCount" => $pagesCount,
			"page" => $page,
			"uri_prfix" => "/?sortBy=$sortBy&sortDir=$sortDir&page=",
		]);
		
		$content = View::render("tasksList", [
			"tasks" => $tasks->items,
			
			"sortByValues" => array(0, 1, 2, 3),
			"sortByNames" => array("Sort by novelty", "Sort by Name", "Sort by Email", "Sort by Status"),
			"sortBySelected" => $sortBy,
			
			"sortDirValues" => array(0, 1),
			"sortDirNames" => array("Ascending", "Descending"),
			"sortDirSelected" => $sortDir,
		]);
		
		return View::main($content . $pagination, [ "promo" => true, "title" => "Public ToDo list" ]);
	}
	
	/**
     * Create new task.
     *
	 * @param  Request  $request
     * @return object
     */
	public function create( Request $request )
	{
		// if request not contains required parameters
		if( !isset( $request->username ) || !isset( $request->email ) || !isset( $request->text ) )
		{
			Session::message("Fill all necessary fields", "warning");
			Router::redirectNow("/create");
		}
		
		// create new object
		$task = new TaskModel([
			"username" => $request->username,
			"email" => $request->email,
			"text" => $request->text
		]);
		
		// save to DB
		if( $task->save() )
		{
			Session::message("New task successfully added", "success");
		}
		
		Router::redirectNow("/");
	}
}

