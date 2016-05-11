<?php
require_once '../model/PetDetails.php';
require_once '../model/UsersDetails.php';
require_once '../model/LoginDetails.php';
require_once '../model/PetCategories.php';
require_once '../model/PetMateDetails.php';
require_once '../model/FilterPetList.php';
require_once '../model/FilterPetMateList.php';
require_once '../model/ClinicDetails.php';
require_once '../model/PetServices.php';
require_once '../model/Feedback.php';
require_once '../model/MyListing.php';
require_once '../model/ClinicFeedbackDetails.php';
require_once '../model/WishListDetails.php';
require_once '../model/ShopProductDetails.php';
require_once '../model/OrderDetails.php';
require_once '../model/OrderConfirmationEmail.php';
require_once '../model/CamapignDetails.php';


function deliver_response($format, $api_response, $isSaveQuery) {

    // Define HTTP responses
    $http_response_code = array(200 => 'OK', 400 => 'Bad Request', 401 => 'Unauthorized', 403 => 'Forbidden', 404 => 'Not Found');

    // Set HTTP Response
    header('HTTP/1.1 ' . $api_response['status'] . ' ' . $http_response_code[$api_response['status']]);

    // Process different content types
    if (strcasecmp($format, 'json') == 0) {

        // Set HTTP Response Content Type
        header('Content-Type: application/json; charset=utf-8');

        // Format data into a JSON response
        $json_response = json_encode($api_response);
        
        // Deliver formatted data
        echo $json_response;

    } elseif (strcasecmp($format, 'xml') == 0) {

        // Set HTTP Response Content Type
        header('Content-Type: application/xml; charset=utf-8');

        // Format data into an XML response (This is only good at handling string data, not arrays)
        $xml_response = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<response>' . "\n" . "\t" . '<code>' . $api_response['code'] . '</code>' . "\n" . "\t" . '<data>' . $api_response['data'] . '</data>' . "\n" . '</response>';

        // Deliver formatted data
        echo $xml_response;

    } else {

        // Set HTTP Response Content Type (This is only good at handling string data, not arrays)
        header('Content-Type: text/html; charset=utf-8');

        // Deliver formatted data
        echo $api_response['data'];

    }

    // End script process
    exit ;

}

// Define whether an HTTPS connection is required
$HTTPS_required = FALSE;

// Define whether user authentication is required
$authentication_required = FALSE;

// Define API response codes and their related HTTP response
$api_response_code = array(0 => array('HTTP Response' => 400, 'Message' => 'Unknown Error'), 1 => array('HTTP Response' => 200, 'Message' => 'Success'), 2 => array('HTTP Response' => 403, 'Message' => 'HTTPS Required'), 3 => array('HTTP Response' => 401, 'Message' => 'Authentication Required'), 4 => array('HTTP Response' => 401, 'Message' => 'Authentication Failed'), 5 => array('HTTP Response' => 404, 'Message' => 'Invalid Request'), 6 => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format'));

// Set default HTTP response of 'ok'
$response['code'] = 0;
$response['status'] = 404;

// --- Step 2: Authorization

// Optionally require connections to be made via HTTPS
if ($HTTPS_required && $_SERVER['HTTPS'] != 'on') {
    $response['code'] = 2;
    $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
    $response['data'] = $api_response_code[$response['code']]['Message'];

    // Return Response to browser. This will exit the script.
    deliver_response($_GET['format'], $response);
}

// Optionally require user authentication
if ($authentication_required) {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $response['code'] = 3;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $response['data'] = $api_response_code[$response['code']]['Message'];

        // Return Response to browser
        deliver_response($_GET['format'], $response);

    }

    // Return an error response if user fails authentication. This is a very simplistic example
    // that should be modified for security in a production environment
    elseif ($_POST['username'] != 'foo' && $_POST['password'] != 'bar') {
        $response['code'] = 4;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $response['data'] = $api_response_code[$response['code']]['Message'];

        // Return Response to browser
        deliver_response($_GET['format'], $response);

    }

}

// --- Step 3: Process Request

// Switch based on incoming method
$checkmethod = $_SERVER['REQUEST_METHOD'];
$var = file_get_contents("php://input");
$string = json_decode($var, TRUE);
$method = $string['method'];

