<?php
require_once "config.php";
$RS_Reg_No = $_POST['RS_Reg_No'];
$Name = strtoupper($_POST['Name']);
$Empid = $_POST['Empid'];
$Mobile = $_POST['Mobile'];
$Email = $_POST['Email'];
$Build_No = $_POST['Build_No'];
$Street = $_POST['Street'];
$City = $_POST['City'];
$District = $_POST['District'];
$State = $_POST['State'];
$Pincode = $_POST['Pincode'];
$status=$msg="";
$sql_s = "SELECT * FROM ration_shop_register WHERE RS_REG_NUM = '$RS_Reg_No'";
$result_s = mysqli_query($MyConnection, $sql_s);

 if (mysqli_num_rows($result_s) === 0) 
 {
     
        $sql_i = "INSERT INTO ration_shop_register( RS_INC_NAME, mobile_number, email_id, EMP_ID, BUILD_NO, STREET, CITY, DISTRICT,"
                . "STATE, PINCODE, RS_REG_NUM) VALUES  "
                
                . "('$Name','$Mobile','$Email','$Empid','$Build_No','$Street',"
                . "'$City','$District','$State','$Pincode','$RS_Reg_No')";
     
        if(mysqli_query($MyConnection, $sql_i))
        {
            $sql = "SELECT * FROM ration_shop_register WHERE RS_REG_NUM = '$RS_Reg_No'";
            $result = mysqli_query($MyConnection, $sql);
            $row = mysqli_fetch_assoc($result);
            $status = "S";
            $msg = "Ration Shop Successfully Added"."\n"."Your Unique ID: ".$row['RS_INC_ID']."\n"."Password: ".$Mobile;
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
        $msg = "Ration Shop Already Exist";
 }
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
