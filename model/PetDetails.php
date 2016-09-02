<?php
require_once '../dao/PetDetailsDAO.php';
class PetDetails
{
	private $first_image_tmp;
    private $second_image_tmp;
    private $third_image_tmp;
    private $first_image_target_path;
    private $second_image_target_path;
    private $third_image_target_path;
    private $categoryOfPet;
    private $breedOfPet;
    private $ageInMonth;
	private $ageInYear;
    private $genderOfPet;
    private $descriptionOfPet;
    private $adoptionOfPet;
    private $priceOfPet;
    private $postDate;
    private $currentPage;
    private $email;
	private $alternateNo;
    private $deviceId;
	private $latitude;
	private $longitude;
	
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
    public function setFirstImageTemporaryName($first_image_tmp) {
        $this->first_image_tmp = $first_image_tmp;
    }    
    public function getFirstImageTemporaryName() {
        return $this->first_image_tmp;
    }    
    public function setSecondImageTemporaryName($second_image_tmp) {
        $this->second_image_tmp = $second_image_tmp;
    }    
    public function getSecondImageTemporaryName() {
        return $this->second_image_tmp;
    }    
    public function setThirdImageTemporaryName($third_image_tmp) {
        $this->third_image_tmp = $third_image_tmp;
    }    
    public function getThirdImageTemporaryName() {
        return $this->third_image_tmp;
    }
    public function setTargetPathOfFirstImage($first_image_target_path) {
        $this->first_image_target_path = $first_image_target_path;
    }    
    public function getTargetPathOfFirstImage() {
        return $this->first_image_target_path;
    }    
    public function setTargetPathOfSecondImage($second_image_target_path) {
        $this->second_image_target_path = $second_image_target_path;
    }    
    public function getTargetPathOfSecondImage() {
        return $this->second_image_target_path;
    }    
    public function setTargetPathOfThirdImage($third_image_target_path) {
        $this->third_image_target_path = $third_image_target_path;
    }    
    public function getTargetPathOfThirdImage() {
        return $this->third_image_target_path;
    }
    public function setCategoryOfPet($categoryOfPet) {
        $this->categoryOfPet = $categoryOfPet;
    }    
    public function getCategoryOfPet() {
        return $this->categoryOfPet;
    }
    public function setBreedOfPet($breedOfPet) {
        $this->breedOfPet = $breedOfPet;
    }    
    public function getBreedOfPet() {
        return $this->breedOfPet;
    }
    public function setAgeInMonth($ageInMonth) {
        $this->ageInMonth = $ageInMonth;
    }    
    public function getAgeInMonth() {
        return $this->ageInMonth;
    }	
	 public function setAgeInYear($ageInYear) {
        $this->ageInYear = $ageInYear;
    }
    public function getAgeInYear() {
        return $this->ageInYear;
    }
    public function setGenderOfPet($genderOfPet) {
        $this->genderOfPet = $genderOfPet;
    }    
    public function getGenderOfPet() {
        return $this->genderOfPet;
    }
    public function setDescriptionOfPet($descriptionOfPet) {
        $this->descriptionOfPet = $descriptionOfPet;
    }    
    public function getDescriptionOfPet() {
        return $this->descriptionOfPet;
    }
    public function setAdoptionOfPet($adoptionOfPet) {
        $this->adoptionOfPet = $adoptionOfPet;
    }    
    public function getAdoptionOfPet() {
        return $this->adoptionOfPet;
    }
    public function setPriceOfPet($priceOfPet) {
        $this->priceOfPet = $priceOfPet;
    }    
    public function getPriceOfPet() {
        return $this->priceOfPet;
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
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }	
	public function setAlternateNo($alternateNo) {
        $this->alternateNo = $alternateNo;
    }
    public function getAlternateNo() {
        return $this->alternateNo;
    }    
    public function setDeviceId($deviceId) {
        $this->deviceId = $deviceId;
    }    
    public function getDeviceId() {
        return $this->deviceId;
    }

