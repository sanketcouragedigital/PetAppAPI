<?php
require_once 'BaseDAO.php';
class SosServiceDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function SosServiceDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function SavingSosService($sosService) {		
        try {	
				$status = 0;
				$sosTempNames = array($sosService->getFirstImageTemporaryName());
				$sosTargetPaths = array($sosService->getTargetPathOfFirstImage());
				foreach ($sosTempNames as $index => $sosTempName) {
					if(move_uploaded_file($sosTempName, $sosTargetPaths[$index])) {
						$status = 1;
					}
				}  
				if($status = 1) {		
					$sql = "INSERT INTO sos_service(description, email,image,post_date)
							VALUES ('".$sosService->getDescription()."', '".$sosService->getEmail()."','".$sosService->getTargetPathOfFirstImage()."','".$sosService->getPostDate()."')";
			
					$isInserted = mysqli_query($this->con, $sql);
					if ($isInserted) {
						$this->data = "DETAILS_SAVED";
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
    
	public function ShowSosService($sosService) {		
       $sql = "SELECT s.id,s.description,s.image,s.post_date,s.email,u.first_name,u.last_name,u.mobileno
					FROM sos_service s
					INNER JOIN userDetails u
					ON s.email = u.email";        
        try {
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($sosService->getCurrentPage())) {
                $currentPage = (int) $sosService->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
            
                $sql = "SELECT s.id,s.description,s.image,s.post_date,s.email,u.first_name,u.last_name,u.mobileno
							FROM sos_service s
							INNER JOIN userDetails u
							ON s.email = u.email						                     
							ORDER BY post_date LIMIT $offset, $rowsPerPage";
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
        return $this->data;
    }
	
	public function DeleteSosService($sosService) {		
        try {									
			$sql = "DELETE FROM sos_service WHERE id = '".$sosService->getSosId()."'";					
			$isDeleted = mysqli_query($this->con, $sql);
			if($isDeleted) {
				$this->data = "DELETED_SUCCESSFULLY";
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