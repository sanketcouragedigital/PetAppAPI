<?php
require_once '../dao/FilterPetMetListDAO.php';
class FilterPetMetList
{
    private $email;
    private $filterSelectedCategories;
    private $filterSelectedBreeds;
    private $filterSelectedAge;
    private $filterSelectedGender;

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setFilterSelectedCategories($filterSelectedCategories) {
        $this->filterSelectedCategories = $filterSelectedCategories;
    }
    
    public function getFilterSelectedCategories() {
        return $this->filterSelectedCategories;
    }
    
    public function setFilterSelectedBreeds($filterSelectedBreeds) {
        $this->filterSelectedBreeds = $filterSelectedBreeds;
    }
    
    public function getFilterSelectedBreeds() {
        return $this->filterSelectedBreeds;
    }
    
    public function setFilterSelectedAge($filterSelectedAge) {
        $this->filterSelectedAge = $filterSelectedAge;
    }
    
    public function getFilterSelectedAge() {
        return $this->filterSelectedAge;
    }
    
    public function setFilterSelectedGender($filterSelectedGender) {
        $this->filterSelectedGender = $filterSelectedGender;
    }
    
    public function getFilterSelectedGender() {
        return $this->filterSelectedGender;
    }
    
    public function filterPetMetLists($email, $filterSelectedCategories, $filterSelectedBreeds, $filterSelectedAge, $filterSelectedGender) {
        $showFilterPetMetListDAO = new FilterPetMetListDAO();
        $this->setEmail($email);
        $this->setFilterSelectedCategories($filterSelectedCategories);
        $this->setFilterSelectedBreeds($filterSelectedBreeds);
        $this->setFilterSelectedAge($filterSelectedAge);
        $this->setFilterSelectedGender($filterSelectedGender);
        $returnShowPetMetList = $showFilterPetMetListDAO->showFilteredPetMetList($this);
        return $returnShowPetMetList;
    }
}
?>