<?php
require_once '../dao/ShopProductDetailsDAO.php';
class ShopProductDetails
{
	
    private $postDate;
    private $currentPage;
	private $email;
   
    
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
   
    public function showingProductDetails($currentPage) {
        $showProductDetailsDAO = new ShopProductDetailsDAO();
        $this->setCurrentPage($currentPage);	
        $returnShowProductDetails = $showProductDetailsDAO->showProductDetail($this);
        return $returnShowProductDetails;
    }
    
    public function showingProductRefreshPetDetails($date) {
        $showProductRefreshListDetailsDAO = new ShopProductDetailsDAO();
        $this->setPostDate($date);
        $returnShowProductDetails = $showProductRefreshListDetailsDAO->showingRefreshProductDetails($this);
        return $returnShowProductDetails;
    }
}
?>