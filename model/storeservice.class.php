<?php

class Navigacija
{
    function getLOIById( $id )
	{
		$db = DB::getConnection();

		$results = $db->run(
			'MATCH (n:Lokacija_od_interes) 
				WHERE n.id = $id
				RETURN n;', //The query is a required parameter
			['id' => $id],  //Parameters can be optionally added
			'backup' //The default connection can be overridden
		);
		foreach($results as $item){
			$row = $item->get('n');
		}
			if( $row === false )
			return null;
		else
			return new Lokacija_od_interesa( $row['id'], $row['name'], $row['x'], $row['y']);
	}

    


};


?>