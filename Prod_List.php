<?php
require_once 'Go_Menu.php';
//session_start();
//if(!isset($_SESSION['user_id']))
//{
//    header('location:index.php');
//}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Product List</title>
<!--        <p style="float:right;font-size:20px;color: orchid;"><u>User Name</u>: <?php echo $_SESSION['User_Name']?><br><u>User Category</u>: <?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else echo "Shop Keeper"; ?></p>-->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        .ui-autocomplete-loading {
    background: white url("img/ui-anim_basic_16x16.gif") right center no-repeat;
  }
        </style>
         <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript">
            $(function(){
                var Search_Key = "<?php if (isset($_GET['Search_Key']) && $_GET['Search_Key'] !== '') echo $_GET['Search_Key']; else echo ''; ?>";
                $('#Search_Key').val(Search_Key);
                $( "#Search_Key" ).autocomplete({
                    source: function( request, response ) {
                  $.ajax({
                    url: "Get_Search_Product.php",
                    dataType: "json",
                    data: {
                      searchkey: request.term
                    },
                    success: function( data ) {
                      response( data );
                    }
                  });
                },
                minLength: 1,
                select: function( event, ui ) {
                      // Do something on select event
                  console.log(ui.item); // ui.item is  responded json from server
                }
              });
              $('#Search').click(function () 
               {
                   var Search_Key = $('#Search_Key').val();
                   
                   //alert(Search_Key);
                   if (Search_Key !== '')
                   {
                       self.location.href = "Prod_List.php?Search_Key="+Search_Key;
                    }
                    else
                    {
                        alert("enter product name");
                        $('#Search_Key').focus();
                    }
                });
            });
        </script>
                
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Product List</h2>
            <table>
                    <tr>
                        <td><input type="text" id="Search_Key" name="Search_Key" placeholder="Enter Product Name" style="width:500px;" class="form-control"></td>
                        <td><input type="button" id="Search" name="Search" class="btn btn-primary" value="Search" style="background:orangered;border:#b5651d;font-weight:bold;"></td>

                    </tr>
                </table>

            <table class="table">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Category</td>
                    <td>Sub-Category</td>
                    <td>Product ID</td>
                    <td>Name</td>
                    <td>Image</td>
                    <td>Quantity</td>
                    <td>Price Range</td>
                    <td>Entry Date</td>
                    <td>Is Essential?</td>
                    <td>Maximum Limit</td>
<!--                <td>Join Family Limit</td>
                    <td>Single Person Limit</td>-->
                    
                </tr>
                
                       
                <?php
                require_once "config.php";
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $search_product = isset($_GET['Search_Key']) ? $_GET['Search_Key'] : "";
                $no_of_records_per_page = 4;
                $offset = ($pageno-1) * $no_of_records_per_page;
                if(isset($_GET['Search_Key']) && $_GET['Search_Key'] !== '') 
                {
                    $total_pages_sql = "SELECT count(*) FROM product_master where product_type = 'G' and PRODUCT_NAME = '$search_product'";

                }
                else
                {
                    $total_pages_sql = "SELECT count(*) FROM product_master where product_type = 'G'";
                }
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);
                if(isset($_GET['Search_Key']) && $_GET['Search_Key'] !== '') 
                {
                    $sql = "SELECT * FROM product_master where product_type = 'G'  and PRODUCT_NAME = '$search_product' order by CATEGORY,Sub_Category,PRODUCT_NAME asc LIMIT $offset,$no_of_records_per_page";

                }
                else
                {
                    $sql = "SELECT * FROM product_master where product_type = 'G'  order by CATEGORY,Sub_Category,PRODUCT_NAME asc LIMIT $offset,$no_of_records_per_page";

                }
                
                $result = mysqli_query($MyConnection, $sql);
                $index = (int)0+(int)$offset;
                
                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>". $index ."</td>";
                        echo "<td>". $row['CATEGORY'] ."</td>";
                        echo "<td>". $row['Sub_Category'] ."</td>";
                        echo "<td>". $row['PRODUCT_ID'] ."</td>";
                        echo "<td>". $row['PRODUCT_NAME'] ."</td>";
                        echo "<td><img src='Product_Image/".$row['product_Image']."' height='75' width='75'></td>";
                        echo "<td>". $row['Prod_Qty'] ." ". $row['Qty_Unit'] ."</td>";
                        echo "<td>". $row['PRICE_RANGE_FROM'] ." - ".$row['PRICE_RANGE_TO']."</td>";
                        echo "<td>". $row['ENTRY_DATE'] ."</td>";
                        if ($row['IS_ESSENTIAL_PRODUCT'] === 'Y')
                        {
                            //echo "<td>Yes</td><td>". $row['MAXIMUM_LIMIT_NF'] ."</td><td>". $row['MAXIMUM_LIMIT_JF'] ."</td><td>". $row['MAXIMUM_LIMIT_SP'] ."</td>";
                            echo "<td>Yes</td><td><b>Nuclear Family:</b> ". $row['MAXIMUM_LIMIT_NF'] ."<br/> <b>Join Family:</b> ". $row['MAXIMUM_LIMIT_JF'] ."<br/> <b>Single Person:</b> ". $row['MAXIMUM_LIMIT_SP'] ."</td>";
                        }
                        else
                        {
                            //echo "<td>No</td><td></td><td></td><td></td>";
                            echo "<td>No</td><td></td>";
                        }
                        
                    }
                        echo "</tr>";
                }
                  

                 mysqli_close($MyConnection);
                ?>
                <tr style="text-align:center;">
                    <td colspan="11">
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
