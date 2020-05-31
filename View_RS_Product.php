<?php
require_once "config.php";
require_once 'IU_Menu.php';
//session_start();
//if(!isset($_SESSION['user_id']))
//{
//    header('location:index.php');
//}
$SHOP_ID = (int)$_GET['Shop_ID'];
$user_id = $_SESSION['user_id'];
$db_SHOP_ID = "";
$db_order_id="";
$order_id="";
$status=$msg="";
//echo $Mobile ;
//define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'eshopping');
///* Attempt to connect to MySQL database */
//$MyConnection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$sql_O = "SELECT * FROM ration_shop_order WHERE USER_ID = '$user_id' and ORDER_STATUS= 1";
$result_O = mysqli_query($MyConnection, $sql_O);

 if (mysqli_num_rows($result_O) === 1) 
 {
     $row_O = mysqli_fetch_assoc($result_O);
     $db_SHOP_ID = (int)$row_O["SHOP_ID"];
     $db_order_id= (int)$row_O["ORDER_ID"];
     
      $sql_u = "update ration_shop_order set SHOP_ID = "
                
                . "'$SHOP_ID' where USER_ID = $user_id and ORDER_STATUS= 1";
        $result_u = mysqli_query($MyConnection, $sql_u);
        if($result_u && $db_SHOP_ID!== '' && $db_SHOP_ID !== $SHOP_ID)
        {
            $sql_d = "delete from ration_ordered_product_list where "
                
                . "ORDER_ID  = $db_order_id ";
            $result_d = mysqli_query($MyConnection, $sql_d);
        }
}
 else 
 {
       $sql_i = "INSERT INTO ration_shop_order(USER_ID, SHOP_ID) "
                
                . "values ('$user_id','$SHOP_ID')";
       $result_i = mysqli_query($MyConnection, $sql_i);
        
  } 
  $sql_s = "SELECT * FROM ration_shop_order WHERE USER_ID = '$user_id' and ORDER_STATUS= 1";
  $result_s = mysqli_query($MyConnection, $sql_s);

 if (mysqli_num_rows($result_s) === 1) 
 {
     $row_s = mysqli_fetch_assoc($result_s);
   
     $order_id= (int)$row_s["ORDER_ID"];
}
 // get ration card type
