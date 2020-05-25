<?php
require_once "config.php";
require_once 'IU_Menu.php';
//session_start();
//if(!isset($_SESSION['user_id']))
//{
//    header('location:index.php');
//}
$order_id = (int)$_GET['order_id'];
$user_id = $_SESSION['user_id'];

$status=$msg="";
$IS_HD_AVAILABLE = "N";
//echo $Mobile ;

//define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'eshopping');
///* Attempt to connect to MySQL database */
//$MyConnection_get = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$sql_get = "SELECT u.USER_ID,u.SHOP_ID,p.PRODUCT_ID,p.QUANTITY,s.PRODUCT_PRICE, (p.QUANTITY*s.PRODUCT_PRICE) as sub_total FROM user_ordered_product_list p, user_order u, shop_product_list s WHERE u.USER_ID = '$user_id' and u.ORDER_STATUS=1 and u.ORDER_ID = p.ORDER_ID and s.PRODUCT_ID = p.PRODUCT_ID and u.SHOP_ID=s.SK_UNIQUE_ID";
$result_get = mysqli_query($MyConnection, $sql_get);

 if (mysqli_num_rows($result_get) > 0) 
 {
    
    while($row_get = mysqli_fetch_assoc($result_get)) 
    {
          $sql_get = "update user_ordered_product_list set sub_total = '".$row_get['sub_total']."' where ORDER_ID ='$order_id' and PRODUCT_ID = '".$row_get['PRODUCT_ID']."'";

           mysqli_query($MyConnection, $sql_get);          
    }
}
// get home delivery option available or not
$sql_HD = "SELECT s.* FROM user_ordered_product_list p, user_order u, shop_keeper_registration s WHERE u.USER_ID = '$user_id' and u.SHOP_ID=s.SK_UNIQUE_ID";
$result_HD = mysqli_query($MyConnection, $sql_HD);

 if (mysqli_num_rows($result_HD) > 0) 
 {
    while($row_HD = mysqli_fetch_assoc($result_HD)) 
    {
        $IS_HD_AVAILABLE = $row_HD['IS_HD_AVAILABLE'];
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Order Checkout</title>
<!--        <p style="float: right;font-size:20px;color: orchid;"><u>User Name</u>: <?php echo $_SESSION['User_Name']?><br><u>User Category</u>: <?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else echo "Shop Keeper"; ?></p>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $('#Place_Order').click(function () 
                {
                    //alert("Hi");
                    var order_id = "<?php echo $order_id ?>";
                    var Deliv_Option = $('#Deliv_Option').val();
                    //alert("order id: "+order_id);
                    $.ajax({
                        type: 'POST',
                        url: 'Post_Place_Order.php',
                        data: {order_id:order_id,Deliv_Option:Deliv_Option },
                        success: function(response) {
                             var result = JSON.parse(response);
                             if(result.status === "S")
                             {
                                 alert(result.msg);
                                 window.location.href="IU_Order_Status.php";
                             }
                             else
                             {
                                 alert(result.msg);
                            }
                        }
                    });
                });
                
//                $('#Place_Order').click(function () 
//                {
//           alert("hi");
//
//  
//                    $.ajax({
//                        type: 'POST',
//                        url: 'Post_Place_Order.php',
//                        data: {order_id:order_id },
//                        success: function(response) {
//                             var result = JSON.parse(response);
//                             if(result.status === "S")
//                             {
//                                 alert(result.msg);
//                                 window.location.href="IU_Order_Status.php";
//                             }
//                             else
//                             {
//                                 alert(result.msg);
//                            }
//                        }
//                    });
//                )};
            });
        </script>
    </head>
    <body>
       
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Order Checkout (Order ID: <?php echo $order_id ?>)</h2>
<!--               <h4 style="color:#b5651d;">Order ID: <?php echo $order_id ?></h4> -->
            
            <table class="table" style="border-spacing: 5px;border-collapse: separate;text-align:center;">
                <tr  style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Product Name</td>
                    <td>Product Image</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Sub Total</td>
                </tr>
                
                       
                <?php
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 3;
                $offset = ($pageno-1) * $no_of_records_per_page;
                $total_pages_sql = "SELECT count(*) FROM user_ordered_product_list p, user_order u, shop_product_list s,product_master m WHERE u.USER_ID = '$user_id' and u.ORDER_STATUS=1 and u.ORDER_ID = p.ORDER_ID and s.PRODUCT_ID = p.PRODUCT_ID and u.SHOP_ID=s.SK_UNIQUE_ID and m.PRODUCT_ID = s.PRODUCT_ID";
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $sql = "SELECT u.USER_ID,u.SHOP_ID,p.PRODUCT_ID,m.PRODUCT_NAME,p.QUANTITY,s.PRODUCT_PRICE, p.sub_total,p.QUANTITY,m.product_Image,m.Prod_Qty,m.Qty_Unit,m.Sub_Category FROM user_ordered_product_list p, user_order u, shop_product_list s,product_master m WHERE u.USER_ID = '$user_id' and u.ORDER_STATUS=1 and u.ORDER_ID = p.ORDER_ID and s.PRODUCT_ID = p.PRODUCT_ID and u.SHOP_ID=s.SK_UNIQUE_ID and m.PRODUCT_ID = s.PRODUCT_ID LIMIT $offset,$no_of_records_per_page";


                 $result = mysqli_query($MyConnection, $sql);
                 $index1 = (int)0+(int)$offset;
                 if (mysqli_num_rows($result) > 0) 
                 {
                     ?>
                     <?php 
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index1++;
                        ?> 
                <tr>
                    <td><?php echo $index1 ?>
                     
                    </td>

                    <td style="text-align:left;"><?php echo $row['PRODUCT_NAME']. " (".$row['Prod_Qty'] ." ". $row['Qty_Unit'].")"?></td>
                    <td><?php echo "<img src='Product_Image/".$row['product_Image']."' height='60' width='75'>";?></td>
                    <td><?php echo $row['PRODUCT_PRICE']?></td>
                    <td><?php echo $row['QUANTITY']?></td>
                    <td><?php echo $row['sub_total']?></td>
                </tr>
              
                     <?php  
                    }
                       
                }
                
                $sql_s = "SELECT sum(sub_total) as total from user_ordered_product_list where ORDER_ID='$order_id'";
                $result_s = mysqli_query($MyConnection, $sql_s);  
                if (mysqli_num_rows($result_s) > 0) 
                 {
                    while($row_s = mysqli_fetch_assoc($result_s)) 
                    {
                        echo "<tr>";
                         echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td style='float:right;font-size:25px;'><b>Total: ". $row_s['total'] ."</b></td>";

                    }
                 }
                
                 mysqli_close($MyConnection);
                ?>
                <tr style="text-align:center;">
                    <td colspan="6">
                    <ul class="pagination">
                        <li><a href="<?php echo "?order_id=".$order_id."&pageno=1"; ?>">First</a></li>
                        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno <= 1){ echo "?order_id=".$order_id; } else { echo "?order_id=".$order_id."&pageno=".($pageno - 1); } ?>">Prev</a>
                        </li>
                        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno >= $total_pages){ echo "?order_id=".$order_id; } else { echo "?order_id=".$order_id."&pageno=".($pageno + 1); } ?>">Next</a>
                        </li>
                        <li><a href="<?php echo "?order_id=".$order_id."&pageno=".$total_pages; ?>">Last</a></li>
                    </ul>
                   </td>
                    
                </tr> 
                <tr>
                    <td colspan="6">
                        <label style="color: orangered;font-size:20px;">Delivery Option:  </label>
                       <select id="Deliv_Option" name="Deliv_Option" >
                           <option value="S" selected="selected">Pick up at Store</option> 
                            <?php
                            if($IS_HD_AVAILABLE === 'Y')
                            {
                            echo "<option value='H'>Home Delivery</option>";
                            }
                            ?>
                        </select>
                        
                         
                    <input type="button" id="Place_Order" name="Place_Order" class="btn btn-primary" value="Place Order" style="background:green;border:green;float:right;font-weight:bold;font-size:15px;">
                   
                    </td>
                </tr>
             </table> 
<!--     <div>
         <input type="button" id="Place_Order" name="Place_Order" class="btn btn-primary" value="Place Order" style="background:green;border:green;float:right;font-size:20px;">
     </div>-->
        </div>    
    </body>
    
</html>