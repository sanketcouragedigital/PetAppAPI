<?php
require_once '../dao/CampaignDetailsDAO.php';
class CampaignDetails
{
	private $first_image_tmp;
    private $second_image_tmp;
    private $third_image_tmp;
    private $first_image_target_path;
    private $second_image_target_path;
    private $third_image_target_path;    
	private $ngoName;
    private $campaignName;
    private $description;
	private $actualAmount;
    private $minimumAmount;
    private $lastDate;
    private $postDate;
    private $currentPage;
    private $email;
	private $campaignId;
	private $donationAmount;
	private $ngoOwnerEmail;
	private $donationPostDate;
	
	public function setDonationPostDate($donationPostDate) {
        $this->donationPostDate = $donationPostDate;
    }
    
    public function getDonationPostDate() {
        return $this->donationPostDate;
    }
	
	
	public function setNgoOwnerEmail($ngoOwnerEmail) {
        $this->ngoOwnerEmail = $ngoOwnerEmail;
    }
    
    public function getNgoOwnerEmail() {
        return $this->ngoOwnerEmail;
    }
	
	
	public function setDonationAmount($donationAmount) {
        $this->donationAmount = $donationAmount;
    }
    
    public function getDonationAmount() {
        return $this->donationAmount;
    }
	
	public function setCampaignId($campaignId) {
        $this->campaignId = $campaignId;
    }
    
    public function getCampaignId() {
        return $this->campaignId;
    }
	
    public function setFirstImageTemporaryName($first_image_tmp) {
        $this->first_image_tmp = $first_image_tmp;
    }
    
    public function getFirstImageTemporaryName() {
        return $this->first_image_tmp;
    }
    
    public function setSecondImageTemporaryName($second_image_tmp) {
        $this->second_image_tmp = $second_image_tmp;
    }
    
    public function getSecondImageTemporaryName() {
        return $this->second_image_tmp;
    }
    
    public function setThirdImageTemporaryName($third_image_tmp) {
        $this->third_image_tmp = $third_image_tmp;
    }
    
    public function getThirdImageTemporaryName() {
        return $this->third_image_tmp;
    }

    public function setTargetPathOfFirstImage($first_image_target_path) {
        $this->first_image_target_path = $first_image_target_path;
    }
    
    public function getTargetPathOfFirstImage() {
        return $this->first_image_target_path;
    }
    
    public function setTargetPathOfSecondImage($second_image_target_path) {
        $this->second_image_target_path = $second_image_target_path;
    }
    
    public function getTargetPathOfSecondImage() {
        return $this->second_image_target_path;
    }
    
    public function setTargetPathOfThirdImage($third_image_target_path) {
        $this->third_image_target_path = $third_image_target_path;
    }
    
    public function getTargetPathOfThirdImage() {
        return $this->third_image_target_path;
    }

    public function setNGOName($ngoName) {
        $this->ngoName = $ngoName;
    }
    
    public function getNGOName() {
        return $this->ngoName;
    }

    public function setCampaignName($campaignName) {
        $this->campaignName = $campaignName;
    }    
    public function getCampaignName() {
        return $this->campaignName;
    }

    public function setDescription($description) {
        $this->description = $description;
    }    
    public function getDescription() {
        return $this->description;
    }
	
	
	 public function setActualAmount($actualAmount) {
        $this->actualAmount = $actualAmount;
    }
    public function getActualAmount() {
        return $this->actualAmount;
    } 
	
    public function setMinimumAmount($minimumAmount) {
        $this->minimumAmount = $minimumAmount;
    }
    
    public function getMinimumAmount() {
        return $this->minimumAmount;
    }

    public function setLastDate($lastDate) {
        $this->lastDate = $lastDate;
    }
    
    public function getLastDate() {
        return $this->lastDate;
    }
    
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function setPostDate($postDate) {
        $this->postDate = $postDate;
    }
    
    public function getPostDate() {
        return $this->postDate;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }    
    public function getEmail() {
        return $this->email;
    }	   

