<?php
require_once "RS_Menu.php";

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - About Ration Shop</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">About Ration Shop</h2>
 

            <table class="table">
               
                <?php
                require_once "config.php";
                $sql = "SELECT * from ration_shop_register where RS_INC_ID = ".$_SESSION['user_id']."";


                 $result = mysqli_query($MyConnection, $sql);

                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        echo "<tr>";
                        echo "<td>Shop Unique ID</td>";
                        echo "<td>". $row['RS_INC_ID'] ."</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Shop Registration Number</td>";
                        echo "<td>". $row['RS_REG_NUM'] ."</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Shop Incharge Name</td>";
                        echo "<td>". $row['RS_INC_NAME'] ."</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Incharge Employee ID</td>";
                        echo "<td>". $row['EMP_ID'] ."</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Shop Mobile Number</td>";
                        echo "<td>". $row['mobile_number'] ."</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Shop Email ID</td>";
                        echo "<td>". $row['email_id'] ."</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td>Shop Address</td>";
                        echo "<td>". $row['BUILD_NO'] .", ".$row['STREET'].", \n". $row['CITY'].", \n". 
                                $row['DISTRICT'].", \n". $row['STATE']." - \n". $row['PINCODE']."</td>";
                        echo "</tr>";
                    }
                        
                }
                  

                 mysqli_close($MyConnection);
                ?>
                                
                        
            </table> 
     
        </div>    
    </body>
</html>
