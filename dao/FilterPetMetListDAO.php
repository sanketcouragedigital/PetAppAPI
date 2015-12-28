<?php

require_once 'BaseDAO.php';
class FilterPetMetListDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function FilterPetMetListDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function showFilteredPetMetList($filterPetMetList) {
        $this->data=array();
        $categories = array();
        $breeds = array();
        $ages = array();
        $genders = array();
        $categories = json_decode($filterPetMetList->getFilterSelectedCategories());
        $breeds = json_decode($filterPetMetList->getFilterSelectedBreeds());
        $ages = json_decode($filterPetMetList->getFilterSelectedAge());
        $genders = json_decode($filterPetMetList->getFilterSelectedGender());
        
        $minAge = $ages[0];
        $maxAge = $ages[1];        
        
        $sqlAddress="SELECT latitude,longitude FROM userDetails WHERE email='".$filterPetMetList->getEmail()."' ";
        $latlong = mysqli_query($this->con, $sqlAddress);
        
        $latLongValue = mysqli_fetch_row($latlong);
        $latitude = $latLongValue[0];
        $longitude = $latLongValue[1];
                
        foreach($categories as $category) {
            $category = trim($category);
            
            foreach($breeds as $breed) {
                $breed = trim($breed);              
                
                foreach($genders as $gender) {
                    $gender = trim($gender);
                    $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                    $sql = "SELECT pm.image_path, pm.pet_category, pm.pet_breed, pm.pet_age, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                            FROM petmet pm 
                            INNER JOIN userDetails ud
                            ON pm.email = ud.email
                            WHERE pet_category='$category' AND pet_breed='$breed' AND pet_age BETWEEN '$minAge' AND '$maxAge' AND pet_gender='$gender'
                            HAVING distance < 5 ORDER BY distance ";
                    try {
                        $select = mysqli_query($this->con, $sql);
                
                        while ($rowdata = mysqli_fetch_assoc($select)) {
                            $this->data[]=$rowdata;
                        }
                    } catch(Exception $e) {
                        echo 'SQL Exception: ' .$e->getMessage();
                    }
                }
            }  
        }
        return $this->data;
    }
}
?>