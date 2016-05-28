<?php
require_once 'EmailGenarator.php';
class OrderConfirmationEmail
{
	private $orderedId;
	private $productId;
	private $productName;
	private $productPrice;
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
	
	
	public function setProductName($productName) {
        $this->productName = $productName;
    }    
    public function getProductName() {
        return $this->productName;
    }
	
	public function setOrderedId($orderedId) {
        $this->orderedId = $orderedId;
    }    
    public function getOrderedId() {
        return $this->orderedId;
    }
	
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
	
    public function GeneraeEmailForUserVendor($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode){
		$this->setOrderedId($orderedId);
        $this->setProductId($productId);
		$this->setProductName($productName);
        $this->setProductPrice($productPrice);
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
		//email for customer	
		$returnEmailForUser = new OrderConfirmationEmail();		
        $returnEmailForUser -> GenarateEmailForUSer($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode);		
		//email for us		
		$returnEmailForVendor = new OrderConfirmationEmail();		
        $returnEmailForVendor -> GenarateEmailForPeto($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode);	
		$returnEmailSuccessMessage = "EMAIL_SUCCESSFUULY_SENT";
		return $returnEmailSuccessMessage;					
    }
	// send email to user for order conformation..
	public function GenarateEmailForUSer($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode){        
		$emailSender = new EmailGenarator();
        $emailSender->setTo($email);//write user mail id
        $emailSender->setFrom('From: orders@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendUser($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode));
        $emailSender->setSubject("Thank you for shopping with Peto !");// from petapp email
        $returnEmailForUser =  $emailSender->sendEmail($emailSender);
		if($returnEmailForUser==true){
			return returnEmailForUser;
		}else {
			$emailSender->sendEmail($emailSender);
		}		
    } 
    public function createMessageToSendUser($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode){
        $emailMessage="Hi $name,  \n\nWe are so glad that you have invested in your pet ! Hope he/she will enjoy your new gift.\nBelow are your order details. In case you have any questions please contact us with these order details. We will do our best to provide you all the information you need. Thank you once again.  \n\n Product Details : \n  Order No : $orderedId \n  Product Name : $productName \n  Product Price : $productPrice \n  Product Quantity : $quantity \n  Shipping Charges : $shippingCharges \n  Total Price : $productTotalPrice \n\n The Shippment will be sent to : \n  Address : $buildingname \n  Area : $area \n  City : $city \n  Pin Code : $pincode \n  Mobile No : $mobileno \n ";			
		return $emailMessage;
    }
	
	public function GenarateEmailForPeto($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode){
        $emailSender = new EmailGenarator();
        $emailSender->setTo('orders@petoandme.com');//write user mail id
        $emailSender->setFrom('From: orders@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendPeto($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode));
        $emailSender->setSubject("New Order Confirmation");// from petapp email      
		$returnEmailForPeto =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForPeto==true){
			return returnEmailForPeto;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToSendPeto($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode){
        $emailMessage="Hi   \n\n New order Generated!  \n\nCustomer Details : \n  Customer Name : $name \n  Customer Email : $email \n  Customer Contact No : $mobileno \n  Address : $buildingname \n  Area : $area \n  City : $city \n  Pin Code : $pincode \n\n Product Details \n  Order Id : $orderedId \n  Product Id : $productId \n  Product Name : $productName \n  Product Price : $productPrice \n  Product Quantity : $quantity \n  Shipping Charges : $shippingCharges \n  Total Price : $productTotalPrice \n ";	       
		return $emailMessage;
    }
    
}
?>