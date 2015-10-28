<?php

require_once 'BaseDAO.php';
class LoginDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function LoginDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    public function loginDetail($LoginDetails) {
           try {
                $sql = "SELECT * FROM userDetails WHERE email='".$LoginDetails->getEmail()."' AND password='".$LoginDetails->getPassword()."'";        
                $isValidating = mysqli_query($this->con, $sql);
                $count=mysqli_num_rows($isValidating);
                if($count==1) {
                    $this->data = "LOGIN_SUCCESS";
                } else {
                    $this->data = "LOGIN_FAILED";
                } 
                
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
    
    public function emailDetail($LoginDetails) {
           try {
                $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
                $sql = "SELECT * FROM userDetails WHERE email='".$LoginDetails->getEmail()."'";        
                $isValidating = mysqli_query($this->con, $sql);
                $count=mysqli_num_rows($isValidating);
                if($count==1) {
                    //$this->data = "VALID_EMAIL";
                    $resetPassword = new LoginDetails();
                    $this->data=$resetPassword -> GenarateRandomNo($LoginDetails->getEmail());
                } else {
                    $this->data = "INVALID_EMAIL"; 
                } 
                
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
    public function savingRandomNo($LoginDetails) {
        try {              
                    $sql = "UPDATE userDetails SET activationcode='".$LoginDetails->getRandomNoForUser()."' WHERE email='".$LoginDetails->getEmail()."'";                     
                    $isUpdate = mysqli_query($this->con, $sql);
                    if ($isUpdate) {
                    //$count = mysqli_affected_rows($this->con);
                    //if ($count==1) {
                        $this->data = "RANDOM_NO_SUCCESSFULLY_UPDATED";
                    } else {
                        $this->data = "RANDOM_NO_NOT_UPDATED";
                    }  
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
   
    public function setNewPassword($LoginDetails) {  
        try {
                $sql = "UPDATE userDetails SET password='".$LoginDetails->getNewPassword()."' WHERE email='".$LoginDetails->getEmail()."' AND activationcode='".$LoginDetails->getActivationCode()."' ";
                //$isUpdate = mysqli_query($this->con, $sql);
                  mysqli_query($this->con, $sql);  
                    if (mysqli_affected_rows($this->con) >= 1) {
                        $this->data = "NEW_PASSWORD_SUCCESSFULLY_SET";
                    } else {
                        $this->data = "ENTER_VALID_ACTIVATION_CODE";
                    }  
        } catch(Exception $e) {
            echo 'SQL Exception: '.$e->getMessage();
        }
        return $this->data;
    }
                
}

?>