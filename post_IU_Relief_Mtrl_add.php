<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}

$Name = $_POST['Name'];
$Email = $_POST['email'];
$Mobile = $_POST['Mobile'];
$Address = $_POST['Address'];
$Vol_Desp = $_POST['Vol_Desp'];
$Delv_Opt = $_POST['Delv_Opt'];
$Track_Address = $_POST['Track_Address'];
$Exp_Date = $_POST['Exp_Date'];
$st_code = $_SESSION['STATE_CODE'];
$st_name = $_SESSION['STATE_NAME'];
$user_id = $_SESSION['user_id'];
$status=$msg="";

$sql_s = "SELECT * FROM relief_material_registration WHERE user_id = '$user_id' and product_description = '$Vol_Desp'";
$result_s = mysqli_query($MyConnection, $sql_s);

 if (mysqli_num_rows($result_s) === 0) 
 {
     
        $sql_i = "INSERT INTO relief_material_registration(Name, Mobile, email, Address,state_code,"
                . "state_name,user_id,product_description,delivery_option,track_address,Exp_Date) VALUES "
                . "('$Name','$Mobile','$Email','$Address','$st_code','$st_name',"
                . "'$user_id','$Vol_Desp','$Delv_Opt','$Track_Address','$Exp_Date')";
     
        if(mysqli_query($MyConnection, $sql_i))
        {
            $status = "S";
            $msg = "Donated Successfully";
            
           
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
        $msg = "Record Already Exist";
 }
mysqli_close($MyConnection);

$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
