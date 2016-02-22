<?php
require_once '../dao/MyListingDAO.php';
class MyListing
{
    private $currentPage;
	private $email;
	private $id;
	private $categoryOfPet;
	private $breedOfPet;
	private $petAgeInMonth;
	private $petAgeInYear;
	private $genderOfPet;
	private $descriptionOfPet;
	private $adoptionOfPet;
	private $priceOfPet;
    
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
	
	public function setId($id) {
        $this->id = $id;
    }    
    public function getId() {
        return $this->id;
    }
	
	public function setCategoryOfPet($categoryOfPet) {
		$this -> categoryOfPet = $categoryOfPet;
	}

	public function getCategoryOfPet() {
		return $this -> categoryOfPet;
	}

	public function setBreedOfPet($breedOfPet) {
		$this -> breedOfPet = $breedOfPet;
	}

	public function getBreedOfPet() {
		return $this -> breedOfPet;
	}

	public function setPetAgeInMonth($petAgeInMonth) {
		$this -> petAgeInMonth = $petAgeInMonth;
	}

	public function getPetAgeInMonth() {
		return $this -> petAgeInMonth;
	}

	public function setPetAgeInYear($petAgeInYear) {
		$this -> petAgeInYear = $petAgeInYear;
	}

	public function getPetAgeInYear() {
		return $this -> petAgeInYear;
	}

	public function setGenderOfPet($genderOfPet) {
		$this -> genderOfPet = $genderOfPet;
	}

	public function getGenderOfPet() {
		return $this -> genderOfPet;
	}

	public function setDescriptionOfPet($descriptionOfPet) {
		$this -> descriptionOfPet = $descriptionOfPet;
	}

	public function getDescriptionOfPet() {
		return $this -> descriptionOfPet;
	}

	public function setAdoptionOfPet($adoptionOfPet) {
		$this -> adoptionOfPet = $adoptionOfPet;
	}

	public function getAdoptionOfPet() {
		return $this -> adoptionOfPet;
	}

	public function setPriceOfPet($priceOfPet) {
		$this -> priceOfPet = $priceOfPet;
	}

	public function getPriceOfPet() {
		return $this -> priceOfPet;
	}
    public function mapIncomingModifiedPetDetailsParams($id,$categoryOfPet, $breedOfPet, $petAgeInMonth, $petAgeInYear, $genderOfPet, $descriptionOfPet, $adoptionOfPet, $priceOfPet, $email) {
		$this -> setCategoryOfPet($categoryOfPet);
		$this -> setBreedOfPet($breedOfPet);
		$this -> setPetAgeInMonth($petAgeInMonth);
		$this -> setPetAgeInYear($petAgeInYear);
		$this -> setGenderOfPet($genderOfPet);
		$this -> setDescriptionOfPet($descriptionOfPet);
		$this -> setAdoptionOfPet($adoptionOfPet);
		$this -> setPriceOfPet($priceOfPet);
		$this -> setEmail($email);
		$this -> setId($id);
	}

	public function savingModifiedPetDetails() {
		$saveMyListingPetDetailsDAO = new MyListingDAO();
		$returnPetDetailSaveSuccessMessage = $saveMyListingPetDetailsDAO -> saveModifiedPetDetail($this);
		return $returnPetDetailSaveSuccessMessage;
	}

public function mapIncomingModifiedPetMateDetailsParams($id, $categoryOfPet, $breedOfPet, $petAgeInMonth, $petAgeInYear, $genderOfPet, $descriptionOfPet, $email) {
		$this -> setCategoryOfPet($categoryOfPet);
		$this -> setBreedOfPet($breedOfPet);
		$this -> setPetAgeInMonth($petAgeInMonth);
		$this -> setPetAgeInYear($petAgeInYear);
		$this -> setGenderOfPet($genderOfPet);
		$this -> setDescriptionOfPet($descriptionOfPet);
		$this -> setEmail($email);
		$this -> setId($id);
	}

	public function savingModifiedPetMateDetails() {
		$saveMyListingPetMateDetailsDAO = new MyListingDAO();
		$returnPetMateDetailSaveSuccessMessage = $saveMyListingPetMateDetailsDAO -> saveModifiedPetMateDetail($this);
		return $returnPetMateDetailSaveSuccessMessage;
	}

  
 	public function showingMyListingPetList($currentPage,$email) {
        $showMyListingPetListDAO = new MyListingDAO();
        $this->setCurrentPage($currentPage);
		$this->setEmail($email);
        $returnShowMyListingPetListDetails = $showMyListingPetListDAO->showMyListingPetList($this);
        return $returnShowMyListingPetListDetails;
    }
	
	public function showingMyListingPetMateList($currentPage,$email) {
        $showMyListingPetMateListDAO = new MyListingDAO();
        $this->setCurrentPage($currentPage);
		$this->setEmail($email);
        $returnShowMyListingPetMateListDetails = $showMyListingPetMateListDAO->showMyListingPetMateList($this);
        return $returnShowMyListingPetMateListDetails;
    } 	
	
	public function deletingMyListingPetList($id,$email) {
        $deleteMyListingPetListDAO = new MyListingDAO();
        $this->setId($id);
		$this->setEmail($email);
        $returnDeleteMyListingPetListDetails = $deleteMyListingPetListDAO->deleteMyListingPetList($this);
        return $returnDeleteMyListingPetListDetails;
    }
	
	public function deletingMyListingPetMateList($id,$email) {
        $deleteMyListingPetMateListDAO = new MyListingDAO();
        $this->setId($id);
		$this->setEmail($email);
        $returnDeleteMyListingPetMateListDetails = $deleteMyListingPetMateListDAO->deleteMyListingPetMateList($this);
        return $returnDeleteMyListingPetMateListDetails;
    } 	
}
?> 