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
		if( Session::has("auth") )
		{
			Router::redirectNow("/");
		}
		
		return View::main( ["tpl" => "signinPage"], [ "title" => "Authorization" ]);
	}
	
	/**
     * Signin
     *
	 * @param  Request  $request
     * @return object
     */
	public function signin( Request $request )
	{
		// if request not contains required parameters
		if( !isset( $request->username ) || !isset( $request->password ) )
		{
			Session::message("Fill all necessary fields", "warning");
			Router::redirectNow("/signin");
		}
		
		$password = md5( CONFIG_WEB["password_salt"][0] . md5( $request->password . CONFIG_WEB["password_salt"][1] ) . strtolower($request->username) );
		
		$id = UserModel::getAuthUser( $request->username, $password );
		
		// check auth status
		if( $id == null )
		{
			Session::message("Incorrect username or password", "danger");
			return $this->signinPage( $request );
		}
		
		Session::set("auth", $id);
		Session::message("Login successful", "success");
		Router::redirectNow("/");
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

