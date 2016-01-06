<?php

require_once 'BaseDAO.php';
class FilterPetListDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function FilterPetListDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }

    public function showBreedsCategoryWise($categoryWiseBreed) {
        $this->data=array();
        $categories = array();
        $categories = json_decode($categoryWiseBreed->getFilterSelectedCategories());
        foreach($categories as $category) {
            $category = trim($category);
            $sql = "SELECT * FROM pet_categories WHERE pet_category='$category'";
            
            try {
                $select = mysqli_query($this->con, $sql);
                
                while ($rowdata = mysqli_fetch_assoc($select)) {
                    $this->data[]=$rowdata;
                }
            } catch(Exception $e) {
                echo 'SQL Exception: ' .$e->getMessage();
            }
        }
        return $this->data;
    }
    
    public function showFilteredPetList($filterPetList) {
        $this->data=array();
        $categories = array();
        $breeds = array();
        $ages = array();
        $genders = array();
        $adoptionAndPrices = array();
        $categories = json_decode($filterPetList->getFilterSelectedCategories());
        $breeds = json_decode($filterPetList->getFilterSelectedBreeds());
        $ages = json_decode($filterPetList->getFilterSelectedAge());
        $genders = json_decode($filterPetList->getFilterSelectedGender());
        $adoptionAndPrices = json_decode($filterPetList->getFilterSelectedAdoptionAndPrice());
        
        $minAge = $ages[0];
        $maxAge = $ages[1];
                
        foreach($categories as $category) {
            $category = trim($category);
            
            foreach($breeds as $breed) {
                $breed = trim($breed);              
                
                foreach($genders as $gender) {
                    $gender = trim($gender);
                        
                    foreach($adoptionAndPrices as $adoptionAndPrice) {
                        $adoptionAndPrice = trim($adoptionAndPrice);
                        if($adoptionAndPrice == "For Adoption"){
                            $sql = "SELECT p.image_path, p.pet_category, p.pet_breed, p.pet_age, p.pet_gender, p.pet_description, p.pet_adoption, p.pet_price, p.post_date, p.email, ud.name, ud.mobileno 
                                    FROM petapp p
                                    INNER JOIN userDetails ud
                                    ON p.email = ud.email
                                    WHERE pet_category='$category' AND pet_breed='$breed' AND pet_age BETWEEN '$minAge' AND '$maxAge' AND pet_gender='$gender' AND pet_adoption='$adoptionAndPrice' ";
                        }
                        else if($adoptionAndPrice == "50000 Onwards") {
                            $sql = "SELECT p.image_path, p.pet_category, p.pet_breed, p.pet_age, p.pet_gender, p.pet_description, p.pet_adoption, p.pet_price, p.post_date, p.email, ud.name, ud.mobileno 
                                    FROM petapp p
                                    INNER JOIN userDetails ud
                                    ON p.email = ud.email 
                                    WHERE pet_category='$category' AND pet_breed='$breed' AND pet_age BETWEEN '$minAge' AND '$maxAge' AND pet_gender='$gender' AND pet_price >= 50000 ";
                        }
                        else {
                            $splitPrice = explode("-", $adoptionAndPrice);
                            $minPrice = trim($splitPrice[0]);
                            $maxPrice = trim($splitPrice[1]);
                            $sql = "SELECT p.image_path, p.pet_category, p.pet_breed, p.pet_age, p.pet_gender, p.pet_description, p.pet_adoption, p.pet_price, p.post_date, p.email, ud.name, ud.mobileno 
                                    FROM petapp p
                                    INNER JOIN userDetails ud
                                    ON p.email = ud.email
                                    WHERE pet_category='$category' AND pet_breed='$breed' AND pet_age BETWEEN '$minAge' AND '$maxAge' AND pet_gender='$gender' AND pet_price BETWEEN '$minPrice' AND '$maxPrice' ";
                        }
            
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
        }
        return $this->data;
    }
}
?>