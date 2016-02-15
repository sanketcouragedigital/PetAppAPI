<?php
require_once '../dao/FilterPetListDAO.php';
class FilterPetList
{
    private $currentPage;
    private $filterSelectedCategories;
    private $filterSelectedBreeds;
    private $filterSelectedAge;
    private $filterSelectedGender;
    private $filterSelectedAdoptionAndPrice;

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
    
    public function setFilterSelectedAdoptionAndPrice($filterSelectedAdoptionAndPrice) {
        $this->filterSelectedAdoptionAndPrice = $filterSelectedAdoptionAndPrice;
    }
    
    public function getFilterSelectedAdoptionAndPrice() {
        return $this->filterSelectedAdoptionAndPrice;
    }

    public function filterCategoryBreeds($filterSelectedCategories) {
        $showfilterCategoryBreedsDAO = new FilterPetListDAO();
        $this->setFilterSelectedCategories($filterSelectedCategories);
        $returnShowPetBreedsCategoryWise = $showfilterCategoryBreedsDAO->showBreedsCategoryWise($this);
        return $returnShowPetBreedsCategoryWise;
    }
    
    public function filterPetLists($currentPage, $filterSelectedCategories, $filterSelectedBreeds, $filterSelectedAge, $filterSelectedGender, $filterSelectedAdoptionAndPrice) {
        $showFilterPetListDAO = new FilterPetListDAO();
        $this->setCurrentPage($currentPage);
        $this->setFilterSelectedCategories($filterSelectedCategories);
        $this->setFilterSelectedBreeds($filterSelectedBreeds);
        $this->setFilterSelectedAge($filterSelectedAge);
        $this->setFilterSelectedGender($filterSelectedGender);
        $this->setFilterSelectedAdoptionAndPrice($filterSelectedAdoptionAndPrice);
        $returnShowPetList = $showFilterPetListDAO->showFilteredPetList($this);
        return $returnShowPetList;
    }
    
    public function deletingFilterPetListObject() {
        $deleteFilterPetListObjectDAO = new FilterPetListDAO();
        $returnFilterPetListObjectDeleteResponse = $deleteFilterPetListObjectDAO->deleteFilterObject();
        return $returnFilterPetListObjectDeleteResponse;
    }
}
?>