<?php
require_once '../model/DonationEmails.php';
$con = new mysqli("localhost", "appcom_petuser", "pet@pp2015!", "appcom_petapp");
//$con = new mysqli("103.21.59.166:3306", "appcom_petuser", "pet@pp2015!", "appcom_petapp");

if ($con->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
	date_default_timezone_set('Asia/Kolkata');
	$currentDateTime = date("Y-m-d H:i:s");
	$lastDate = "SELECT * FROM campaign WHERE lastDate = DATE_ADD('currentDateTime', INTERVAL 3 day)";
	$sql=mysqli_query($con,$lastDate);
	$NGODetails=array();
	while($rowdata = mysqli_fetch_assoc($sql)){
		$NGODetails[]=$rowdata;
	}
  //mysqli_close($con);
	//print_r ($NGODetails);

	foreach($NGODetails as $value){
        $con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);        
		 $campaign_id = $value['campaign_id'];
		 $campaignName = $value['campaignName'];
		 $ngoName = $value['ngoName'];
		 $ngoOwnerEmail = $value['email'];				
		 $lastDateOfCampaign = $value['lastDate'];
		 $postedDateOfCampaign = $value['postDate'];
		//send email
		$objCampaignDeleteDetails = new DonationEmails();
		$objCampaignDeleteDetails -> SendCampaignDeleteDateWiseEmail($campaign_id,$campaignName,$ngoName,$ngoOwnerEmail,$lastDateOfCampaign,$postedDateOfCampaign);                      
	}
	//delete todays campaign list
	try {
                $sql = "DELETE FROM campaign WHERE lastDate = 'currentDateTime'";
        
                $isRemoved = mysqli_query($con, $sql);
                if ($isRemoved) {
                    echo "Campign Successfully Deleted";
						
                } else {
                   echo "ERROR_WHILE_REMOVING";
                }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
	
	
?>