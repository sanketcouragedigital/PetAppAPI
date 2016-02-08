<?php

require_once 'BaseDAO.php';
class MyListingDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
	
    public function MyListingDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
        
    public function showMyListingPetList($MyListingPetList) {
         $sql = "SELECT * FROM petapp WHERE email='".$MyListingPetList->getEmail()."'";
        try {
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($MyListingPetList->getCurrentPage())) {
                $currentPage = (int) $MyListingPetList->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
            
                $sql = "SELECT *FROM petapp 
						WHERE email='".$MyListingPetList->getEmail()."' ORDER BY post_date DESC LIMIT $offset, $rowsPerPage";
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
	
	 public function showMyListingPetMateList($MyListingPetmateList) {
		  $sql = "SELECT * FROM petmate WHERE email='".$MyListingPetmateList->getEmail()."'";
        
         try {
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($MyListingPetmateList->getCurrentPage())) {
                $currentPage = (int) $MyListingPetmateList->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
            
                $sql = "SELECT * FROM petmate 
						WHERE email='".$MyListingPetmateList->getEmail()."' ORDER BY post_date DESC LIMIT $offset, $rowsPerPage";
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
	public function deleteMyListingPetList($MyListingPetList) {
		 try {
			 $sql = "DELETE FROM petapp WHERE id='".$MyListingPetList->getId()."' AND email='".$MyListingPetList->getEmail()."' ";
			 $isDeleted = mysqli_query($this->con, $sql);
                if ($isDeleted) {
					$this->data = "MyListing_Pet_Deleted";
                } else {
                    $this->data = "ERROR";
                }
			 
		} catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;	 		
	}
	
	public function deleteMyListingPetMateList($MyListingPetmateList) {
		 try {
			  $sql = "DELETE FROM petmate WHERE id='".$MyListingPetmateList->getId()."' AND email='".$MyListingPetmateList->getEmail()."' ";
			  $isDeleted = mysqli_query($this->con, $sql);
                if ($isDeleted) {
					$this->data = "MyListing_PetMate_Deleted";
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