<?php
require_once '../dao/SosServiceDAO.php';

class SosService
{
	private $sosId;
    private $description;
	private $email;
	private $currentPage;
	private $first_image_tmp;   
    private $first_image_target_path;
	private $postDate;
	
	public function setSosId($sosId) {
        $this->sosId = $sosId;
    }   
    public function getSosId() {
        return $this->sosId;
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
	public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }   
    public function getCurrentPage() {
        return $this->currentPage;
    }		
    public function setDescription($description) {
        $this->description = $description;
    }
    public function getDescription() {
        return $this->description;
    }
	public function setFirstImageTemporaryName($first_image_tmp) {
        $this->first_image_tmp = $first_image_tmp;
    }
    
    public function getFirstImageTemporaryName() {
        return $this->first_image_tmp;
    }
    
    public function setTargetPathOfFirstImage($first_image_target_path) {
        $this->first_image_target_path = $first_image_target_path;
    }
    
    public function getTargetPathOfFirstImage() {
        return $this->first_image_target_path;
    }	
	
     public function SaveSosDetails($description, $email,$first_image_tmp, $first_image_target_path,$postDate) {
		$this->setDescription($description);
		$this->setEmail($email);
		$this->setPostDate($postDate);		
		$this->setFirstImageTemporaryName($first_image_tmp);
        $this->setTargetPathOfFirstImage($first_image_target_path);
        $saveSosDetailsDAO = new SosServiceDAO();    
        $returnSaveSosServiceDAODetails = $saveSosDetailsDAO->SavingSosService($this);
        return $returnSaveSosServiceDAODetails;
    }
	public function showingSosList($currentPage) {
		$this->setCurrentPage($currentPage);
        $showSosServiceDAO = new SosServiceDAO();				
        $returnShowSosService = $showSosServiceDAO->ShowSosService($this);
        return $returnShowSosService;
    } 

	public function deleteSOSService($sosId) {
		$this->setSosId($sosId);
        $deleteSosServiceDAO = new SosServiceDAO();				
        $returnDeleteSosService = $deleteSosServiceDAO->DeleteSosService($this);
        return $returnDeleteSosService;
    } 
}
?>