    //public function mapIncomingPetDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $categoryOfPet, $breedOfPet, $ageInMonth, $ageInYear, $genderOfPet, $descriptionOfPet, $adoptionOfPet, $priceOfPet, $postDate, $email, $alternateNo, $deviceId) {
		public function mapIncomingPetDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $categoryOfPet, $breedOfPet, $ageInMonth, $ageInYear, $genderOfPet, $descriptionOfPet, $postDate, $email, $alternateNo, $deviceId) {
        $this->setFirstImageTemporaryName($first_image_tmp);
        $this->setSecondImageTemporaryName($second_image_tmp);
        $this->setThirdImageTemporaryName($third_image_tmp);
        $this->setTargetPathOfFirstImage($first_image_target_path);
        $this->setTargetPathOfSecondImage($second_image_target_path);
        $this->setTargetPathOfThirdImage($third_image_target_path);
        $this->setCategoryOfPet($categoryOfPet);
        $this->setBreedOfPet($breedOfPet);
        $this->setAgeInYear($ageInYear);
		$this->setAgeInMonth($ageInMonth);
        $this->setGenderOfPet($genderOfPet);
        $this->setDescriptionOfPet($descriptionOfPet);
       // $this->setAdoptionOfPet($adoptionOfPet);
        //$this->setPriceOfPet($priceOfPet);
		$this->setPostDate($postDate);
        $this->setEmail($email);
		$this->setAlternateNo($alternateNo);
        $this->setDeviceId($deviceId);
    }

    //public function mapIncomingPetForDesktopDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $categoryOfPet, $breedOfPet, $ageInMonth, $ageInYear, $genderOfPet, $descriptionOfPet, $adoptionOfPet, $priceOfPet, $postDate, $email, $alternateNo, $deviceId) {
	public function mapIncomingPetForDesktopDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $categoryOfPet, $breedOfPet, $ageInMonth, $ageInYear, $genderOfPet, $descriptionOfPet, $postDate, $email, $alternateNo, $deviceId) {
        $this->setFirstImageTemporaryName($first_image_tmp);
        $this->setSecondImageTemporaryName($second_image_tmp);
        $this->setThirdImageTemporaryName($third_image_tmp);
        $this->setTargetPathOfFirstImage($first_image_target_path);
        $this->setTargetPathOfSecondImage($second_image_target_path);
        $this->setTargetPathOfThirdImage($third_image_target_path);
        $this->setCategoryOfPet($categoryOfPet);
        $this->setBreedOfPet($breedOfPet);
        $this->setAgeInYear($ageInYear);
        $this->setAgeInMonth($ageInMonth);
        $this->setGenderOfPet($genderOfPet);
        $this->setDescriptionOfPet($descriptionOfPet);
        //$this->setAdoptionOfPet($adoptionOfPet);
        //$this->setPriceOfPet($priceOfPet);
        $this->setPostDate($postDate);
        $this->setEmail($email);
        $this->setAlternateNo($alternateNo);
        $this->setDeviceId($deviceId);
    }

    public function savingPetDetails() {
        $savePetDetailsDAO = new PetDetailsDAO();
        $returnPetDetailSaveSuccessMessage = $savePetDetailsDAO->saveDetail($this);
        return $returnPetDetailSaveSuccessMessage;
    }

    public function savingPetForDesktopDetails() {
        $savePetDetailsDAO = new PetDetailsDAO();
        $returnPetDetailSaveSuccessMessage = $savePetDetailsDAO->saveForDesktopDetail($this);
        return $returnPetDetailSaveSuccessMessage;
    }
	
	public function showingPetDetailsForDesktop($currentPage) {
        $showPetDetailsDAO = new PetDetailsDAO();
        $this->setCurrentPage($currentPage);
        $returnShowPetDetails = $showPetDetailsDAO->showDetailForDesktop($this);
        return $returnShowPetDetails;
    }
	public function showingUserWishList($email) {
        $showshowUserWishListDAO = new PetDetailsDAO();
        $this->setEmail($email);
        $returnShowPetDetails = $showshowUserWishListDAO->showUserWishList($this);
        return $returnShowPetDetails;
    }
	public function showingPetDetails($currentPage) {
        $showPetDetailsDAO = new PetDetailsDAO();
        $this->setCurrentPage($currentPage);
        $returnShowPetDetails = $showPetDetailsDAO->showDetail($this);
        return $returnShowPetDetails;
    }
    
    public function showingRefreshPetDetails($date) {
        $showPetRefreshListDetailsDAO = new PetDetailsDAO();
        $this->setPostDate($date);
        $returnShowPetDetails = $showPetRefreshListDetailsDAO->showRefreshListDetail($this);
        return $returnShowPetDetails;
    }
    // public function showingPetDetailsWithNearlyLocated($currentPage,$latitude,$longitude) {
        // $showPetDetailsDAO = new PetDetailsDAO();
        // $this->setCurrentPage($currentPage);
		// $this->setLatitude($latitude);
		// $this->setLongitude($longitude);
        // $returnShowPetDetails = $showPetDetailsDAO->showDetailWithNearlyLocated($this);
        // return $returnShowPetDetails;
    // }
    
    // public function showingRefreshPetDetailsWithNearlyLocated($date,$latitude,$longitude) {
        // $showPetRefreshListDetailsDAO = new PetDetailsDAO();
        // $this->setPostDate($date);
		// $this->setLatitude($latitude);
		// $this->setLongitude($longitude);
        // $returnShowPetDetails = $showPetRefreshListDetailsDAO->showRefreshListDetailWithNearlyLocated($this);
        // return $returnShowPetDetails;
    // }
	
}
?>