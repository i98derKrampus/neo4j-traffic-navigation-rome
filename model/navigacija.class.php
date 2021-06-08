<?php

class Navigacija
{

	function getTockaById( $id )
	{
		$db = DB::getConnection();

		$results = $db->run(
			'MATCH (n:Tocka) 
				WHERE n.id = $id
				RETURN n;',
			['id' => $id],  
			'backup' 
		);
        $row = false;
		foreach($results as $item){
			$row = $item->get('n');
		}
        
        if( $row === false )
            return null;
		else
			return new Tocka( $row['id'], $row['x'], $row['y'],$row['lat'], $row['lon'], $row['name']);
	}

	function getClosestTockaFromLatLon($lat, $lon){
		$db = DB::getConnection();

		$results = $db->run('MATCH (p:Tocka)
							RETURN p, 2 * 6371 * asin(sqrt(haversin(radians( p.latitude - $lat ))
								+ cos(radians( p.latitude )) * cos(radians( $lat )) *
								haversin(radians( p.longitude - $lon )))) AS dist
							ORDER BY dist ASC
							LIMIT 1;',
							['lat' => $lat, 'lon' => $lon],
							'backup');

		$row = $results[0]->get('p');

		return new Tocka($row['id'], $row['x'], $row['y'], $row['lat'], $row['lon'], $row['name']);
	}

	
	function getShortestPathDijkstra($id1, $id2){
		
		$db = DB::getConnection();
		
		$results = $db->run(
						'MATCH (source:Tocka {id: $id1}), (target:Tocka {id: $id2})
						CALL gds.beta.shortestPath.dijkstra.stream("dijkstratest1", {
							sourceNode: id(source),
							targetNode: id(target),
							relationshipWeightProperty: "distance"
						})
						YIELD index, sourceNode, targetNode, totalCost, nodeIds, costs
						RETURN
							index,
							gds.util.asNode(sourceNode) AS sourceNodeName,
							gds.util.asNode(targetNode) AS targetNodeName,
							totalCost,
							[nodeId IN nodeIds | gds.util.asNode(nodeId).id] AS nodeids,
							costs
						ORDER BY index;',
						['id1' => $id1, 'id2' => $id2],
						'backup'
		);

		$array_nodes_ids = $results[0]->get('nodeids');
		$array_nodes = array();
		$i = 0;
		foreach($array_nodes_ids as $node_id){
			$array_nodes[$i] = $this->getTockaById($node_id);
			$i++;
		}
		$array_distances = $results[0]->get('costs');
		$total_distane = $results[0]->get('totalDistance');
		$final_array = array('totalDistance' => $total_distane,
							'tocke' => $array_nodes,
							'distances' => $array_distances
		);
		return $final_array;
	}

	function getShortestPathAstar($id1, $id2){
		
		$db = DB::getConnection();
		
		$results = $db->run(
						'match (source:Tocka {id:$id1}), (target:Tocka {id:$id2})
						call gds.beta.shortestPath.astar.stream("astartest1",{
							sourceNode: id(source),
							targetNode: id(target),
							latitudeProperty: "latitude",
							longitudeProperty: "longitude",
							relationshipWeightProperty: "distance"
						})
						yield index, sourceNode, targetNode, totalCost, nodeIds, costs
						return
							index,
							gds.util.asNode(sourceNode).name as sourceNodeName,
							gds.util.asNode(targetNode).name as targetNodeName,
							totalCost,
							[nodeId in nodeIds | gds.util.asNode(nodeId).id] as nodeids,
							costs
						order by index',
						['id1' => $id1, 'id2' => $id2],
						'backup'
		);

		$array_nodes_ids = $results[0]->get('nodeids');
		$array_nodes = array();
		$i = 0;
		foreach($array_nodes_ids as $node_id){
			$array_nodes[$i] = $this->getTockaById($node_id);
			$i++;
		}
		$array_distances = $results[0]->get('costs');
		$total_distane = $results[0]->get('totalDistance');
		$final_array = array('totalDistance' => $total_distane,
							'tocke' => $array_nodes,
							'distances' => $array_distances
		);
		return $final_array;


	}

	function getQuickestPathDijkstra($id1, $id2){
		
		$db = DB::getConnection();
		
		$results = $db->run(
						'MATCH (source:Tocka {id: $id1}), (target:Tocka {id: $id2})
						CALL gds.beta.shortestPath.dijkstra.stream("dijkstratest1", {
							sourceNode: id(source),
							targetNode: id(target),
							relationshipWeightProperty: "expected_time"
						})
						YIELD index, sourceNode, targetNode, totalCost, nodeIds, costs
						RETURN
							index,
							gds.util.asNode(sourceNode) AS sourceNodeName,
							gds.util.asNode(targetNode) AS targetNodeName,
							totalCost,
							[nodeId IN nodeIds | gds.util.asNode(nodeId).id] AS nodeids,
							costs
						ORDER BY index;',
						['id1' => $id1, 'id2' => $id2],
						'backup'
		);

		$array_nodes_ids = $results[0]->get('nodeids');
		$array_nodes = array();
		$i = 0;
		foreach($array_nodes_ids as $node_id){
			$array_nodes[$i] = $this->getTockaById($node_id);
			$i++;
		}
		$array_distances = $results[0]->get('costs');
		$total_distane = $results[0]->get('totalTime');
		$final_array = array('totalDistance' => $total_distane,
							'tocke' => $array_nodes,
							'times' => $array_distances
		);
		return $final_array;
	}


	function getquickestPathAstar($id1, $id2){
		
		$db = DB::getConnection();
		
		$results = $db->run(
						'match (source:Tocka {id:$id1}), (target:Tocka {id:$id2})
						call gds.beta.shortestPath.astar.stream("astartest1",{
							sourceNode: id(source),
							targetNode: id(target),
							latitudeProperty: "latitude",
							longitudeProperty: "longitude",
							relationshipWeightProperty: "expected_time"
						})
						yield index, sourceNode, targetNode, totalCost, nodeIds, costs
						return
							index,
							gds.util.asNode(sourceNode).name as sourceNodeName,
							gds.util.asNode(targetNode).name as targetNodeName,
							totalCost,
							[nodeId in nodeIds | gds.util.asNode(nodeId).id] as nodeids,
							costs
						order by index',
						['id1' => $id1, 'id2' => $id2],
						'backup'
		);

		$array_nodes_ids = $results[0]->get('nodeids');
		$array_nodes = array();
		$i = 0;
		foreach($array_nodes_ids as $node_id){
			$array_nodes[$i] = $this->getTockaById($node_id);
			$i++;
		}
		$array_distances = $results[0]->get('costs');
		$total_distane = $results[0]->get('totalDistance');
		$final_array = array('totalTime' => $total_distane,
							'tocke' => $array_nodes,
							'times' => $array_distances
		);
		return $final_array;


	}

};


?>
