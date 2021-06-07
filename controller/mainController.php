<?php 

class MainController extends BaseController
{
    public function index() 
	{
		// Kontroler koji prikazuje popis svih usera
		$ns = new Navigacija();


		$this->registry->template->title = 'Navigacija';
        $this->registry->template->loi = $ns->getLOIById('155');
        $this->registry->template->show( 'main' );
	}
}

?>