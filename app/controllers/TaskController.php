<?php

class TaskController extends Controller
{
	public function page( $request, $page = 1 )
	{
		$tasks = TaskModel::all();
		
		$content = View::render("tasksList", [
			"tasks" => $tasks->items,
		]);
		
		return View::main($content, [ "promo" => true, "title" => "Public ToDo list" ]);
	}
}

