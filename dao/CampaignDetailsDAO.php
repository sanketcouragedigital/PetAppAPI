<?php
require_once 'BaseDAO.php';
require_once '../model/DonationEmails.php';

class CampaignDetailsDAO
{    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function CampaignDetailsDAO() {
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
					$lastDateOfCampaign = "";
					if($campaignDetail->getLastDate()!=="") {
						$lastDateOfCampaign =  DateTime::createFromFormat('d-m-Y', $campaignDetail->getLastDate())->format('Y-m-d');
					}
					$sql = "INSERT INTO campaign(first_image_path, second_image_path, third_image_path, campaignName, description, actualAmount, minimumAmount, lastDate, postDate, email)
							VALUES('".$campaignDetail->getTargetPathOfFirstImage()."','".$campaignDetail->getTargetPathOfSecondImage()."','".$campaignDetail->getTargetPathOfThirdImage()."','".$campaignDetail->getCampaignName()."','".$campaignDetail->getDescription()."','".$campaignDetail->getActualAmount()."','".$campaignDetail->getMinimumAmount()."','".$lastDateOfCampaign."','".$campaignDetail->getPostDate()."','".$campaignDetail->getEmail()."' )";
						
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

    public function saveCampaignForDesktopDetail($campaignDetail) {
      try {

        $status = 0;
        $campaignTempNames = array($campaignDetail->getFirstImageTemporaryName(), $campaignDetail->getSecondImageTemporaryName(), $campaignDetail->getThirdImageTemporaryName());
        $campaignTargetPaths = array($campaignDetail->getTargetPathOfFirstImage(), $campaignDetail->getTargetPathOfSecondImage(), $campaignDetail->getTargetPathOfThirdImage());
        foreach ($campaignTempNames as $index => $campaignTempName) {
          $campaignImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $campaignTempName));
          if($campaignTargetPaths[$index] != "") {
            if(file_put_contents($campaignTargetPaths[$index], $campaignImage)) {
              $status = 1;
            }
          }
        }
        if($status = 1) {
          $sql = "INSERT INTO campaign(first_image_path, second_image_path, third_image_path, campaignName, description, actualAmount, minimumAmount, lastDate, postDate, email)
              VALUES('".$campaignDetail->getTargetPathOfFirstImage()."','".$campaignDetail->getTargetPathOfSecondImage()."','".$campaignDetail->getTargetPathOfThirdImage()."','".$campaignDetail->getCampaignName()."','".$campaignDetail->getDescription()."','".$campaignDetail->getActualAmount()."','".$campaignDetail->getMinimumAmount()."','".$campaignDetail->getLastDate()."','".$campaignDetail->getPostDate()."','".$campaignDetail->getEmail()."')";

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
					/*$lastDateOfCampaign = "";
					if($campaignDetail->getLastDate()!=="") {
						$lastDateOfCampaign =  DateTime::createFromFormat('d/m/Y', $campaignDetail->getLastDate())->format('Y-m-d');
					}	*/		
					$sql = "UPDATE campaign SET campaignName='".$campaignDetail->getCampaignName()."',description='".$campaignDetail->getDescription()."',actualAmount='".$campaignDetail->getActualAmount()."',minimumAmount='".$campaignDetail->getMinimumAmount()."',lastDate='".$campaignDetail->getLastDate()."' WHERE email='".$campaignDetail->getEmail()."' AND campaign_id='".$campaignDetail->getCampaignId()."'";
						
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
					
					$sql = "INSERT INTO ngo_donation(campaign_id, donationAmount, email,postDate)
							VALUES('".$donationDetail->getCampaignId()."','".$donationDetail->getDonationAmount()."','".$donationDetail->getEmail()."','".$donationDetail->getDonationPostDate()."')";
						
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {
							$this->data = "DONATION_DETAILS_SAVED_SUCCESSFULLY";
							
							$SqlDonationDetails="SELECT c.campaign_id,c.campaignName,c.email as ngoOwnerEmail,
													ud.ngo_name,
													nd.donationAmount, nd.postDate as donation_Date,
													u.id as userId, u.name as donarName, u.email as donarEmail,u.mobileno as donarMobileNo
													FROM campaign c
													INNER JOIN userDetails ud
													ON c.email=ud.email
													INNER JOIN ngo_donation nd
													ON c.campaign_id = nd.campaign_id
													INNER JOIN userDetails u
													ON u.email = nd.email 
													WHERE c.campaign_id='".$donationDetail->getCampaignId()."'";
							$result = mysqli_query($this->con, $SqlDonationDetails);
								$donationDetails=array();
								while ($rowdata = mysqli_fetch_assoc($result)) {
									$donationDetails=$rowdata;									
								}
								//print_r ($donationDetails);
								
								$campaign_id = $donationDetails['campaign_id'];
								$donation_Date = $donationDetails['donation_Date'];
								$donar_id = $donationDetails['userId'];					
								$campaignName = $donationDetails['campaignName'];
								$ngoName = $donationDetails['ngoName'];
								$ngoOwnerEmail = $donationDetails['ngoOwnerEmail'];
								$donarName = $donationDetails['donarName'];
								$donarEmail = $donationDetails['donarEmail'];
								$donarMobileNo = $donationDetails['donarMobileNo'];
								$donationAmount = $donationDetails['donationAmount'];
							$objDonationEmailDetails = new DonationEmails();
							$objDonationEmailDetails -> SendDonationEmail($donation_Date,$donar_id,$campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$donarName,$donarEmail,$donarMobileNo,$donationAmount);
						} else {
							$this->data = "ERROR";
						}	
						//$this->data=array('donationDetails' => $donationDetails,'donationSave' => $response);	
					
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
				$sql = "SELECT  sum(nd.donationAmount)as collectedAmount,c.actualAmount - sum(nd.donationAmount)as remainingAmount,
							c.actualAmount,c.email as ngo_email,c.campaign_id,c.campaignName,c.description,c.minimumAmount,
							c.lastDate,c.postDate,c.first_image_path,c.second_image_path,c.third_image_path,
							d.ngo_url,d.mobileno,d.ngo_name
							FROM ngo_donation  nd
							RIGHT JOIN campaign c
							ON nd.campaign_id = c.campaign_id
							INNER JOIN userDetails d 
							ON d.email = c.email
							WHERE c.email ='".$pageWiseData->getEmail()."' GROUP BY c.campaign_id
							ORDER BY postDate DESC LIMIT $offset, $rowsPerPage";
                $result = mysqli_query($this->con, $sql);
                $this->data=array();
                while ($rowdata = mysqli_fetch_assoc($result)) {
                    $this->data[]=$rowdata;
                }
				return $this->data;
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
       return $this->data=array();
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
				$sql = "SELECT  sum(nd.donationAmount)as collectedAmount,c.actualAmount - sum(nd.donationAmount)as remainingAmount,
							c.actualAmount,c.email as ngo_email,c.campaign_id,c.campaignName,c.description,
							c.minimumAmount,c.lastDate,c.postDate,c.first_image_path,c.second_image_path,c.third_image_path,
							d.ngo_url,d.mobileno,d.ngo_name
							FROM ngo_donation  nd
							RIGHT JOIN campaign c
							ON nd.campaign_id = c.campaign_id
							INNER JOIN userDetails d 
							ON d.email = c.email
							GROUP BY c.campaign_id
							ORDER BY postDate  DESC LIMIT $offset, $rowsPerPage";
                $result = mysqli_query($this->con, $sql);
                $this->data=array();
                while ($rowdata = mysqli_fetch_assoc($result)) {
                    $this->data[]=$rowdata;
                }
				return $this->data;
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data=array();
    }

   
}
?>