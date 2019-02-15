<?php

class View
{
	/**
	 * Render and return view with attributes.
	 *
	 * @param  string  $view
	 * @param  array  $attributes
	 * @param  array  $settings
	 * @return string
	 */
	public static function render( $view, array $attributes = array(), $settings = array() )
	{
		$smarty = self::prepareSmarty( $attributes, $settings );
		
		return $smarty->fetch($view . ".tpl");
	}
	
	/**
     * Name of main teamplate
     *
     * @var string
     */
	public static $mainTpl = "main";
	
	/**
	 * Render and return view with main teamplate.
	 *
	 * @param  mixed  $content
	 * @param  array  $attributes
	 * @param  array  $settings
	 * @return string
	 */
	public static function main( $content, array $attributes = array(), $settings = array() )
	{
		if( static::$mainTpl === null )
		{
			return $content;
		}
		
		$attributes["_messages"] = Session::pullMessages();
		$attributes["_auth"] = Session::has("auth");
		
		$smarty = self::prepareSmarty( $attributes, $settings );
		
		// render content by tpl name
		if( is_array($content) )
		{
			if( isset($content["tpl"]) )
			{
				$content = self::render(
					$content["tpl"], 
					isset($content["attributes"]) ? $content["attributes"] : array()
				);
			}
			else
			{
				$content = "";
			}
		}
		
		$smarty->assign("content", $content);
		
		return $smarty->fetch(static::$mainTpl . ".tpl");
	}
	
	/**
	 * Return prepeared Smarty object
	 *
	 * @param  array  $attributes
	 * @param  array  $settings
	 * @return Smarty
	 */
	protected static function prepareSmarty( array $attributes = array(), $settings = array() )
	{
		$smarty = new Smarty;
		
		$smarty->template_dir = __DIR__ . '/../views';
		$smarty->compile_dir = __DIR__ . '/../views/compile';
		
		// set smarty attributes
		foreach( $attributes as $key => $value )
		{
			$smarty->assign($key, $value);
		}
		
		// set smarty settings
		foreach( $settings as $attr => $value )
		{
			$smarty->$attr = $value;
		}
		
		return $smarty;
	}
}

