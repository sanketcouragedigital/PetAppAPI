<?php
require_once '../dao/PetServicesDAO.php';
class PetServices
{
	
    private $currentPage;
    private $image;
    private $imageName;
    private $name;
    private $description;
    private $address;
    private $city;
    private $area;
    private $contact;
    private $email;
    private $timing;
	
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function setImage($image) {
        $this->image = $image;
    }
    
    public function getImage() {
        return $this->image;
    }

    public function setImageName($imageName) {
        $this->imageName = $imageName;
    }
    
    public function getImageName() {
        return $this->imageName;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setAddress($address) {
        $this->address = $address;
    }
    
    public function getAddress() {
        return $this->address;
    }

    public function setCity($city) {
        $this->city = $city;
    }
    
    public function getCity() {
        return $this->city;
    }

    public function setArea($area) {
        $this->area = $area;
    }
    
    public function getArea() {
        return $this->area;
    }

    public function setContact($contact) {
        $this->contact = $contact;
    }
    
    public function getContact() {
        return $this->contact;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function setTiming($timing) {
        $this->timing = $timing;
    }
    
    public function getTiming() {
        return $this->timing;
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

    public function savingGroomerForDesktopDetails($groomerImage, $groomerImageName, $groomerName, $description, $groomerAddress, $groomerArea, $groomerCity, $contactNo, $email, $timing) {
        $this->setImage($groomerImage);
        $this->setImageName($groomerImageName);
        $this->setName($groomerName);
        $this->setDescription($description);
        $this->setAddress($groomerAddress);
        $this->setArea($groomerArea);
        $this->setCity($groomerCity);
        $this->setContact($contactNo);
        $this->setEmail($email);
        $this->setTiming($timing);
        $saveGroomerDetailsDAO = new PetServicesDAO();
        $returnSaveGroomerDetails = $saveGroomerDetailsDAO->saveGroomerDetailsFromDesktop($this);
        return $returnSaveGroomerDetails;
    }

    public function savingShelterForDesktopDetails($shelterImage, $shelterImageName, $shelterName, $description, $shelterAddress, $shelterArea, $shelterCity, $contactNo, $email, $timing) {
        $this->setImage($shelterImage);
        $this->setImageName($shelterImageName);
        $this->setName($shelterName);
        $this->setDescription($description);
        $this->setAddress($shelterAddress);
        $this->setArea($shelterArea);
        $this->setCity($shelterCity);
        $this->setContact($contactNo);
        $this->setEmail($email);
        $this->setTiming($timing);
        $saveShelterDetailsDAO = new PetServicesDAO();
        $returnSaveShelterDetails = $saveShelterDetailsDAO->saveShelterDetailsFromDesktop($this);
        return $returnSaveShelterDetails;
    }

    public function savingTrainerForDesktopDetails($trainerImage, $trainerImageName, $trainerName, $description, $trainerAddress, $trainerArea, $trainerCity, $contactNo, $email, $timing) {
        $this->setImage($trainerImage);
        $this->setImageName($trainerImageName);
        $this->setName($trainerName);
        $this->setDescription($description);
        $this->setAddress($trainerAddress);
        $this->setArea($trainerArea);
        $this->setCity($trainerCity);
        $this->setContact($contactNo);
        $this->setEmail($email);
        $this->setTiming($timing);
        $saveTrainerDetailsDAO = new PetServicesDAO();
        $returnSaveTrainerDetails = $saveTrainerDetailsDAO->saveTrainerDetailsFromDesktop($this);
        return $returnSaveTrainerDetails;
    }
}
?>