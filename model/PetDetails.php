<?php
require_once '../dao/PetDetailsDAO.php';
class PetDetails
{
	private $image_tmp;
    private $target_path;
    private $petBreedOrigin;

    public function setImageTemporaryName($image_tmp) {
        $this->image_tmp = $image_tmp;
    }
    
    public function getImageTemporaryName() {
        return $this->image_tmp;
    }

    public function setTargetPathOfImage($target_path) {
        $this->target_path = $target_path;
    }
    
    public function getTargetPathOfImage() {
        return $this->target_path;
    }

    public function setPetBreedOrigin($petBreedOrigin) {
        $this->petBreedOrigin = $petBreedOrigin;
    }
    
    public function getPetBreedOrigin() {
        return $this->petBreedOrigin;
    }

    public function mapIncomingPetDetailsParams($image_tmp, $target_path, $petBreedOrigin) {
        $this->setImageTemporaryName($image_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setPetBreedOrigin($petBreedOrigin);
    }

    public function savingPetDetails() {
        $savePetDetailsDAO = new PetDetailsDAO();
        $returnPetDetailSaveSuccessMessage = $savePetDetailsDAO->saveDetail($this);
        return $returnPetDetailSaveSuccessMessage;
    }
	
    public function showingPetDetails() {
        $showPetDetailsDAO = new PetDetailsDAO();
        $returnShowPetDetails = $showPetDetailsDAO->showDetail($this);
        return $returnShowPetDetails;
    }
}
?>