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

    public function saveGroomerDetailsFromDesktop($groomerDetail) {
        try {           
                $status = 0;
                if($groomerDetail->getImageName() != "") {
                    $groomerImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $groomerDetail->getImage()));
                    if(file_put_contents($groomerDetail->getImageName(), $groomerImage)) {
                        $status = 1;
                    }
                }          
                if($status = 1) {

                    $sql = "INSERT INTO pet_groomer(image, name, description, address, area, city, contact, email, timing)
                            VALUES 
                            ('".$groomerDetail->getImageName()."',
                            '".$groomerDetail->getName()."',
                            '".$groomerDetail->getDescription()."',
                            '".$groomerDetail->getAddress()."',
                            '".$groomerDetail->getArea()."',
                            '".$groomerDetail->getCity()."',
                            '".$groomerDetail->getContact()."',
                            '".$groomerDetail->getEmail()."',
                            '".$groomerDetail->getTiming()."'
                            )";
                        
                    $isInserted = mysqli_query($this->con, $sql);
                    if ($isInserted) {
                        $this->data = "GROOMER_DETAILS_SAVED";
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

    public function saveShelterDetailsFromDesktop($shelterDetail) {
        try {           
                $status = 0;
                if($shelterDetail->getImageName() != "") {
                    $shelterImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $shelterDetail->getImage()));
                    if(file_put_contents($shelterDetail->getImageName(), $shelterImage)) {
                        $status = 1;
                    }
                }          
                if($status = 1) {

                    $sql = "INSERT INTO pet_shelter(image, name, description, address, area, city, contact, email, timing)
                            VALUES 
                            ('".$shelterDetail->getImageName()."',
                            '".$shelterDetail->getName()."',
                            '".$shelterDetail->getDescription()."',
                            '".$shelterDetail->getAddress()."',
                            '".$shelterDetail->getArea()."',
                            '".$shelterDetail->getCity()."',
                            '".$shelterDetail->getContact()."',
                            '".$shelterDetail->getEmail()."',
                            '".$shelterDetail->getTiming()."'
                            )";
                        
                    $isInserted = mysqli_query($this->con, $sql);
                    if ($isInserted) {
                        $this->data = "SHELTER_DETAILS_SAVED";
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

    public function saveTrainerDetailsFromDesktop($trainerDetail) {
        try {           
                $status = 0;
                if($trainerDetail->getImageName() != "") {
                    $trainerImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $trainerDetail->getImage()));
                    if(file_put_contents($trainerDetail->getImageName(), $trainerImage)) {
                        $status = 1;
                    }
                }          
                if($status = 1) {

                    $sql = "INSERT INTO pet_trainer(image, name, description, address, area, city, contact, email, timing)
                            VALUES 
                            ('".$trainerDetail->getImageName()."',
                            '".$trainerDetail->getName()."',
                            '".$trainerDetail->getDescription()."',
                            '".$trainerDetail->getAddress()."',
                            '".$trainerDetail->getArea()."',
                            '".$trainerDetail->getCity()."',
                            '".$trainerDetail->getContact()."',
                            '".$trainerDetail->getEmail()."',
                            '".$trainerDetail->getTiming()."'
                            )";
                        
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
