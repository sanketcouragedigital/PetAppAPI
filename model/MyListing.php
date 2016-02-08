<?php
require_once '../dao/MyListingDAO.php';
class MyListing
{
    private $currentPage;
	private $email;
	private $id;
    
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