<?php

class UserController extends Controller
{
	public function ping( $request )
	{
		return sprintf("ping-ping!<br><br>time: %d", time());
	}
	
	public function userPage( $request, $user_id )
	{
		return sprintf("User page<br><br>id: %d", $user_id);
	}
}