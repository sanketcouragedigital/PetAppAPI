<?php
require_once 'BaseDAO.php';
class PetDetailsDAO
{    
    private $con;
    private $msg;
    private $data;
    private $googleAPIKey;
    
    // Attempts to initialize the database connection using the supplied info.
    public function PetDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
        $this->googleAPIKey = $baseDAO->getGoogleAPIKey();
    }
    
    public function saveDetail($petDetail) {
        try {			
				$status = 0;
				$petsTempNames = array($petDetail->getFirstImageTemporaryName(), $petDetail->getSecondImageTemporaryName(), $petDetail->getThirdImageTemporaryName());
				$petsTargetPaths = array($petDetail->getTargetPathOfFirstImage(), $petDetail->getTargetPathOfSecondImage(), $petDetail->getTargetPathOfThirdImage());
				foreach ($petsTempNames as $index => $petsTempName) {
					if(move_uploaded_file($petsTempName, $petsTargetPaths[$index])) {
						$status = 1;
					}
				}            
				if($status = 1) {
					$addAlternateNo = $petDetail->getAlternateNo();
					if($addAlternateNo == "") {
						$sql = "SELECT mobileno FROM userDetails WHERE email='".$petDetail->getEmail()."'";
						$result = mysqli_query($this->con, $sql);  
							//$rowdata = mysqli_fetch_assoc($result);
							$rowdata= mysqli_fetch_row($result);
							$addAlternateNo = $rowdata[0];
							
						$sql = "INSERT INTO petapp(first_image_path, second_image_path, third_image_path, pet_category, pet_breed, pet_age_inMonth, pet_age_inYear, pet_gender, pet_description, pet_adoption, pet_price, post_date, email,alternateNo)
										VALUES 
										('".$petDetail->getTargetPathOfFirstImage()."',
										 '".$petDetail->getTargetPathOfSecondImage()."',
										 '".$petDetail->getTargetPathOfThirdImage()."',
										 '".$petDetail->getCategoryOfPet()."',
										 '".$petDetail->getBreedOfPet()."',
										 '".$petDetail->getAgeInMonth()."',
										 '".$petDetail->getAgeInYear()."',
										 '".$petDetail->getGenderOfPet()."',
										 '".$petDetail->getDescriptionOfPet()."',  
										 '".$petDetail->getAdoptionOfPet()."',
										 '".$petDetail->getPriceOfPet()."',
										 '".$petDetail->getPostDate()."',
										 '".$petDetail->getEmail()."',
										 '$addAlternateNo'
										 )";
						
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {
							$this->data = "PET_DETAILS_SAVED";
							
								$checkSql= "SELECT pet_breed FROM pet_categories WHERE pet_breed='".$petDetail->getBreedOfPet()."'";
								$result = mysqli_query($this->con, $checkSql);
								$count=mysqli_num_rows($result);
								if($count!=1) {
									$addBreedSQL = "INSERT INTO pet_categories(pet_category, pet_breed)
									VALUES('".$petDetail->getCategoryOfPet()."','".$petDetail->getBreedOfPet()."')";
									$isInserted = mysqli_query($this->con, $addBreedSQL);
								}

								if($petDetail->getAdoptionOfPet() == "For Adoption") {
						            $setListingType = $petDetail->getAdoptionOfPet();
						        }
						        else {
						            $setListingType = $petDetail->getPriceOfPet();
						        }

								$this->msg = array
								(	
									'PET_NOTIFICATION_TYPE' => 'OPEN_ACTIVITY_PET_DETAILS',
									'PET_FIRST_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfFirstImage(),
									'PET_SECOND_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfSecondImage(),
									'PET_THIRD_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfThirdImage(),
									'PET_BREED' => $petDetail->getBreedOfPet(),
									'PET_LISTING_TYPE' => $setListingType,
									'PET_AGE_MONTH'	=> $petDetail->getAgeInMonth(),
									'PET_AGE_YEAR' => $petDetail->getAgeInYear(),
									'PET_GENDER' => $petDetail->getGenderOfPet(),
									'PET_DESCRIPTION' => $petDetail->getDescriptionOfPet(),
									'POST_OWNER_MOBILENO' => $addAlternateNo,
								);
								$this->fetchFirebaseTokenUsers($this->msg, $petDetail->getDeviceId());
						} else {
							$this->data = "ERROR";
						}			
					} else {
						$sql = "INSERT INTO petapp(first_image_path, second_image_path, third_image_path, pet_category, pet_breed, pet_age_inMonth, pet_age_inYear, pet_gender, pet_description, pet_adoption, pet_price, post_date, email,alternateNo)
										VALUES 
										('".$petDetail->getTargetPathOfFirstImage()."',
										 '".$petDetail->getTargetPathOfSecondImage()."',
										 '".$petDetail->getTargetPathOfThirdImage()."',
										 '".$petDetail->getCategoryOfPet()."',
										 '".$petDetail->getBreedOfPet()."',
										 '".$petDetail->getAgeInMonth()."',
										 '".$petDetail->getAgeInYear()."',
										 '".$petDetail->getGenderOfPet()."',
										 '".$petDetail->getDescriptionOfPet()."',   
										 '".$petDetail->getAdoptionOfPet()."',
										 '".$petDetail->getPriceOfPet()."',
										 '".$petDetail->getPostDate()."',
										 '".$petDetail->getEmail()."',
										 '".$petDetail->getAlternateNo()."'
										 )";
						
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {
							$this->data = "PET_DETAILS_SAVED";
							$checkSql= "SELECT pet_breed FROM pet_categories WHERE pet_breed='".$petDetail->getBreedOfPet()."'";
								$result = mysqli_query($this->con, $checkSql);
								$count=mysqli_num_rows($result);
								if($count!=1) {
									$addBreedSQL = "INSERT INTO pet_categories(pet_category, pet_breed)
									VALUES('".$petDetail->getCategoryOfPet()."','".$petDetail->getBreedOfPet()."')";
									$isInserted = mysqli_query($this->con, $addBreedSQL);
								}

								if($petDetail->getAdoptionOfPet() == "For Adoption") {
						            $setListingType = $petDetail->getAdoptionOfPet();
						        }
						        else {
						            $setListingType = $petDetail->getPriceOfPet();
						        }

								$this->msg = array
								(	
									'PET_NOTIFICATION_TYPE' => 'OPEN_ACTIVITY_PET_DETAILS',
									'PET_FIRST_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfFirstImage(),
									'PET_SECOND_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfSecondImage(),
									'PET_THIRD_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfThirdImage(),
									'PET_BREED' => $petDetail->getBreedOfPet(),
									'PET_LISTING_TYPE' => $setListingType,
									'PET_AGE_MONTH'	=> $petDetail->getAgeInMonth(),
									'PET_AGE_YEAR' => $petDetail->getAgeInYear(),
									'PET_GENDER' => $petDetail->getGenderOfPet(),
									'PET_DESCRIPTION' => $petDetail->getDescriptionOfPet(),
									'POST_OWNER_MOBILENO' => $petDetail->getAlternateNo(),
								);
								$this->fetchFirebaseTokenUsers($this->msg, $petDetail->getDeviceId());
						} else {
							$this->data = "ERROR";
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

    public function saveForDesktopDetail($petDetail) {
        try {			
				$status = 0;
				$petsTempNames = array($petDetail->getFirstImageTemporaryName(), $petDetail->getSecondImageTemporaryName(), $petDetail->getThirdImageTemporaryName());
				$petsTargetPaths = array($petDetail->getTargetPathOfFirstImage(), $petDetail->getTargetPathOfSecondImage(), $petDetail->getTargetPathOfThirdImage());
				foreach ($petsTempNames as $index => $petsTempName) {
					$petImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $petsTempName));
			        if($petsTargetPaths[$index] != "") {
			            if(file_put_contents($petsTargetPaths[$index], $petImage)) {
			        	    $status = 1;
			            }
			        }
				}            
				if($status = 1) {
					$addAlternateNo = $petDetail->getAlternateNo();
					if($addAlternateNo == ""){
						$sql = "SELECT mobileno FROM userDetails WHERE email='".$petDetail->getEmail()."'";
						$result = mysqli_query($this->con, $sql);
							//$rowdata = mysqli_fetch_assoc($result);
							$rowdata= mysqli_fetch_row($result);
							$addAlternateNo = $rowdata[0];
							
						$sql = "INSERT INTO petapp(first_image_path, second_image_path, third_image_path, pet_category, pet_breed, pet_age_inMonth, pet_age_inYear, pet_gender, pet_description, pet_adoption, pet_price, post_date, email,alternateNo)
										VALUES 
										('".$petDetail->getTargetPathOfFirstImage()."',
										 '".$petDetail->getTargetPathOfSecondImage()."',
										 '".$petDetail->getTargetPathOfThirdImage()."',
										 '".$petDetail->getCategoryOfPet()."',
										 '".$petDetail->getBreedOfPet()."',
										 '".$petDetail->getAgeInMonth()."',
										 '".$petDetail->getAgeInYear()."',
										 '".$petDetail->getGenderOfPet()."',
										 '".$petDetail->getDescriptionOfPet()."',
										 '".$petDetail->getAdoptionOfPet()."',
										 '".$petDetail->getPriceOfPet()."',
										 '".$petDetail->getPostDate()."',
										 '".$petDetail->getEmail()."',
										 '$addAlternateNo'
										 )";
						
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {
							$this->data = "PET_DETAILS_SAVED";
							
								$checkSql= "SELECT pet_breed FROM pet_categories WHERE pet_breed='".$petDetail->getBreedOfPet()."'";
								$result = mysqli_query($this->con, $checkSql);
								$count=mysqli_num_rows($result);
								if($count!=1) {
									$addBreedSQL = "INSERT INTO pet_categories(pet_category, pet_breed)
									VALUES('".$petDetail->getCategoryOfPet()."','".$petDetail->getBreedOfPet()."')";
									$isInserted = mysqli_query($this->con, $addBreedSQL);
								}

								if($petDetail->getAdoptionOfPet() == "For Adoption") {
						            $setListingType = $petDetail->getAdoptionOfPet();
						        }
						        else {
						            $setListingType = $petDetail->getPriceOfPet();
						        }

								$this->msg = array
								(	
									'PET_NOTIFICATION_TYPE' => 'OPEN_ACTIVITY_PET_DETAILS',
									'PET_FIRST_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfFirstImage(),
									'PET_SECOND_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfSecondImage(),
									'PET_THIRD_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfThirdImage(),
									'PET_BREED' => $petDetail->getBreedOfPet(),
									'PET_LISTING_TYPE' => $setListingType,
									'PET_AGE_MONTH'	=> $petDetail->getAgeInMonth(),
									'PET_AGE_YEAR' => $petDetail->getAgeInYear(),
									'PET_GENDER' => $petDetail->getGenderOfPet(),
									'PET_DESCRIPTION' => $petDetail->getDescriptionOfPet(),
									'POST_OWNER_MOBILENO' => $addAlternateNo,
								);
								$this->fetchFirebaseTokenUsers($this->msg, $petDetail->getDeviceId());
						} else {
							$this->data = "ERROR";
						}			
					} else {									
						$sql = "INSERT INTO petapp(first_image_path, second_image_path, third_image_path, pet_category, pet_breed, pet_age_inMonth, pet_age_inYear, pet_gender, pet_description, pet_adoption, pet_price, post_date, email,alternateNo)
										VALUES 
										('".$petDetail->getTargetPathOfFirstImage()."',
										 '".$petDetail->getTargetPathOfSecondImage()."',
										 '".$petDetail->getTargetPathOfThirdImage()."',
										 '".$petDetail->getCategoryOfPet()."',
										 '".$petDetail->getBreedOfPet()."',
										 '".$petDetail->getAgeInMonth()."',
										 '".$petDetail->getAgeInYear()."',
										 '".$petDetail->getGenderOfPet()."',
										 '".$petDetail->getDescriptionOfPet()."',   
										 '".$petDetail->getAdoptionOfPet()."',
										 '".$petDetail->getPriceOfPet()."',
										 '".$petDetail->getPostDate()."',
										 '".$petDetail->getEmail()."',
										 '".$petDetail->getAlternateNo()."'
										 )";
						
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {
							$this->data = "PET_DETAILS_SAVED";
							$checkSql= "SELECT pet_breed FROM pet_categories WHERE pet_breed='".$petDetail->getBreedOfPet()."'";
								$result = mysqli_query($this->con, $checkSql);
								$count=mysqli_num_rows($result);
								if($count!=1) {
									$addBreedSQL = "INSERT INTO pet_categories(pet_category, pet_breed)
									VALUES('".$petDetail->getCategoryOfPet()."','".$petDetail->getBreedOfPet()."')";
									$isInserted = mysqli_query($this->con, $addBreedSQL);
								}

								if($petDetail->getAdoptionOfPet() == "For Adoption") {
						            $setListingType = $petDetail->getAdoptionOfPet();
						        }
						        else {
						            $setListingType = $petDetail->getPriceOfPet();
						        }

								$this->msg = array
								(	
									'PET_NOTIFICATION_TYPE' => 'OPEN_ACTIVITY_PET_DETAILS',
									'PET_FIRST_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfFirstImage(),
									'PET_SECOND_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfSecondImage(),
									'PET_THIRD_IMAGE' => 'http://petoandme.com/API/pet_images/'.$petDetail->getTargetPathOfThirdImage(),
									'PET_BREED' => $petDetail->getBreedOfPet(),
									'PET_LISTING_TYPE' => $setListingType,
									'PET_AGE_MONTH'	=> $petDetail->getAgeInMonth(),
									'PET_AGE_YEAR' => $petDetail->getAgeInYear(),
									'PET_GENDER' => $petDetail->getGenderOfPet(),
									'PET_DESCRIPTION' => $petDetail->getDescriptionOfPet(),
									'POST_OWNER_MOBILENO' => $petDetail->getAlternateNo(),
								);
								$this->fetchFirebaseTokenUsers($this->msg, $petDetail->getDeviceId());
						} else {
							$this->data = "ERROR";
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

	public function showUserWishList($userWishList) {
        try {           
			$sql ="SELECT *
					FROM petList_wishList 			
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
        try {
			$sql = "SELECT * FROM petapp";
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
            
               /* $sql = "SELECT p.first_image_path, p.second_image_path, p.third_image_path, p.pet_category, p.pet_breed, p.pet_age_inMonth, p.pet_age_inYear, p.pet_gender, p.pet_description, p.pet_adoption, p.pet_price, p.post_date, p.email, ud.name, ud.mobileno 
                        FROM petapp p
                        INNER JOIN userDetails ud
                        ON p.email = ud.email
                        ORDER BY post_date DESC LIMIT $offset, $rowsPerPage";*/
						$sql = "SELECT p.id,p.first_image_path, p.second_image_path, p.third_image_path, p.pet_category, p.pet_breed, p.pet_age_inMonth, p.pet_age_inYear, p.pet_gender, p.pet_description, p.pet_adoption, p.pet_price, p.post_date, p.email, p.alternateNo, ud.name 
								FROM petapp p
								INNER JOIN userDetails ud
								ON p.email = ud.email
								ORDER BY post_date DESC LIMIT $offset, $rowsPerPage ";
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
        try {
            /*$sql = "SELECT p.first_image_path, p.second_image_path, p.third_image_path, p.pet_category, p.pet_breed, p.pet_age_inMonth, p.pet_age_inYear, p.pet_gender, p.pet_description, p.pet_adoption, p.pet_price, p.post_date, p.email, ud.name, ud.mobileno 
                    FROM petapp p
                    INNER JOIN userDetails ud
                    ON p.email = ud.email 
                    WHERE post_date > '".$DateOfPost->getPostDate()."' " */
			$sql ="SELECT p.id, p.first_image_path, p.second_image_path, p.third_image_path, p.pet_category, p.pet_breed, p.pet_age_inMonth, p.pet_age_inYear, p.pet_gender, p.pet_description, p.pet_adoption, p.pet_price, p.post_date, p.email, p.alternateNo, ud.name 
					FROM petapp p
					INNER JOIN userDetails ud
					ON p.email = ud.email
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

    function fetchFirebaseTokenUsers($message, $deviceId) {       
    	$query = "SELECT token FROM firebase_tokens";
    	$fcmRegIds = array();
	    if($query_run = mysqli_query($this->con, $query)) {	        
	        while($query_row = mysqli_fetch_assoc($query_run)) {
	            //$fcmRegIds[] = $query_row['token'];
	            array_push($fcmRegIds, $query_row['token']);
	        }
	    }
	    
	    if($deviceId != null) {
            $query = "SELECT token FROM firebase_tokens WHERE device_id = '$deviceId'";
            if ($query_run = mysqli_query($this->con, $query)) {
                while($query_row = mysqli_fetch_array($query_run)) {
                    $fcmToken = $query_row['token'];
                    if (($key = array_search($fcmToken, $fcmRegIds)) !== false) {
                        unset($fcmRegIds[$key]);
                    }
                }
            }            
        }
        
        define('GOOGLE_API_KEY', 'AIzaSyCmwKfKS6M75W814jOQ0r3o8bpVdYCoD8A');
        
	    if(isset($fcmRegIds)) {
	        foreach ($fcmRegIds as $key => $token) {
				$pushStatus = $this->sendPushNotification($token, $message);
			}
	    }
    }

    function sendPushNotification($registration_id, $message) {

    	ignore_user_abort();
    	ob_start();

	    $url = 'https://fcm.googleapis.com/fcm/send';

	    $fields = array(
	        'to' => $registration_id,
	        'data' => $message,
	    );	    

	    $headers = array(
	        'Authorization:key='.$this->googleAPIKey,
	        'Content-Type: application/json'
	    );	    
	    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

	    $result = curl_exec($ch);
	    if($result === false)
	        die('Curl failed ' . curl_error());

	    curl_close($ch);
	    ob_flush();
	}
}
?>