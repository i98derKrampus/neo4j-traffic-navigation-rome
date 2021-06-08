<?php

class Raskrizje extends Tocka
{
    
	function __construct( $id, $x, $y, $lat, $lon )
	{
		$this->lat = $lat;
        $this->lon = $lon;
		$this->id = $id;
		$this->x = $x;
		$this->y = $y;
	}	

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>