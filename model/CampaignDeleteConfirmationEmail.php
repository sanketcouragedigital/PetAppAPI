<?php
require_once 'EmailGenarator.php';
class CampaignDeleteConfirmationEmail
{
	private $campaignId;
	private $campaignName;
	private $ngoName;
	private $ngoEmail;
	private $lastDate;
	private $userEmail;
	private $mobileNo;
	
	
	public function setMobileNo($mobileNo) {
        $this->mobileNo = $mobileNo;
    }    
    public function getMobileNo() {
        return $this->mobileNo;
    }
	
	public function setCampaignId($campaignId) {
        $this->campaignId = $campaignId;
    }    
    public function getCampaignId() {
        return $this->campaignId;
    }
	
	public function setCampaignName($campaignName) {
        $this->campaignName = $campaignName;
    }    
    public function getCampaignName() {
        return $this->campaignName;
    }
	
	public function setNgoName($ngoName) {
        $this->ngoName = $ngoName;
    }    
    public function getNgoName() {
        return $this->ngoName;
    }
	
	public function setNgoEmail($ngoEmail) {
        $this->ngoEmail = $ngoEmail;
    }    
    public function getNgoEmail() {
        return $this->ngoEmail;
    }
	
	public function setLastDate($lastDate) {
        $this->lastDate = $lastDate;
    }    
    public function getLastDate() {
        return $this->lastDate;
    }
	
	public function setUserEmail($userEmail) {
        $this->userEmail = $userEmail;
    }    
    public function getUserEmail() {
        return $this->userEmail;
    }
	
    public function EmailToDeleteCampaignForUserVendor($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$userEmail,$mobileNo){
		$this->setCampaignId($campaignId);
        $this->setCampaignName($campaignName);		
        $this->setNgoName($ngoName);
		$this->setNgoEmail($ngoEmail);
        $this->setLastDate($lastDate);
		$this->setUserEmail($userEmail);
		$this->setMobileNo($mobileNo);
		//email for customer	
		//$returnEmailForUser = new CampaignDeleteConfirmationEmail();		
        //$returnEmailForUser -> GenarateEmailForVendor($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$userEmail);		
		//email for us		
		$returnEmailForVendor = new CampaignDeleteConfirmationEmail();		
        $returnEmailForVendor -> GenarateEmailForUseConfirmationr($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$userEmail,$mobileNo);	
		$returnEmailSuccessMessage = "EMAIL_SUCCESSFUULY_SENT_FOR_DELETE_CAMPAIGN";
		return $returnEmailSuccessMessage;					
    }
	// send email to user for order conformation..
	public function GenarateEmailForUseConfirmationr($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$userEmail,$mobileNo){        
		$emailSender = new EmailGenarator();
        $emailSender->setTo('sonawane.ptk@gmail.com');//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: peto@couragedigital.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessage($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$userEmail,$mobileNo));
        $emailSender->setSubject("Delete Campaign");// from petapp email
        $returnEmailForUser =  $emailSender->sendEmail($emailSender);
		if($returnEmailForUser==true){
			return returnEmailForUser;
		}else {
			$emailSender->sendEmail($emailSender);
		}		
    } 
    public function createMessage($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$userEmail,$mobileNo){
        $emailMessage="Hi,  \n\n  Delete this campaign,\n\n Camoaign Id	$campaignId \n Camoaign Name	$campaignName \n NGO Name	$ngoName \n NGO Email	$ngoEmail \n Camoaign Claosing Date		$lastDate \n User Email		$userEmail \n User Mobile No	$mobileNo.\n";			
		return $emailMessage;
    }
	
	/*public function GenarateEmailForVendor($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$userEmail){
        $emailSender = new EmailGenarator();
        $emailSender->setTo('orders@petoandme.com');//write user mail id
        $emailSender->setFrom('From: orders@petoandme.com' . "\r\n" . 'Reply-To: peto@couragedigital.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendVendor($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$userEmail));
        $emailSender->setSubject("New Order Confirmation");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToSendVendor($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$userEmail){
        $emailMessage="Hi   \n\n New order Generated!  \n\nCustomer Details : \n  Customer Name : $name \n  Customer Email : $email \n  Customer Contact No : $mobileno \n  Address : $buildingname \n  Area : $area \n  City : $city \n  Pin Code : $pincode \n\n Product Details \n  Order Id : $orderedId \n  Product Id : $productId \n  Product Name : $productName \n  Product Price : $productPrice \n  Product Quantity : $quantity \n  Shipping Charges : $shippingCharges \n  Total Price : $productTotalPrice \n ";	       
		return $emailMessage;
    }*/
    
}
?>