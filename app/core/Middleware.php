<?php

abstract class Middleware
{
	/**
	 * Return filtration result.
	 *
	 * @param  Request  $request
	 * @return boolean
	 */
	public function handle( Request $request )
	{
		return true;
	}
}

