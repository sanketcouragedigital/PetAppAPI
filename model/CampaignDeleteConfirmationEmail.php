<?php
require_once 'EmailGenarator.php';
class CampaignDeleteConfirmationEmail
{
	private $campaignId;
	private $campaignName;
	private $ngoName;
	private $ngoEmail;
	private $lastDate;
	private $postDate;
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
	
	public function setPostDate($postDate) {
        $this->postDate = $postDate;
    }    
    public function getPostDate() {
        return $this->postDate;
    }
	
	public function setUserEmail($userEmail) {
        $this->userEmail = $userEmail;
    }    
    public function getUserEmail() {
        return $this->userEmail;
    }
	
    public function EmailToDeleteCampaignForUserVendor($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$postDate,$userEmail,$mobileNo){
		$this->setCampaignId($campaignId);
        $this->setCampaignName($campaignName);		
        $this->setNgoName($ngoName);
		$this->setNgoEmail($ngoEmail);
        $this->setLastDate($lastDate);
		$this->setPostDate($postDate);
		$this->setUserEmail($userEmail);
		$this->setMobileNo($mobileNo);
		//email for customer	
		$returnEmailForUser = new CampaignDeleteConfirmationEmail();		
        $returnEmailForUser -> GenarateEmailForDeleteCampaign($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$postDate,$userEmail);		
		//email to NGo	
		$returnEmailForVendor = new CampaignDeleteConfirmationEmail();		
        $returnEmailForVendor -> GenarateEmailForUseConfirmation($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$postDate,$userEmail,$mobileNo);	
		$returnEmailSuccessMessage = "EMAIL_SUCCESSFUULY_SENT_FOR_DELETE_CAMPAIGN";
		return $returnEmailSuccessMessage;					
    }
	// send email to user for order conformation..
	public function GenarateEmailForUseConfirmation($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$postDate,$userEmail,$mobileNo){        
		$emailSender = new EmailGenarator();
        $emailSender->setTo($ngoEmail);//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: peto@couragedigital.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessage($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$postDate,$userEmail,$mobileNo));
        $emailSender->setSubject("Delete Campaign");// from petapp email
        $returnEmailForUser =  $emailSender->sendEmail($emailSender);
		if($returnEmailForUser==true){
			return returnEmailForUser;
		}else {
			$emailSender->sendEmail($emailSender);
		}		
    } 
    public function createMessage($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$postDate,$userEmail,$mobileNo){
        $emailMessage="Dear $ngoName,\nWe would like to caution you that the campaign $campaignName you have created on $postDate will be expiring on $lastDate.\nPlease visit our dashboard if you would like to extend the campaign, else it will be removed. If you have any further questions or concerns please feel free to contact us at: donations@petoandme.com\nThank you,\nTeam Peto";			
		return $emailMessage;
    }
	
	public function GenarateEmailForDeleteCampaign($campaignId,$campaignName,$ngoName,$ngoEmail,$postDate,$lastDate,$userEmail){
        $emailSender = new EmailGenarator();
        $emailSender->setTo('orders@petoandme.com');//write user mail id
        $emailSender->setFrom('From: orders@petoandme.com' . "\r\n" . 'Reply-To: peto@couragedigital.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToPeto($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$postDate,$userEmail));
        $emailSender->setSubject("Delete Campaign");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToPeto($campaignId,$campaignName,$ngoName,$ngoEmail,$lastDate,$postDate,$userEmail){
        $emailMessage="Hi Peto,  \n\n  Delete this campaign,\n\n Camoaign Id	$campaignId \n Camoaign Name	$campaignName \n NGO Name	$ngoName \n NGO Email	$ngoEmail \n Camoaign Posting Date		$postDate \n Camoaign Claosing Date		$lastDate \n User Email		$userEmail \n User Mobile No	$mobileNo.\n";	       
		return $emailMessage;
    }
    
}
?>