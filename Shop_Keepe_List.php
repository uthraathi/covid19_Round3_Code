<?php
require_once 'Go_Menu.php';
//session_start();
//if(!isset($_SESSION['user_id']))
//{
//    header('location:index.php');
//}
$PINCODE=$_SESSION['PINCODE'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Shop Keeper List</title>
<!--        <p style="float: right;font-size:20px;color: orchid;"><u>User Name</u>: <?php echo $_SESSION['User_Name']?><br><u>User Category</u>: <?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else echo "Shop Keeper"; ?></p>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Shop Keeper List</h2>
 

            <table class="table">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Category</td>
                    <td>Shop ID</td>
                    <td>Shop Name</td>
                    <td>Shop Owner Name</td>
                    <td>Mobile Number</td>
                    <td>Email ID</td>
                    <td>Shop GST TIN</td>
                    <td>Registration Number</td>
                    <td>Entry Date</td>
                    <td>Shop Address</td>
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
                $total_pages_sql = "SELECT count(*) FROM shop_keeper_registration where SHOP_PINCODE = '$PINCODE'";
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $sql = "SELECT * FROM shop_keeper_registration where SHOP_PINCODE = '$PINCODE' order by SHOP_PINCODE,SHOP_CATEGORY,shop_name asc LIMIT $offset,$no_of_records_per_page";


                 $result = mysqli_query($MyConnection, $sql);
                 $index = (int)0+(int)$offset;
                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>". $index ."</td>";
                        echo "<td>". $row['SHOP_CATEGORY'] ."</td>";
                        echo "<td>". $row['SK_UNIQUE_ID'] ."</td>";
                        echo "<td>". $row['shop_name'] ."</td>";
                        echo "<td>". $row['SHOP_OWNER_NAME'] ."</td>";
                        echo "<td>". $row['SHOP_MOBILE_NUMBER'] ."</td>";
                        echo "<td>". $row['SHOP_EMAIL_ID'] ."</td>";
                        
                        echo "<td>". $row['SHOP_GST_TIN_NUM'] ."</td>";
                        echo "<td>". $row['SHOP_REG_NUMBER'] ."</td>";
                        echo "<td>". $row['ENTRY_DATE'] ."</td>";
                        echo "<td>". $row['SHOP_BUILD_NO'] .", ".$row['SHOP_STREET'].", \n". $row['SHOP_CITY'].", \n". $row['SHOP_DISTRICT'].", \n". $row['SHOP_STATE']." - \n". $row['SHOP_PINCODE']."</td>";
                        
                        echo "</tr>";
                    }
                        
                }
                  

                 mysqli_close($MyConnection);
                ?>
                 <tr style="text-align:center;">
                    <td colspan="12">
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
