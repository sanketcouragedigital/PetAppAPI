<?php
require_once '../dao/PetMateDetailsDAO.php';
class PetMateDetails
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
	private $postDate;
	private $currentPage;
    private $email;

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
	
	public function setPostDate($postDate) {
        $this->postDate = $postDate;
    }
    
    public function getPostDate() {
        return $this->postDate;
    }
	public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }
	
	 public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }
    public function mapIncomingPetMateDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $categoryOfPet, $breedOfPet, $ageInMonth, $ageInYear, $genderOfPet, $descriptionOfPet,$postDate, $email) {
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
		$this->setPostDate($postDate);
        $this->setEmail($email);
    }

    public function savingPetMateDetails() {
        $savePetMateDetailsDAO = new PetMateDetailsDAO();
        $returnPetMateDetailSaveSuccessMessage = $savePetMateDetailsDAO->saveDetail($this);
        return $returnPetMateDetailSaveSuccessMessage;
    }
	
   public function showingPetMateDetails($currentPage, $email) {
        $showPetDetailsDAO = new PetMateDetailsDAO();
        $this->setCurrentPage($currentPage);
		$this->setEmail($email);
        $returnShowPetMateDetails = $showPetDetailsDAO->showDetail($this);
        return $returnShowPetMateDetails;
    }
    
    public function showingRefreshPetMateDetails($date,$email) {
        $showPetRefreshListDetailsDAO = new PetMateDetailsDAO();
        $this->setPostDate($date);
		$this->setEmail($email);
        $returnShowPetDetails = $showPetRefreshListDetailsDAO->showRefreshListDetail($this);
        return $returnShowPetDetails;
    }
}
?>