<?php

class Lokacija_od_interesa
{
	protected $id, $name, $x, $y;

	function __construct( $id, $name, $x, $y )
	{
		$this->name = $name;
		$this->id = $id;
		$this->x = $x;
		$this->y = $y;
		
	}	

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}


?>

