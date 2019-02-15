<?php

class Collection
{
	/**
     * List of models
     *
     * @var array
     */
	public $items = [];
	
	public function __construct( $items = array() )
	{
		$this->items = $items;
    }
}