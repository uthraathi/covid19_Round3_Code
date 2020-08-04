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
        <title>List of Registered Hospitals</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">List of Registered Hospitals</h2>
 

            <table class="table">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    
                    <td>Hospital ID</td>
                    <td>Name</td>
                    <td>In-Charge Name</td>
                    <td>Mobile Number</td>
                    <td>Email ID</td>
                    
                    <td>Registration Number</td>
                    <td>Entry Date</td>
                    <td>Address</td>
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
                $total_pages_sql = "SELECT count(*) FROM hospital_registration where PINCODE = '$PINCODE'";
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $sql = "SELECT * FROM hospital_registration where PINCODE = '$PINCODE' order by PINCODE,hospital_name asc LIMIT $offset,$no_of_records_per_page";


                 $result = mysqli_query($MyConnection, $sql);
                 $index = (int)0+(int)$offset;
                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>". $index ."</td>";
                       
                        echo "<td>". $row['UNIQUE_ID'] ."</td>";
                        echo "<td>". $row['hospital_name'] ."</td>";
                        echo "<td>". $row['OWNER_NAME'] ."</td>";
                        echo "<td>". $row['MOBILE_NUMBER'] ."</td>";
                        echo "<td>". $row['EMAIL_ID'] ."</td>";
                        
                        
                        echo "<td>". $row['REG_NUMBER'] ."</td>";
                        echo "<td>". $row['ENTRY_DATE'] ."</td>";
                        echo "<td>". $row['BUILD_NO'] .", ".$row['STREET'].", \n". $row['CITY'].", \n". $row['DISTRICT'].", \n". $row['STATE']." - \n". $row['PINCODE']."</td>";
                        
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
