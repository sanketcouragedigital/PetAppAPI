<?php

require_once 'BaseDAO.php';
class UsersDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function UsersDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function saveDetail($UsersDetail) {
		
        try {
			
				//convert area to lat long..
					$address = "'".$UsersDetail->getArea()."'";
					$region = "'".$UsersDetail->getCity()."'";
					$address = str_replace(" ", "+", $address);
					$region= str_replace(" ", "+", $region);
					
					$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
					$json = json_decode($json);

					$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
					$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
					
                $sql = "INSERT INTO userDetails(name,buildingname,area,city,mobileno,email,password,latitude,longitude)
                        VALUES ('".$UsersDetail->getName()."', '".$UsersDetail->getBuildingname()."', '".$UsersDetail->getArea()."', '".$UsersDetail->getCity()."', '".$UsersDetail->getMobileno()."', '".$UsersDetail->getEmail()."', '".$UsersDetail->getPassword()."','$lat','$long')";
        
                $isInserted = mysqli_query($this->con, $sql);
                if ($isInserted) {
					$this->data = "USERS_DETAILS_SAVED";
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