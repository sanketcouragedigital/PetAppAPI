<?php
require_once 'EmailGenarator.php';
class DonationEmails
{	
    private $email;
	private $ngoOwnerEmail;

    public function setEmail($email) {
        $this->email = $email;
    }    
    public function getEmail() {
        return $this->email;
    }
	
	public function setNgoOwnerEmail($ngoOwnerEmail) {
        $this->ngoOwnerEmail = $ngoOwnerEmail;
    }    
    public function getNgoOwnerEmail() {
        return $this->ngoOwnerEmail;
    }
	
    public function SendDonationEmail($email,$ngoOwnerEmail){
		
        $this->setEmail($email);
		$this->setNgoOwnerEmail($ngoOwnerEmail);
       	   
		//email for customer	
		$returnEmailForUser = new DonationEmails();		
        $returnEmailForUser -> GenarateEmailForDonar($email,$ngoOwnerEmail);		
		//email for us		
		$returnEmailForVendor = new DonationEmails();		
        $returnEmailForVendor -> GenarateEmailForNgoOwner($email,$ngoOwnerEmail);	
		//email to peto
		$returnEmailForVendor = new DonationEmails();		
        $returnEmailForVendor -> GenarateEmailForPeto($email,$ngoOwnerEmail);	
		
		$returnEmailSuccessMessage = "EMAIL_SUCCESSFUULY_SENT";
		return $returnEmailSuccessMessage;					
    }
	// send email to user for Donation Success..
	public function GenarateEmailForDonar($email,$ngoOwnerEmail){        
		$emailSender = new EmailGenarator();
        $emailSender->setTo($email);//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: donations@petoandme.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendUser($email,$ngoOwnerEmail));
        $emailSender->setSubject("Thank you for donation !");// from petapp email
        $returnEmailForUser =  $emailSender->sendEmail($emailSender);
		if($returnEmailForUser==true){
			return returnEmailForUser;
		}else {
			$emailSender->sendEmail($emailSender);
		}		
    } 
    public function createMessageToSendUser($email,$ngoOwnerEmail){
        $emailMessage="\n hi \ndonation successfully done";		
		return $emailMessage;
    }
	// send email to NGO Owner for Donation Success..
	public function GenarateEmailForNgoOwner($email,$ngoOwnerEmail){
        $emailSender = new EmailGenarator();
        $emailSender->setTo($ngoOwnerEmail);//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: donations@couragedigital.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendNgoOwner($email,$ngoOwnerEmail));
        $emailSender->setSubject("New donation");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToSendNgoOwner($email,$ngoOwnerEmail){
        $emailMessage="\n hi \ndonation successfully done";	      
		return $emailMessage;
    }
	//email to peto
	public function GenarateEmailForPeto($email,$ngoOwnerEmail){
        $emailSender = new EmailGenarator();
        $emailSender->setTo('donations@petoandme.com');//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: donations@couragedigital.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendPeto($email,$ngoOwnerEmail));
        $emailSender->setSubject("New donation");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToSendPeto($email,$ngoOwnerEmail){
        $emailMessage="\n hi \n donation successfully done";	 
		return $emailMessage;
    }
    
}
?>