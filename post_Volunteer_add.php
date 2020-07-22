<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}
$District = $_POST['District'];
$Category = strtoupper($_POST['Category']);
$Sub_Category = strtoupper($_POST['Sub_Category']);
$Name = $_POST['Name'];
$Email = $_POST['email'];
$Mobile = $_POST['Mobile'];
$Gender = $_POST['Gender'];
$DOB = $_POST['DOB'];
$Address = $_POST['Address'];
$Availability = $_POST['Availability'];
$Edu_Qual = $_POST['Edu_Qual'];
$st_code = $_SESSION['STATE_CODE'];
$st_name = $_SESSION['STATE_NAME'];
$user_id = $_SESSION['user_id'];
$status=$msg="";

$sql_s = "SELECT * FROM volunteer_registration WHERE user_id = '$user_id'";
$result_s = mysqli_query($MyConnection, $sql_s);

 if (mysqli_num_rows($result_s) === 0) 
 {
     
        $sql_i = "INSERT INTO volunteer_registration(Name, Mobile, email, Address,Availability,DOB,Gender,Edu_Qual,state_code,"
                . "state_name,district,category,sub_category,user_id) VALUES "
                . "('$Name','$Mobile','$Email','$Address','$Availability','$DOB','$Gender','$Edu_Qual','$st_code','$st_name',"
                . "'$District','$Category','$Sub_Category','$user_id')";
     
        if(mysqli_query($MyConnection, $sql_i))
        {
            $status = "S";
            $msg = "You are registered as Volunteer now";
            
            $sql_q = "SELECT * FROM voulteer_category_master WHERE CATEGORY = '$Category' and SUB_CATEGORY= '$Sub_Category'";
            $result_q = mysqli_query($MyConnection, $sql_q);
            if(mysqli_num_rows($result_q) === 0)
            {
               $sql_ir = "INSERT INTO voulteer_category_master(CATEGORY,SUB_CATEGORY) VALUES ('$Category','$Sub_Category')"; 
               mysqli_query($MyConnection, $sql_ir);
            }
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
        $msg = "Volunteer Already Exist";
 }
mysqli_close($MyConnection);

$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
