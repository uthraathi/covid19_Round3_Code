<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}

$DOCTOR_ID = $_POST['doc_id'];
$PATIENT_ID = $_SESSION['user_id'];
$APPOINTMENT_ID = "";
$status=$msg="";
// INITIAL INSERT FOR ONLINE BOOKING
$sql_O = "SELECT * FROM doctor_appointment WHERE PATIENT_ID = '$PATIENT_ID' and STATUS= 1";
$result_O = mysqli_query($MyConnection, $sql_O);
$cond = "";
 if (mysqli_num_rows($result_O) === 1) 
 {
     //$row_O = mysqli_fetch_assoc($result_O);
$cond ="if";
      $sql_u = "update doctor_appointment set DOCTOR_ID = "
                
                . "'$DOCTOR_ID' where PATIENT_ID = '$PATIENT_ID' and STATUS= 1";
      $result_u = mysqli_query($MyConnection, $sql_u);
        
}
 else 
 {
     $cond = "else";
       $sql_i = "INSERT INTO doctor_appointment (DOCTOR_ID,PATIENT_ID) VALUES ('$DOCTOR_ID','$PATIENT_ID')";
       $result_i = mysqli_query($MyConnection, $sql_i);
        
 } 
  $sql_sD = "SELECT * FROM doctor_appointment WHERE PATIENT_ID = '$PATIENT_ID' and STATUS= 1";
  $result_sD = mysqli_query($MyConnection, $sql_sD);

 if (mysqli_num_rows($result_sD) === 1) 
 {
     $row_sD = mysqli_fetch_assoc($result_sD);
   
     $APPOINTMENT_ID = (int)$row_sD["APPOINTMENT_ID"];
}
$current_date =  date('Y-m-d');
$current_time =  date('H:i');
$current_time_H =  date('H');
$current_time_M =  date('i');
$current_date_time = date("Y-m-d H:i");
// get DOCTOR details
$sql_s = "SELECT s.* FROM doctor_appointment u, doctor_registration s WHERE u.APPOINTMENT_ID = '$APPOINTMENT_ID' and s.UNIQUE_ID = u.DOCTOR_ID";
$result = mysqli_query($MyConnection, $sql_s);
$row = mysqli_fetch_assoc($result);
$Open_Time = date('H:i',strtotime($row['Open_Time']));
$Open_Time_H = date('H',strtotime($row['Open_Time']));
$Open_Time_M = date('i',strtotime($row['Open_Time']));
$Close_Time = date('H:i',strtotime($row['Close_Time']));
$Close_Time_H = date('H',strtotime($row['Close_Time']));
$Close_Time_M = date('i',strtotime($row['Close_Time']));
$No_of_Person = (int) $row['No_of_Person'];
$Service_Time = (int) $row['Service_Time']*60;

$count_person = "";
// get max deivery time
$sql_d = "SELECT MAX(APPOINTMENT_DATE_TIME) AS delivery_time FROM doctor_appointment WHERE STATUS > 1 AND ENTRY_DATE = CURRENT_DATE()";
$result_d = mysqli_query($MyConnection, $sql_d);
$row_d = mysqli_fetch_assoc($result_d);
if ($row_d['delivery_time'] === NULL) {
    $max_deliv_dt = "";
} else {
    $max_deliv_dt = date('Y-m-d H:i', strtotime($row_d['delivery_time']));
}

if ($max_deliv_dt !== '')
 {
     // get person count
    $sql_c = "SELECT COUNT(*) AS CNT FROM doctor_appointment WHERE STATUS > 1 AND ENTRY_DATE = CURRENT_DATE()";
    $result_c = mysqli_query($MyConnection, $sql_c);
    $row_c = mysqli_fetch_assoc($result_c);
    $count_person = (int)$row_c['CNT'];
    
        if($count_person !== 0 && $count_person < $No_of_Person && $max_deliv_dt > $current_date_time)
        {
            $cond = "if1";
                    $max_deliv_dt = $max_deliv_dt;
        }
        else if($count_person !== 0 && $count_person === $No_of_Person && $max_deliv_dt > $current_date_time)
        {
            $cond = "if2";
                    $max_deliv_dt = date('Y-m-d H:i',strtotime($max_deliv_dt) + $Service_Time);
        }
        else
        {
            if ($current_date_time > $max_deliv_dt && date('H:i',strtotime($current_time) + $Service_Time) > $Close_Time)
            {
                $cond = "if3";
                    $max_deliv_dt =  date('Y-m-d H:i',strtotime($current_date) + $Service_Time + (int)($Open_Time_H)*60*60 + (int)($Open_Time_M)*60 + 86400);
            }
            else
            {
                $cond = "if4";
                     $max_deliv_dt =  date('Y-m-d H:i',strtotime($current_date_time) + $Service_Time);
            }
        }
    
 
 }
else 
{

        if(($current_time > $Open_Time) && (date('H:i',strtotime($current_time) + $Service_Time) < $Close_Time))
        {
            $cond = "else1";
            $max_deliv_dt = date('Y-m-d H:i',strtotime($current_date_time) + $Service_Time);

        }
        else if(date('h:i:s',strtotime($current_date_time)) < $Open_Time)
        {
            $cond = "else2";
            $max_deliv_dt = date('Y-m-d H:i',strtotime($current_date) + $Service_Time + 
                    (int)($Open_Time_H)*60*60 + (int)($Open_Time_M)*60);

        }
        else
        {
             $cond = "else3";
             $max_deliv_dt = date('Y-m-d H:i',strtotime($current_date) + $Service_Time + 
                     (int)($Open_Time_H)*60*60 + (int)($Open_Time_M)*60 + 86400);
        }
   
}
$sql = "update doctor_appointment set STATUS = 2,ENTRY_DATE = now(), APPOINTMENT_DATE_TIME = '$max_deliv_dt' WHERE APPOINTMENT_ID = '$APPOINTMENT_ID' and STATUS = 1";
if (mysqli_query($MyConnection, $sql)) 
 {
  
      
            $status = "S";
            $msg = "Appointment Booked Successfully. Your Appointment Date & Time is: ".$max_deliv_dt;
        
     
 } 
 else {
            $status = "F";
            $msg = "Error";
}
//$time = "";
//if(($current_time > $Open_Time) && (date('H:i',strtotime($current_time) + $Service_Time) < $Close_Time))
//    $time .= date('H:i',strtotime($current_time) + $Service_Time);
//else
//    $time .= $Close_Time;
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' =>$msg ); 
echo json_encode($arr);
?>
