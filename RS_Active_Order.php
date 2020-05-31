<?php
require_once 'RS_Menu.php';

$user_id = $_SESSION['user_id'];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Active Ration Order List</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
                
                $('input[id$="Dispatch"]').click(function () 
                {
                    //alert("Hi");
                    var vartr = $(this).closest('tr');
                    var order_id = vartr.find('input[id$="order_id"]').val();
                   //window.location.href= "Update_Order_Status.php?order_id="+order_id;
                    $.ajax({
                        type: 'POST',
                        url: 'Update_RS_Order_Status.php',
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
                    window.location.href= "View_RS_Order_Invoice.php?order_id="+order_id;

                });
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            
           
            <h2 style="color:#b5651d;">Ration Shop - Active Order List</h2>
 

            <table class="table" style="text-align:center;">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Order ID</td>
                    <td>Customer Name</td>
                    <td>Order Date</td>
                    <td>Delivery Option</td>
                    <td>Delivery Time</td>
                    <td>Order Invoice</td>
                    <td>Action</td>
                </tr>
                
                       
                <?php
                require_once "config.php";


                $sql = "SELECT u.*,s.RS_INC_NAME,r.user_name,s.HD_Service_Time,s.Service_Time FROM user_registration r, ration_shop_order u,ration_shop_register s where u.SHOP_ID = '$user_id' and  r.user_id = u.user_id and u.ORDER_STATUS = 2 and s.RS_INC_ID = u.SHOP_ID order by u.ORDER_DATE desc";


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
                    <td><?php echo $delivery_time." - ". $delivery_totime?></td>
                    
                    <td><input type="button" id="obj[<?php echo $index?>].Order_Invoice" name="obj[<?php echo $index?>].Order_Invoice" class="btn btn-primary" value="View Invoice" style="background:orangered;border:#b5651d;font-weight:bold;"></td>
                    <td><input type="button" id="obj[<?php echo $index?>].Dispatch" name="obj[<?php echo $index?>].Dispatch" class="btn btn-primary" value="Order Dispatched" style="background:orangered;border:#b5651d;font-weight:bold;"></td>

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
