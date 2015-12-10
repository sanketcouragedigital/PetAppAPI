<?php
require_once '../dao/PetMetDetailsDAO.php';
class PetMetDetails
{
	private $image_tmp;
    private $target_path;
    private $categoryOfPet;
    private $breedOfPet;
    private $ageOfPet;
    private $genderOfPet;
    private $descriptionOfPet;
	private $post_date;
	private $currentPage;

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
	
		public function setPost_date($post_date) {
        $this->post_date = $post_date;
    }
    
    public function getPost_date() {
        return $this->post_date;
    }
	public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }
	
    public function mapIncomingPetMetDetailsParams($image_tmp, $target_path, $categoryOfPet, $breedOfPet, $ageOfPet, $genderOfPet, $descriptionOfPet,$post_date ) {
        $this->setImageTemporaryName($image_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setCategoryOfPet($categoryOfPet);
        $this->setBreedOfPet($breedOfPet);
        $this->setAgeOfPet($ageOfPet);
        $this->setGenderOfPet($genderOfPet);
        $this->setDescriptionOfPet($descriptionOfPet);
		$this->setPost_date($post_date);
    }

    public function savingPetMetDetails() {
        $savePetMetDetailsDAO = new PetMetDetailsDAO();
        $returnPetMetDetailSaveSuccessMessage = $savePetMetDetailsDAO->saveDetail($this);
        return $returnPetMetDetailSaveSuccessMessage;
    }
	
   public function showingPetMetDetails($currentPage) {
        $showPetDetailsDAO = new PetMetDetailsDAO();
        $this->setCurrentPage($currentPage);
        $returnShowPetDetails = $showPetDetailsDAO->showDetail($this);
        return $returnShowPetDetails;
    }
    
    public function showingRefreshPetMetDetails($date) {
        $showPetRefreshListDetailsDAO = new PetMetDetailsDAO();
        $this->setPost_date($date);
        $returnShowPetDetails = $showPetRefreshListDetailsDAO->showRefreshListDetail($this);
        return $returnShowPetDetails;
    }
}
?>