<?php
require_once '../dao/ClinicFeedbackDetailsDAO.php';
class ClinicFeedbackDetails
{
    private $clinicRatings;
    private $clinicFeedback;
	private $email;
	private $clinicId;
	private $currentPage;
		
	public function setEmail($email) {
        $this->email = $email;
    }   
    public function getEmail() {
        return $this->email;
    }
	public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }   
    public function getCurrentPage() {
        return $this->currentPage;
    }	
	public function setClinicId($clinicId) {
        $this->clinicId = $clinicId;
    }   
    public function getClinicId() {
        return $this->clinicId;
    }
    public function setClinicRatings($clinicRatings) {
        $this->clinicRatings = $clinicRatings;
    }
    public function getClinicRatings() {
        return $this->clinicRatings;
    }
    public function setClinicFeedback($clinicFeedback) {
        $this->clinicFeedback = $clinicFeedback;
    }
    public function getClinicFeedback() {
        return $this->clinicFeedback;
    }
    public function mapIncomingClinicFeedbackDetails($clinicRatings, $clinicFeedback,$email,$clinicId) {
        $this->setClinicRatings($clinicRatings);
        $this->setClinicFeedback($clinicFeedback);
		$this->setEmail($email);
		$this->setClinicId($clinicId);
    }    
     public function SavingClinicFeedbackDetails() {
        $showClinicFeedbackDAO = new ClinicFeedbackDetailsDAO();    
        $returnshowClinicFeedbackDAODetails = $showClinicFeedbackDAO->SavingClinicFeedback($this);
        return $returnshowClinicFeedbackDAODetails;
    }
	public function showingClinicReviews($currentPage,$clinicId) {
        $showClinicReviewsDAO = new ClinicFeedbackDetailsDAO();
		$this->setCurrentPage($currentPage);
		$this->setClinicId($clinicId);
        $returnShowReviewsList = $showClinicReviewsDAO->ShowClinicReviews($this);
        return $returnShowReviewsList;
    } 	
}
?>