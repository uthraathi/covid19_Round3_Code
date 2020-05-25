<?php
require_once "config.php";
session_start();
$category = $_POST['category'];
$username = $_POST['username'];
$password = $_POST['password'];

$status=$msg="";
//echo $Mobile ;
//define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'eshopping');
// 
///* Attempt to connect to MySQL database */
//$MyConnection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($category === 'GO')
{
    $sql = "SELECT * FROM govt_official_registration WHERE GOVT_OFFICIAL_ID = '$username' and PHONE_NUMBER= '$password'";
}
else if ($category === 'IU')
{
    $sql = "SELECT * FROM user_registration WHERE user_id  = '$username' and mobile_number= '$password'";
}
else
{
    $sql = "SELECT * FROM shop_keeper_registration WHERE SK_UNIQUE_ID   = '$username' and  SHOP_MOBILE_NUMBER = '$password'";
}
 $result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) ===1) 
 {
    while($row = mysqli_fetch_assoc($result)) 
    {
        $status = "S";
        $msg = "Login Successfully";
        $_SESSION['user_id'] = $username;
        $_SESSION['user_category'] = $category;
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
   }
}
else
{
     $_SESSION['Latitude'] = "";
     $_SESSION['Longitude'] = "";
}
 
 mysqli_close($MyConnection);

$arr = array('status' => $status, 
             'msg'    => $msg); 
echo json_encode($arr);

?>
