<?php

class Tocka
{
	protected $id, $x, $y, $lat, $lon;

	function __construct( $id, $x, $y, $lat, $lon, $name )
	{
		$this->lat = $lat;
		$this->lon = $lon;
		$this->id = $id;
		$this->x = $x;
		$this->y = $y;
		$this->name = $name;
	}	

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>