<?php
require_once 'EmailGenarator.php';
class NewRegistrationEmails
{	
	//For NGO Registration
    public function SendNewNGORegistrationEmail($name,$email,$ngoUrl,$ngoName,$numOfRows){
				
		//email for NGO		
		$returnEmailForNgoOwner = new NewRegistrationEmails();
        $returnEmailForNgoOwner -> GenarateEmailForNgo($name,$email,$ngoUrl,$ngoName);	
		
		//email to peto
		$returnEmailForPeto= new NewRegistrationEmails();		
        $returnEmailForPeto -> GenarateNgoRegistrationEmailForPeto($name,$email,$ngoUrl,$ngoName,$numOfRows);	
		
		$returnEmailSuccessMessage = "EMAIL_SUCCESSFULLY_SENT";
		return $returnEmailSuccessMessage;
    }
	
	//For User Registration
	public function SendNewUserRegistrationEmail($name,$email,$numOfRows){
				
		//email for User		
		$returnEmailForNgoOwner = new NewRegistrationEmails();
        $returnEmailForNgoOwner -> GenarateEmailForUser($name,$email);	
		
		//email to peto
		$returnEmailForPeto= new NewRegistrationEmails();		
        $returnEmailForPeto -> GenarateUserRegistrationEmailForPeto($name,$email,$numOfRows);	
		
		$returnEmailSuccessMessage = "EMAIL_SUCCESSFULLY_SENT";
		return $returnEmailSuccessMessage;
    }
	
	// send email to User for New Registration..
	public function GenarateEmailForUser($name,$email){
        $emailSender = new EmailGenarator();
        $emailSender->setTo($email);//write user mail id
        $emailSender->setFrom('From: ourpeto@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendUser($name,$email));
        $emailSender->setSubject("Welcome to Peto");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToSendUser($name,$email){
        $emailMessage="Hey there !\n\n\nThank you so much for downloading and signing up with Peto. We hope to keep you updated with everything related to animals. \nWe are constantly striving hard to aggregate all possible information for you regarding pets or animals. \nPlease do let us know if you have any suggestions or feedback regarding our offerings as we are always open to new ideas and suggestions. \n\nThanking you,\nTeam Peto";	      
		return $emailMessage;
    }
	
	//email to peto for New User Registration.
	public function GenarateUserRegistrationEmailForPeto($name,$email,$numOfRows){
        $emailSender = new EmailGenarator();
        $emailSender->setTo('ourpeto@petoandme.com');//write user mail id
        $emailSender->setFrom('From: ourpeto@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createUserReistrationMessageToSendPeto($name,$email,$numOfRows));
        $emailSender->setSubject("New User Registration");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createUserReistrationMessageToSendPeto($name,$email,$numOfRows){
        $emailMessage="New User Registration Done,\n Username = $name.\nEmail = $email \n Total User = $numOfRows.";	 
		return $emailMessage;
    }
	
	// send email to NGO  for New Registration.
	public function GenarateEmailForNgo($name,$email,$ngoUrl,$ngoName){
        $emailSender = new EmailGenarator();
        $emailSender->setTo($email);//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendNgo($name,$email,$ngoUrl,$ngoName));
        $emailSender->setSubject("Welcome Peto");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToSendNgo($name,$email,$ngoUrl,$ngoName){
        $emailMessage="Hi there ! \nThank you for signing up as an NGO with us. We hope to work together in helping as many animals as possible. Petoandme.com is a venture of CourageComm Solutions Private Limited.  We are focused around animal and pet needs. \nWe will be activating your account post a quick simple verification round done at our end for your NGO. By doing this we ensure that we are donating money for the right needs of animals.\nThank you for being so patient and we hope to establish a long term relationship in working for all needy animals. \nThanking you,\nTeam Peto\n\n";	 ;	      
		return $emailMessage;
    }
	
	//email to peto for New NGO Registration.
	public function GenarateNgoRegistrationEmailForPeto($name,$email,$ngoUrl,$ngoName,$numOfRows){
        $emailSender = new EmailGenarator();
        $emailSender->setTo('ourpeto@petoandme.com');//write user mail id
        $emailSender->setFrom('From: ourpeto@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendPeto($name,$email,$ngoUrl,$ngoName,$numOfRows));
        $emailSender->setSubject("New NGO Registration");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToSendPeto($name,$email,$ngoUrl,$ngoName){
        $emailMessage="New User Registration Done,\n Username = $name.\nNgo Name= $ngoName\nEmail = $email\nNgo Url = $ngoUrl \n Total User = $numOfRows."; 
		return $emailMessage;
    }
    
}
?>