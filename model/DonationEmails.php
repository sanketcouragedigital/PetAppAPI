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
	
    public function SendDonationEmail($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount){
		
        $this->setEmail($email);
		$this->setNgoOwnerEmail($ngoOwnerEmail);
       	   
		//email for customer	
		$returnEmailForUser = new DonationEmails();		
        $returnEmailForUser -> GenarateEmailForDonar($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount);		
		//email for us		
		$returnEmailForNgoOwner = new DonationEmails();		
        $returnEmailForNgoOwner -> GenarateEmailForNgoOwner($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount);	
		//email to peto
		$returnEmailForPeto= new DonationEmails();		
        $returnEmailForPeto -> GenarateEmailForPeto($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount);	
		
		$returnEmailSuccessMessage = "EMAIL_SUCCESSFULLY_SENT";
		return $returnEmailSuccessMessage;					
    }
	// send email to user for Donation Success..
	public function GenarateEmailForDonar($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount){        
		$emailSender = new EmailGenarator();
        $emailSender->setTo($donarEmail);//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendDonar($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount));
        $emailSender->setSubject("Thank you for donation !");// from petapp email
        $returnEmailForUser =  $emailSender->sendEmail($emailSender);
		if($returnEmailForUser==true){
			return returnEmailForUser;
		}else {
			$emailSender->sendEmail($emailSender);
		}		
    } 
    public function createMessageToSendDonar($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwner,$donarName,$donarEmail,$donarMobileNo,$donationAmount){
        $emailMessage="Dear $donarName,\n\n\n Thank you for donating Rs $donationAmount towards $campaignName . You have helped a someone today and that is something to be proud of ! \n\nIf you have any questions or concerns or need any assistance with anything else related to your donation please write to us on: donations@petoandme.com\n  \n  \n Thanking you,\n Team Peto";		
		return $emailMessage;
    }
	
	// send email to NGO Owner for Donation Success..
	public function GenarateEmailForNgoOwner($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount){
        $emailSender = new EmailGenarator();
        $emailSender->setTo($ngoOwnerEmail);//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendNgoOwner($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount));
        $emailSender->setSubject("New Donation");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToSendNgoOwner($campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount){
        $emailMessage="Dear $ngoName \n\n\n We have some good news ! A donation of amount Rs $donationAmount has been made by $donarName towards your campaign $campaignName.\n\n You may visit our dashboard to view total amount of donation made so far for your campaign $campaignName by clicking here <link to dashboard> \n\n If you have any questions or concerns please feel free to contact us at: donations@petoandme.com \n\n Thanking you,\n Team Peto";	      
		return $emailMessage;
    }
	
	//email to peto
	public function GenarateEmailForPeto($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount){
        $emailSender = new EmailGenarator();
        $emailSender->setTo('donations@petoandme.com');//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendPeto($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount));
        $emailSender->setSubject("New Donation Done");// from petapp email      
		$returnEmailForVendor =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForVendor==true){
			return returnEmailForVendor;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageToSendPeto($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount){
        $emailMessage="\n Peto,\n\n\n A new donation has been made by user: $donarName and id: $donar_id \n\n\n Details of transaction: \n\n\n Amount: $donationAmount \n Date and time: $donation_Date \n Campaign Name: $campaignName \n Email of user: $donarEmail \n\n\n\n\n Regards,\n Team Peto";	 
		return $emailMessage;
    }
	
	
	//send email to NGO for Imforming that Their campaign will delete after three days
		public function SendCampaignDeleteDateWiseEmail($campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$lastDateOfCampaign,$postedDateOfCampaign){
        $emailSender = new EmailGenarator();
        $emailSender->setTo($ngoOwnerEmail);//write user mail id
        $emailSender->setFrom('From: donations@petoandme.com' . "\r\n" . 'Reply-To: no-reply@app.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion());//write pet App mail id
        $emailSender->setMessage($this->createMessageForNgoToDeleteCampaign($campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$lastDateOfCampaign,$postedDateOfCampaign));
        $emailSender->setSubject("Campaign Delete Notification");// from petapp email      
		$returnEmailForNGO =  $emailSender->sendEmail($emailSender);		
		if($returnEmailForNGO==true){
			return returnEmailForNGO;
		}else {
			$emailSender->sendEmail($emailSender);
		}      
    } 
    public function createMessageForNgoToDeleteCampaign($campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$lastDateOfCampaign,$postedDateOfCampaign){
        $emailMessage="\n Peto,your campaign wil delete after three days.\ncapmapin id= $campaign_id \n campaign name= $campaignName\n NGO name= $ngoName\n Last Date = $lastDateOfCampaign \n Posted Date = $postedDateOfCampaign\n";	 
		return $emailMessage;
    }
    
}
?>