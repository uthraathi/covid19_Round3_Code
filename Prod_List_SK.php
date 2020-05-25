<?php
require_once 'SK_Menu.php';
//session_start();
//if(!isset($_SESSION['user_id']))
//{
//    header('location:index.php');
//}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Product Stock Availability</title>
        <!--<p style="float: right;font-size:20px;color: orchid;"><u>User Name</u>: <?php echo $_SESSION['User_Name']?><br><u>User Category</u>: <?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else echo "Shop Keeper"; ?></p>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Product Stock Availability</h2>
 

            <table class="table">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Category</td>
                    <td>Sub-Category</td>
                    <td>Product ID</td>
                    <td>Name</td>
                    <td>Image</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>Stock Available</td>
                    <td>Entry Date</td>
                   </tr>
                <?php
                require_once "config.php";
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 4;
                $offset = ($pageno-1) * $no_of_records_per_page;
                $total_pages_sql = "SELECT count(*) FROM product_master p, shop_product_list sp where SK_UNIQUE_ID = ".$_SESSION['user_id']." and p.PRODUCT_ID=sp.PRODUCT_ID";
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $sql = "SELECT sp.*,p.PRODUCT_NAME,p.product_Image,p.Prod_Qty,p.Qty_Unit,p.Sub_Category FROM product_master p, shop_product_list sp where SK_UNIQUE_ID = ".$_SESSION['user_id']." and p.PRODUCT_ID=sp.PRODUCT_ID order by sp.PRODUCT_CATEGORY,sp.PRODUCT_ID LIMIT $offset,$no_of_records_per_page";
                $result = mysqli_query($MyConnection, $sql);
                $index = (int)0+(int)$offset;
                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>". $index ."</td>";
                        echo "<td>". $row['PRODUCT_CATEGORY'] ."</td>";
                        echo "<td>". $row['Sub_Category'] ."</td>";
                        echo "<td>". $row['PRODUCT_ID'] ."</td>";
                        echo "<td>". $row['PRODUCT_NAME'] ."</td>";
                        echo "<td><img src='Product_Image/".$row['product_Image']."' height='75' width='75'></td>";
                        echo "<td>". $row['Prod_Qty'] ." ". $row['Qty_Unit'] ."</td>";
                        echo "<td>". $row['PRODUCT_PRICE']."</td>";
                        echo "<td>". $row['QUANTITY_AVAILABLE']."</td>";
                        echo "<td>". $row['ENTRY_DATE'] ."</td>";
                        echo "</tr>";
                    }
                        
                }
                  

                 mysqli_close($MyConnection);
                ?>
                 <tr style="text-align:center;">
                    <td colspan="10">
                    <ul class="pagination">
                        <li><a href="?pageno=1">First</a></li>
                        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                        </li>
                        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                        </li>
                        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                    </ul>
                </td>
                </tr>                  
                        
            </table> 
     
        </div>    
    </body>
</html>
