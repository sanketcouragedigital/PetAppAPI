<?php

require_once 'BaseDAO.php';
class PetDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function PetDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function saveDetail($petDetail) {
        try {
            if(move_uploaded_file($petDetail->getImageTemporaryName(), $petDetail->getTargetPathOfImage())) {
                $sql = "INSERT INTO petapp(image_path, pet_category, pet_breed, pet_age, pet_gender, pet_description, pet_adoption, pet_giveaway, pet_price)
                        VALUES 
                        ('".$petDetail->getTargetPathOfImage()."',
                         '".$petDetail->getCategoryOfPet()."',
                         '".$petDetail->getBreedOfPet()."',
                         '".$petDetail->getAgeOfPet()."',
                         '".$petDetail->getGenderOfPet()."',
                         '".$petDetail->getDescriptionOfPet()."',
                         '".$petDetail->getAdoptionOfPet()."',
                         '".$petDetail->getGiveAwayOfPet()."',
                         '".$petDetail->getPriceOfPet()."'
                         )";
        
                $isInserted = mysqli_query($this->con, $sql);
                if ($isInserted) {
                    $this->data = "PET_DETAILS_SAVED";
                } else {
                    $this->data = "ERROR";
                }
            } else {
                $this->data = "ERROR_UPLOAD_FILE";
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
    
    public function showDetail() {
        $sql = "SELECT * FROM petapp";
        
        try {
            $select = mysqli_query($this->con, $sql);
            $this->data=array();
            while ($rowdata = mysqli_fetch_assoc($select)) {
                $this->data[]=$rowdata;
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
}
?>