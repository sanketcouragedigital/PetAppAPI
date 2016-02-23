<?php
require_once 'BaseDAO.php';
class PetServicesDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function PetServicesDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function showPetShelter($PetServices) {
        try {
			$sql = "SELECT * FROM pet_shelter ";        
                $isValidating = mysqli_query($this->con, $sql);
                $count=mysqli_num_rows($isValidating);
				$numOfRows = count($count);
            
				$rowsPerPage = 10;
				$totalPages = ceil($numOfRows / $rowsPerPage);
				
				$this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
				
				if (is_numeric($PetServices->getCurrentPage())) {
					$currentPage = (int) $PetServices->getCurrentPage();
				}
				
				if ($currentPage >= 1 && $currentPage <= $totalPages) {
					$offset = ($currentPage - 1) * $rowsPerPage;
				
					$sql = "SELECT * FROM pet_shelter LIMIT $offset, $rowsPerPage";
								
					$result = mysqli_query($this->con, $sql);
					
					$this->data=array();
					while ($rowdata = mysqli_fetch_assoc($result)) {
						$this->data[]=$rowdata;
					}
				}
        } catch(Exception $e) {
            echo 'SQL Exception:'.$e->getMessage();
        }
        return $this->data;
    }
    
    public function showTrainer($PetServices) {
		
        try {
			$sql = "SELECT * FROM pet_trainer ";        
                $isValidating = mysqli_query($this->con, $sql);
                $count=mysqli_num_rows($isValidating);
				$numOfRows = count($count);
            
				$rowsPerPage = 10;
				$totalPages = ceil($numOfRows / $rowsPerPage);
				
				$this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
				
				if (is_numeric($PetServices->getCurrentPage())) {
					$currentPage = (int) $PetServices->getCurrentPage();
				}            
				if ($currentPage >= 1 && $currentPage <= $totalPages) {
					$offset = ($currentPage - 1) * $rowsPerPage;
				
					$sql = "SELECT * FROM pet_trainer LIMIT $offset, $rowsPerPage";
								
					$result = mysqli_query($this->con, $sql);
					
					$this->data=array();
					while ($rowdata = mysqli_fetch_assoc($result)) {
						$this->data[]=$rowdata;
					}
				}            
        } catch(Exception $e) {
            echo 'SQL Exception:'.$e->getMessage();
        }
        return $this->data;
    }
	public function showStores($PetServices) {
                
        try {
				$sql = "SELECT * FROM pet_stores ";        
                $isValidating = mysqli_query($this->con, $sql);
                $count=mysqli_num_rows($isValidating);
				$numOfRows = count($count);
            
				$rowsPerPage = 10;
				$totalPages = ceil($numOfRows / $rowsPerPage);
				
				$this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
				
				if (is_numeric($PetServices->getCurrentPage())) {
					$currentPage = (int) $PetServices->getCurrentPage();
				}
				
				if ($currentPage >= 1 && $currentPage <= $totalPages) {
					$offset = ($currentPage - 1) * $rowsPerPage;
				
					$sql = "SELECT * FROM pet_stores LIMIT $offset, $rowsPerPage";
								
					$result = mysqli_query($this->con, $sql);
					
					$this->data=array();
					while ($rowdata = mysqli_fetch_assoc($result)) {
						$this->data[]=$rowdata;
					}
				}      
        }catch(Exception $e) {
            echo 'SQL Exception:'.$e->getMessage();
        }
        return $this->data;
    }
	public function showGroomer($PetServices) {
                
        try {
				$sql = "SELECT * FROM pet_groomer ";        
                $isValidating = mysqli_query($this->con, $sql);
                $count=mysqli_num_rows($isValidating);
				$numOfRows = count($count);
            
				$rowsPerPage = 10;
				$totalPages = ceil($numOfRows / $rowsPerPage);
				
				$this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
				
				if (is_numeric($PetServices->getCurrentPage())) {
					$currentPage = (int) $PetServices->getCurrentPage();
				}
				
				if ($currentPage >= 1 && $currentPage <= $totalPages) {
					$offset = ($currentPage - 1) * $rowsPerPage;
				
					$sql = "SELECT * FROM pet_groomer LIMIT $offset, $rowsPerPage";
								
					$result = mysqli_query($this->con, $sql);
					
					$this->data=array();
					while ($rowdata = mysqli_fetch_assoc($result)) {
						$this->data[]=$rowdata;
					}
				}
            } catch(Exception $e) {
				echo 'SQL Exception:'.$e->getMessage();
			}
        return $this->data;
    }
}
?>
