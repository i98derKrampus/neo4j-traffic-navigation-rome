<?php

class Lokacija_od_interesa extends Tocka
{
	protected $name;

	function __construct( $id, $x, $y, $lat, $lon, $name )
	{
		$this->name = $name;
		$this->id = $id;
		$this->x = $x;
		$this->y = $y;
		$this->lon = $lon;
		$this->lat = $lat;
		
	}	

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}


?>

