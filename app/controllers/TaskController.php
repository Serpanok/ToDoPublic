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
	public function page( Request $request, $page = 1 )
	{
		$tasks = TaskModel::all();
		
		$content = View::render("tasksList", [
			"tasks" => $tasks->items,
		]);
		
		return View::main($content, [ "promo" => true, "title" => "Public ToDo list" ]);
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

