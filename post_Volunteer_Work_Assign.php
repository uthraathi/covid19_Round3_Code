<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}
$target = "Work_Assigned/";
$target = $target . basename($_FILES['Work_Doc']['name']);
$Filename=basename($_FILES['Work_Doc']['name']);

$Category = strtoupper($_POST['Category']);
$Sub_Category = strtoupper($_POST['Sub_Category']);
$Start_dt = $_POST['Start_dt'];
$End_dt = $_POST['End_dt'];
$Work_Title = $_POST['Work_Title'];
$Req_Volu = (int) $_POST['Req_Volu'];

$st_code = $_SESSION['STATE_CODE'];
$st_name = $_SESSION['STATE_NAME'];
$user_id = $_SESSION['user_id'];
$PINCODE = $_SESSION['PINCODE'];
$status=$msg="";
$vol_cnt = (int)0;
$sql_s = "SELECT COUNT(*) AS CNT FROM volunteer_registration V, user_registration U WHERE U.user_id = V.user_id AND "
        . "U.PINCODE = '$PINCODE' AND V.CATEGORY = '$Category' AND V.sub_category = '$Sub_Category' AND V.Vol_ID NOT IN "
        . "(SELECT VOL_ID FROM volunteer_work_assign WHERE '$Start_dt' > END_DT AND CATEGORY = '$Category' AND SUB_CATEGORY = "
        . "'$Sub_Category')";
$result_s = mysqli_query($MyConnection, $sql_s);

if (mysqli_num_rows($result_s) > 0) 
{
    while($row_s = mysqli_fetch_assoc($result_s)) 
    {
        
        $vol_cnt = (int)$row_s['CNT'];
    }
    
}
if ($vol_cnt >= $Req_Volu) 
{
    $sql_As = "SELECT v.Vol_ID FROM volunteer_registration V, user_registration U WHERE U.user_id = V.user_id AND "
        . "U.PINCODE = '$PINCODE' AND V.CATEGORY = '$Category' AND V.sub_category = '$Sub_Category' AND NOT EXISTS "
        . "(SELECT * FROM volunteer_work_assign WHERE '$Start_dt' > END_DT AND CATEGORY = '$Category' AND SUB_CATEGORY = "
        . "'$Sub_Category')";
    $result_As = mysqli_query($MyConnection, $sql_As);
    if (mysqli_num_rows($result_As) > 0) 
    {
        if(move_uploaded_file($_FILES['Work_Doc']['tmp_name'], $target)) 
        {
            while($row = mysqli_fetch_assoc($result_As)) 
            {
                $volid = $row['Vol_ID'];

                $sql_i = "INSERT INTO volunteer_work_assign(GOV_ID, VOL_ID,WORK_TITLE,START_DT,END_DT,CATEGORY,SUB_CATEGORY,WORK_PDF) VALUES 
                   ('$user_id','$volid','$Work_Title','$Start_dt','$End_dt','$Category','$Sub_Category','$Filename')";
                mysqli_query($MyConnection, $sql_i);
            }
             $status = "S";
             $msg = "WORK ASSIGNED SUCCESSFULLY TO THE REGISTERED VOLUNTEER(S)";
        }
         else 
        {
            $status = "F";
            $msg = "Sorry, there was a problem uploading your file.";
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
     $msg = "VOLUNTEER AVAILABLE IN YOUR AREA IS INSUFFICIENT. AVAILABLE VOLUNTEER FOR "
             . "SELECTED CATEGORY AND SUB-CATEGORY IS: ".$vol_cnt;
}
 mysqli_close($MyConnection);

$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>