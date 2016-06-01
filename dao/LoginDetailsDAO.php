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
        $this->data = $this->checkUser($LoginDetails);
           
        return $this->data;
    }

    public function checkUser($LoginDetails) {
        try {
            $sql = "SELECT * FROM userDetails WHERE email='".$LoginDetails->getEmail()."' AND password='".$LoginDetails->getPassword()."'";        
            $isValidating = mysqli_query($this->con, $sql);
            $count=mysqli_num_rows($isValidating);
            if($count==1) {
                $this->data = $this->checkNGO($LoginDetails);
            } else {
                $this->data = "LOGIN_FAILED";
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

    public function checkNGO($LoginDetails) {
        try {
            $sql = "SELECT * FROM userDetails WHERE email='".$LoginDetails->getEmail()."' AND password='".$LoginDetails->getPassword()."' AND is_ngo = 'Yes'";
            $isNGO = mysqli_query($this->con, $sql);
            $count = mysqli_num_rows($isNGO);
            if($count == 1) {
                $this->data = $this->checkApprovedNGO($LoginDetails);
            } else {
                $this->data = "NOT_NGO";
                if($LoginDetails->getEmail() == "peto@couragedigital.com" && $LoginDetails->getPassword() == "490b61875085b974d9395ba9b3333d51a9cf7e9cbf6900cccb312cf984865946") {
                    $this->data = "ADMIN_USER";
                }
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;        
    }
    
    public function checkApprovedNGO($LoginDetails) {
        try {
            $sql = "SELECT * FROM userDetails WHERE email='".$LoginDetails->getEmail()."' AND password='".$LoginDetails->getPassword()."' AND is_ngo = 'Yes' AND is_verified = 'Yes'";
            $isApprovedNGO = mysqli_query($this->con, $sql);
            $count = mysqli_num_rows($isApprovedNGO);
            if($count == 1) {
                $this->data = "APPROVED_NGO";
            } else {
				$emailToNotVerifyNGo = new LoginDetails();
                $this->data=$emailToNotVerifyNGo -> NgoNotVerify($LoginDetails->getEmail());
                $this->data = "NOT_APPROVED_NGO";
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

	public function checkPassword($CheckPassword) {
           try {
                $sql = "SELECT * FROM userDetails WHERE email='".$CheckPassword->getEmail()."' AND password='".$CheckPassword->getPassword()."' ";        
                $isValidating = mysqli_query($this->con, $sql);
                $count=mysqli_num_rows($isValidating);
                if($count==1) {
                    $this->data = "VALID_PASSWORD";
                } else {
                    $this->data = "INVALID_PASSWORD";
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