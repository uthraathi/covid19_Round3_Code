<?php
require_once "config.php";
session_start();
$category = $_POST['category'];
$username = $_POST['username'];
$password = $_POST['password'];
$st_code = "PB";
$st_name = "Punjab";
$status=$msg="";

if($category === 'GO')
{
    $sql = "SELECT G.* FROM govt_official_registration G, pincode_master P WHERE G.GOVT_OFFICIAL_ID = '$username' and G.PHONE_NUMBER= '$password' AND P.STATE_CODE = '$st_code' AND P.pincode = G.EMP_WORKING_LOC_PINCODE";
}
else if ($category === 'IU')
{
    $sql = "SELECT * FROM user_registration WHERE user_id  = '$username' and mobile_number= '$password' and STATE = '$st_name'";
}
else if ($category === 'RS')
{
    $sql = "SELECT * FROM ration_shop_register WHERE RS_INC_ID  = '$username' and mobile_number= '$password' and STATE = '$st_name'";
}
else
{
    $sql = "SELECT * FROM shop_keeper_registration WHERE SK_UNIQUE_ID   = '$username' and  SHOP_MOBILE_NUMBER = '$password' and SHOP_STATE = '$st_name'";
}
 $result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) === 1) 
 {
    while($row = mysqli_fetch_assoc($result)) 
    {
        $status = "S";
        $msg = "Login Successfully";
        $_SESSION['user_id'] = $username;
        $_SESSION['user_category'] = $category;
        $_SESSION['STATE_CODE'] = $st_code;
        $_SESSION['STATE_NAME'] = $st_name;
        if($category === 'GO')
        {
            $_SESSION['User_Name'] = $row['NAME'];
            $_SESSION['PINCODE'] = $row['EMP_WORKING_LOC_PINCODE'];
            $_SESSION['FAMILY_TYPE'] = "";
        }
        else if ($category === 'IU')
        {
            $_SESSION['User_Name']= $row['user_name'];
            $_SESSION['PINCODE'] = $row['PINCODE'];
            $_SESSION['FAMILY_TYPE'] = $row['family_type'];
            
        }
        else if ($category === 'RS')
        {
            $_SESSION['User_Name']= $row['RS_INC_NAME'];
            $_SESSION['PINCODE'] = $row['PINCODE'];
            $_SESSION['FAMILY_TYPE'] = "";
            
        }
        else
        {
            $_SESSION['User_Name']= $row['SHOP_OWNER_NAME'];
            $_SESSION['PINCODE'] = $row['SHOP_PINCODE'];
            $_SESSION['FAMILY_TYPE'] =  "";
        }
        //$msg = $msg.$_SESSION['PINCODE'];
    }
 } 
 else 
 {
        $status = "F";
        $msg = "Access Denied";
 }
$sql_zip = "SELECT * FROM pincode_master WHERE pincode  = ".$_SESSION['PINCODE']."";
$result_zip = mysqli_query($MyConnection, $sql_zip);

if (mysqli_num_rows($result_zip) === 1) 
{
   while($row_zip = mysqli_fetch_assoc($result_zip)) 
   {
       $_SESSION['Latitude'] = $row_zip['Latitude'];
       $_SESSION['Longitude'] = $row_zip['Longitude'];
       //$_SESSION['STATE_CODE'] = $row_zip['STATE_CODE'];
       
   }
}
else
{
     $_SESSION['Latitude'] = "";
     $_SESSION['Longitude'] = "";
     //$_SESSION['STATE_CODE'] = "";
}
 
 mysqli_close($MyConnection);

$arr = array('status' => $status, 
             'msg'    => $msg); 
echo json_encode($arr);

?>
