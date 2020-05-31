<?php
require_once 'IU_Menu.php';
$user_id = $_SESSION['user_id'];
date_default_timezone_set('Asia/Kolkata'); 

$To_date = date('Y-m-d');
$From_Date = date('Y-m-d',strtotime($To_date) - 2592000);

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Previous Order History</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
              
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
            <h2 style="color:#b5651d;">Previous Order History</h2>
<!--                <table style="text-align:center;margin:0 auto;">
                    <tr>
                        <td>From Date: <input type="Date" id="From_Date" name="From_Date" value="<?php echo $From_Date; ?>"></td>
                        <td>To Date: <input type="Date" id="To_Date" name="To_Date" value="<?php echo $To_date; ?>"></td>
                        <td><input type="button" id="Search" name="Search" class="btn btn-primary" value="Search" style="background:orangered;border:#b5651d;font-weight:bold;"></td>

                    </tr>
                </table>-->
            
            <table class="table" style="text-align:center;">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Order ID</td>
                    <td>Customer Name</td>
                    <td>Order Date</td>
                    <td>Delivery Option</td>
                    <td>Delivery Time</td>
                    <td>Order Invoice</td>
                </tr>
                
                       
                <?php
                require_once "config.php";
                $Service_time = "";


                $sql = "SELECT r.user_name,u.*,s.shop_name,s.HD_Service_Time,s.Service_Time FROM user_order u,shop_keeper_registration s,user_registration r where u.SHOP_ID='$user_id' and u.user_id = r.user_id  and u.ORDER_STATUS > 2 and s.SK_UNIQUE_ID = u.SHOP_ID order by u.ORDER_DATE desc";


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
                    <td><?php echo $row['user_name']?></td>
                    <td><?php echo $order_date?></td>
                   <td><?php if ($row['delivery_option'] === 'H') echo 'Home Delivery'; else echo 'Pick up at Store';?></td>
                    <td><?php echo $delivery_time." - ". $delivery_totime    ?></td>
                    
                    <td><input type="button" id="obj[<?php echo $index?>].Order_Invoice" name="obj[<?php echo $index?>].Order_Invoice" class="btn btn-primary" value="View Invoice" style="background:orangered;border:#b5651d;font-weight:bold;"></td>

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
