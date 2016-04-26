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
	
	public function saveModifiedPetDetail($MyListingPetList) {
		try {
			if ($status = 1) {
				$sql = "UPDATE petapp SET 	pet_category = '" . $MyListingPetList -> getCategoryOfPet() . "',
			                                pet_breed = '" . $MyListingPetList -> getBreedOfPet() . "',
			                                pet_age_inMonth = '" . $MyListingPetList -> getPetAgeInMonth() . "' ,  
			                                pet_age_inYear ='" . $MyListingPetList -> getPetAgeInYear() . "' , 
			                                pet_gender ='" . $MyListingPetList -> getGenderOfPet() . "',
			                                pet_description= '" . $MyListingPetList -> getDescriptionOfPet() . "',
			                                pet_adoption ='" . $MyListingPetList -> getAdoptionOfPet() . "',
			                                pet_price= '" . $MyListingPetList -> getPriceOfPet() . "'			                                
			                    		 	WHERE id = '" . $MyListingPetList -> getId() . "'  
                                            AND  email = '" . $MyListingPetList -> getEmail() . "' ";

				$isUpdated = mysqli_query($this -> con, $sql);
				if ($isUpdated) {
					$this -> data = "PET_DETAILS_UPDATED";
				} else {
					$this -> data = "ERROR";
				}
			} else {
				$this -> data = "ERROR";
			}
		} catch(Exception $e) {
			echo 'SQL Exception: ' . $e -> getMessage();
		}
		return $this -> data;
	}



    public function saveModifiedPetMateDetail($MyListingPetMateList) {
        try {
            if ($status = 1) {
                $sql = "UPDATE petmate SET  pet_category = '" . $MyListingPetMateList -> getCategoryOfPet() . "',
                                            pet_breed = '" . $MyListingPetMateList -> getBreedOfPet() . "',
                                            pet_age_inMonth = '" . $MyListingPetMateList -> getPetAgeInMonth() . "' ,  
                                            pet_age_inYear ='" . $MyListingPetMateList -> getPetAgeInYear() . "' , 
                                            pet_gender ='" . $MyListingPetMateList -> getGenderOfPet() . "',
                                            pet_description= '" . $MyListingPetMateList -> getDescriptionOfPet() . "'
                                            
                                            WHERE id = '" . $MyListingPetMateList -> getId() . "'   
                                            AND email = '". $MyListingPetMateList -> getemail() ."' " ;

                $isUpdated = mysqli_query($this -> con, $sql);
                if ($isUpdated) {
                    $this -> data = "PET_MATE_DETAILS_UPDATED";
                } else {
                    $this -> data = "ERROR";
                }
            } else {
                $this -> data = "ERROR";
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' . $e -> getMessage();
        }
        return $this -> data;
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
            $sql = "SELECT * FROM petapp WHERE id = '".$MyListingPetList->getId()."' AND email = '".$MyListingPetList->getEmail()."'";
            $fetchData = mysqli_query($this->con, $sql);
            $this->result=array();
            while ($rowdata = mysqli_fetch_assoc($fetchData)) {
                $this->result[]=$rowdata;
            }
            $firstImagePath = $this->result[0]['first_image_path'];
            $secondImagePath = $this->result[0]['second_image_path'];
            $thirdImagePath = $this->result[0]['third_image_path'];
            
			$sql = "DELETE FROM petapp WHERE id='".$MyListingPetList->getId()."' AND email='".$MyListingPetList->getEmail()."' ";
			$isDeleted = mysqli_query($this->con, $sql);
            if ($isDeleted) {
                $this->data = "MyListing_Pet_Deleted";
                $petImagePaths = array($firstImagePath, $secondImagePath, $thirdImagePath);
                foreach ($petImagePaths as $index => $petImagePath) {
                    if($petImagePath != "" && !empty($petImagePath)) {
                        chmod($petImagePath, 777);
                        unlink($petImagePath);
                    }
                }
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
		    $sql = "SELECT * FROM petmate WHERE id = '".$MyListingPetmateList->getId()."' AND email = '".$MyListingPetmateList->getEmail()."'";
            $fetchData = mysqli_query($this->con, $sql);
            $this->result=array();
            while ($rowdata = mysqli_fetch_assoc($fetchData)) {
                $this->result[]=$rowdata;
            }
            $firstImagePath = $this->result[0]['first_image_path'];
            $secondImagePath = $this->result[0]['second_image_path'];
            $thirdImagePath = $this->result[0]['third_image_path'];
            
			$sql = "DELETE FROM petmate WHERE id='".$MyListingPetmateList->getId()."' AND email='".$MyListingPetmateList->getEmail()."' ";
			$isDeleted = mysqli_query($this->con, $sql);
            if ($isDeleted) {
                $this->data = "MyListing_PetMate_Deleted";
                $petImagePaths = array($firstImagePath, $secondImagePath, $thirdImagePath);
                foreach ($petImagePaths as $index => $petImagePath) {
                    if($petImagePath != "" && !empty($petImagePath)) {
                        chmod($petImagePath, 777);
                        unlink($petImagePath);
                    }
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