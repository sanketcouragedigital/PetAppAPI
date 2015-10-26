<?php
require_once '../dao/PetCategoriesDAO.php';
class PetCategories
{
	private $petCategory;

    public function setPetCategory($petCategory) {
        $this->petCategory = $petCategory;
    }
    
    public function getPetCategory() {
        return $this->petCategory;
    }
	
    public function showingPetCategories() {
        $showPetCategoriesDAO = new PetCategoriesDAO();
        $returnShowPetCategories = $showPetCategoriesDAO->showCategories();
        return $returnShowPetCategories;
    }

    public function showingPetBreeds($petCategory) {
        $showPetBreedsDAO = new PetCategoriesDAO();
        $this->setPetCategory($petCategory);
        $returnShowPetBreeds = $showPetBreedsDAO->showBreeds($this);
        return $returnShowPetBreeds;
    }
}
?>