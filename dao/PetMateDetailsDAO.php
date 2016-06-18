<?php
require_once 'BaseDAO.php';
class PetMateDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function PetMateDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function saveDetail($petMateDetail) {
        try {
            $status = 0;
            $petsTempNames = array($petMateDetail->getFirstImageTemporaryName(), $petMateDetail->getSecondImageTemporaryName(), $petMateDetail->getThirdImageTemporaryName());
            $petsTargetPaths = array($petMateDetail->getTargetPathOfFirstImage(), $petMateDetail->getTargetPathOfSecondImage(), $petMateDetail->getTargetPathOfThirdImage());
            foreach ($petsTempNames as $index => $petsTempName) {
                if(move_uploaded_file($petsTempName, $petsTargetPaths[$index])) {
                    $status = 1;
                }
            }  
            if($status = 1) {
				$addAlternateNo = $petMateDetail->getAlternateNo();
				if($addAlternateNo == ""){
					
					$sql = "SELECT mobileno FROM userDetails WHERE email='".$petMateDetail->getEmail()."'";
					$result = mysqli_query($this->con, $sql);  						
                        $rowdata= mysqli_fetch_row($result);
						$addAlternateNo = $rowdata[0];
				
					$sql = "INSERT INTO petmate(first_image_path, second_image_path, third_image_path, pet_category, pet_breed, pet_age_inMonth, pet_age_inYear, pet_gender, pet_description, post_date, email,alternateNo)
							VALUES 
							('".$petMateDetail->getTargetPathOfFirstImage()."',
							 '".$petMateDetail->getTargetPathOfSecondImage()."',
							 '".$petMateDetail->getTargetPathOfThirdImage()."',
							 '".$petMateDetail->getCategoryOfPet()."',
							 '".$petMateDetail->getBreedOfPet()."',
							 '".$petMateDetail->getAgeInMonth()."',
							 '".$petMateDetail->getAgeInYear()."',
							 '".$petMateDetail->getGenderOfPet()."',
							 '".$petMateDetail->getDescriptionOfPet()."',
							 '".$petMateDetail->getPostDate()."',
							 '".$petMateDetail->getEmail()."',
							 '$addAlternateNo'
							)";
			
					$isInserted = mysqli_query($this->con, $sql);
					if ($isInserted) {
						$this->data = "PET_DETAILS_SAVED";
					} else {
						$this->data = "ERROR";
					}
				} else {
					$sql = "INSERT INTO petmate(first_image_path, second_image_path, third_image_path, pet_category, pet_breed, pet_age_inMonth, pet_age_inYear, pet_gender, pet_description, post_date, email,alternateNo)
							VALUES 
							('".$petMateDetail->getTargetPathOfFirstImage()."',
							 '".$petMateDetail->getTargetPathOfSecondImage()."',
							 '".$petMateDetail->getTargetPathOfThirdImage()."',
							 '".$petMateDetail->getCategoryOfPet()."',
							 '".$petMateDetail->getBreedOfPet()."',
							 '".$petMateDetail->getAgeInMonth()."',
							 '".$petMateDetail->getAgeInYear()."',
							 '".$petMateDetail->getGenderOfPet()."',
							 '".$petMateDetail->getDescriptionOfPet()."',
							 '".$petMateDetail->getPostDate()."',
							 '".$petMateDetail->getEmail()."',
							 '".$petDetail->getAlternateNo()."'
							)";
			
					$isInserted = mysqli_query($this->con, $sql);
					if ($isInserted) {
						$this->data = "PET_DETAILS_SAVED";
					} else {
						$this->data = "ERROR";
					}
				}
            }
            else {
                $this->data = "ERROR";
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

    public function saveForDesktopDetail($petMateDetail) {
        try {
            $status = 0;
            $petsTempNames = array($petMateDetail->getFirstImageTemporaryName(), $petMateDetail->getSecondImageTemporaryName(), $petMateDetail->getThirdImageTemporaryName());
            $petsTargetPaths = array($petMateDetail->getTargetPathOfFirstImage(), $petMateDetail->getTargetPathOfSecondImage(), $petMateDetail->getTargetPathOfThirdImage());
            foreach ($petsTempNames as $index => $petsTempName) {
                $petImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $petsTempName));
                if($petsTargetPaths[$index] != "") {
                    if(file_put_contents($petsTargetPaths[$index], $petImage)) {
                        $status = 1;
                    }
                }
            }  
            if($status = 1) {
                $addAlternateNo = $petMateDetail->getAlternateNo();
                if($addAlternateNo == ""){
                    
                    $sql = "SELECT mobileno FROM userDetails WHERE email='".$petMateDetail->getEmail()."'";
                    $result = mysqli_query($this->con, $sql);                       
                        $rowdata= mysqli_fetch_row($result);
                        $addAlternateNo = $rowdata[0];
                
                    $sql = "INSERT INTO petmate(first_image_path, second_image_path, third_image_path, pet_category, pet_breed, pet_age_inMonth, pet_age_inYear, pet_gender, pet_description, post_date, email,alternateNo)
                            VALUES 
                            ('".$petMateDetail->getTargetPathOfFirstImage()."',
                             '".$petMateDetail->getTargetPathOfSecondImage()."',
                             '".$petMateDetail->getTargetPathOfThirdImage()."',
                             '".$petMateDetail->getCategoryOfPet()."',
                             '".$petMateDetail->getBreedOfPet()."',
                             '".$petMateDetail->getAgeInMonth()."',
                             '".$petMateDetail->getAgeInYear()."',
                             '".$petMateDetail->getGenderOfPet()."',
                             '".$petMateDetail->getDescriptionOfPet()."',
                             '".$petMateDetail->getPostDate()."',
                             '".$petMateDetail->getEmail()."',
                             '$addAlternateNo'
                            )";
            
                    $isInserted = mysqli_query($this->con, $sql);
                    if ($isInserted) {
                        $this->data = "PET_DETAILS_SAVED";
                    } else {
                        $this->data = "ERROR";
                    }
                } else {
                    $sql = "INSERT INTO petmate(first_image_path, second_image_path, third_image_path, pet_category, pet_breed, pet_age_inMonth, pet_age_inYear, pet_gender, pet_description, post_date, email,alternateNo)
                            VALUES 
                            ('".$petMateDetail->getTargetPathOfFirstImage()."',
                             '".$petMateDetail->getTargetPathOfSecondImage()."',
                             '".$petMateDetail->getTargetPathOfThirdImage()."',
                             '".$petMateDetail->getCategoryOfPet()."',
                             '".$petMateDetail->getBreedOfPet()."',
                             '".$petMateDetail->getAgeInMonth()."',
                             '".$petMateDetail->getAgeInYear()."',
                             '".$petMateDetail->getGenderOfPet()."',
                             '".$petMateDetail->getDescriptionOfPet()."',
                             '".$petMateDetail->getPostDate()."',
                             '".$petMateDetail->getEmail()."',
                             '".$petDetail->getAlternateNo()."'
                            )";
            
                    $isInserted = mysqli_query($this->con, $sql);
                    if ($isInserted) {
                        $this->data = "PET_DETAILS_SAVED";
                    } else {
                        $this->data = "ERROR";
                    }
                }
            }
            else {
                $this->data = "ERROR";
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

	public function showUserWishList($userWishList) {
        try {           
			$sql ="SELECT *
					FROM petMateList_wishList 			
					WHERE email='".$userWishList->getEmail()."' ";
					
            $result = mysqli_query($this->con, $sql);   
            $this->data=array();
            while ($rowdata = mysqli_fetch_assoc($result)) {
                $this->data[]=$rowdata;
            }
            return $this->data;
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data=array();
    }
    
    public function showDetail($pageWiseData) {
		
		$sqlAddress="SELECT latitude,longitude FROM userDetails WHERE email='".$pageWiseData->getEmail()."' ";
		$latlong = mysqli_query($this->con, $sqlAddress);
		
		$latLongValue = mysqli_fetch_row($latlong);
		$latitude = $latLongValue[0];
		$longitude = $latLongValue[1];
        $sql = "SELECT pm.id, pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date, pm.alternateNo, ud.name, ud.email,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                FROM petmate pm
                INNER JOIN userDetails ud
                ON pm.email = ud.email
                HAVING distance < 20 ORDER BY distance";        
        try {
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
            
                $sql = "SELECT pm.id, pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,pm.alternateNo, ud.name, ud.email,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
						FROM petmate pm
						INNER JOIN userDetails ud
						ON pm.email = ud.email
						HAVING distance < 20 ORDER BY distance, post_date DESC LIMIT $offset, $rowsPerPage";
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
	 public function showRefreshListDetail($DateOfPost) {
        $sqlAddress="SELECT latitude,longitude FROM userDetails WHERE email='".$DateOfPost->getEmail()."' ";
		$latlong = mysqli_query($this->con, $sqlAddress);
		
		$latLongValue = mysqli_fetch_row($latlong);
		$latitude = $latLongValue[0];
		$longitude = $latLongValue[1];
        
        try {
            $sql = "SELECT pm.id, pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear,pm.pet_gender, pm.pet_description, pm.post_date,pm.alternateNo, ud.name, ud.email,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
						FROM petmate pm
						INNER JOIN userDetails ud
						ON pm.email = ud.email 
						WHERE post_date > '".$DateOfPost->getPostDate()."' ";
            $result = mysqli_query($this->con, $sql);   
            $this->data=array();
            while ($rowdata = mysqli_fetch_assoc($result)) {
                $this->data[]=$rowdata;
            }            
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
}
?>