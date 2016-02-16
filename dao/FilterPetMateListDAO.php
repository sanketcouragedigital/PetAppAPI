<?php
require_once 'BaseDAO.php';
require_once 'CacheMemcache.php';

class FilterPetMateListDAO {

    private $con;
    private $msg;
    private $data;

    // Attempts to initialize the database connection using the supplied info.
    public function FilterPetMateListDAO() {
        $baseDAO = new BaseDAO();
        $this -> con = $baseDAO -> getConnection();
    }

    public function showFilteredPetMateList($filterPetMateList) {
        $this->data = array();
        $categories = array();
        $breeds = array();
        $ages = array();
        $genders = array();
        $email = $filterPetMateList->getEmail();
        $categories = json_decode($filterPetMateList -> getFilterSelectedCategories());
        $breeds = json_decode($filterPetMateList -> getFilterSelectedBreeds());
        $ages = json_decode($filterPetMateList -> getFilterSelectedAge());
        $genders = json_decode($filterPetMateList -> getFilterSelectedGender());

        $sqlAddress = "SELECT latitude,longitude FROM userDetails WHERE email='" . $filterPetMateList -> getEmail() . "' ";
        $latlong = mysqli_query($this -> con, $sqlAddress);

        $latLongValue = mysqli_fetch_row($latlong);
        $latitude = $latLongValue[0];
        $longitude = $latLongValue[1];

        if((int) $filterPetMateList->getCurrentPage() == 1) {
            if (empty($categories) && empty($ages)) {
                foreach ($genders as $gender) {
                    $gender = trim($gender);
                    $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                    $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                            FROM petmate pm 
                            INNER JOIN userDetails ud
                            ON pm.email = ud.email
                            WHERE pet_gender='$gender'
                            HAVING distance < 5 ORDER BY distance ";
                    try {
                        $select = mysqli_query($this -> con, $sql);
    
                        while ($rowdata = mysqli_fetch_assoc($select)) {
                            $this -> data[] = $rowdata;
                        }
                    } catch(Exception $e) {
                        echo 'SQL Exception: ' . $e -> getMessage();
                    }
                }
            } else if (empty($categories) && empty($genders)) {
                $minAge = $ages[0];
                $maxAge = $ages[1];
                $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                        FROM petmate pm 
                        INNER JOIN userDetails ud
                        ON pm.email = ud.email
                        WHERE pet_age_inYear BETWEEN $minAge AND $maxAge
                        HAVING distance < 5 ORDER BY distance ";
                try {
                    $select = mysqli_query($this -> con, $sql);
    
                    while ($rowdata = mysqli_fetch_assoc($select)) {
                        $this -> data[] = $rowdata;
                    }
                } catch(Exception $e) {
                    echo 'SQL Exception: ' . $e -> getMessage();
                }
            } else if (empty($ages) && empty($genders)) {
                foreach ($categories as $category) {
                    $category = trim($category);
                    if (empty($breeds)) {
                        $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                        $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                                FROM petmate pm 
                                INNER JOIN userDetails ud
                                ON pm.email = ud.email
                                WHERE pet_category='$category'
                                HAVING distance < 5 ORDER BY distance ";
                        try {
                            $select = mysqli_query($this->con, $sql);
    
                            while ($rowdata = mysqli_fetch_assoc($select)) {
                                $this -> data[] = $rowdata;
                            }
                        } catch(Exception $e) {
                            echo 'SQL Exception: ' . $e -> getMessage();
                        }
                    } else {
                        foreach ($breeds as $breed) {
                            $breed = trim($breed);
                            $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                            $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                                    FROM petmate pm 
                                    INNER JOIN userDetails ud
                                    ON pm.email = ud.email
                                    WHERE pet_category='$category' AND pet_breed='$breed'
                                    HAVING distance < 5 ORDER BY distance ";
                            try {
                                $select = mysqli_query($this -> con, $sql);
    
                                while ($rowdata = mysqli_fetch_assoc($select)) {
                                    $this -> data[] = $rowdata;
                                }
                            } catch(Exception $e) {
                                echo 'SQL Exception: ' . $e -> getMessage();
                            }
                        }
                    }
                }
            } else if (empty($categories)) {
                $minAge = $ages[0];
                $maxAge = $ages[1];
                foreach ($genders as $gender) {
                    $gender = trim($gender);
                    $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                    $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                            FROM petmate pm 
                            INNER JOIN userDetails ud
                            ON pm.email = ud.email
                            WHERE pet_age_inYear BETWEEN $minAge AND $maxAge AND pet_gender='$gender'
                            HAVING distance < 5 ORDER BY distance ";
                    try {
                        $select = mysqli_query($this -> con, $sql);
    
                        while ($rowdata = mysqli_fetch_assoc($select)) {
                            $this -> data[] = $rowdata;
                        }
                    } catch(Exception $e) {
                        echo 'SQL Exception: ' . $e -> getMessage();
                    }
                }
            } else if (empty($ages)) {
                foreach ($categories as $category) {
                    $category = trim($category);
                    if (empty($breeds)) {
                        foreach ($genders as $gender) {
                            $gender = trim($gender);
                            $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                            $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                                    FROM petmate pm 
                                    INNER JOIN userDetails ud
                                    ON pm.email = ud.email
                                    WHERE pet_category='$category' AND pet_gender='$gender'
                                    HAVING distance < 5 ORDER BY distance ";
                            try {
                                $select = mysqli_query($this -> con, $sql);
    
                                while ($rowdata = mysqli_fetch_assoc($select)) {
                                    $this -> data[] = $rowdata;
                                }
                            } catch(Exception $e) {
                                echo 'SQL Exception: ' . $e -> getMessage();
                            }
                        }
                    } else {
                        foreach ($breeds as $breed) {
                            $breed = trim($breed);
                            foreach ($genders as $gender) {
                                $gender = trim($gender);
                                $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                                $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                                        FROM petmate pm 
                                        INNER JOIN userDetails ud
                                        ON pm.email = ud.email
                                        WHERE pet_category='$category' AND pet_breed='$breed' AND pet_gender='$gender'
                                        HAVING distance < 5 ORDER BY distance ";
                                try {
                                    $select = mysqli_query($this -> con, $sql);
    
                                    while ($rowdata = mysqli_fetch_assoc($select)) {
                                        $this -> data[] = $rowdata;
                                    }
                                } catch(Exception $e) {
                                    echo 'SQL Exception: ' . $e -> getMessage();
                                }
                            }
                        }
                    }
                }
            } else if (empty($genders)) {
                $minAge = $ages[0];
                $maxAge = $ages[1];
                foreach ($categories as $category) {
                    $category = trim($category);
                    if (empty($breeds)) {
                        $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                        $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                                FROM petmate pm 
                                INNER JOIN userDetails ud
                                ON pm.email = ud.email
                                WHERE pet_category='$category' AND pet_age_inYear BETWEEN $minAge AND $maxAge
                                HAVING distance < 5 ORDER BY distance ";
                        try {
                            $select = mysqli_query($this -> con, $sql);
    
                            while ($rowdata = mysqli_fetch_assoc($select)) {
                                $this -> data[] = $rowdata;
                            }
                        } catch(Exception $e) {
                            echo 'SQL Exception: ' . $e -> getMessage();
                        }
                    } else {
                        foreach ($breeds as $breed) {
                            $breed = trim($breed);
                            $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                            $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                                    FROM petmate pm 
                                    INNER JOIN userDetails ud
                                    ON pm.email = ud.email
                                    WHERE pet_category='$category' AND pet_breed='$breed' AND pet_age_inYear BETWEEN $minAge AND $maxAge
                                    HAVING distance < 5 ORDER BY distance ";
                            try {
                                $select = mysqli_query($this -> con, $sql);
    
                                while ($rowdata = mysqli_fetch_assoc($select)) {
                                    $this -> data[] = $rowdata;
                                }
                            } catch(Exception $e) {
                                echo 'SQL Exception: ' . $e -> getMessage();
                            }
                        }
                    }
                }
            } else {
                $minAge = $ages[0];
                $maxAge = $ages[1];
                if (empty($breeds)) {
                    foreach ($categories as $category) {
                        $category = trim($category);
    
                        foreach ($genders as $gender) {
                            $gender = trim($gender);
                            $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                            $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                                    FROM petmate pm 
                                    INNER JOIN userDetails ud
                                    ON pm.email = ud.email
                                    WHERE pet_category='$category' AND pet_age_inYear BETWEEN $minAge AND $maxAge AND pet_gender='$gender'
                                    HAVING distance < 5 ORDER BY distance ";
                            try {
                                $select = mysqli_query($this -> con, $sql);
    
                                while ($rowdata = mysqli_fetch_assoc($select)) {
                                    $this -> data[] = $rowdata;
                                }
                            } catch(Exception $e) {
                                echo 'SQL Exception: ' . $e -> getMessage();
                            }
                        }
                    }
                } else {
                    foreach ($categories as $category) {
                        $category = trim($category);
    
                        foreach ($breeds as $breed) {
                            $breed = trim($breed);
    
                            foreach ($genders as $gender) {
                                $gender = trim($gender);
                                $this -> con -> options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                                $sql = "SELECT pm.first_image_path, pm.second_image_path, pm.third_image_path, pm.pet_category, pm.pet_breed, pm.pet_age_inMonth, pm.pet_age_inYear, pm.pet_gender, pm.pet_description, pm.post_date,ud.name,ud.email,ud.mobileno,( 3959 * acos( cos( radians('$latitude') ) * cos( radians( ud.latitude ) ) * cos( radians( ud.longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( ud.latitude ) ) ) ) * 1.609344 AS distance
                                        FROM petmate pm 
                                        INNER JOIN userDetails ud
                                        ON pm.email = ud.email
                                        WHERE pet_category='$category' AND pet_breed='$breed' AND pet_age_inYear BETWEEN $minAge AND $maxAge AND pet_gender='$gender'
                                        HAVING distance < 5 ORDER BY distance ";
                                try {
                                    $select = mysqli_query($this -> con, $sql);
    
                                    while ($rowdata = mysqli_fetch_assoc($select)) {
                                        $this -> data[] = $rowdata;
                                    }
                                } catch(Exception $e) {
                                    echo 'SQL Exception: ' . $e -> getMessage();
                                }
                            }
                        }
                    }
                }
            }
            $count = 0;
            $count+= count($this->data);
            $rowsPerPage = 10;
            $totalPages = ceil($count / $rowsPerPage);
            if (is_numeric($filterPetMateList->getCurrentPage())) {
                $currentPage = (int) $filterPetMateList->getCurrentPage();
            }
            
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
                
                $formattedArray = array();
                foreach ($this->data as $key => $row)
                {
                    $formattedArray[$key] = $row['post_date'];
                }
                array_multisort($formattedArray, SORT_DESC, $this->data);
                $output = array_slice($this->data, $offset, $rowsPerPage);
                 
                $cache = new CacheMemcache();
                if ($cache->memcacheEnabled) {
                    $cache->setData('filter_pet_mate_list_email', $email);
                    $cache->setData('filter_pet_mate_list_array', $this->data); // saving data to cache server          
                }
            }
        }
        else {
            $cache = new CacheMemcache();
            if($cache->memcacheEnabled) {
                if($email == $cache->getData('filter_pet_mate_list_email')) {
                    $this->data = $cache->getData('filter_pet_mate_list_array');
                    $count = 0;
                    $count+= count($this->data);
                    $rowsPerPage = 10;
                    $totalPages = ceil($count / $rowsPerPage);
                    if (is_numeric($filterPetMateList->getCurrentPage())) {
                        $currentPage = (int) $filterPetMateList->getCurrentPage();
                    }
                    $output = null;
                    if ($currentPage >= 1 && $currentPage <= $totalPages) {
                        $offset = ($currentPage - 1) * $rowsPerPage;
                        $output = array_slice($this->data, $offset, $rowsPerPage);
                    }
                }
            }
        }
        return $output;
    }

    public function deleteFilterObject($deletePetMateListFilterObject) {
        $cache = new CacheMemcache();        
        if ($cache->memcacheEnabled) {
            $email = $deletePetMateListFilterObject->getEmail();
            if($email == $cache->getData('filter_pet_mate_list_email')) {        
                $this->data = $cache->delData('filter_pet_mate_list_array'); // removing data from cache server
            }
        }
        return $this->data;
    }
}
?>