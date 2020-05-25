<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}
$target = "Product_Image/";
$target = $target . basename($_FILES['Prod_Img']['name']);
$Filename=basename( $_FILES['Prod_Img']['name']);

$Category = $_POST['Category'];
$Sub_Category = $_POST['Sub_Category'];
$Name = strtoupper($_POST['Name']);
$Price_From = $_POST['Price_From'];
$Prod_Qty = $_POST['Prod_Qty'];
$Qty_unit = $_POST['Qty_unit'];
$Price_To = $_POST['Price_To'];
$Is_Essential = $_POST['Is_Essential'];
$Limit_NF = $_POST['Limit_NF'];
$Limit_JF = $_POST['Limit_JF'];
$Limit_SP = $_POST['Limit_SP'];
$govt_off_id =$_SESSION['user_id'];
$status=$msg="";
//$status .= "F";
//$msg .= "Error ".$Filename;

$sql = "SELECT * FROM product_master WHERE PRODUCT_NAME = '$Name' and CATEGORY= '$Category'";
$result = mysqli_query($MyConnection, $sql);

 if (mysqli_num_rows($result) === 0) 
 {
     if ($Is_Essential === 'Y')
     {
        if(move_uploaded_file($_FILES['Prod_Img']['tmp_name'], $target)) 
        {
             $sql = "INSERT INTO product_master(CATEGORY, PRODUCT_NAME, PRICE_RANGE_FROM, PRICE_RANGE_TO, "
                     . "IS_ESSENTIAL_PRODUCT,MAXIMUM_LIMIT_NF, MAXIMUM_LIMIT_JF, MAXIMUM_LIMIT_SP, GOVT_OFF_ID,"
                     . "product_Image,Sub_Category,Prod_Qty,Qty_Unit) "
                     . "values ('$Category','$Name','$Price_From','$Price_To','$Is_Essential','$Limit_NF',"
                     . "'$Limit_JF','$Limit_SP','$govt_off_id','$Filename','$Sub_Category','$Prod_Qty','$Qty_unit')";
     
        } 
        else 
        {
            $status = "F";
            $msg = "Sorry, there was a problem uploading your file.";
        }
     }
     else
     {
        if(move_uploaded_file($_FILES['Prod_Img']['tmp_name'], $target)) 
        {
             $sql = "INSERT INTO product_master(CATEGORY, PRODUCT_NAME, PRICE_RANGE_FROM, PRICE_RANGE_TO, IS_ESSENTIAL_PRODUCT, "
                . " GOVT_OFF_ID,product_Image,Sub_Category,Prod_Qty,Qty_Unit) values ('$Category','$Name','$Price_From',"
                 . "'$Price_To','$Is_Essential','$govt_off_id','$Filename','$Sub_Category','$Prod_Qty','$Qty_unit')";
        } 
        else 
        {
            $status = "F";
            $msg = "Sorry, there was a problem uploading your file.";
        }
     }
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
