<?php

class AuthController extends Controller
{
	/**
     * Render signin page.
     *
	 * @param  Request  $request
     * @return object
     */
	public function signinPage( Request $request )
	{
		return View::main( ["tpl" => "signinPage"], [ "title" => "Authorization" ]);
	}
	
	/**
     * Signout.
     *
	 * @param  Request  $request
     * @return void
     */
	public function signout( Request $request )
	{
		Session::message("Logout successful", "success");
		
		Router::redirectNow("/");
	}
}

