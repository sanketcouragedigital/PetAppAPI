<?php
require_once 'FeedbackMail.php';
class Feedback
{
    private $email;
    private $feedback;

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setFeedback($feedback) {
        $this->feedback = $feedback;
    }
    
    public function getFeedback() {
        return $this->feedback;
    }

    public function mapIncomingFeedbackParams($email, $feedback) {
        $this->setEmail($email);
        $this->setFeedback($feedback);
    }

    public function sendFeedbackEmailToAdmin() {
        $emailSender = new FeedbackMail();
        $emailSender->setTo("sanketdhotre.dhotre3@gmail.com");
        $emailSender->setFrom($this->email);
        $emailSender->setMessage($this->createEmailMessageBodyForFeedback());
        $emailSender->setSubject("An Email from ".$this->email.".");
        return $emailSender->sendEmail($emailSender);
    }
    
    public function createEmailMessageBodyForFeedback() {
        $emailMessage = "Feedback: ".$this->feedback;
        return $emailMessage;
    }   
}
?>