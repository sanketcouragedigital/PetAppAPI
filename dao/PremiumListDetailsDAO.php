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
					$sql = "INSERT INTO trainer(image, first_name,last_name, description, timing, list_position, list_price, post_date, email)
							VALUES('".$trainerDetail->getTargetPathOfFirstImage()."','".$trainerDetail->getFirstName()."','".$trainerDetail->getLastName()."','".$trainerDetail->getDescription()."','".$trainerDetail->getTiming()."','".$trainerDetail->getListPosition()."','".$trainerDetail->getListPrice()."','".$trainerDetail->getPostDate()."','".$trainerDetail->getEmail()."')";							 	
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

    
}
?>