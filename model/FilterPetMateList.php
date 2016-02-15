<?php
require_once '../dao/FilterPetMateListDAO.php';
class FilterPetMateList
{
    private $email;
    private $currentPage;
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
    
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
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
    
    public function filterPetMateLists($email, $currentPage, $filterSelectedCategories, $filterSelectedBreeds, $filterSelectedAge, $filterSelectedGender) {
        $showFilterPetMateListDAO = new FilterPetMateListDAO();
        $this->setEmail($email);
        $this->setCurrentPage($currentPage);
        $this->setFilterSelectedCategories($filterSelectedCategories);
        $this->setFilterSelectedBreeds($filterSelectedBreeds);
        $this->setFilterSelectedAge($filterSelectedAge);
        $this->setFilterSelectedGender($filterSelectedGender);
        $returnShowPetMateList = $showFilterPetMateListDAO->showFilteredPetMateList($this);
        return $returnShowPetMateList;
    }
    
    public function deletingFilterPetMateListObject($email) {
        $deleteFilterPetMateListObjectDAO = new FilterPetMateListDAO();
        $this->setEmail($email);
        $returnFilterPetMateListObjectDeleteResponse = $deleteFilterPetMateListObjectDAO->deleteFilterObject($this);
        return $returnFilterPetMateListObjectDeleteResponse;
    }
}
?>