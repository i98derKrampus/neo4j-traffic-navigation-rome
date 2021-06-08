<?php 

class MainController extends BaseController
{
    public function index() 
	{
		// Kontroler koji prikazuje popis svih usera
		$ns = new Navigacija();


		$this->registry->template->title = 'Navigacija';
        $this->registry->template->loi = $ns->getLOIById('155');
		if(!isset($_SESSION["pt1"])){
			$this->registry->template->pt1 = " nije odabrano";
		} else{
			$this->registry->template->pt1 =
				 " " . ($_SESSION["pt1"]->lat) . "N " . ($_SESSION["pt1"]->lon) . "E";
		}
		if(!isset($_SESSION["pt2"])){
			$this->registry->template->pt2 = " nije odabrano";
		} else{
			$this->registry->template->pt2 =
				 " " . ($_SESSION["pt2"]->lat) . "N " . ($_SESSION["pt2"]->lon) . "E";
		}
        $this->registry->template->show( 'main' );
	}
}

?>