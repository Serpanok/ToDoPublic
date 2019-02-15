<?php

abstract class Model
{
	/**
     * Name of the table associated with the model
     *
     * @var string
     */
	protected static $table = null;
	
	/**
     * Name of the field which is the primary key
     *
     * @var string
     */
	protected static $primaryKey = 'id';
	
	/**
     * Default values of the attributes in new object
     *
     * @var array
     */
	protected static $default = [];
	
	/**
     * The attributes that should be hidden from object
     *
     * @var array
     */
    protected static $hidden = [ "password" ];
	
	/**
     * List of object attributes
     *
     * @var array
     */
    protected $attributes = [];
	
	/**
	 * @param  array  $default		Default values of attributes
     * @return void
     */
	public function __construct( $default = array() )
	{
		$attributes = array_merge(static::$default, $default);
		self::setAttributes($this, $attributes);
    }
	
	/**
	 * Getter of object attributes.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function __get( $name )
	{
		return isset( $this->attributes[ $name ] ) ? $this->attributes[ $name ] : null;
	}
	
	/**
	 * Setter of input item.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function __set( $name, mixed $value )
	{
		$this->attributes[$name] = $value;
	}
	
	public function __isset( $name )
	{
		return isset( $this->attributes[ $name ] );
	}
	
	public function __unset( $name ) 
    {
        unset( $this->attributes[ $name ] );
    }
	
	/**
     * Find Model by primary key.
     *
	 * @param  int  $primaryKey
     * @return object
     */
	public static function find( $primaryKey )
	{
		self::init();
		
		// Select one item by primary key in Database
		$result = Database::selectOne("SELECT * FROM `" . static::$table . "` WHERE `" . static::$primaryKey . "` = ?", $primaryKey);		
		if( $result == null )
		{
			return null;
		}
		
		// Create & return new object of Model
		return self::newItem($result);
	}
	
	/**
     * Find all Models.
     *
     * @return Collection
     */
	public static function all()
	{
		self::init();
		
		$collection = new Collection();
		
		$result = DataBase::select("SELECT * FROM `" . static::$table . "`");
		
		if( $result !== null )
		{
			foreach( $result as $item )
			{
				$collection->items[] = self::newItem($item);
			}
		}
		
		return $collection;
	}
	
	/**
     * Delete Model form Database.
     *
     * @return int
     */
	public function delete()
	{
		if( !isset($this->attributes[static::$primaryKey]) || $this->attributes[static::$primaryKey] <= 0 )
		{
			return false;
		}
		
		return DataBase::delete("DELETE FROM `" . static::$table . "` WHERE `" . static::$primaryKey . "` = ?", $this->attributes[static::$primaryKey]);
	}
	
	/**
     * Create new object of Model & set attributes.
     *
	 * @param  array  $result
     * @return object
     */
	protected static function newItem( $result = array() )
	{
		$class = get_called_class();
		$item = new $class;
		
		self::setAttributes($item, $result);
		
		return $item;
	}
	
	/**
     * Set attributes in object by array.
     *
	 * @param  Model  $object
	 * @param  array  $attributes
     * @return void
     */
	protected static function setAttributes( Model &$object, array $attributes )
	{
		foreach($attributes as $key => $value)
		{
			if( array_search($key, static::$hidden) === false )
			{
				$object->attributes[$key] = $value;
			}
		}
	}
	
	/**
     * Static constructor(init). Use for set static::$table by class name(ex: UserModel -> users).
     *
     * @return void
     */
	protected static function init()
	{
		if( static::$table === null )
		{
			// set the table name by Model name
			// Ex: UserModel -> users
			static::$table = strtolower( preg_replace('/Model$/', '', get_called_class()) ) . "s";
		}
	}
}