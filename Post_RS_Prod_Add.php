<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}

$Name = strtoupper($_POST['Prod_Name']);
$AAP_Qty = $_POST['AAP_Qty'];
$AAP_Price = $_POST['AAP_Price'];
$PHH_Qty = $_POST['PHH_Qty'];
$PHH_Price = $_POST['PHH_Price'];
$NPHH_Qty = $_POST['NPHH_Qty'];
$NPHH_Price = $_POST['NPHH_Price'];

$aap_fm_type = $_POST['aap_fm_type'];
$phh_fm_type = $_POST['phh_fm_type'];
$nphh_fm_type = $_POST['nphh_fm_type'];

$STATE_CODE =$_SESSION['STATE_CODE'];
$govt_off_id =$_SESSION['user_id'];
$status=$msg="";

$sql = "SELECT * FROM ration_product_master WHERE PRODUCT_NAME = '$Name' and STATE_CODE= '$STATE_CODE'";
$result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) === 0) 
 {
     
        $sql = "INSERT INTO ration_product_master(PRODUCT_NAME, aap_Price, phh_Price,nphh_Price, aap_limit,phh_limit,nphh_limit,GOVT_OFF_ID,"
                . "ENTRY_DATE,STATE_CODE,aap_fm_type,phh_fm_type,nphh_fm_type) VALUES"
                . " ('$Name','$AAP_Price','$PHH_Price','$NPHH_Price','$AAP_Qty','$PHH_Qty','$NPHH_Qty','$govt_off_id',curdate(),'$STATE_CODE',"
                . "'$aap_fm_type','$phh_fm_type','$nphh_fm_type')";
     
        if(mysqli_query($MyConnection, $sql))
        {
            $status = "S";
            $msg = "Product Successfully Added";
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
        $msg = "Product Already Exist";
 }
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
