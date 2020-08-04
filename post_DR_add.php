<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}

$Name = strtoupper($_POST['Name']);
$Specialization = $_POST['Specialization'];
$Incharge = $_POST['Incharge'];
$Mobile = $_POST['Mobile'];
$Email = $_POST['Email'];

$Reg_No = $_POST['Reg_No'];
$Build_No = $_POST['Build_No'];
$Street = $_POST['Street'];
$City = $_POST['City'];
$District = $_POST['District'];
$State = $_POST['State'];
$Pincode = $_POST['Pincode'];

$HOSPITAL_ID =$_SESSION['user_id'];
$status=$msg="";

$sql = "SELECT * FROM doctor_registration WHERE PINCODE= '$Pincode' and REG_NUMBER= '$Reg_No'";
$result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) === 0) 
 {
     
        $sql = "INSERT INTO doctor_registration(NAME, SPECIALIZATION,REG_NUMBER, MOBILE_NUMBER, "
                . "EMAIL_ID, BUILD_NO, STREET, CITY, DISTRICT, STATE, PINCODE, HOSPITAL_ID,IS_INCHARGE_COVID)  "
                . "values ('$Name','$Specialization','$Reg_No','$Mobile','$Email','$Build_No','$Street','$City','$District',"
                . "'$State','$Pincode','$HOSPITAL_ID','$Incharge')";
     
        if(mysqli_query($MyConnection, $sql))
        {
            $status = "S";
            $msg = "Doctor Successfully Added";
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
        $msg = "Doctor Already Exist";
 }
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
