<?php

abstract class Middleware
{
	/**
	 * Return filtration result.
	 *
	 * @param  Request  $request
	 * @return int
	 */
	public function handle( Request $request )
	{
		return 200;
	}
}

