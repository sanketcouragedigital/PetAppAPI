<?php
require_once 'BaseDAO.php';
class PetCategoriesDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function PetCategoriesDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function showCategories() {
        $sql = "SELECT DISTINCT pet_category FROM pet_categories";
        
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

    public function showBreeds($breeds) {
        $sql = "SELECT * FROM pet_categories WHERE pet_category='".$breeds->getPetCategory()."'";
        
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