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
	private $password;
	
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
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

    public function mapIncomingUserDetailsParams($name,$buildingname,$area,$city,$mobileno,$email,$password) {
        $this->setName($name);
        $this->setBuildingname($buildingname);
        $this->setArea($area);
		$this->setCity($city);
        $this->setMobileno($mobileno);
        $this->setEmail($email);
		$this->setPassword($password);
    }

    public function SavingUsersDetails() {
        $saveUsersDetailsDAO = new UsersDetailsDAO();
        $returnUsersDetailsSaveSuccessMessage = $saveUsersDetailsDAO->saveDetail($this);
        return $returnUsersDetailsSaveSuccessMessage;
    }
    
}
?>