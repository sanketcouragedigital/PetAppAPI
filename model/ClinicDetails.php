<?php
require_once '../dao/ClinicDetailsDAO.php';
class ClinicDetails
{
	
    
    private $currentPage;
	private $latitude;
	private $longitude;
	private $email;

    
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }
	 public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }
    
    public function getLatitude() {
        return $this->latitude;
    }
    
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }
    
    public function getLongitude() {
        return $this->longitude;
    }
	
	 public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
  
    public function showingClinicByCurrentLocation($currentPage,$email) {
        $showClinicDetailsDAO = new ClinicDetailsDAO();
        $this->setCurrentPage($currentPage);
		$this->setLatitude($latitude);
		$this->setLongitude($longitude);
		$this->setEmail($email);
        $returnShowClinicDetails = $showClinicDetailsDAO->showByCurrentLocation($this);
        return $returnShowClinicDetails;
    } 
	public function showingClinicByAddress($currentPage,$email) {
        $showClinicDetailsDAO = new ClinicDetailsDAO();
        $this->setCurrentPage($currentPage);
		$this->setEmail($email);
        $returnShowClinicDetails = $showClinicDetailsDAO->showByAddress($this);
        return $returnShowClinicDetails;
    } 	
}
?> 