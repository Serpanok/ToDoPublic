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
     * The flag shows the existence of an object in DB
     *
     * @var boolean
     */
    protected $isExist = false;
	
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
		self::init();
		
		$attributes = array_merge(static::$default, $default);
		self::setAttributes($this, $attributes);
    }
	
	/**
	 * Return attribute of object.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function input( $name )
	{
		return isset( $this->attributes[ $name ] ) ? $this->attributes[ $name ] : null;
	}
	
	/**
	 * Getter of object attributes.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function __get( $name )
	{
		return $this->input( $name );
	}
	
	/**
	 * Setter of input item.
	 *
	 * @param  string  $name
	 * @param  mixed  $value
	 * @return string
	 */
	public function __set( $name, $value )
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
		
		$result = DataBase::select("SELECT * FROM `" . static::$table . "`");
		
		return self::newCollection($result);
	}
	
	/**
     * Save Model changes to Database.
     *
     * @return int
     */
	public function save()
	{
		if( $this->isExist )
		{
			return $this->update();
		}
		else
		{
			return $this->insert();
		}
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
     * Insert object to Database.
     *
     * @return boolean
     */
	protected function insert()
	{
		//prepare placeholders for SQL query
		$placeholders = implode(",", array_fill(0, count($this->attributes), "?"));
		//prepare columns names for SQL query
		$columns = implode( "`,`", array_keys($this->attributes) );
		
		$methodAttributes = array_values($this->attributes);
		// add first method attribute - query
		array_unshift($methodAttributes, "INSERT INTO `" . static::$table . "` (`$columns`) VALUES ($placeholders)");
		
		// inserting
		$result = call_user_func_array("Database::insert", $methodAttributes);
		if( $result )
		{
			$this->isExist = true;
			// set PK
			$this->attributes[static::$primaryKey] = Database::lastInsertId();
			
			return true;
		}
		
		return false;
	}
	
	/**
     * update object in Database.
     *
     * @return boolean
     */
	protected function update()
	{
		$set = array();
		foreach( $this->attributes as $column => $value )
		{
			$set[] = "`$column`=?";
		}
		$set = implode(",", $set);
		
		$methodAttributes = array_values( $this->attributes );
		// add first method attribute - query
		array_unshift($methodAttributes, "UPDATE `" . static::$table . "` SET $set WHERE `" . static::$primaryKey . "` = ?");
		// add last method attribute - primaryKey to WHERE
		$methodAttributes[] = $this->attributes[static::$primaryKey];
		
		// inserting
		return call_user_func_array("Database::update", $methodAttributes);
	}
	
	/**
     * Create new object of Model & set attributes.
     *
	 * @param  array  $result
	 * @param  boolean  $isExist
     * @return object
     */
	protected static function newItem( $result = array(), $isExist = true )
	{
		$class = get_called_class();
		$item = new $class($result);
		
		$item->isExist = $isExist;
		
		return $item;
	}
	
	/**
     * Create new Collection of Models.
     *
	 * @param  array  &$result
     * @return Collection
     */
	protected static function newCollection( &$result = null )
	{
		$collection = new Collection();
		
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