<?php
require_once 'IU_Menu.php';
//session_start();
//if(!isset($_SESSION['user_id']))
//{
//    header('location:index.php');
//}
$user_id = $_SESSION['user_id'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Order Status</title>
        <!--<p style="float: right;font-size:20px;color: orchid;"><u>User Name</u>: <?php echo $_SESSION['User_Name']?><br><u>User Category</u>: <?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else echo "Shop Keeper"; ?></p>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $('input[id$="Delivered"]').click(function () 
                {
                    //alert("Hi");
                    var vartr = $(this).closest('tr');
                    var order_id = vartr.find('input[id$="order_id"]').val();
                   //window.location.href= "Update_Order_Status.php?order_id="+order_id;
                    $.ajax({
                        type: 'POST',
                        url: 'Update_Order_Delivery.php',
                        data: { order_id: order_id},
                        success: function(response) {
                             var result = JSON.parse(response);
                             //alert(result.status);
                             if(result.status === "S")
                             {
                                 alert(result.msg);
                                 vartr.remove();
                             }
                             else
                             {
                                 alert(result.msg);
                            }
                        }
                    });
                });
                $('input[id$="Order_Invoice"]').click(function () 
             
                {
                    //alert("Hi");
                    var vartr = $(this).closest('tr');
                    var order_id = vartr.find('input[id$="order_id"]').val();
                    //alert("Order ID: "+order_id);
                    window.location.href= "View_Order_Invoice.php?order_id="+order_id;

                });
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Order Status</h2>
 

            <table class="table" style="text-align:center;">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Order ID</td>
                    <td>Shop Name</td>
                    <td>Order Date</td>
                    <td>Delivery Option</td>
                    <td>Delivery Time</td>
                    <td>Order Invoice</td>
                    <td>Action</td>
                </tr>
                
                       
                <?php
                require_once "config.php";
                $Service_time = "";
//                define('DB_SERVER', 'localhost');
//                define('DB_USERNAME', 'root');
//                define('DB_PASSWORD', '');
//                define('DB_NAME', 'eshopping');
//
//                /* Attempt to connect to MySQL database */
//                $MyConnection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

                $sql = "SELECT u.*,s.shop_name,s.HD_Service_Time,s.Service_Time FROM user_order u,shop_keeper_registration s where u.USER_ID='$user_id' and u.ORDER_STATUS > 1 and u.ORDER_STATUS !=4 and s.SK_UNIQUE_ID = u.SHOP_ID order by u.ORDER_DATE desc";


                 $result = mysqli_query($MyConnection, $sql);
                 $index = (int)0;
                 if (mysqli_num_rows($result) > 0) 
                     {
                     ?>
                     <?php 
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        $order_date = date('d-m-Y',strtotime($row['ORDER_DATE']));
                        $delivery_time = date('d-m-Y h:i A',strtotime($row['delivery_time']));
                        if ($row['delivery_option'] === 'H')
                        {
                            $Service_time = (int) $row['HD_Service_Time'] *60;
                        }
                        else
                        {
                            $Service_time = (int) $row['Service_Time'] *60;
                        }
                        $delivery_totime = date('h:i A',strtotime($row['delivery_time'])+ $Service_time) ;
                    ?> 
                <tr>
                    <td><?php echo $index ?></td>
                    <td><?php echo $row['ORDER_ID']?>
                    <input type="hidden" id="obj[<?php echo $index?>].order_id" name="obj[<?php echo $index?>].order_id" value="<?php echo $row['ORDER_ID']?>" >
                    
                    </td>
                    <td><?php echo $row['shop_name']?></td>
                    <td><?php echo $order_date?></td>
                   <td><?php if ($row['delivery_option'] === 'H') echo 'Home Delivery'; else echo 'Pick up at Store';?></td>
                    <td><?php echo $delivery_time." - ". $delivery_totime    ?></td>
                    
                    <td><input type="button" id="obj[<?php echo $index?>].Order_Invoice" name="obj[<?php echo $index?>].Order_Invoice" class="btn btn-primary" value="View Invoice" style="background:orangered;border:#b5651d;font-weight:bold;"></td>
                    <td><input type="button" id="obj[<?php echo $index?>].Delivered" name="obj[<?php echo $index?>].Delivered" class="btn btn-primary" value="Order Delivered" style="background:orangered;border:#b5651d;font-weight:bold;"></td>

                </tr>

                     <?php  
                    }
                       
                }
                 mysqli_close($MyConnection);
                ?>
                                
                        
            </table> 
     
        </div>    
    </body>
</html>
