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
                $sql = "INSERT INTO userDetails(name,buildingname,area,city,mobileno,email,password)
                        VALUES ('".$UsersDetail->getName()."', '".$UsersDetail->getBuildingname()."', '".$UsersDetail->getArea()."', '".$UsersDetail->getCity()."', '".$UsersDetail->getMobileno()."', '".$UsersDetail->getEmail()."', '".$UsersDetail->getPassword()."')";
        
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