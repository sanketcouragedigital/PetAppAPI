<?php
require_once '../dao/PetServicesDAO.php';
class PetServices
{
	
    private $currentPage;
	
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }
	
  
    public function showingPetShelter($currentPage) {
        $showPetServicesDAO = new PetServicesDAO();
        $this->setCurrentPage($currentPage);		
        $returnshowPetShelter = $showPetServicesDAO->showPetShelter($this);
        return $returnshowPetShelter;
    } 
	public function showingStores($currentPage) {
        $showPetServicesDAO = new PetServicesDAO();
        $this->setCurrentPage($currentPage);
        $returnshowStores = $showPetServicesDAO->showStores($this);
        return $returnshowStores;
    } 	
	public function showingGroomer($currentPage) {
        $showPetServicesDAO = new PetServicesDAO();
        $this->setCurrentPage($currentPage);		
        $returnShowshowGroomer = $showPetServicesDAO->showGroomer($this);
        return $returnShowshowGroomer;
    } 
	public function showingTrainer($currentPage) {
        $showPetServicesDAO = new PetServicesDAO();
        $this->setCurrentPage($currentPage);
        $returnShowshowTrainer = $showPetServicesDAO->showTrainer($this);
        return $returnShowshowTrainer;
    } 	
}
?> 