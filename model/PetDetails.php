<?php
require_once '../dao/PetDetailsDAO.php';
class PetDetails
{
	private $image_tmp;
    private $target_path;
    private $categoryOfPet;
    private $breedOfPet;
    private $ageOfPet;
    private $genderOfPet;
    private $descriptionOfPet;
    private $adoptionOfPet;
    private $giveAwayOfPet;
    private $priceOfPet;
    private $postDate;
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

    public function setAdoptionOfPet($adoptionOfPet) {
        $this->adoptionOfPet = $adoptionOfPet;
    }
    
    public function getAdoptionOfPet() {
        return $this->adoptionOfPet;
    }

    public function setGiveAwayOfPet($giveAwayOfPet) {
        $this->giveAwayOfPet = $giveAwayOfPet;
    }
    
    public function getGiveAwayOfPet() {
        return $this->giveAwayOfPet;
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

    public function mapIncomingPetDetailsParams($image_tmp, $target_path, $categoryOfPet, $breedOfPet, $ageOfPet, $genderOfPet, $descriptionOfPet, $adoptionOfPet, $giveAwayOfPet, $priceOfPet, $postDate) {
        $this->setImageTemporaryName($image_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setCategoryOfPet($categoryOfPet);
        $this->setBreedOfPet($breedOfPet);
        $this->setAgeOfPet($ageOfPet);
        $this->setGenderOfPet($genderOfPet);
        $this->setDescriptionOfPet($descriptionOfPet);
        $this->setAdoptionOfPet($adoptionOfPet);
        $this->setGiveAwayOfPet($giveAwayOfPet);
        $this->setPriceOfPet($priceOfPet);
		$this->setPostDate($postDate);
    }

    public function savingPetDetails() {
        $savePetDetailsDAO = new PetDetailsDAO();
        $returnPetDetailSaveSuccessMessage = $savePetDetailsDAO->saveDetail($this);
        return $returnPetDetailSaveSuccessMessage;
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
}
?>