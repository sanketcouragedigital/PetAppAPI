<?php
require_once '../dao/WhishListDetailsDAO.php';
class WhishListDetails
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
        $showWhishListDetailsDAO = new WhishListDetailsDAO();    
		$this->setEmail($email);
		$this->setListId($listId);
        $returnSaveWhishListDetailsDAO = $showWhishListDetailsDAO->petWishListSave($this);
        return $returnSaveWhishListDetailsDAO;
    }
	public function savePetMateWishList($email,$listId) {
        $showWhishListDetailsDAO = new WhishListDetailsDAO();
		$this->setEmail($email);
		$this->setListId($listId);
        $returnSaveWhishListDetailsDAO = $showWhishListDetailsDAO->petMateWishListSave($this);
        return $returnSaveWhishListDetailsDAO;
    } 	
	
	public function showingPetListWishList($email,$currentPage) {
        $showWhishListDetailsDAO = new WhishListDetailsDAO();
		$this->setEmail($email);	
		$this->setCurrentPage($currentPage);		
        $returnshowWhishListDetailsDAO = $showWhishListDetailsDAO->showPetWishList($this);
        return $returnshowWhishListDetailsDAO;
	}
	public function showingPetMateListWishList($email,$currentPage) {
        $showWhishListDetailsDAO = new WhishListDetailsDAO();
		$this->setEmail($email);
		$this->setCurrentPage($currentPage);
        $returnshowWhishListDetailsDAO = $showWhishListDetailsDAO->showPetMateWishList($this);
        return $returnshowWhishListDetailsDAO;
	}
}
?>