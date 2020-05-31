<?php
require_once "config.php";
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}
$product_id = $_POST['product_id'];
$quantity= (int)$_POST['quantity'];
$order_id = $_POST['order_id'];
$SHOP_ID = $_POST['SHOP_ID'];
$user_id =$_SESSION['user_id'];
$Ration_Card_Type = $_SESSION['Ration_Card_Type'];
$Ration_Card=$_SESSION['rationcard'];
$LIMIT = (int)$_POST['limit'];
$price = $_POST['price'];
$order_qty = (int)0;
$purchase_type = "";
$family_count = (int)1;
// get quantity limit per family or member
$sql_p_m = "SELECT * FROM ration_product_master WHERE PRODUCT_ID = '$product_id'";
  $result_p_m = mysqli_query($MyConnection, $sql_p_m);

 if (mysqli_num_rows($result_p_m) === 1) 
 {
     $row_p_m = mysqli_fetch_assoc($result_p_m);
   
     if ($Ration_Card_Type === 'NPHH')
     {
         $purchase_type = $row_p_m['nphh_fm_type'];
     }
     else if ($Ration_Card_Type === 'PHH')
     {
         $purchase_type = $row_p_m['phh_fm_type'];
     }
     else
     {
         $purchase_type = $row_p_m['aap_fm_type'];
     }
}
// get family count for restriction based on family count
$sql_f_c = "SELECT count(*) as cnt FROM user_dependent WHERE user_id = '$user_id'";
$result_f_c= mysqli_query($MyConnection, $sql_f_c);
if (mysqli_num_rows($result_f_c) > 0) 
 {
    $ROW_F_C = mysqli_fetch_assoc($result_f_c);
    $family_count = (int)$ROW_F_C['cnt'] > 0 ? (int)$ROW_F_C['cnt']  : 1;
}
// check limit os assigned for memeber then multiply family count * limit
if ($purchase_type === 'M')
{
    $LIMIT = $LIMIT * $family_count;
}
$status=$msg="";

//$status=='F';
//$msg = "TEST".$LIMIT;
    if ( $quantity > $LIMIT )
    {
        $status = "F";
        $msg = "Warning: Monthly Limit Exceeded:\n\n\n";
        $msg .= "You are exceeding the monthly purchase limit of quantity ".$LIMIT;
    }
    else 
    {
        //$sql_q = "SELECT sum(p.QUANTITY) as qty FROM ration_shop_order u,ration_ordered_product_list p WHERE YEAR(u.ORDER_DATE) = YEAR(now()) AND MONTH(u.ORDER_DATE) = month(now()) and u.ORDER_STATUS > 1 and u.ORDER_ID = p.ORDER_ID and p.PRODUCT_ID = '$product_id' and u.USER_ID = '$user_id'";
        $sql_q = "SELECT sum(p.QUANTITY) as qty FROM ration_shop_order u,ration_ordered_product_list p, user_registration r WHERE YEAR(u.ORDER_DATE) = YEAR(now()) AND MONTH(u.ORDER_DATE) = month(now()) and u.ORDER_STATUS > 1 and u.ORDER_ID = p.ORDER_ID and p.PRODUCT_ID = '$product_id' and u.USER_ID = r.user_id and r.rationcard = '$Ration_Card'";
        $result_q = mysqli_query($MyConnection, $sql_q);
        if (mysqli_num_rows($result_q) >  0) 
        {
           while($row_q = mysqli_fetch_assoc($result_q))
           {
               $order_qty = (int)$row_q['qty'];


           }
        }
              if(($quantity+$order_qty)> $LIMIT)
               {
                   $status = "F";
                   $msg = "Warning: Monthly Limit Exceeded:\n\n\n";
                   $msg .= "You had already ordered quantity ".$order_qty. ". Now this selected quantity ".$quantity." exceeded the monthly puchase limit of quantity ".$LIMIT;
               }
               else
                {
                    $sql_s = "SELECT * FROM ration_ordered_product_list WHERE ORDER_ID = '$order_id' and PRODUCT_ID= '$product_id'";
                    $result_s = mysqli_query($MyConnection, $sql_s);

                     if (mysqli_num_rows($result_s) === 0) 
                     {

                            $sql_i = "INSERT INTO ration_ordered_product_list(ORDER_ID,PRODUCT_ID,QUANTITY,price) "
                                    . "values ('$order_id','$product_id','$quantity','$price')";

                            if(mysqli_query($MyConnection, $sql_i))
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
                          $sql_u = "update ration_ordered_product_list set QUANTITY ='$quantity' where ORDER_ID = '$order_id' and PRODUCT_ID= '$product_id'";
                          if(mysqli_query($MyConnection, $sql_u))
                            {
                                $status = "S";
                                $msg = "Product Successfully Updated";
                            }
                            else
                            {
                                $status = "F";
                                $msg = "Error";
                            }
                    }  
                } 

    }
mysqli_close($MyConnection);
$arr = array('status' => $status, 
            'msg' => $msg); 
echo json_encode($arr);
?>
