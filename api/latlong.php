<?php
	 $address ="gandhi nagar";
     $region ="dombivli";
     
      $latlong    =   get_lat_long($address,$region); 
	function get_lat_long($address,$region){

    $address = str_replace(" ", "+", $address);
    $region= str_replace(" ", "+", $region);
    
    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	echo $lat;
	echo "long="+$long;
    //return $lat.','.$long;
}
?>