    public function mapIncomingCampaignDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $campaignName, $description, $actualAmount, $minimumAmount, $lastDate, $postDate, $email) {
        $this->setFirstImageTemporaryName($first_image_tmp);
        $this->setSecondImageTemporaryName($second_image_tmp);
        $this->setThirdImageTemporaryName($third_image_tmp);
        $this->setTargetPathOfFirstImage($first_image_target_path);
        $this->setTargetPathOfSecondImage($second_image_target_path);
        $this->setTargetPathOfThirdImage($third_image_target_path);		
        //$this->setNGOName($ngoName);
        $this->setCampaignName($campaignName);
        $this->setDescription($description);
		$this->setActualAmount($actualAmount);
        $this->setMinimumAmount($minimumAmount);
        $this->setLastDate($lastDate);      
		$this->setPostDate($postDate);
        $this->setEmail($email);		
    }

    public function mapIncomingCampaignForDesktopDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $campaignName, $description, $actualAmount, $minimumAmount, $lastDate, $postDate, $email) {
        $this->setFirstImageTemporaryName($first_image_tmp);
        $this->setSecondImageTemporaryName($second_image_tmp);
        $this->setThirdImageTemporaryName($third_image_tmp);
        $this->setTargetPathOfFirstImage($first_image_target_path);
        $this->setTargetPathOfSecondImage($second_image_target_path);
        $this->setTargetPathOfThirdImage($third_image_target_path);
        //$this->setNGOName($ngoName);
        $this->setCampaignName($campaignName);
        $this->setDescription($description);
        $this->setActualAmount($actualAmount);
        $this->setMinimumAmount($minimumAmount);
        $this->setLastDate($lastDate);
        $this->setPostDate($postDate);
        $this->setEmail($email);
    }

    public function savingCampaignDetails() {
        $saveCampaignDetailsDAO = new CampaignDetailsDAO();
        $returnCampaignDetailSaveSuccessMessage = $saveCampaignDetailsDAO->saveCampaignDetail($this);
        return $returnCampaignDetailSaveSuccessMessage;
    }

    public function savingCampaignForDesktopDetails() {
        $saveCampaignDetailsDAO = new CampaignDetailsDAO();
        $returnCampaignDetailSaveSuccessMessage = $saveCampaignDetailsDAO->saveCampaignForDesktopDetail($this);
        return $returnCampaignDetailSaveSuccessMessage;
    }
	//for modification
	
	public function mapIncomingCamapignModifyDetailsParams($campaignId, $campaignName, $description, $actualAmount, $minimumAmount, $lastDate, $email) {		
        $this->setCampaignId($campaignId);
		//$this->setNGOName($ngoName);
        $this->setCampaignName($campaignName);
        $this->setDescription($description);
		$this->setActualAmount($actualAmount);
        $this->setMinimumAmount($minimumAmount);
        $this->setLastDate($lastDate);      		
        $this->setEmail($email);		
    }

    public function modifyingCampaignDetails() {
        $saveCampaignDetailsDAO = new CampaignDetailsDAO();
        $returnCampaignDetailSaveSuccessMessage = $saveCampaignDetailsDAO->modifyCampaignDetail($this);
        return $returnCampaignDetailSaveSuccessMessage;
    }
	//for Donation
	
	public function mapIncomingDonationParams($campaignId,$email, $donationAmount, $ngoOwnerEmail,$donationPostDate) {		
        $this->setCampaignId($campaignId);
		$this->setEmail($email);
		$this->setDonationAmount($donationAmount);        	
		$this->setNgoOwnerEmail($ngoOwnerEmail);	
		$this->setDonationPostDate($donationPostDate);		
    }

    public function donationInfo() {
        $saveCampaignDetailsDAO = new CampaignDetailsDAO();
        $returnCampaignDetailSaveSuccessMessage = $saveCampaignDetailsDAO->saveDonationInfo($this);
        return $returnCampaignDetailSaveSuccessMessage;
    }
	
    public function showingCampaignDetails($email,$currentPage) {
        $showCampaignDetailsDAO = new CampaignDetailsDAO();
        $this->setCurrentPage($currentPage);
		 $this->setEmail($email);
        $returnShowCampaignDetails = $showCampaignDetailsDAO->showCampaignDetail($this);
        return $returnShowCampaignDetails;
    }
	
	public function showingCampaignDetailsForAll($currentPage) {
        $showCampaignDetailsDAO = new CampaignDetailsDAO();
        $this->setCurrentPage($currentPage);
        $returnShowCampaignDetails = $showCampaignDetailsDAO->showCampaignDetailForAll($this);
        return $returnShowCampaignDetails;
    }
	
    
}
?>