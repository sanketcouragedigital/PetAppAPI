<?php
require_once '../dao/UsersDetailsDAO.php';
class UsersDetails
{
	private $name;
    private $buildingname;
    private $area;
	private $city;
    private $mobileno;
    private $email;
    private $oldEmail;
	private $password;
    private $isNGO;
    private $urlOfNGO;
	
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
     public function setOldEmail($oldEmail) {
        $this->oldEmail = $oldEmail;
    }
    
    public function getOldEmail() {
        return $this->oldEmail;
    }

    public function setBuildingname($buildingname) {
        $this->buildingname = $buildingname;
    }
    
    public function getBuildingname() {
        return $this->buildingname;
    }

    public function setArea($area) {
        $this->area = $area;
    }
    
    public function getArea() {
        return $this->area;
    }
	public function setCity($city) {
        $this->city = $city;
    }
    
    public function getCity() {
        return $this->city;
    }

    public function setMobileno($mobileno) {
        $this->mobileno = $mobileno;
    }
    
    public function getMobileno() {
        return $this->mobileno;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }
	
	public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setIsNGO($isNGO) {
        $this->isNGO = $isNGO;
    }
    
    public function getIsNGO() {
        return $this->isNGO;
    }
    
    public function setUrlOfNGO($urlOfNGO) {
        $this->urlOfNGO = $urlOfNGO;
    }
    
    public function getUrlOfNGO() {
        return $this->urlOfNGO;
    }

    public function mapIncomingUserDetailsParams($name,$buildingname,$area,$city,$mobileno,$email,$password, $isNGO, $urlOfNGO) {
        $this->setName($name);
        $this->setBuildingname($buildingname);
        $this->setArea($area);
		$this->setCity($city);
        $this->setMobileno($mobileno);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setIsNGO($isNGO);
        $this->setUrlOfNGO($urlOfNGO);
    }

    public function SavingUsersDetails() {
        $saveUsersDetailsDAO = new UsersDetailsDAO();
        $returnUsersDetailsSaveSuccessMessage = $saveUsersDetailsDAO->saveDetail($this);
        return $returnUsersDetailsSaveSuccessMessage;
    }
    public function mapIncomingEditUserDetailsParams($name,$buildingname,$area,$city,$mobileno,$email,$oldEmail,$password,$urlOfNGO) {
        $this->setName($name);
        $this->setBuildingname($buildingname);
        $this->setArea($area);
        $this->setCity($city);
        $this->setMobileno($mobileno);
        $this->setEmail($email);
        $this->setOldEmail($oldEmail);
        $this->setPassword($password);
		$this->setUrlOfNGO($urlOfNGO);
    }
    public function SavingEditUsersDetails() {
        $saveUsersDetailsDAO = new UsersDetailsDAO();
        $returnUsersDetailsSaveSuccessMessage = $saveUsersDetailsDAO->saveEditDetail($this);
        return $returnUsersDetailsSaveSuccessMessage;
    }
    public function FetchingUsersDetails($oldEmail,$password) {
        $saveUsersDetailsDAO = new UsersDetailsDAO();
        $this->setOldEmail($oldEmail);
		$this->setPassword($password);
        $returnUsersDetailsSaveSuccessMessage = $saveUsersDetailsDAO->fetchUserDetail($this);
        return $returnUsersDetailsSaveSuccessMessage;
    }
	public function FetchingContactDetails($email) {
        $fetchContactDetailsDAO = new UsersDetailsDAO();
        $this->setEmail($email);	
        $returnFetchContactDetailsMessage = $fetchContactDetailsDAO->fetchContactDetail($this);
        return $returnFetchContactDetailsMessage;
    }
    
}
?>