if (isset($_POST['method']) || $checkmethod == 'POST') {
	if(strcasecmp($method,'userRegistration') == 0){
		$response['code'] = 1;
		$response['status'] = $api_response_code[$response['code']]['HTTP Response'];
		$objuserDetails = new UsersDetails();
		$name = $string['name'];
		$buildingname= $string['buildingname'];
		$area= $string['area'];
		$city= $string['city'];
		$mobileno= $string['mobileno'];
		$email= $string['email'];
		$password= $string['confirmpassword'];
		$isNGO = $string['isNGO'];
        $urlOfNGO = $string['urlOfNGO'];
		$objuserDetails->mapIncomingOrderDetailsParams($name,$buildingname,$area,$city,$mobileno,$email,$password);	
		$response['saveUsersDetailsResponse'] = $objuserDetails -> SavingOrderDetails();
		//deliver_response($format[1],$response,false);
        deliver_response($string['format'],$response,false);
	}
	else if(strcasecmp($method,'sendOrderEmail') == 0){
		$response['code'] = 1;	
		$response['status'] = $api_response_code[$response['code']]['HTTP Response'];
		$objOrderEmailDetails = new OrderConfirmationEmail();
		$orderedId = $string['orderedId'];
		$productId = $string['productId'];
		$productName = $string['productName'];
		$productPrice = $string['productPrice'];
		$quantity = $string['quantity'];
		$shippingCharges = $string['shippingCharges'];
		$productTotalPrice = $string['productTotalPrice'];		
		$name = $string['customer_name'];
		$mobileno= $string['customer_contact'];
		$email= $string['customer_email'];	
		$buildingname= $string['address'];
		$area= $string['area'];
		$city= $string['city'];
		$pincode= $string['pincode'];					
		$response['saveOrderEmailDetailsResponse'] = $objOrderEmailDetails -> GeneraeEmailForUserVendor($orderedId,$productId,$productName,$productPrice,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode);	
		//deliver_response($format[1],$response,false);
        deliver_response($string['format'],$response,false);
	}
	else if(strcasecmp($method,'orderGenaration') == 0){
		$response['code'] = 1;	
		$response['status'] = $api_response_code[$response['code']]['HTTP Response'];
		$objOrdersDetails = new OrderDetails();
		$productId = $string['productId'];
		$quantity = $string['quantity'];
		$shippingCharges = $string['shippingCharges'];
		$productTotalPrice = $string['productTotalPrice'];		
		$name = $string['customer_name'];
		$mobileno= $string['customer_contact'];
		$email= $string['customer_email'];	
		$buildingname= $string['address'];
		$area= $string['area'];
		$city= $string['city'];
		$pincode= $string['pincode'];					
		date_default_timezone_set('Asia/Kolkata');
        $postDate = date("Y-m-d H:i:s");		
		$objOrdersDetails->mapIncomingOrderDetailsParams($productId,$quantity,$shippingCharges,$productTotalPrice,$name,$mobileno,$email,$buildingname,$area,$city,$pincode,$postDate);	
		$response['saveOrdersDetailsResponse'] = $objOrdersDetails -> SavingOrderDetails();
		//deliver_response($format[1],$response,false);
        deliver_response($string['format'],$response,false);
	}

	else if(strcasecmp($method,'saveWishListForPetList') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objPetWishListDetails = new WishListDetails();
        $listId=$string['petListId'];        
        $email= $string['userEmail'];
        $response['savePetWishListResponse'] = $objPetWishListDetails -> savePetWishList($email,$listId);       
        deliver_response($string['format'],$response,false);
    }
	else if(strcasecmp($method,'saveWishListForPetMateList') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objPetMateWishListDetails = new WishListDetails();
        $listId=$string['petMateListId'];        
        $email= $string['userEmail'];
        $response['savePetMateWishListResponse'] = $objPetMateWishListDetails -> savePetMateWishList($email,$listId);       
        deliver_response($string['format'],$response,false);
    }
    else if(strcasecmp($method,'editProfile') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objuserDetails = new UsersDetails();
        $name = $string['name'];
        $buildingname= $string['buildingname'];
        $area= $string['area'];
        $city= $string['city'];
        $mobileno= $string['mobileno'];
        $email= $string['email'];
        $oldEmail=$string['oldEmail'];
        $password= $string['confirmpassword'];
        $objuserDetails->mapIncomingEditUserDetailsParams($name,$buildingname,$area,$city,$mobileno,$email,$oldEmail,$password);    
        $response['saveUsersEditDetailsResponse'] = $objuserDetails -> SavingEditUsersDetails();
        deliver_response($string['format'],$response,false);
    }
    else if(strcasecmp($method,'userLogin') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objuserDetails = new LoginDetails();
        $email= $string['email'];
        $password= $string['confirmpassword'];
        $response['loginDetailsResponse'] = $objuserDetails ->CheckingUsersDetails($email,$password);
        deliver_response($string['format'],$response,false);
    } 
	else if(strcasecmp($method,'fetchUserDetails') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objuserDetails = new UsersDetails();
        $oldEmail=$string['oldEmail']; 
		$password=$string['confirmpassword']; 
        $response['showUserDetails'] = $objuserDetails -> FetchingUsersDetails($oldEmail,$password);
        deliver_response($string['format'],$response,false);
    }
	else if(strcasecmp($method,'checkPassword') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objuserDetails = new LoginDetails();
        $email= $string['email'];
        $password= $string['confirmpassword'];
        $response['CheckPasswordResponse'] = $objuserDetails ->PasswordChecking($email,$password);
        deliver_response($string['format'],$response,false);
    } 
    else if(strcasecmp($method,'setNewPassword') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objuserDetails = new LoginDetails();
        $activationCode= $string['code'];
        $newPassword= $string['password'];
        $email= $string['email'];
        $response['setNewPasswordResponse'] = $objuserDetails -> SettingNewPassword($activationCode,$newPassword,$email);
            deliver_response($string['format'],$response,false);
    } 
    else if(strcasecmp($method,'checkemail') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objuserDetails = new LoginDetails();
        $email= $string['email'];
        $response['checkemailResponse'] = $objuserDetails -> CheckingEmail($email);
        deliver_response($string['format'],$response,false);
    }
    else if (strcasecmp($method,'saveModifiedPetDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objMyListingModifyPetDetails = new MyListing();
        $id = $string['id'];
        $categoryOfPet = $string['categoryOfPet'];
        $breedOfPet = $string['breedOfPet'];
        $petAgeInMonth = $string['petAgeInMonth'];
        $petAgeInYear = $string['petAgeInYear'];
        $genderOfPet = $string['genderOfPet'];
        $descriptionOfPet = $string['descriptionOfPet'];
        $adoptionOfPet = $string['adoptionOfPet'];
        $priceOfPet = $string['priceOfPet'];
        $email = $string['email'];        
        $objMyListingModifyPetDetails->mapIncomingModifiedPetDetailsParams($id, $categoryOfPet, $breedOfPet, $petAgeInMonth, $petAgeInYear, $genderOfPet, $descriptionOfPet, $adoptionOfPet, $priceOfPet, $email);
        $response['saveModifiedPetDetailsResponse'] = $objMyListingModifyPetDetails -> savingModifiedPetDetails();
        deliver_response($string['format'], $response, true);
    }
    else if (strcasecmp($method,'saveModifiedPetMateDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objMyListingModifyPetMateDetails = new MyListing();
        $id = $string['id'];
        $categoryOfPet = $string['categoryOfPet'];
        $breedOfPet = $string['breedOfPet'];
        $petAgeInMonth = $string['petAgeInMonth'];
        $petAgeInYear = $string['petAgeInYear'];
        $genderOfPet = $string['genderOfPet'];
        $descriptionOfPet = $string['descriptionOfPet'];
        $email = $string['email'];        
        $objMyListingModifyPetMateDetails->mapIncomingModifiedPetMateDetailsParams($id, $categoryOfPet, $breedOfPet, $petAgeInMonth, $petAgeInYear, $genderOfPet, $descriptionOfPet, $email);
        $response['saveModifiedPetMateDetailsResponse'] = $objMyListingModifyPetMateDetails -> savingModifiedPetMateDetails();
        deliver_response($string['format'], $response, true);
    }
    else if(strcasecmp($method,'filterCategoryWiseBreed') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objfilterBreeds = new FilterPetList();
        $filterSelectedCategories = $string['filterSelectedCategories'];
        $response['filterBreedsCategoryWise'] = $objfilterBreeds -> filterCategoryBreeds($filterSelectedCategories);
        deliver_response($string['format'],$response,false);
    }
    else if(strcasecmp($method,'filterPetList') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objFilter = new FilterPetList();
        $email = $string['email'];
        $currentPage = $string['currentPage'];
        $filterSelectedCategories = "";
        $filterSelectedBreeds = "";
        $filterSelectedAge = "";
        $filterSelectedGender = "";
        $filterSelectedAdoptionAndPrice = "";        
        if(!empty($string['filterSelectedCategories'])) {
            $filterSelectedCategories = $string['filterSelectedCategories'];
        }
        if(!empty($string['filterSelectedBreeds'])) {
            $filterSelectedBreeds = $string['filterSelectedBreeds'];
        }
        if(!empty($string['filterSelectedAge'])) {
            $filterSelectedAge = $string['filterSelectedAge'];
        }
        if(!empty($string['filterSelectedGender'])) {
            $filterSelectedGender = $string['filterSelectedGender'];
        }
        if(!empty($string['filterSelectedAdoptionAndPrice'])) {
            $filterSelectedAdoptionAndPrice = $string['filterSelectedAdoptionAndPrice'];
        }
        $response['showPetDetailsResponse'] = $objFilter -> filterPetLists($email, $currentPage, $filterSelectedCategories, $filterSelectedBreeds, $filterSelectedAge, $filterSelectedGender, $filterSelectedAdoptionAndPrice);
        deliver_response($string['format'],$response,false);
    }
    else if(strcasecmp($method,'filterPetMateList') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objFilter = new FilterPetMateList();
        $email = $string['email'];
        $currentPage = $string['currentPage'];
        $filterSelectedCategories = "";
        $filterSelectedBreeds = "";
        $filterSelectedAge = "";
        $filterSelectedGender = "";        
        if(!empty($string['filterSelectedCategories'])) {
            $filterSelectedCategories = $string['filterSelectedCategories'];
        }
        if(!empty($string['filterSelectedBreeds'])) {
            $filterSelectedBreeds = $string['filterSelectedBreeds'];
        }
        if(!empty($string['filterSelectedAge'])) {
            $filterSelectedAge = $string['filterSelectedAge'];
        }
        if(!empty($string['filterSelectedGender'])) {
            $filterSelectedGender = $string['filterSelectedGender'];
        }
        $response['showPetMateDetailsResponse'] = $objFilter -> filterPetMateLists($email, $currentPage, $filterSelectedCategories, $filterSelectedBreeds, $filterSelectedAge, $filterSelectedGender);
        deliver_response($string['format'],$response,false);
    }
    else if(strcasecmp($method,'userFeedback') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objuserFeedback = new FeedBack();
        $email = $string['email'];
        $feedback = $string['feedback'];
        $objuserFeedback->mapIncomingFeedbackParams($email,$feedback);    
        $response['saveFeedbackResponse'] = $objuserFeedback -> sendFeedbackEmailToAdmin();
        deliver_response($string['format'],$response,false);
    }
    else if(strcasecmp($method,'submitClinicFeedback') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objClinicFeedbackDetails = new ClinicFeedbackDetails();
        $clinicRatings = $string['ratings'];
        $clinicFeedback= $string['feedback'];
        $email =  $string['email'];
        $clinicId =  $string['clinicId'];
        $objClinicFeedbackDetails->mapIncomingClinicFeedbackDetails($clinicRatings,$clinicFeedback,$email,$clinicId);
        $response['saveClinicFeedbackResponse'] = $objClinicFeedbackDetails -> SavingClinicFeedbackDetails();   
        deliver_response($string['format'],$response,false);
    }
	//////////////////////////////////////////////////////////////////////////////////////////////////
	else if(strcasecmp($_POST['method'], 'saveDonation') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objCamapignDetails = new CamapignDetails();
        $campaignId = $_POST['campaignId'];
        $email = $_POST['donarEmail'];
		$donationAmount = $_POST['donationAmount'];
		$ngoOwnerEmail = $_POST['ngoOwnerEmail'];	
        $objCamapignDetails->mapIncomingDonationParams($campaignId,$email,$donationAmount,$ngoOwnerEmail);   
        $response['saveDonationDetailsResponse'] = $objCamapignDetails -> donationInfo();
        deliver_response($_POST['format'], $response, true);
    }
	else if(strcasecmp($_POST['method'], 'ModifyCampaign') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objCamapignDetails = new CamapignDetails();      
        $ngoName = $_POST['ngoName'];
        $campaignName = $_POST['campaignName'];
        $actualAmount=$_POST['actualAmount'];
        $minimumAmount=$_POST['minimumAmount'];
        $description = $_POST['description'];
        $lastDate = $_POST['lastDate'];      
        $email = $_POST['email'];	
		$campaignId = $_POST['campaignId'];		
		$objCamapignDetails->mapIncomingCamapignModifyDetailsParams($campaignId, $ngoName, $campaignName, $description, $actualAmount, $minimumAmount, $lastDate, $email);
        $response['saveModifiedCampaignDetailsResponse'] = $objCamapignDetails -> modifyingCamapignDetails();
        deliver_response($_POST['format'], $response, true);
	}
	else if(strcasecmp($_POST['method'], 'CreateCampaign') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objCamapignDetails = new CamapignDetails();
        $first_image_tmp = "";
        $first_image_target_path = "";
        $second_image_tmp = "";
        $second_image_target_path = "";
        $third_image_tmp = "";
        $third_image_target_path = "";
        $ngoName = $_POST['ngoName'];
        $campaignName = $_POST['campaignName'];
        $actualAmount=$_POST['actualAmount'];
        $minimumAmount=$_POST['minimumAmount'];
        $description = $_POST['description'];
        $lastDate = $_POST['lastDate'];      
        $email = $_POST['email'];		
        date_default_timezone_set('Asia/Kolkata');
        $postDate = date("Y-m-d H:i:s");
		
        if(isset($_FILES['firstCampaignImage'])){
            $first_image_tmp = $_FILES['firstCampaignImage']['tmp_name'];
            $first_image_name = $_FILES['firstCampaignImage']['name'];
            $first_image_target_path = "../campaign_images/".basename($first_image_name);
        }
        if(isset($_FILES['secondCampaignImage'])){
            $second_image_tmp = $_FILES['secondCampaignImage']['tmp_name'];
            $second_image_name = $_FILES['secondCampaignImage']['name'];
            $second_image_target_path = "../campaign_images/".basename($second_image_name);
        }
        if(isset($_FILES['thirdCampaignImage'])){
            $third_image_tmp = $_FILES['thirdCampaignImage']['tmp_name'];
            $third_image_name = $_FILES['thirdCampaignImage']['name'];
            $third_image_target_path = "../campaign_images/".basename($third_image_name);
        }
        $objCamapignDetails->mapIncomingCamapignDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $ngoName, $campaignName, $description, $actualAmount, $minimumAmount, $lastDate, $postDate, $email);
        $response['saveCampaignDetailsResponse'] = $objCamapignDetails -> savingCamapignDetails();
        deliver_response($_POST['format'], $response, true);
    }
	//////////////////////////////////////////////////////////////////////////////////////////////////
    else if(strcasecmp($_POST['method'], 'savePetDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objPetDetails = new PetDetails();
        $first_image_tmp = "";
        $first_image_target_path = "";
        $second_image_tmp = "";
        $second_image_target_path = "";
        $third_image_tmp = "";
        $third_image_target_path = "";
        $categoryOfPet = $_POST['categoryOfPet'];
        $breedOfPet = $_POST['breedOfPet'];
        $ageInMonth=$_POST['petAgeInMonth'];
        $ageInYear=$_POST['petAgeInYear'];
        $genderOfPet = $_POST['genderOfPet'];
        $descriptionOfPet = $_POST['descriptionOfPet'];
        $adoptionOfPet = $_POST['adoptionOfPet'];
        $priceOfPet = $_POST['priceOfPet'];
        $email = $_POST['email'];
		$alternateNo = $_POST['alternateNo'];
        date_default_timezone_set('Asia/Kolkata');
        $postDate = date("Y-m-d H:i:s");
        if(isset($_FILES['firstPetImage'])){
            $first_image_tmp = $_FILES['firstPetImage']['tmp_name'];
            $first_image_name = $_FILES['firstPetImage']['name'];
            $first_image_target_path = "../pet_images/".basename($first_image_name);
        }
        if(isset($_FILES['secondPetImage'])){
            $second_image_tmp = $_FILES['secondPetImage']['tmp_name'];
            $second_image_name = $_FILES['secondPetImage']['name'];
            $second_image_target_path = "../pet_images/".basename($second_image_name);
        }
        if(isset($_FILES['thirdPetImage'])){
            $third_image_tmp = $_FILES['thirdPetImage']['tmp_name'];
            $third_image_name = $_FILES['thirdPetImage']['name'];
            $third_image_target_path = "../pet_images/".basename($third_image_name);
        }
        $objPetDetails->mapIncomingPetDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $categoryOfPet, $breedOfPet, $ageInMonth, $ageInYear, $genderOfPet, $descriptionOfPet, $adoptionOfPet, $priceOfPet, $postDate, $email,$alternateNo);
        $response['savePetDetailsResponse'] = $objPetDetails -> savingPetDetails();
        deliver_response($_POST['format'], $response, true);
    }    
	
    else if (strcasecmp($_POST['method'], 'savePetMateDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objPetDetails = new PetMateDetails();
        $first_image_tmp = "";
        $first_image_target_path = "";
        $second_image_tmp = "";
        $second_image_target_path = "";
        $third_image_tmp = "";
        $third_image_target_path = "";
        $categoryOfPet = $_POST['categoryOfPet'];
        $breedOfPet = $_POST['breedOfPet'];
        $ageInMonth=$_POST['petAgeInMonth'];
        $ageInYear=$_POST['petAgeInYear'];
        $genderOfPet = $_POST['genderOfPet'];
        $email = $_POST['email'];
		$alternateNo = $_POST['alternateNo'];
        $descriptionOfPet = $_POST['descriptionOfPet'];
        date_default_timezone_set('Asia/Kolkata');
        $postDate = date("Y-m-d H:i:s");
       
        if(isset($_FILES['firstPetImage'])){
            $first_image_tmp = $_FILES['firstPetImage']['tmp_name'];
            $first_image_name = $_FILES['firstPetImage']['name'];
            $first_image_target_path = "../pet_mate_images/".basename($first_image_name);
        }
        if(isset($_FILES['secondPetImage'])){
            $second_image_tmp = $_FILES['secondPetImage']['tmp_name'];
            $second_image_name = $_FILES['secondPetImage']['name'];
            $second_image_target_path = "../pet_mate_images/".basename($second_image_name);
        }
        if(isset($_FILES['thirdPetImage'])){
            $third_image_tmp = $_FILES['thirdPetImage']['tmp_name'];
            $third_image_name = $_FILES['thirdPetImage']['name'];
            $third_image_target_path = "../pet_mate_images/".basename($third_image_name);
        }
        $objPetDetails->mapIncomingPetMateDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $categoryOfPet, $breedOfPet, $ageInMonth ,$ageInYear, $genderOfPet, $descriptionOfPet, $postDate, $email,$alternateNo);
        $response['savePetMateDetailsResponse'] = $objPetDetails -> savingPetMateDetails();
        deliver_response($_POST['format'], $response, true);
    }    
}
else if (isset($_GET['method'])) {
    if (strcasecmp($_GET['method'], 'showPetDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetDetails = new PetDetails();
		//current page for petlist
        $currentPage = $_GET['currentPage'];
		//email for wishlist
		$email=$_GET['email'];
		if($currentPage == 1){
			$response['showWishListResponse'] = $fetchPetDetails -> showingUserWishList($email);
		}
		$response['showPetDetailsResponse'] = $fetchPetDetails -> showingPetDetails($currentPage);
        deliver_response($_GET['format'], $response, false);
    }	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if (strcasecmp($_GET['method'], 'showCampaignDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchCampaignDetails = new CamapignDetails();		
		$email = $_GET['email'];
		$currentPage = $_GET['currentPage'];
		$response['showCampaignDetailsResponse'] = $fetchCampaignDetails -> showingCampaignDetails($email,$currentPage);
        deliver_response($_GET['format'], $response, false);
    }
	
	else if (strcasecmp($_GET['method'], 'showCampaignForAll') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchCampaignDetails = new CamapignDetails();		
		$currentPage = $_GET['currentPage'];
		$response['showCampaignDetailsForAllResponse'] = $fetchCampaignDetails -> showingCampaignDetailsForAll($currentPage);
        deliver_response($_GET['format'], $response, false);
    }
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    else if (strcasecmp($_GET['method'], 'showPetSwipeRefreshList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetRefreshListDetails = new PetDetails();
        $date = $_GET['date'];
        $response['showPetDetailsResponse'] = $fetchPetRefreshListDetails -> showingRefreshPetDetails($date);
        deliver_response($_GET['format'], $response, false);
    }
	else if (strcasecmp($_GET['method'], 'showShopProductsDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetDetails = new ShopProductDetails();		
        $currentPage = $_GET['currentPage'];
		$response['showShopProductDetailsResponse'] = $fetchPetDetails -> showingProductDetails($currentPage);
        deliver_response($_GET['format'], $response, false);
    }	
    else if (strcasecmp($_GET['method'], 'showShopProductSwipeRefreshList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetRefreshListDetails = new ShopProductDetails();
        $date = $_GET['date'];
        $response['showShopProductDetailsResponse'] = $fetchPetRefreshListDetails -> showingRefreshPetDetails($date);
        deliver_response($_GET['format'], $response, false);
    }
	else if (strcasecmp($_GET['method'], 'showContactNo') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchContactDetails = new UsersDetails();		
		$email = $_GET['email'];
		$response['showContactDetailsResponse'] = $fetchContactDetails -> FetchingContactDetails($email);
        deliver_response($_GET['format'], $response, false);
    }
	else if (strcasecmp($_GET['method'], 'showUserOrders') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchOrderDetails = new OrderDetails();		
		$email = $_GET['email'];
		$currentPage = $_GET['currentPage'];
		$response['showOrderDetailsResponse'] = $fetchOrderDetails -> FetchingOrderDetails($email,$currentPage);
        deliver_response($_GET['format'], $response, false);
    }
	else if (strcasecmp($_GET['method'], 'showPetMateDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetMateDetails = new PetMateDetails();
		$email=$_GET['email'];
        $currentPage = $_GET['currentPage'];
		if($currentPage == 1){
			$response['showWishListResponse'] = $fetchPetMateDetails -> showingUserWishListForPetMate($email);
		}
        $response['showPetMateDetailsResponse'] = $fetchPetMateDetails -> showingPetMateDetails($currentPage,$email);
        deliver_response($_GET['format'], $response, false);
    }
	else if (strcasecmp($_GET['method'], 'showPetMateSwipeRefreshList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetRefreshListDetails = new PetMateDetails();
        $date = $_GET['date'];
		$email=$_GET['email'];
        $response['showPetMateDetailsResponse'] = $fetchPetRefreshListDetails -> showingRefreshPetMateDetails($date,$email);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'showPetCategories') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetCategories = new PetCategories();
        $response['showPetCategoriesResponse'] = $fetchPetCategories -> showingPetCategories();
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'showPetBreedsAsPerPetCategory') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetBreedsAsPerPetCategory = new PetCategories();
        $petCategory = $_GET['petCategory'];
        $response['showPetBreedsResponse'] = $fetchPetBreedsAsPerPetCategory -> showingPetBreeds($petCategory);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'ClinicByCurrentLocation') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchClinicDetails = new ClinicDetails();
		$latitude = $_GET['latitude'];
        $longitude = $_GET['longitude'];
        $currentPage = $_GET['currentPage'];
        $response['showClinicDetailsResponse'] = $fetchClinicDetails -> showingClinicByCurrentLocation($currentPage,$latitude,$longitude);
        deliver_response($_GET['format'], $response, false);
    }
	else if (strcasecmp($_GET['method'], 'ClinicByAddress') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchClinicDetails = new ClinicDetails();
		$email=$_GET['email'];
        $currentPage = $_GET['currentPage'];
        $response['showClinicDetailsResponse'] = $fetchClinicDetails -> showingClinicByAddress($currentPage,$email);
        deliver_response($_GET['format'], $response, false);
    }
	/*else if (strcasecmp($_GET['method'], 'checkClinic') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchClinicDetails = new ClinicDetails();
		$email=$_GET['email'];
        $currentPage = $_GET['currentPage'];
        $response['showClinicDetailsResponse'] = $fetchClinicDetails -> showingClinicByAddress($currentPage,$email);
        deliver_response($_GET['format'], $response, false);
    }*/
    else if (strcasecmp($_GET['method'], 'showPetShelter') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetServices = new PetServices();
        $currentPage = $_GET['currentPage'];
        $response['showPetShelterResponse'] = $fetchPetServices -> showingPetShelter($currentPage);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'showPetStores') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetServices = new PetServices();
        $currentPage = $_GET['currentPage'];
        $response['showPetStoresResponse'] = $fetchPetServices -> showingStores($currentPage);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'showPetGroomer') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetServices = new PetServices();
        $currentPage = $_GET['currentPage'];
        $response['showPetGroomerResponse'] = $fetchPetServices -> showingGroomer($currentPage);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'showPetTrainer') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetServices = new PetServices();
        $currentPage = $_GET['currentPage'];
        $response['showPetTrainerResponse'] = $fetchPetServices -> showingTrainer($currentPage);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'showMyListingPetList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchMyListingPetList = new MyListing();
        $currentPage = $_GET['currentPage'];
        $email=$_GET['email'];
        $response['showMyListingPetListResponse'] = $fetchMyListingPetList -> showingMyListingPetList($currentPage,$email);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'showMyListingPetMateList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchMyListingPetMateList = new MyListing();
        $currentPage = $_GET['currentPage'];
        $email=$_GET['email'];
        $response['showMyListingPetMateListResponse'] = $fetchMyListingPetMateList -> showingMyListingPetMateList($currentPage,$email);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'deleteMyListingPetList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchMyListingPetList = new MyListing();
        $id = $_GET['id'];
        $email=$_GET['email'];
        $response['deleteMyListingPetListResponse'] = $fetchMyListingPetList -> deletingMyListingPetList($id,$email);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'deleteMyListingPetMateList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchMyListingPetMateList = new MyListing();
        $id = $_GET['id'];
        $email=$_GET['email'];
        $response['deleteMyListingPetMateListResponse'] = $fetchMyListingPetMateList -> deletingMyListingPetMateList($id,$email);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'deleteFilterPetListObject') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $deleteFilterPetListObj = new FilterPetList();
        $email=$_GET['email'];
        $response['deleteFilterPetListObjectResponse'] = $deleteFilterPetListObj -> deletingFilterPetListObject($email);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'deleteFilterPetMateListObject') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $deleteFilterPetMateListObj = new FilterPetMateList();
        $email=$_GET['email'];
        $response['deleteFilterPetMateListObjectResponse'] = $deleteFilterPetMateListObj -> deletingFilterPetMateListObject($email);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'showClinicReviews') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchClinicReviewsDetails = new ClinicFeedbackDetails();
        $clinicId=$_GET['clinicId'];
        $currentPage = $_GET['currentPage'];
        $response['showClinicReviewsResponse'] = $fetchClinicReviewsDetails -> showingClinicReviews($currentPage,$clinicId);
        deliver_response($_GET['format'], $response, false);
    }
	else if (strcasecmp($_GET['method'], 'showPetListWishList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetWishListDetails = new WishListDetails();
        $email=$_GET['email'];
        $currentPage = $_GET['currentPage'];
        $response['showPetWishListResponse'] = $fetchPetWishListDetails -> showingPetListWishList($email,$currentPage);
        deliver_response($_GET['format'], $response, false);
    }
	else if (strcasecmp($_GET['method'], 'showPetMateWishList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPetMateWishListDetails = new WishListDetails();
        $email=$_GET['email'];
        $currentPage = $_GET['currentPage'];
        $response['showPetMateWishListResponse'] = $fetchPetMateWishListDetails -> showingPetMateListWishList($email,$currentPage);
        deliver_response($_GET['format'], $response, false);
    }
	else if (strcasecmp($_GET['method'], 'deleteWishListPetList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchMyListingPetList = new WishListDetails();
        $listId = $_GET['id'];
        $email=$_GET['email'];
        $response['deleteWishListPetListResponse'] = $fetchMyListingPetList -> deletingWishListPetList($listId,$email);
        deliver_response($_GET['format'], $response, false);
    }
    else if (strcasecmp($_GET['method'], 'deleteWishListPetMateList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchMyListingPetMateList = new WishListDetails();
        $listId = $_GET['id'];
        $email=$_GET['email'];
        $response['deleteWishListPetMateListResponse'] = $fetchMyListingPetMateList -> deletingWishListPetMateList($listId,$email);
        deliver_response($_GET['format'], $response, false);
    }
}
?>
