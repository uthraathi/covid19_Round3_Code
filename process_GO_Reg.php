<?php
require_once "config.php";
$Name = $_POST['Name'];
$Pincode = $_POST['Pincode'];
$Mobile = $_POST['Mobile'];
$Email = $_POST['Email'];
$Empid = $_POST['Empid'];
$status=$msg=$goid="";


mysqli_query($MyConnection ,"SET @p1='".$Name."'");
mysqli_query($MyConnection ,"SET @p0='".$Pincode."'");
mysqli_query($MyConnection ,"SET @p2='".$Mobile."'");
mysqli_query($MyConnection ,"SET @p3='".$Email."'");
mysqli_query($MyConnection ,"SET @p4='".$Empid."'");

mysqli_query($MyConnection ,"SET @status='".$status."'");
mysqli_query($MyConnection ,"SET @msg='".$msg."'");
mysqli_query($MyConnection ,"SET @goid='".$goid."'");
mysqli_multi_query ($MyConnection, "CALL GOVT_OFF_REGISTER (@p0,@p1,@p2,@p3,@p4,@status, @msg, @goid)") OR DIE (mysqli_error($MyConnection));
$select = mysqli_query($MyConnection,'SELECT @status, @msg, @goid');
$result = mysqli_fetch_assoc($select);
$status  .= $result['@status'];
$msg  = $result['@msg'];
$goid  = $result['@goid'];


$arr = array('status' => $status, 
            'msg' => $msg."\n"."Your Unique ID: ".$goid."\n"."Password: ".$Mobile, 
            'go_id' => $goid); 
echo json_encode($arr);
?>
