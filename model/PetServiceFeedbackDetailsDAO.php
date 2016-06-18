<?php
require_once 'BaseDAO.php';
class PetServiceFeedbackDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function PetServiceFeedbackDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function SavingPetServiceFeedback($petServiceFeedback) {		
        try {					
                $sql = "INSERT INTO service_feedback(ratings, reviews, email, serviceListId, serviceType)
                        VALUES ('".$petServiceFeedback->getPetServiceRatings()."', '".$petServiceFeedback->getPetServiceFeedback()."', '".$petServiceFeedback->getEmail()."', '".$petServiceFeedback->getPetServiceId()."', '".$petServiceFeedback->getPetServiceType()."')";
        
                $isInserted = mysqli_query($this->con, $sql);
                if ($isInserted) {
					$this->data = "PET_SERVICE_FEEDBACK_SAVED";
                } else {
                    $this->data = "ERROR";
                }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
    
	public function ShowPetServiceReviews($petServiceFeedback) {		
       $sql = "SELECT sf.ratings, sf.reviews, ud.name
                FROM service_feedback sf
                INNER JOIN userDetails ud
                ON sf.email = ud.email
				WHERE sf.serviceListId = '".$petServiceFeedback->getPetServiceId()."'
                AND sf.serviceType = '".$petServiceFeedback->getPetServiceType()."' ";
        
        try {
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($petServiceFeedback->getCurrentPage())) {
                $currentPage = (int) $petServiceFeedback->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
            
                $sql = "SELECT sf.ratings, sf.reviews, ud.name
						FROM service_feedback sf
						INNER JOIN userDetails ud
						ON sf.email = ud.email
						WHERE sf.serviceListId = '".$petServiceFeedback->getPetServiceId()."'
                        AND sf.serviceType = '".$petServiceFeedback->getPetServiceType()."'
						LIMIT $offset, $rowsPerPage";
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
        //return $this->data=array();
        $this->data=array();
        
        $this->data[0]['emptyKey']="Empty";

        return $this->data;
    }
   
}
?>