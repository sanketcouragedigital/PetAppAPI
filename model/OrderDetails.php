<?php
require_once '../dao/OrderDetailsDAO.php';
require_once 'EmailGenarator.php';
class OrderDetails
{
	private $productId;
	private $quantity;
	private $shippingCharges;
	private $productTotalPrice;
	private $name;
    private $buildingname;
    private $area;
	private $city;
    private $mobileno;
    private $email;
	private $postDate;
	private $currentPage;
	private $pincode;
	
	public function setPincode($pincode) {
        $this->pincode = $pincode;
    }    
    public function getPincode() {
        return $this->pincode;
    }
	
	public function setProductId($productId) {
        $this->productId = $productId;
    }    
    public function getProductId() {
        return $this->productId;
    }
	
	public function setProductPrice($productPrice) {
        $this->productPrice = $productPrice;
    }    
    public function getProductPrice() {
        return $this->productPrice;
    }
	
	public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }    
    public function getQuantity() {
        return $this->quantity;
    }
	
	public function setProductTotalPrice($productTotalPrice) {
        $this->productTotalPrice = $productTotalPrice;
    }    
    public function getProductTotalPrice() {
        return $this->productTotalPrice;
    }
	
	public function setShippingCharges($shippingCharges) {
        $this->shippingCharges = $shippingCharges;
    }    
    public function getShippingCharges() {
        return $this->shippingCharges;
    }
	
    public function setName($name) {
        $this->name = $name;
    }    
    public function getName() {
        return $this->name;
    }

    public function setBuildingname($buildingname) {
        $this->buildingname = $buildingname;
    }    
    public function getBuildingname() {
        return $this->buildingname;
    }

    public function setArea($area) {
        $this->area = $area;
    }    
    public function getArea() {
        return $this->area;
    }
	
	public function setCity($city) {
        $this->city = $city;
    }    
    public function getCity() {
        return $this->city;
    }

    public function setMobileno($mobileno) {
        $this->mobileno = $mobileno;
    }    
    public function getMobileno() {
        return $this->mobileno;
    }

    public function setEmail($email) {
        $this->email = $email;
    }    
    public function getEmail() {
        return $this->email;
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
	
    public function mapIncomingOrderDetailsParams($productId,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode,$postDate) {
        $this->setProductId($productId);
		$this->setQuantity($quantity);			
		$this->setShippingCharges($shippingCharges);	
		$this->setProductTotalPrice($productTotalPrice);		
		$this->setName($name);
		$this->setMobileno($mobileno);
        $this->setEmail($email); 
        $this->setBuildingname($buildingname);
        $this->setArea($area);
		$this->setCity($city); 
		$this->setPincode($pincode); 				
		$this->setPostDate($postDate);
    }

    public function SavingOrderDetails() {
        $saveOrderDetailsDAO = new OrderDetailsDAO();
        $returnOrderDetailsSaveSuccessMessage = $saveOrderDetailsDAO->SaveOrderDetails($this);
        return $returnOrderDetailsSaveSuccessMessage;
    }
    
	public function FetchingOrderDetails($email,$currentPage) {
        $fetchOrderDetailsDAO = new OrderDetailsDAO();
        $this->setEmail($email);
		$this->setCurrentPage($currentPage);		
        $returnFetchOrderDetailsMessage = $fetchOrderDetailsDAO->FetchingOrderDetails($this);
        return $returnFetchOrderDetailsMessage;
    }    
}
?>