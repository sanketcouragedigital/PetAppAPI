<?php
require_once '../dao/PremiumListDetailsDAO.php';
class PremiumListDetails
{
	private $first_image_tmp;   
    private $first_image_target_path;
    private $firstName;    
	private $lastName;
	private $description;
    private $timing;
    private $listPosition;
	private $listPrice;	
    private $postDate;   		
    private $email;	
	private $date_booking_from;
	private $date_booking_to;
	private $adv_date_booking_from;
	private $adv_date_booking_to;
	private $adv_booking;
	
	
	public function setAdv_booking($adv_booking) {
        $this->adv_booking = $adv_booking;
    }    
    public function getAdv_booking() {
        return $this->adv_booking;
    }
	
	public function setAdv_date_booking_to($adv_date_booking_to) {
        $this->adv_date_booking_to = $adv_date_booking_to;
    }    
    public function getAdv_date_booking_to() {
        return $this->adv_date_booking_to;
    }
	
	public function setAdv_date_booking_from($adv_date_booking_from) {
        $this->adv_date_booking_from = $adv_date_booking_from;
    }    
    public function getAdv_date_booking_from() {
        return $this->adv_date_booking_from;
    }
	
	public function setDate_booking_to($date_booking_to) {
        $this->date_booking_to = $date_booking_to;
    }    
    public function getDate_booking_to() {
        return $this->date_booking_to;
    }
	
	public function setDate_booking_from($date_booking_from) {
        $this->date_booking_from = $date_booking_from;
    }    
    public function getDate_booking_from() {
        return $this->date_booking_from;
    }

	public function setListPrice($listPrice) {
        $this->listPrice = $listPrice;
    }
    
    public function getListPrice() {
        return $this->listPrice;
    }
	
    public function setFirstImageTemporaryName($first_image_tmp) {
        $this->first_image_tmp = $first_image_tmp;
    }
    
    public function getFirstImageTemporaryName() {
        return $this->first_image_tmp;
    }
    
    public function setTargetPathOfFirstImage($first_image_target_path) {
        $this->first_image_target_path = $first_image_target_path;
    }
    
    public function getTargetPathOfFirstImage() {
        return $this->first_image_target_path;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }    
    public function getFirstName() {
        return $this->firstName;
    }

    public function setDescription($description) {
        $this->description = $description;
    }    
    public function getDescription() {
        return $this->description;
    }
		
	 public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    public function getLastName() {
        return $this->lastName;
    } 
	
    public function setTiming($timing) {
        $this->timing = $timing;
    }
    
    public function getTiming() {
        return $this->timing;
    }

    public function setListPosition($listPosition) {
        $this->listPosition = $listPosition;
    }
    
    public function getListPosition() {
        return $this->listPosition;
    }
    
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function setPostDate($postDate) {
        $this->postDate = $postDate;
    }
    
    public function getPostDate() {
        return $this->postDate;
    }
	
	public function setLastDate($lastDate) {
        $this->lastDate = $lastDate;
    }
    
    public function getLastDate() {
        return $this->lastDate;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }    
    public function getEmail() {
        return $this->email;
    }	   
	
	 

    public function mapIncomingTrainerDetailsParams($first_image_tmp, $first_image_target_path, $firstName, $description, $lastName, $timing, $listPosition, $listPrice, $postDate, $adv_booking,$date_booking_from, $date_booking_to, $adv_date_booking_from, $adv_date_booking_to, $email) {
        $this->setFirstImageTemporaryName($first_image_tmp);
        $this->setTargetPathOfFirstImage($first_image_target_path);		       
        $this->setFirstName($firstName);
        $this->setDescription($description);
		$this->setLastName($lastName);
        $this->setTiming($timing);
        $this->setListPosition($listPosition);   
		$this->setListPrice($listPrice);   		
		$this->setPostDate($postDate);
		$this->setAdv_booking($adv_booking);
		$this->setDate_booking_from($date_booking_from);
		$this->setDate_booking_to($date_booking_to);
		$this->setAdv_date_booking_from($adv_date_booking_from);
		$this->setAdv_date_booking_to($adv_date_booking_to);
        $this->setEmail($email);		
    }

    public function savingTrainerDetails() {
        $savePremiumListDetailsDAO = new PremiumListDetailsDAO();
        $returnTrainerDetailSaveSuccessMessage = $savePremiumListDetailsDAO->saveTrainerDetail($this);
        return $returnTrainerDetailSaveSuccessMessage;
    }
	
	public function showingTrainer($currentPage) {
        $showPetServicesDAO = new PremiumListDetailsDAO();
        $this->setCurrentPage($currentPage);
        $returnShowTrainer = $showPetServicesDAO->showTrainerPremiumListWise($this);
        return $returnShowTrainer;
    }
	public function checkListAvailability($listPosition) {
        $showPetServicesDAO = new PremiumListDetailsDAO();
        $this->setListPosition($listPosition);
        $returnShowTrainer = $showPetServicesDAO->showListAvailability($this);
        return $returnShowTrainer;
    }
	
	
 
}
?>