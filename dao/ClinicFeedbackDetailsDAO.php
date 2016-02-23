<?php
require_once 'BaseDAO.php';
class ClinicFeedbackDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function ClinicFeedbackDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function SavingClinicFeedback($clinicFeedback) {		
        try {					
                $sql = "INSERT INTO clinic_feedback(ratings,reviews,email,clinic_id)
                        VALUES ('".$clinicFeedback->getclinicRatings()."', '".$clinicFeedback->getClinicFeedback()."', '".$clinicFeedback->getEmail()."', '".$clinicFeedback->getClinicId()."')";
        
                $isInserted = mysqli_query($this->con, $sql);
                if ($isInserted) {
					$this->data = "CLINIC_FEEDBACK_SAVED";
                } else {
                    $this->data = "ERROR";
                }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
	public function ShowClinicReviews($clinicReviews) {		
       $sql = "SELECT cf.ratings,cf.reviews,ud.name
                FROM clinic_feedback cf
                INNER JOIN userDetails ud
                ON cf.email = ud.email
				WHERE cf.clinic_id= '".$clinicReviews->getClinicId()."' ";
        
        try {
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($clinicReviews->getCurrentPage())) {
                $currentPage = (int) $clinicReviews->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
            
                $sql = "SELECT cf.ratings,cf.reviews,ud.name
						FROM clinic_feedback cf
						INNER JOIN userDetails ud
						ON cf.email = ud.email
						WHERE cf.clinic_id= '".$clinicReviews->getClinicId()."'
						LIMIT $offset, $rowsPerPage";
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