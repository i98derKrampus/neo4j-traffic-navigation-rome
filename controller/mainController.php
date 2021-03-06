<?php 

class MainController extends BaseController
{
    public function index() 
	{
		$ns = new Navigacija();
		$this->registry->template->title = 'Navigacija';
		if(!isset($_SESSION["pt1_id"])){
			$this->registry->template->pt1 = " nije odabrano";
			$this->registry->template->pt1_lat = null;
			$this->registry->template->pt1_lon = null;
		} else{
			$pt1 = $ns->getTockaById($_SESSION["pt1_id"]);
			$this->registry->template->pt1 =
				 " " . ($pt1->lat) . "&deg;N " . ($pt1->lon) . "&deg;E";
			$this->registry->template->pt1_lat = $pt1->lat;
			$this->registry->template->pt1_lon = $pt1->lon;
		}
		if(!isset($_SESSION["pt2_id"])){
			$this->registry->template->pt2 = " nije odabrano";
			$this->registry->template->pt2_lat = null;
			$this->registry->template->pt2_lon = null;
		} else{
			$pt2 = $ns->getTockaById($_SESSION["pt2_id"]);
			$this->registry->template->pt2 =
				 " " . ($pt2->lat) . "&deg;N " . ($pt2->lon) . "&deg;E";
			$this->registry->template->pt2_lat = $pt2->lat;
			$this->registry->template->pt2_lon = $pt2->lon;
		}
        $this->registry->template->show( 'main' );
	}

	public function search()
	{
		$ns = new Navigacija();

		if(isset($_POST["add_pt1"]) || isset($_POST["add_pt2"])){
			if(!isset($_POST["source_type"])){
				$this->index();
				return;
			}
			if(!in_array($_POST["source_type"], ["map_centre", "lat_lon"])){
				$this->index();
				return;
			}

			if($_POST["source_type"] === "map_centre"){
				if(!isset($_POST["map_lat"]) || !isset($_POST["map_lon"])){
					$this->index();
					return;
				}
				$latitude  = (float)$_POST["map_lat"];
				$longitude = (float)$_POST["map_lon"];
			}

			if($_POST["source_type"] === "lat_lon"){
				if(!isset($_POST["text_lat"]) ||
					!is_numeric($_POST["text_lat"]) ||
					!isset($_POST["text_lat_smjer"]) ||
					!isset($_POST["text_lon"]) ||
					!is_numeric($_POST["text_lon"]) ||
					!isset($_POST["text_lon_smjer"])
				){
					$this->index();
					return;
				}

				$latitude =  ((float)$_POST["text_lat"]);
				$longitude = ((float)$_POST["text_lon"]);

				if($_POST["text_lat_smjer"] === "S"){
					$latitude *= -1;
				}
				if($_POST["text_lon_smjer"] === "W"){
					$longitude *= -1;
				}
			}

			$tocka = $ns->getClosestTockaFromLatLon($latitude, $longitude);
			if(isset($_POST["add_pt1"])){
				$_SESSION["pt1_id"] = $tocka->id;
			}

			if(isset($_POST["add_pt2"])){
				$_SESSION["pt2_id"] = $tocka->id;
			}

			$this->index();
			return;
		}

		if(isset($_POST["find_path"])){
			if(!isset($_SESSION["pt1_id"]) ||
				!isset($_SESSION["pt2_id"])){
				$this->index();
				return;
			}

			$result = $ns->getShortestPathDijkstra($_SESSION["pt1_id"], $_SESSION["pt2_id"]);
			
			$this->registry->template->title = 'Navigacija';
			$this->registry->template->type = "Najkra??i put";
			$this->registry->template->unit = "m";
			$this->registry->template->totalDistance = $result["totalDistance"];
			$this->registry->template->tocke = $result["tocke"];
			$this->registry->template->distances = $result["distances"];

			$this->registry->template->show('searchresults');
			return;
		}

		if(isset($_POST["find_path_quickest"])){
			if(!isset($_SESSION["pt1_id"]) ||
				!isset($_SESSION["pt2_id"])){
				$this->index();
				return;
			}

			$result = $ns->getQuickestPathDijkstra($_SESSION["pt1_id"], $_SESSION["pt2_id"]);
			
			$this->registry->template->title = 'Navigacija';
			$this->registry->template->type = "Najbr??i put";
			$this->registry->template->unit = "s";
			$this->registry->template->totalDistance = $result["totalTime"];
			$this->registry->template->tocke = $result["tocke"];
			$this->registry->template->distances = $result["times"];

			$this->registry->template->show('searchresults');
			return;
		}

		$this->index();
		return;
	}
}

?>