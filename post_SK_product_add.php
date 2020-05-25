<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}
$Category = $_POST['Category'];
$Sub_Category = $_POST['Sub_Category'];
$ID = $_POST['ID'];
$Price = $_POST['Price'];
$Quantity = $_POST['Quantity'];

$SK_id =$_SESSION['user_id'];
$status=$msg="";
//$status.='F';
//$msg .= 'Sub_Category '.$Sub_Category;
$sql = "SELECT * FROM shop_product_list WHERE PRODUCT_ID  = '$ID' and SK_UNIQUE_ID= '$SK_id'";
$result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) === 0) 
 {
     
        $sql_i = "insert into shop_product_list(SK_UNIQUE_ID,PRODUCT_ID,PRODUCT_CATEGORY,QUANTITY_AVAILABLE,PRODUCT_PRICE,PRODUCT_SUB_CATEGORY) values "
                . "('$SK_id','$ID','$Category','$Quantity','$Price','$Sub_Category')";
     
        if(mysqli_query($MyConnection, $sql_i))
        {
            $status = "S";
            $msg = "Product Successfully Added";
        }
        else
        {
            $status = "F";
            $msg = "Error";
        }
     
 } 
 else 
 {
        $status = "F";
        $msg = "Product Already Exist";
 }
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
