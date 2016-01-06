<?php
require_once '../dao/PetMateDetailsDAO.php';
class PetMateDetails
{
	private $image_tmp;
    private $target_path;
    private $categoryOfPet;
    private $breedOfPet;
    private $ageOfPet;
    private $genderOfPet;
    private $descriptionOfPet;
	private $postDate;
	private $currentPage;
    private $email;

    public function setImageTemporaryName($image_tmp) {
        $this->image_tmp = $image_tmp;
    }
    
    public function getImageTemporaryName() {
        return $this->image_tmp;
    }

    public function setTargetPathOfImage($target_path) {
        $this->target_path = $target_path;
    }
    
    public function getTargetPathOfImage() {
        return $this->target_path;
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

    public function setAgeOfPet($ageOfPet) {
        $this->ageOfPet = $ageOfPet;
    }
    
    public function getAgeOfPet() {
        return $this->ageOfPet;
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
    public function mapIncomingPetMateDetailsParams($image_tmp, $target_path, $categoryOfPet, $breedOfPet, $ageOfPet, $genderOfPet, $descriptionOfPet,$postDate, $email) {
        $this->setImageTemporaryName($image_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setCategoryOfPet($categoryOfPet);
        $this->setBreedOfPet($breedOfPet);
        $this->setAgeOfPet($ageOfPet);
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
        $showPateDetailsDAO = new PetMateDetailsDAO();
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