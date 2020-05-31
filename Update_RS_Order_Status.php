<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}
$order_id = $_POST['order_id'];
$user_id =$_SESSION['user_id'];
$status=$msg="";


        $sql = "update ration_shop_order set  ORDER_STATUS  = 3 where SHOP_ID = '$user_id' and ORDER_ID = '$order_id'";
     
        if(mysqli_query($MyConnection, $sql))
        {
            $status = "S";
            $msg = "Order Dispatched Successfully";
        }
        else
        {
            $status = "F";
            $msg = "Error";
        }
     
 
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
