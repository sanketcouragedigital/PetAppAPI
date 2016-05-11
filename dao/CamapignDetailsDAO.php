<?php
require_once 'BaseDAO.php';
require_once '../model/DonationEmails.php';

class CamapignDetailsDAO
{    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function CamapignDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function saveCampaignDetail($campaignDetail) {
			try {
			
				$status = 0;
				$campaignTempNames = array($campaignDetail->getFirstImageTemporaryName(), $campaignDetail->getSecondImageTemporaryName(), $campaignDetail->getThirdImageTemporaryName());
				$campaignTargetPaths = array($campaignDetail->getTargetPathOfFirstImage(), $campaignDetail->getTargetPathOfSecondImage(), $campaignDetail->getTargetPathOfThirdImage());
				foreach ($campaignTempNames as $index => $campaignTempName) {
					if(move_uploaded_file($campaignTempName, $campaignTargetPaths[$index])) {
						$status = 1;
					}
				}  
				if($status = 1) {				
					$sql = "INSERT INTO campaign(first_image_path, second_image_path, third_image_path, ngoName, campaignName, description, actualAmount, minimumAmount, lastDate, postDate, email)
							VALUES 
							('".$campaignDetail->getTargetPathOfFirstImage()."',
							 '".$campaignDetail->getTargetPathOfSecondImage()."',
							 '".$campaignDetail->getTargetPathOfThirdImage()."',
							 '".$campaignDetail->getNGOName()."',
							 '".$campaignDetail->getCampaignName()."',
							 '".$campaignDetail->getDescription()."',
							 '".$campaignDetail->getActualAmount()."',
							 '".$campaignDetail->getMinimumAmount()."',
							 '".$campaignDetail->getLastDate()."',   						 
							 '".$campaignDetail->getPostDate()."',
							 '".$campaignDetail->getEmail()."'
							 )";
						
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {
							$this->data = "CAMPAIGN_DETAILS_SAVED";							
						} else {
							$this->data = "ERROR";
						}	
				} else {
					$this->data = "ERROR";
				}
			} catch(Exception $e) {
				echo 'SQL Exception: ' .$e->getMessage();
			}
        return $this->data;
    }
    
	public function modifyCampaignDetail($campaignDetail) {
			try { 			
					$sql = "UPDATE campaign SET
							 ngoName='".$campaignDetail->getNGOName()."',
							 campaignName='".$campaignDetail->getCampaignName()."',
							 description='".$campaignDetail->getDescription()."',
							 actualAmount='".$campaignDetail->getActualAmount()."',
							 minimumAmount='".$campaignDetail->getMinimumAmount()."',
							 lastDate='".$campaignDetail->getLastDate()."' 						 							 
							 WHERE email='".$campaignDetail->getEmail()."' AND campaign_id='".$campaignDetail->getCampaignId()."'";
						
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {
							$this->data = "CAMPAIGN_DETAILS_UPDATED";							
						} else {
							$this->data = "ERROR";
						}	
				
			} catch(Exception $e) {
				echo 'SQL Exception: ' .$e->getMessage();
			}
        return $this->data;
    }
	
	  public function saveDonationInfo($donationDetail) {
			try {
					
					$sql = "INSERT INTO ngo_donation(campaign_id, donationAmount, email)
							VALUES 
							(
							 '".$donationDetail->getCampaignId()."',
							 '".$donationDetail->getDonationAmount()."',
							 '".$donationDetail->getEmail()."'
							 )";
						
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {
							$this->data = "DONATION_DETAILS_SAVED_SUCCESSFULLY";
							$resetPassword = new LoginDetails();
							$objDonationEmailDetails = new DonationEmails();
							$objDonationEmailDetails -> SendDonationEmail($donationDetail->getEmail(),$donationDetail->getNgoOwnerEmail());
						} else {
							$this->data = "ERROR";
						}	
				
			} catch(Exception $e) {
				echo 'SQL Exception: ' .$e->getMessage();
			}
        return $this->data;
    }
	
    public function showCampaignDetail($pageWiseData) {               
        try {
			$sql = "SELECT * FROM campaign WHERE email = '".$pageWiseData->getEmail()."'";
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($pageWiseData->getCurrentPage())) {
                $currentPage = (int) $pageWiseData->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;                        
				$sql = "SELECT * FROM campaign WHERE email = '".$pageWiseData->getEmail()."'
						ORDER BY postDate DESC LIMIT $offset, $rowsPerPage";
                $result = mysqli_query($this->con, $sql);
                $this->data=array();
                while ($rowdata = mysqli_fetch_assoc($result)) {
                    $this->data[]=$rowdata;
                }
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
	
	public function showCampaignDetailForAll($pageWiseData) {               
        try {
			$sql = "SELECT * FROM campaign";
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($pageWiseData->getCurrentPage())) {
                $currentPage = (int) $pageWiseData->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;                        
				$sql = "SELECT * FROM campaign
						ORDER BY postDate DESC LIMIT $offset, $rowsPerPage";
                $result = mysqli_query($this->con, $sql);
                $this->data=array();
                while ($rowdata = mysqli_fetch_assoc($result)) {
                    $this->data[]=$rowdata;
                }
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

   
}
?>