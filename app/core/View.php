<?php

class View
{
	/**
	 * Renver and return view with attributes.
	 *
	 * @param  string  $view
	 * @param  array  $attributes
	 * @param  array  $settings
	 * @return string
	 */
	public static function render( $view, array $attributes = array(), $settings = array() )
	{
		$smarty = new Smarty;
		$smarty->template_dir = __DIR__ . '/../views';
		$smarty->compile_dir = __DIR__ . '/../views/compile';
		
		foreach( $attributes as $key => $value )
		{
			$smarty->assign($key, $value);
		}
		
		foreach( $settings as $attr => $value )
		{
			$smarty->$attr = $value;
		}
		
		return $smarty->fetch($view . ".tpl");
	}
}

