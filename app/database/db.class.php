<?php

class DB
{
	private static $db = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection() 
	{
		if( DB::$db === null )
	    {
	    	DB::$db = Laudis\Neo4j\ClientBuilder::create()
			->addHttpConnection('backup', 'http://neo4j:delta@localhost')
			->addBoltConnection('default', 'bolt://neo4j:delta@localhost')
			->setDefaultConnection('default')
			->build();
	    }
		return DB::$db;
	}
}

?>
