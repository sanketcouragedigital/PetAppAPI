<?php

require_once 'BaseDAO.php';
class ClinicDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function ClinicDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    
    public function showByCurrentLocation($latlong) {
        $sql = "SELECT clinic_name,clinic_address,doctor_name,contact,email,clinic_image,city,area,( 3959 * acos( cos( radians('".$latlong->getLatitude()."') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('".$latlong->getLongitude()."') ) + sin( radians('".$latlong->getLatitude()."') ) * sin( radians( latitude ) ) ) ) * 1.609344 AS distance
				FROM petclinic
				HAVING distance < 5 ORDER BY distance";
        
        try {
            $result = mysqli_query($this->con, $sql);
            $count = mysqli_fetch_row($result);
            $numOfRows = count($count);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($latlong->getCurrentPage())) {
                $currentPage = (int) $latlong->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
            
                $sql = "SELECT clinic_name,clinic_address,doctor_name,contact,email,clinic_image,city,area,( 3959 * acos( cos( radians('".$latlong->getLatitude()."') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('".$latlong->getLongitude()."') ) + sin( radians('".$latlong->getLatitude()."') ) * sin( radians( latitude ) ) ) ) * 1.609344 AS distance
						FROM petclinic
						HAVING distance < 5 ORDER BY distance
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
	
	 public function showByAddress($pageWiseData) {
		$sqlAddress="SELECT latitude,longitude FROM userDetails WHERE email='".$pageWiseData->getEmail()."' ";
		$latlong = mysqli_query($this->con, $sqlAddress);
		
		$latLongValue = mysqli_fetch_row($latlong);
		$latitude = $latLongValue[0];
		$longitude = $latLongValue[1];
			
			
        $sql = "SELECT clinic_name,clinic_address,doctor_name,contact,email,clinic_image,city,area,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) * 1.609344 AS distance
					FROM petclinic
					HAVING distance < 5 ORDER BY distance";
        
        try {
            $result = mysqli_query($this->con, $sql);
            $count = mysqli_fetch_row($result);
            $numOfRows = count($count);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (is_numeric($pageWiseData->getCurrentPage())) {
                $currentPage = (int) $pageWiseData->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
            
                $sql = "SELECT clinic_name,clinic_address,doctor_name,contact,email,clinic_image,city,area,(3959 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) * 1.609344 AS distance
							FROM petclinic
							HAVING distance < 5 ORDER BY distance LIMIT $offset, $rowsPerPage";
							
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