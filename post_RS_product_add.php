<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}

$ID = $_POST['ID'];
$Quantity = $_POST['Quantity'];

$RS_id =$_SESSION['user_id'];
$status=$msg="";

$sql = "SELECT * FROM ration_shop_product_list WHERE PRODUCT_ID  = '$ID' and RS_UNIQUE_ID= '$RS_id'";
$result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) === 0) 
 {
     
        $sql_i = "insert into ration_shop_product_list(RS_UNIQUE_ID,PRODUCT_ID,QUANTITY_AVAILABLE) values "
                . "('$RS_id','$ID','$Quantity')";
     
        if(mysqli_query($MyConnection, $sql_i))
        {
            $status = "S";
            $msg = "Ration Shop Product Successfully Added";
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
        $msg = "Ration Shop Product Already Exist";
 }
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
