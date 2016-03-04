<?php
require_once 'BaseDAO.php';
class WhishListDetailsDAO
{    
    private $con;
    private $msg;
    private $data;   
    // Attempts to initialize the database connection using the supplied info.
    public function WhishListDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function petWishListSave($petListWishList) {		
        try {					
                $sql = "INSERT INTO petList_wishList(email,listId)
                        VALUES ('".$petListWishList->getEmail()."', '".$petListWishList->getListId()."')";
        
                $isInserted = mysqli_query($this->con, $sql);
                if ($isInserted) {
					$this->data = "LIST_ADDED_SUCCESSFULLY";
                } else {
                    $this->data = "ERROR";
                }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }	
	public function petMateWishListSave($petMateListWishList) {		
        try {					
                $sql = "INSERT INTO petMateList_wishList(email,listId)
                        VALUES ('".$petMateListWishList->getEmail()."', '".$petMateListWishList->getListId()."')";
        
                $isInserted = mysqli_query($this->con, $sql);
                if ($isInserted) {
					$this->data = "LIST_ADDED_SUCCESSFULLY";
                } else {
                    $this->data = "ERROR";
                }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
	
	
	public function showPetWishList($petListWishList) {		
       $sql = "SELECT pm.id, pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date, pm.pet_adoption, pm.pet_price, pm.alternateNo				
                FROM petList_wishList pw
                INNER JOIN petapp pm
                ON pw.listId = pm.id
				WHERE pw.email= '".$petListWishList->getEmail()."' ";        
        try {
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($petListWishList->getCurrentPage())) {
                $currentPage = (int) $petListWishList->getCurrentPage();
            }            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
            
                $sql = "SELECT pm.id, pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date, pm.pet_adoption, pm.pet_price, pm.alternateNo
                FROM petList_wishList pw
                INNER JOIN petapp pm
                ON pw.listId = pm.id
				WHERE pw.email= '".$petListWishList->getEmail()."'
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
	public function showPetMateWishList($petMateListWishList) {		
       $sql = "SELECT pm.id, pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date, pm.alternateNo
                FROM petMateList_wishList pmw
                INNER JOIN petmate pm
                ON pmw.listId = pm.id
				WHERE pmw.email= '".$petMateListWishList->getEmail()."' ";
        
        try {
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($petMateListWishList->getCurrentPage())) {
                $currentPage = (int) $petMateListWishList->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
            
                $sql = "SELECT pm.id, pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date, pm.alternateNo
                FROM petMateList_wishList pmw
                INNER JOIN petmate pm
                ON pmw.listId = pm.id
				WHERE pmw.email= '".$petMateListWishList->getEmail()."'
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
	public function deleteWishListPetList($WishListPetList) {
		 try {            
			$sql = "DELETE FROM petList_wishList WHERE listId='".$WishListPetList->getListId()."' AND email='".$WishListPetList->getEmail()."' ";
			$isDeleted = mysqli_query($this->con, $sql);
            if ($isDeleted) {
                $this->data = "WishList_Pet_Deleted";                
            } else {
                $this->data = "ERROR";
            }
			 
		} catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;	 		
	}
	
	public function deleteWishListPetMateList($WishListPetmateList) {
		 try {            
			$sql = "DELETE FROM petMateList_wishList WHERE listId='".$WishListPetmateList->getListId()."' AND email='".$WishListPetmateList->getEmail()."' ";
			$isDeleted = mysqli_query($this->con, $sql);
            if ($isDeleted) {
                $this->data = "WishList_PetMate_Deleted";                             
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