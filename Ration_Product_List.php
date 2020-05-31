<?php
require_once 'GO_Menu.php';
$STATE_CODE = $_SESSION['STATE_CODE'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Ration Shop Product List</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Ration Shop Product List</h2>
 

            <table class="table">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Product ID</td>
                    <td>Name</td>
                    <td>AAP Card Limit</td>
                    <td>PHH Card Limit</td>
                    <td>NPHH Card Limit</td>
                    <td>Entry Date</td>
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
                $total_pages_sql = "SELECT count(*) FROM ration_product_master  where state_code = '$STATE_CODE'";
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $sql = "SELECT * FROM ration_product_master  where state_code = '$STATE_CODE' order by PRODUCT_NAME asc LIMIT $offset,$no_of_records_per_page";


                 $result = mysqli_query($MyConnection, $sql);
                 $index = (int)0+(int)$offset;
                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>". $index ."</td>";
                        echo "<td>". $row['PRODUCT_ID'] ."</td>";
                        echo "<td>". $row['PRODUCT_NAME'] ."</td>";
                        echo "<td>". $row['aap_limit'] ." Kg/ Litre";
                        if ($row['aap_fm_type'] === 'F')
                        {
                            echo " (per Family) "."<br>"." <b>Price:</b> Rs. ".$row['aap_Price'];
                        }
                        else 
                        {
                            echo " (per Member) "."<br>"." <b>Price:</b> Rs. ".$row['aap_Price'];
                        }
                        echo "</td>";
                        
                        echo "<td>". $row['phh_limit'] ." Kg/ Litre";
                        if ($row['phh_fm_type'] === 'F')
                        {
                            echo " (per Family)"."<br>"." <b>Price:</b> Rs. ".$row['phh_Price'];
                        }
                        else 
                        {
                            echo " (per Member) "."<br>"." <b>Price:</b> Rs. ".$row['phh_Price'];
                        }
                        echo "</td>";
                        
                        echo "<td>". $row['nphh_limit'] ." Kg/ Litre";
                        if ($row['nphh_fm_type'] === 'F')
                        {
                            echo " (per Family) "."<br>"." <b>Price:</b> Rs. ".$row['nphh_Price'];
                        }
                        else 
                        {
                            echo " (per Member) "."<br>"." <b>Price:</b> Rs. ".$row['nphh_Price'];
                        }
                        echo "</td>";
                       
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
