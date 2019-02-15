<?php

class AuthMiddleware extends Middleware
{
	/**
	 * Passes only authorized users.
	 *
	 * @param  Request  $request
	 * @return int
	 */
	public function handle( Request $request )
	{
		if( Session::has("auth") )
		{
			return 200;
		}
		
		Router::redirectNow("/signin");
		return 401;
	}
}

