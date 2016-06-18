<?php
require_once '../dao/PetServiceFeedbackDetailsDAO.php';
class PetServiceFeedbackDetails
{
    private $serviceRatings;
    private $serviceFeedback;
	private $email;
	private $serviceListId;
    private $serviceType;
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
	public function setPetServiceId($serviceListId) {
        $this->serviceListId = $serviceListId;
    }   
    public function getPetServiceId() {
        return $this->serviceListId;
    }
    public function setPetServiceRatings($serviceRatings) {
        $this->serviceRatings = $serviceRatings;
    }
    public function getPetServiceRatings() {
        return $this->serviceRatings;
    }
    public function setPetServiceFeedback($serviceFeedback) {
        $this->serviceFeedback = $serviceFeedback;
    }
    public function getPetServiceFeedback() {
        return $this->serviceFeedback;
    }
    public function setPetServiceType($serviceType) {
        $this->serviceType = $serviceType;
    }
    public function getPetServiceType() {
        return $this->serviceType;
    }
    public function mapIncomingPetServiceFeedbackDetails($serviceRatings, $serviceFeedback, $email, $serviceListId, $serviceType) {
        $this->setPetServiceRatings($serviceRatings);
        $this->setPetServiceFeedback($serviceFeedback);
		$this->setEmail($email);
		$this->setPetServiceId($serviceListId);
        $this->setPetServiceType($serviceType);
    }    
     public function SavingPetServiceFeedbackDetails() {
        $showPetServiceFeedbackDAO = new PetServiceFeedbackDetailsDAO();    
        $returnshowPetServiceFeedbackDAODetails = $showPetServiceFeedbackDAO->SavingPetServiceFeedback($this);
        return $returnshowPetServiceFeedbackDAODetails;
    }
	public function showingPetServiceReviews($currentPage, $serviceListId, $serviceType) {
        $showPetServiceReviewsDAO = new PetServiceFeedbackDetailsDAO();
		$this->setCurrentPage($currentPage);
		$this->setPetServiceId($serviceListId);
        $this->setPetServiceType($serviceType);
        $returnShowReviewsList = $showPetServiceReviewsDAO->ShowPetServiceReviews($this);
        return $returnShowReviewsList;
    } 	
}
?>