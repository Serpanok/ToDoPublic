<?php

class UserController extends Controller
{
	public function ping( $request )
	{
		return sprintf("ping-ping!<br><br>time: %d", time());
	}
	
	public function userPage( $request, $user_id )
	{
		$user = UserModel::find($user_id);
		
		if( $user === null )
		{
			Router::terminate(404);
		}
		
		return sprintf("User page<br><br>id: %d<br>Username: %s", $user_id, $user->username);
	}
}