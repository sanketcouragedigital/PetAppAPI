<?php
require_once '../dao/ClinicDetailsDAO.php';
class ClinicDetails
{
	
    
    private $currentPage;
	private $latitude;
	private $longitude;
	private $email;
    private $clinicImage;
    private $clinicImageName;
    private $clinicName;
    private $doctorName;
    private $clinicAddress;
    private $clinicArea;
    private $clinicCity;
    private $contactNo;
    private $email;
    private $notesOfClinic;

    
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

    public function setClinicImage($clinicImage) {
        $this->clinicImage = $clinicImage;
    }
    
    public function getClinicImage() {
        return $this->clinicImage;
    }

    public function setClinicImageName($clinicImageName) {
        $this->clinicImageName = $clinicImageName;
    }
    
    public function getClinicImageName() {
        return $this->clinicImageName;
    }

    public function setClinicName($clinicName) {
        $this->clinicName = $clinicName;
    }
    
    public function getClinicName() {
        return $this->clinicName;
    }

    public function setDoctorName($doctorName) {
        $this->doctorName = $doctorName;
    }
    
    public function getDoctorName() {
        return $this->doctorName;
    }

    public function setClinicAddress($clinicAddress) {
        $this->clinicAddress = $clinicAddress;
    }
    
    public function getClinicAddress() {
        return $this->clinicAddress;
    }

    public function setClinicArea($clinicArea) {
        $this->clinicArea = $clinicArea;
    }
    
    public function getClinicArea() {
        return $this->clinicArea;
    }

    public function setClinicCity($clinicCity) {
        $this->clinicCity = $clinicCity;
    }
    
    public function getClinicCity() {
        return $this->clinicCity;
    }

    public function setContactNo($contactNo) {
        $this->contactNo = $contactNo;
    }
    
    public function getContactNo() {
        return $this->contactNo;
    }

    public function setNotesOfClinic($notesOfClinic) {
        $this->notesOfClinic = $notesOfClinic;
    }
    
    public function getNotesOfClinic() {
        return $this->notesOfClinic;
    }    
  
    public function showingClinicByCurrentLocation($currentPage,$latitude,$longitude) {
        $showClinicDetailsDAO = new ClinicDetailsDAO();
        $this->setCurrentPage($currentPage);
		$this->setLatitude($latitude);
		$this->setLongitude($longitude);
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

    public function mapIncomingClinicForDesktopDetailsParams($clinicImage, $clinicImageName, $clinicName, $doctorName, $clinicAddress, $clinicArea, $clinicCity, $contactNo, $email, $notesOfClinic) {
        $this->setClinicImage($clinicImage);
        $this->setClinicImageName($clinicImageName);
        $this->setClinicName($clinicName);
        $this->setDoctorName($doctorName);
        $this->setClinicAddress($clinicAddress);
        $this->setClinicArea($clinicArea);
        $this->setClinicCity($clinicCity);
        $this->setContactNo($contactNo);
        $this->setEmail($email);
        $this->setNotesOfClinic($notesOfClinic);
    }

    public function savingClinicForDesktopDetails() {
        $saveClinicDetailsDAO = new ClinicDetailsDAO();
        $returnSaveClinicDetails = $saveClinicDetailsDAO->saveClinicDetailsFromDesktop($this);
        return $returnSaveClinicDetails;
    }
}
?>