<?php
require_once "config.php";
date_default_timezone_set('Asia/Kolkata'); 
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}
$order_id = $_POST['order_id'];
$Deliv_Option = $_POST['Deliv_Option'];
$user_id =$_SESSION['user_id'];
$status=$msg="";
$current_date =  date('Y-m-d');
$current_time =  date('H:i');
$current_date_time = date("Y-m-d H:i");
// get shop details
$sql_s = "SELECT s.* FROM ration_shop_order u, ration_shop_register s WHERE u.ORDER_ID = '$order_id' and s.RS_INC_ID  = u.SHOP_ID";
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
$HD_No_of_Person = (int) $row['HD_No_of_Person'];
$HD_Service_Time = (int) $row['HD_Service_Time']*60;
$count_person = "";
// get max deivery time
$sql_d = "SELECT MAX(delivery_time) AS delivery_time FROM ration_shop_order WHERE ORDER_STATUS > 1 AND ORDER_DATE = CURRENT_DATE() and delivery_option = '$Deliv_Option'";
$result_d = mysqli_query($MyConnection, $sql_d);
$row_d = mysqli_fetch_assoc($result_d);
//$max_deliv_dt = date("Y-m-d h:i",$row_d['delivery_time']) ;
$max_deliv_dt = date('Y-m-d H:i',strtotime($row_d['delivery_time']));
//$status .= "F";
//$msg = "Delivery Time: ".$max_deliv_dt;
if ($max_deliv_dt != '')
 {
     // get person count
    $sql_c = "SELECT COUNT(*) AS CNT FROM ration_shop_order WHERE ORDER_STATUS > 1 AND ORDER_DATE = CURRENT_DATE() and delivery_option = '$Deliv_Option'";
    $result_c = mysqli_query($MyConnection, $sql_c);
    $row_c = mysqli_fetch_assoc($result_c);
    $count_person = (int)$row_c['CNT'];
    if ($Deliv_Option === 'S')
    {
        if($count_person !== 0 && $count_person < $No_of_Person && $max_deliv_dt > $current_date_time)
        {
                    $max_deliv_dt = $max_deliv_dt;
        }
        else if($count_person !== 0 && $count_person === $No_of_Person && $max_deliv_dt > $current_date_time)
        {
                    $max_deliv_dt = date('Y-m-d H:i',strtotime($max_deliv_dt) + $Service_Time);
        }
        else
        {
            if ($current_date_time > $max_deliv_dt && date('H:i',strtotime($current_time) + $Service_Time) > $Close_Time)
            {
                    $max_deliv_dt =  date('Y-m-d H:i',strtotime($current_date) + $Service_Time + (int)($Open_Time_H)*60*60 + (int)($Open_Time_M)*60 + 86400);
            }
            else
            {
                     $max_deliv_dt =  date('Y-m-d H:i',strtotime($current_date_time) + $Service_Time);
            }
        }
    }
    else
    {
        if($count_person !== 0 && $count_person < $HD_No_of_Person && $max_deliv_dt > $current_date_time)
        {
                    $max_deliv_dt = $max_deliv_dt;
        }
        else if($count_person !== 0 && $count_person === $HD_No_of_Person && $max_deliv_dt > $current_date_time)
        {
                    $max_deliv_dt = date('Y-m-d H:i',strtotime($max_deliv_dt) + $HD_Service_Time);
        }
        else
        {
            if ($current_date_time > $max_deliv_dt && date('H:i',strtotime($current_time) + $HD_Service_Time) > $Close_Time)
            {
                    $max_deliv_dt =  date('Y-m-d H:i',strtotime($current_date) + $HD_Service_Time + (int)($Open_Time_H)*60*60 + (int)($Open_Time_M)*60 + 86400);
            }
            else
            {
                     $max_deliv_dt =  date('Y-m-d H:i',strtotime($current_date_time) + $HD_Service_Time);
            }
        }
    }
 }
else 
{
    if ($Deliv_Option === 'S')
    {
        if($current_time > $Open_Time && date('H:i',strtotime($current_time) + $Service_Time) < $Close_Time)
        {
            $max_deliv_dt = date('Y-m-d H:i',strtotime($current_date_time) + $Service_Time);

        }
        else if(date('h:i:s',strtotime($current_date_time)) < $Open_Time)
        {
            $max_deliv_dt = date('Y-m-d H:i',strtotime($current_date) + $Service_Time + (int)($Open_Time_H)*60*60 + (int)($Open_Time_M)*60);

        }
        else 
        {
             $max_deliv_dt = date('Y-m-d H:i',strtotime($current_date) + $Service_Time + (int)($Open_Time_H)*60*60 + (int)($Open_Time_M)*60 + 86400);
        }
    }
    else 
    {
        if($current_time > $Open_Time && date('H:i',strtotime($current_time) + $HD_Service_Time) < $Close_Time)
        {
            $max_deliv_dt = date('Y-m-d H:i',strtotime($current_date_time) + $HD_Service_Time);
        }
        else if(date('h:i:s',strtotime($current_date_time)) < $Open_Time)
        {
            $max_deliv_dt = date('Y-m-d H:i',strtotime($current_date) + $HD_Service_Time + (int)($Open_Time_H)*60*60 + (int)($Open_Time_M)*60);
        }
        else 
        {
             $max_deliv_dt = date('Y-m-d H:i',strtotime($current_date) + $HD_Service_Time + (int)($Open_Time_H)*60*60 + (int)($Open_Time_M)*60 + 86400);
        }
    }
}

//$sql = "update user_order set ORDER_STATUS = 2,ORDER_DATE = now(), delivery_time = now() WHERE ORDER_ID = '$order_id' and ORDER_STATUS = 1";
$sql_status = "update ration_shop_order set ORDER_STATUS = 2,ORDER_DATE = now(), delivery_time = '$max_deliv_dt',delivery_option = '$Deliv_Option' WHERE ORDER_ID = '$order_id' and ORDER_STATUS = 1";
mysqli_query($MyConnection, $sql_status);
//$status .= "F";
//$msg = "Order Placed Successfully ".mysqli_query($MyConnection, $sql_status);
if (mysqli_query($MyConnection, $sql_status)) 
 {
  
            $sql_e = "SELECT s.RS_UNIQUE_ID,p.PRODUCT_ID,s.QUANTITY_AVAILABLE,p.QUANTITY, (s.QUANTITY_AVAILABLE - p.QUANTITY) as current_qty FROM ration_shop_order u,ration_ordered_product_list p,ration_shop_product_list s WHERE u.ORDER_ID = '$order_id' and u.ORDER_ID = p.ORDER_ID and s.PRODUCT_ID = p.PRODUCT_ID and s.RS_UNIQUE_ID = u.SHOP_ID ";
            $result_e = mysqli_query($MyConnection, $sql_e);

             if (mysqli_num_rows($result_e) > 0) 
             {

                while($row_e = mysqli_fetch_assoc($result_e)) 
                {
                      $sql_final = "update ration_shop_product_list set QUANTITY_AVAILABLE = '".$row_e['current_qty']."' where RS_UNIQUE_ID ='".$row_e['RS_UNIQUE_ID']."' and PRODUCT_ID = '".$row_e['PRODUCT_ID']."'";

                       mysqli_query($MyConnection, $sql_final);          
                }
            }
            $status = "S";
            $msg = "Order Placed Successfully";
        
     
 } 
 else {
            $status = "F";
            $msg = "Error";
}
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
