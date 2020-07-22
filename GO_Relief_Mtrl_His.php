<?php
require_once 'GO_Menu.php';

$STATE_CODE = $_SESSION['STATE_CODE'];
$USER_ID = $_SESSION['user_id'];
$PINCODE = $_SESSION['PINCODE'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Received Relief Material</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Received Relief Material</h2>
 

            <table class="table">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td> ID</td>
                    <td> Name</td>
                    <td> Mobile</td>
                    <td> Email</td>
                    <td>Product Description with Quantity</td>
                    <td>Delivery Option</td>
                    <td>Shipment Tracking Number/ Address</td>
                    <td>Expected Date of Delivery</td>
                </tr>
                <?php
                require_once "config.php";
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 5;
                $offset = ($pageno-1) * $no_of_records_per_page;
                $total_pages_sql = "SELECT count(*) FROM relief_material_registration r, user_registration u where u.user_id = r.user_id and u.PINCODE = '$PINCODE' ORDER BY r.Exp_Date desc";
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $sql = "SELECT r.* from relief_material_registration r, user_registration u where u.user_id = r.user_id and u.PINCODE = '$PINCODE' ORDER BY r.Exp_Date desc LIMIT $offset,$no_of_records_per_page";


                 $result = mysqli_query($MyConnection, $sql);
                 $index = (int)0+(int)$offset;
                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>". $index ."</td>";
                        echo "<td>". $row['user_id'] ."</td>";
                        echo "<td>". $row['Name'] ."</td>";
                        echo "<td>". $row['Mobile'] ."</td>";
                        echo "<td>". $row['email'] ."</td>";
                        echo "<td>". $row['product_description'] ."</td>";
                        if($row['delivery_option']==='O')
                        {
                            echo "<td>Online Delivery</td>"; 
                        }
                        else if($row['delivery_option']==='P')
                        {
                           echo "<td>Parcel Delivery</td>";  
                        }
                        else
                        {
                           echo "<td>Pick-up at Address</td>"; 
                        }
                        
                        echo "<td>". $row['track_address'] ."</td>";
                        echo "<td>". $row['Exp_Date']."</td>";

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
