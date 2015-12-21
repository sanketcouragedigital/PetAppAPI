<?php
require_once '../dao/FilterPetListDAO.php';
class FilterPetList
{
    private $filterSelectedCategories;

    public function setFilterSelectedCategories($filterSelectedCategories) {
        $this->filterSelectedCategories = $filterSelectedCategories;
    }
    
    public function getFilterSelectedCategories() {
        return $this->filterSelectedCategories;
    }

    public function filterCategoryBreeds($filterSelectedCategories) {
        $showfilterCategoryBreedsDAO = new FilterPetListDAO();
        $this->setFilterSelectedCategories($filterSelectedCategories);
        $returnShowPetBreedsCategoryWise = $showfilterCategoryBreedsDAO->showBreedsCategoryWise($this);
        return $returnShowPetBreedsCategoryWise;
    }
}
?>