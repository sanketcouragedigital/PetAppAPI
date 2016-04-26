<?php
require_once '../dao/WishListDetailsDAO.php';
class WishListDetails
{
	private $email;
	private $listId;
	private $currentPage;
		
	public function setEmail($email) {
        $this->email = $email;
    }   
    public function getEmail() {
        return $this->email;
    }	
	
	public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }   
    public function getCurrentPage() {
        return $this->currentPage;
    }
	
	public function setListId($listId) {
        $this->listId = $listId;
    }   
    public function getListId() {
        return $this->listId;
    }
	  
     public function savePetWishList($email,$listId) {
        $showWishListDetailsDAO = new WishListDetailsDAO();    
		$this->setEmail($email);
		$this->setListId($listId);
        $returnSaveWishListDetailsDAO = $showWishListDetailsDAO->petWishListSave($this);
        return $returnSaveWishListDetailsDAO;
    }
	public function savePetMateWishList($email,$listId) {
        $showWishListDetailsDAO = new WishListDetailsDAO();
		$this->setEmail($email);
		$this->setListId($listId);
        $returnSaveWishListDetailsDAO = $showWishListDetailsDAO->petMateWishListSave($this);
        return $returnSaveWishListDetailsDAO;
    } 	
	
	public function showingPetListWishList($email,$currentPage) {
        $showWishListDetailsDAO = new WishListDetailsDAO();
		$this->setEmail($email);	
		$this->setCurrentPage($currentPage);		
        $returnshowWishListDetailsDAO = $showWishListDetailsDAO->showPetWishList($this);
        return $returnshowWishListDetailsDAO;
	}
	public function showingPetMateListWishList($email,$currentPage) {
        $showWishListDetailsDAO = new WishListDetailsDAO();
		$this->setEmail($email);
		$this->setCurrentPage($currentPage);
        $returnshowWishListDetailsDAO = $showWishListDetailsDAO->showPetMateWishList($this);
        return $returnshowWishListDetailsDAO;
	}
	public function deletingWishListPetList($listId,$email) {
        $deleteWishListPetListDAO = new WishListDetailsDAO();
        $this->setListId($listId);
		$this->setEmail($email);
        $returnDeleteWishListPetListDetails = $deleteWishListPetListDAO->deleteWishListPetList($this);
        return $returnDeleteWishListPetListDetails;
    }
	
	public function deletingWishListPetMateList($listId,$email) {
        $deleteWishListPetMateListDAO = new WishListDetailsDAO();
        $this->setListId($listId);
		$this->setEmail($email);
        $returnDeleteWishListPetMateListDetails = $deleteWishListPetMateListDAO->deleteWishListPetMateList($this);
        return $returnDeleteWishListPetMateListDetails;
    } 	
}
?>