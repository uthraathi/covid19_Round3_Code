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


        $sql = "update user_order set  ORDER_STATUS  = 4 where USER_ID = '$user_id' and ORDER_ID = '$order_id' and ORDER_STATUS = 3";
     
        if(mysqli_query($MyConnection, $sql))
        {
            $status = "S";
            $msg = "Order Delivered Successfully";
        }
        else
        {
            $status = "F";
            $msg = "Order not yet dispatched";
        }
     
 
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
