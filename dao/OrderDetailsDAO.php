<?php
require_once 'BaseDAO.php';
class OrderDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function OrderDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function SaveOrderDetails($OrderDetail) {
		
        try {			
				/*convert area to lat long..
					$address = "'".$OrderDetail->getArea()."'";
					$region = "'".$OrderDetail->getCity()."'";
					$address = str_replace(" ", "+", $address);
					$region= str_replace(" ", "+", $region);
					
					$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
					$json = json_decode($json);

					$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
					$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

				*/	
                $sql = "INSERT INTO orders(product_Id,quantity,shipping_charges,total_price,customer_name,customer_contact,customer_email,address,area,city,pincode,post_date)
                        VALUES ('".$OrderDetail->getProductId()."',
								'".$OrderDetail->getQuantity()."',
								'".$OrderDetail->getShippingCharges()."',
								'".$OrderDetail->getProductTotalPrice()."',								
								'".$OrderDetail->getName()."',
								'".$OrderDetail->getMobileno()."',
								'".$OrderDetail->getEmail()."', 
								'".$OrderDetail->getBuildingname()."',
								'".$OrderDetail->getArea()."',
								'".$OrderDetail->getCity()."',
								'".$OrderDetail->getPincode()."',
								'".$OrderDetail->getPostDate()."')";
        
                $isInserted = mysqli_query($this->con, $sql);
				$orderId="";
                if ($isInserted) {					
					$response= "ORDER_GENERATED";
					$orderId = mysqli_insert_id($this->con);					
					$sql="SELECT * FROM products WHERE id='".$OrderDetail->getProductId()."'";
					$productResult = mysqli_query($this->con, $sql);
					$productDetails = array();
					while ($rowdata = mysqli_fetch_assoc($productResult)) {
						$productDetails[]=$rowdata;
					}					
                } else {
					$response= "ERROR";                   
                }
				$this->data=array('OrderGenerateResponse' => $response,'orderId' => $orderId);			
				//print_r ($this->data);
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

   public function FetchingOrderDetails($fetchDetails) {
		 try {
			$sql = "SELECT * FROM orders WHERE customer_email='".$fetchDetails->getEmail()."'";
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            
            if (($fetchDetails->getCurrentPage())) {
                $currentPage = (int) $fetchDetails->getCurrentPage();				
            }           
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
			   $offset = ($currentPage - 1) * $rowsPerPage;           
						$sql = "SELECT o.order_id,o.quantity,o.shipping_charges,o.total_price,o.customer_name,o.customer_contact,o.customer_email,o.address,o.area,o.city,o.post_date,o.pincode,p.id,p.first_image_path, p.second_image_path, p.third_image_path, p.product_name, p.product_price, p.product_description
								FROM orders o
								INNER JOIN products p
								ON o.product_id = p.id
                                WHERE o.customer_email='".$fetchDetails->getEmail()."'
								ORDER BY post_date DESC LIMIT $offset, $rowsPerPage ";
                $result = mysqli_query($this->con, $sql);
                $this->data=array();
                while ($rowdata = mysqli_fetch_assoc($result)) {
                    $this->data[]=$rowdata;					
                }
				return $this->data;
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data=array();
        
   }
   
}
?>