$sql_card = "SELECT * FROM user_registration WHERE USER_ID = '$user_id'";
  $result_card = mysqli_query($MyConnection, $sql_card);

 if (mysqli_num_rows($result_card) === 1) 
 {
     $row_card = mysqli_fetch_assoc($result_card);
   
     $Ration_Card_Type= $row_card["Ration_Card_Type"];
     $_SESSION['rationcard'] = $row_card["rationcard"];
     $_SESSION['Ration_Card_Type'] = $row_card["Ration_Card_Type"];
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Ration Shop - Product List</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width:auto; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $('#Back').click(function() {
              window.location.href="IU_Ration_Shop.php";
              });
                $('input[id$="Cart"]').click(function () 
                //            $('#Proceed').click(function () 
                {
                    //alert("Hi");
                    var vartr = $(this).closest('tr');
                    var product_id = vartr.find('input[id$="product_id"]').val();
                    var quantity = vartr.find('select[id$="quantity"]').val();
                    var limit = vartr.find('input[id$="limit"]').val();
                    var price = vartr.find('input[id$="price"]').val();
                    var order_id = "<?php echo $order_id ?>";
                    var SHOP_ID = "<?php echo $SHOP_ID ?>";
                    //alert( " product_id: "+quantity);
//                    alert("Shop ID: "+SHOP_ID + " product_id: "+product_id+ " order_id: " +order_id);
                    //windows.location.href= "View_Shop_Product.php?Shop_ID="+shop_id;
                    if(quantity !== "0")
                    {
                    $.ajax({
                        type: 'POST',
                        url: 'Post_RS_cart.php',
                        data: { product_id: product_id, order_id: order_id ,SHOP_ID: SHOP_ID,quantity:quantity,limit:
                                limit,price:price},
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
                }
                else
                {alert("select quantity");}
                });

                $('#Proceed_Checkout').click(function () 
                {
//                alert("hi");
                var order_id = "<?php echo $order_id ?>";
               window.location.href= "View_RS_Order_Checkout.php?order_id="+order_id;
                });
            });
        </script>
    </head>
    <body>
<!--        <input type="submit" class="btn btn-primary" id="Back" name="Back" value="Go Back" style="background:orangered;border:orangered;font-weight:bold;">-->
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Ration Shop - Product List (Order ID: <?php echo $order_id ?>)</h2>
            
               <h4 style="color:#b5651d;">User Ration Card Type: <?php echo $Ration_Card_Type ?></h4> 
            
            <table class="table" style="border-spacing: 5px;border-collapse: separate;text-align:center;">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
<!--                    <td>Order ID</td>-->
                    <td style="width:30%;">Product Name</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Action</td>
                    
                </tr>
                
                       
                <?php
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 4;
                $offset = ($pageno-1) * $no_of_records_per_page;
                if ($Ration_Card_Type === 'NPHH' )
                {
                   $total_pages_sql = "SELECT count(*) FROM ration_product_master p, ration_shop_product_list sp where sp.RS_UNIQUE_ID  = ".$SHOP_ID." and p.PRODUCT_ID=sp.PRODUCT_ID and sp.QUANTITY_AVAILABLE > 0 and p.nphh_limit > 0 order by sp.PRODUCT_ID";
                }
                else if ($Ration_Card_Type === 'PHH' )
                {
                    $total_pages_sql = "SELECT count(*) FROM ration_product_master p, ration_shop_product_list sp where sp.RS_UNIQUE_ID  = ".$SHOP_ID." and p.PRODUCT_ID=sp.PRODUCT_ID and sp.QUANTITY_AVAILABLE > 0 and p.phh_limit > 0 order by sp.PRODUCT_ID";

                }
                else
                {
                   $total_pages_sql = "SELECT count(*) FROM ration_product_master p, ration_shop_product_list sp where sp.RS_UNIQUE_ID  = ".$SHOP_ID." and p.PRODUCT_ID=sp.PRODUCT_ID and sp.QUANTITY_AVAILABLE > 0 and p.aap_limit > 0 order by sp.PRODUCT_ID";

                }
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);
                if ($Ration_Card_Type === 'NPHH' )
                {
                   $sql_P = "SELECT sp.*,p.PRODUCT_NAME,p.nphh_Price as PRODUCT_PRICE,p.nphh_limit as p_limit FROM ration_product_master p, ration_shop_product_list sp where sp.RS_UNIQUE_ID   = ".$SHOP_ID." and p.PRODUCT_ID=sp.PRODUCT_ID and sp.QUANTITY_AVAILABLE > 0 and p.nphh_limit > 0 order by sp.PRODUCT_ID LIMIT $offset,$no_of_records_per_page";
                }
                else if ($Ration_Card_Type === 'PHH' )
                {
                    $sql_P = "SELECT sp.*,p.PRODUCT_NAME,p.phh_Price as PRODUCT_PRICE,p.phh_limit as p_limit FROM ration_product_master p, ration_shop_product_list sp where sp.RS_UNIQUE_ID   = ".$SHOP_ID." and p.PRODUCT_ID=sp.PRODUCT_ID and sp.QUANTITY_AVAILABLE > 0 and p.phh_limit > 0 order by sp.PRODUCT_ID LIMIT $offset,$no_of_records_per_page";

                }
                else
                {
                   $sql_P = "SELECT sp.*,p.PRODUCT_NAME,p.aap_Price as PRODUCT_PRICE,p.aap_limit as p_limit FROM ration_product_master p, ration_shop_product_list sp where sp.RS_UNIQUE_ID   = ".$SHOP_ID." and p.PRODUCT_ID=sp.PRODUCT_ID and sp.QUANTITY_AVAILABLE > 0 and p.aap_limit > 0 order by sp.PRODUCT_ID LIMIT $offset,$no_of_records_per_page";

                }
                $result_P = mysqli_query($MyConnection, $sql_P);
                 $index1 = (int)0+(int)$offset;
                 if (mysqli_num_rows($result_P) > 0) 
                 {
                     ?>
                     <?php 
                    while($row_P = mysqli_fetch_assoc($result_P)) 
                    {
                        $index1++;
                        ?> 
                <tr>
                    <td><?php echo $index1 ?>
                     <input type="hidden" id="obj[<?php echo $index1?>].product_id" name="obj[<?php echo $index1?>].product_id" value="<?php echo $row_P['PRODUCT_ID']?>" >
                     <input type="hidden" id="obj[<?php echo $index1?>].limit" name="obj[<?php echo $index1?>].limit" value="<?php echo $row_P['p_limit']?>" >
                     <input type="hidden" id="obj[<?php echo $index1?>].price" name="obj[<?php echo $index1?>].price" value="<?php echo $row_P['PRODUCT_PRICE']?>" >

                    </td>

                    <td style="text-align:left;"><?php echo $row_P['PRODUCT_NAME']?></td>
                    <td><?php echo $row_P['PRODUCT_PRICE']?></td>
                    <td>
                        <select id="obj[<?php echo $index1?>].quantity" name="obj[<?php echo $index1?>].quantity">
                            <?php
                            for($i=0; $i<=$row_P['QUANTITY_AVAILABLE']; $i++){
                                echo "<option value='".$i."'>" . $i . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="button" id="obj[<?php echo $index1?>].Cart" name="obj[<?php echo $index1?>].Cart" class="btn btn-primary" value="Add to Cart" style="background:orangered;border:orangered;font-weight:bold;"></td>
                </tr>

                     <?php  
                    }
                       
                }
                  
                            
                 mysqli_close($MyConnection);
                ?>
                  <tr style="text-align:center;">
                    <td colspan="6">
                        <input type="submit" class="btn btn-primary" id="Back" name="Back" value="Go Back" style="background:orangered;border:orangered;font-weight:bold;float:left;">
                    <ul class="pagination">
                        
                        <li><a href="<?php echo "?Shop_ID=".$SHOP_ID."&pageno=1"; ?>">First</a></li>
                        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno <= 1){ echo "?Shop_ID=".$SHOP_ID; } else { echo "?Shop_ID=".$SHOP_ID."&pageno=".($pageno - 1); } ?>">Prev</a>
                        </li>
                        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno >= $total_pages){ echo "?Shop_ID=".$SHOP_ID; } else { echo "?Shop_ID=".$SHOP_ID."&pageno=".($pageno + 1); } ?>">Next</a>
                        </li>
                        <li><a href="<?php echo "?Shop_ID=".$SHOP_ID."&pageno=".$total_pages; ?>">Last</a></li>
                    </ul>
<!--                </td>
                <td>-->
                     <input type="button" id="Proceed_Checkout" name="Proceed_Checkout" class="btn btn-primary" value="Proceed to Checkout" style="background:green;border:green;float:right;font-weight:bold;">
                </td>
                </tr>               
<!--                <tr>
                    <td colspan="6">
                        <input type="button" id="Proceed_Checkout" name="Proceed_Checkout" class="btn btn-primary" value="Proceed to Checkout" style="background:green;border:green;float:right;font-weight:bold;">
                    </td>
                </tr>        -->
            </table> 
<!--            <div><input type="button" id="Proceed_Checkout" name="Proceed_Checkout" class="btn btn-primary" value="Proceed to Checkout" style="background:green;border:green;float:right;"></div>-->
        </div>    
    </body>
    
</html>