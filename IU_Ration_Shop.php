<?php
require_once 'IU_Menu.php';
require_once "config.php";

$pincode = $_SESSION['PINCODE'];
$latitude = $_SESSION['Latitude'];
$longitude = $_SESSION['Longitude'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Ration Purchase Online</title>
          <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
         .ui-autocomplete-loading {
    background: white url("img/ui-anim_basic_16x16.gif") right center no-repeat;
  }
        </style>
<!--         <script src="http://code.jquery.com/jquery-1.10.2.js"></script>-->
                <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

        <script type="text/javascript">
            $(function(){
               

                
                $('input[id$="Proceed"]').click(function () 
                //            $('#Proceed').click(function () 
                {
                    //alert("Hi");
                    var vartr = $(this).closest('tr');
                    var shop_id = vartr.find('input[id$="shop_id"]').val();
                    //alert("Shop ID: "+shop_id);
                    window.location.href= "View_RS_Product.php?Shop_ID="+shop_id;
                
                });
//       
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
                <h2 style="color:#b5651d;">Ration Shop - Purchase Online</h2>
                

               
               
            <table class="table">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    
                    <td> Registration Number</td>
                    <td> Incharge Name</td>
                    <td>Mobile Number</td>
                    <td>Email ID</td>
                    <td> Address</td>
                    <td>Action</td>
                    
                    
                </tr>
                
                       
                <?php
               
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 6;
                $offset = ($pageno-1) * $no_of_records_per_page;
               
                $total_pages_sql = "SELECT count(*) FROM ration_shop_register where PINCODE = '$pincode'";
                
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);
                
                
                $sql = "SELECT * FROM ration_shop_register where PINCODE = '$pincode' order by RS_REG_NUM asc LIMIT $offset,$no_of_records_per_page";
                
                $result = mysqli_query($MyConnection, $sql);
                 $index = (int)0+(int)$offset;
                 if (mysqli_num_rows($result) > 0) 
                 {
                     ?>
                     <?php 
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        ?> 
                <tr>
                    <td><?php echo $index ?></td>
                    <td><?php echo $row['RS_REG_NUM']?>
                    <input type="hidden" id="obj[<?php echo $index?>].shop_id" name="obj[<?php echo $index?>].shop_id" value="<?php echo $row['RS_INC_ID']?>" >
                    
                    </td>
                    <td><?php echo $row['RS_INC_NAME']?></td>
                    <td><?php echo $row['mobile_number']?></td>
                    <td><?php echo $row['email_id']?></td>
                    <td><?php echo $row['BUILD_NO'].", ".$row['STREET'].", \n". $row['CITY'].", \n". $row['DISTRICT'].", \n". $row['STATE']." - \n". $row['PINCODE']?></td>
                    <td><input type="button" id="obj[<?php echo $index?>].Proceed" name="obj[<?php echo $index?>].Proceed" class="btn btn-primary" value="Click here to view product" style="background:orangered;border:#b5651d;font-weight:bold;"></td>
                </tr>

                     <?php  
                    }
                       
                }
                  
                            
                 mysqli_close($MyConnection);
                ?>
                 <tr style="text-align:center;">
                    <td colspan="7">
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