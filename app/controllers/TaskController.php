<?php

class TaskController extends Controller
{
	public function page( $request, $page = 1 )
	{
		$tasks = TaskModel::all();
		
		//printf("<pre>%s</pre>", print_r($tasks, true));
		
		return View::render("index");
	}
}