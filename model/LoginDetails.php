<?php
require_once '../dao/LoginDetailsDAO.php';
require_once 'RandomNoGenarator.php';
require_once 'EmailGenarator.php';

class LoginDetails
{
    private $email;
    private $password;
    private $randomNoForUser;
    private $activationCode;
    private $newPassword;
    
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setRandomNoForUser($randomNoForUser) {
        $this->randomNoForUser = $randomNoForUser;
    }
    
    public function getRandomNoForUser() {
        return $this->randomNoForUser;
    }
    public function setActivationCode($activationCode) {
        $this->activationCode = $activationCode;
    }
    
    public function getActivationCode() {
        return $this->activationCode;
    }
     public function setNewPassword($newPassword) {
        $this->newPassword = $newPassword;
    }
    
    public function getNewPassword() {
        return $this->newPassword;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getPassword() {
        return $this->password;
    }
//for login
    public function CheckingUsersDetails($email,$password) {
        $this->setEmail($email);
        $this->setPassword($password);
        $showLoginDetailsDAO = new LoginDetailsDAO();
        $returnShowLoginDetails = $showLoginDetailsDAO->loginDetail($this);
        return $returnShowLoginDetails;
    }
    public function SettingNewPassword($activationCode,$newPassword,$email) {
        $this->setActivationCode($activationCode);
        $this->setNewPassword($newPassword);
        $this->setEmail($email);
        $newPasswordDetailsDAO = new LoginDetailsDAO();
        $returnNewPasswordDetails = $newPasswordDetailsDAO->setNewPassword($this);
        return $returnNewPasswordDetails;
    }
 //checkin mail valid user or not..
    public function CheckingEmail($email) {
        $this->setEmail($email);
        $showLoginDetailsDAO = new LoginDetailsDAO();
        $returnShowLoginDetails = $showLoginDetailsDAO->emailDetail($this);
        return $returnShowLoginDetails;
    }
    
     public function GenarateRandomNo($email) {
        //Call RandomNoGenarator class to create Random no
        $this->setEmail($email);
        $randomno = new RandomNoGenarator();
        $genaratedRandomNo = $randomno->GenarateCode(6);
        $this->setRandomNoForUser($genaratedRandomNo);
        
        // call GenarateEmailForUSer to send Randomno to user
        $returnSuccessRandomNo = $this->GenarateEmailForUSer();
        
        //call LoginDetailsDAO to save random no as per user 
        $saveRandomNoDAO= new LoginDetailsDAO();
        $returnSuccessRandomNo = $saveRandomNoDAO->savingRandomNo($this);
        return $returnSuccessRandomNo;
    }
    //Call Email Class to create email for user
    public function GenarateEmailForUSer(){
        $emailSender = new EmailGenarator();
        $emailSender->setTo($this->getEmail());//write user mail id
        $emailSender->setFrom("abc@petapp.com");//write pet App mail id
        $emailSender->setMessage($this->createMessageToSendUser());
        $emailSender->setSubject("Password Recovery Code");// from petapp email
        return $emailSender->sendEmail($emailSender);
        
    } 
    public function createMessageToSendUser(){
        $emailMessage="Your activation code is ".$this->getRandomNoForUser();
        return $emailMessage;
    }
}
?>