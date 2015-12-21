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
        /*$categories = explode("[", $categoryWiseBreed->getFilterSelectedCategories() );
        $categories = explode("]", $categories[1] );
        $categories = $categories[0];*/
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
}
?>