<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}
$Open_Time = $_POST['Open_Time'];
$Close_Time = $_POST['Close_Time'];
$Service_Time = $_POST['Service_Time'];
$No_of_Person = $_POST['No_of_Person'];
$HD_Avail = $_POST['HD_Avail'];
$HD_Service_Time = $_POST['HD_Service_Time'];
$HD_No_of_Person = $_POST['HD_No_of_Person'];

$RS_id =$_SESSION['user_id'];
$status=$msg="";


        $sql = "update ration_shop_register set Open_Time = '$Open_Time', Close_Time = '$Close_Time', "
                . "Service_Time= '$Service_Time',No_of_Person =$No_of_Person,IS_HD_AVAILABLE = '$HD_Avail'"
                . ",HD_No_of_Person = '$HD_No_of_Person',HD_Service_Time = '$HD_Service_Time' where "
                . "RS_INC_ID = '$RS_id'";
     
        if(mysqli_query($MyConnection, $sql))
        {
            $status = "S";
            $msg = "Service Time Updated Successfully";
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
