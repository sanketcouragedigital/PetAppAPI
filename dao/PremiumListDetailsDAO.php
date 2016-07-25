<?php
require_once 'BaseDAO.php';
//require_once '../model/PremiumListingEmails.php';

class PremiumListDetailsDAO
{    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function PremiumListDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function saveTrainerDetail($trainerDetail) {
			try {				
			
				$status = 0;
				$trainerTempNames = array($trainerDetail->getFirstImageTemporaryName());
				$trainerTargetPaths = array($trainerDetail->getTargetPathOfFirstImage());
				foreach ($trainerTempNames as $index => $trainerTempName) {
					if(move_uploaded_file($trainerTempName, $trainerTargetPaths[$index])) {
						$status = 1;
					}
				}  
				if($status = 1) {						
					$sql = "INSERT INTO trainer(image, first_name,last_name, description, timing, list_position, list_price, date_booking_from, date_booking_to, adv_date_booking_from, adv_date_booking_to,adv_booked,list_post_date, email)
							VALUES 
							('".$trainerDetail->getTargetPathOfFirstImage()."',							 
							 '".$trainerDetail->getFirstName()."',
							 '".$trainerDetail->getLastName()."',
							 '".$trainerDetail->getDescription()."',
							 '".$trainerDetail->getTiming()."',	
							 '".$trainerDetail->getListPosition()."',							   						
							 '".$trainerDetail->getListPrice()."',							 							 
							 '".$trainerDetail->getDate_booking_from()."',
							 '".$trainerDetail->getDate_booking_to()."',
							 '".$trainerDetail->getAdv_date_booking_from()."',
							 '".$trainerDetail->getAdv_date_booking_to()."',
							 '".$trainerDetail->getAdv_booking()."',
							 '".$trainerDetail->getPostDate()."',
							 '".$trainerDetail->getEmail()."'
							 )";							 	
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {
							$this->data = "TRAINER_DETAILS_SAVED";							
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
	
	    public function showTrainerPremiumListWise($PetServices) {		
        try {
			$sql = "SELECT * FROM pet_trainer ";        
                $isValidating = mysqli_query($this->con, $sql);
                $count=mysqli_num_rows($isValidating);
				$numOfRows = $count;
            
				$rowsPerPage = 10;
				$totalPages = ceil($numOfRows / $rowsPerPage);
				
				$this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
				
				if (is_numeric($PetServices->getCurrentPage())) {
					$currentPage = (int) $PetServices->getCurrentPage();
				}            
				if ($currentPage >= 1 && $currentPage <= $totalPages) {
					$offset = ($currentPage - 1) * $rowsPerPage;
				
					$sql = "SELECT * FROM trainer order by list_price desc LIMIT $offset, $rowsPerPage";
								
					$result = mysqli_query($this->con, $sql);
					
					$this->data=array();
					while ($rowdata = mysqli_fetch_assoc($result)) {
						$this->data[]=$rowdata;
					}
                    return $this->data;
				}            
        } catch(Exception $e) {
            echo 'SQL Exception:'.$e->getMessage();
        }
        return $this->data=array();
    }
	
	public function showListAvailability($listAvailability) {		
        try {
			$sql = "SELECT adv_booked FROM trainer WHERE list_position='".$listAvailability->getListPosition()."'";
			$isValidating = mysqli_query($this->con, $sql);
            $count=mysqli_num_rows($isValidating);
            if($count==0) {
                 $this->data = "Booking_Available_For_Current_Month";
            } 
			else if($count==1) {
				$sql = "SELECT date_booking_to FROM trainer WHERE list_position='".$listAvailability->getListPosition()."'";
				$result = mysqli_query($this->con, $sql);					
				$this->data=array();
				while ($rowdata = mysqli_fetch_assoc($result)) {
					$dateForAdvBooking=$rowdata;
				}
				$advDate = $dateForAdvBooking['date_booking_to'];
                $this->data = $advDate;
				//echo  "Advance Booking Available";
            }
			else {
				$this->data = "Booking_Not_Available";
			}
			/* $sql = "SELECT count(adv_booked)as count FROM trainer WHERE list_position='".$listAvailability->getListPosition()."'";			
			$result = mysqli_query($this->con, $sql);
			$this->data=array();
			while ($rowdata = mysqli_fetch_assoc($result)) {
				$this->data[]=$rowdata;
			}
            return $this->data;	*/		
        } catch(Exception $e) {
            echo 'SQL Exception:'.$e->getMessage();
        }
        return $this->data;
    }

    
}
?>