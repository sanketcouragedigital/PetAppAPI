<?php
require_once '../dao/ClinicDetailsDAO.php';
class ClinicDetails
{
	
    
    private $currentPage;

    
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }
  
    public function showingClinicDetails($currentPage) {
        $showClinicDetailsDAO = new ClinicDetailsDAO();
        $this->setCurrentPage($currentPage);
        $returnShowClinicDetails = $showClinicDetailsDAO->showDetail($this);
        return $returnShowClinicDetails;
    }  
}
?> 