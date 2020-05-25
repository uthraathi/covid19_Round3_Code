<?php
require_once 'IU_Menu.php';
require_once "config.php";
//session_start();
//if(!isset($_SESSION['user_id']))
//{
//    header('location:index.php');
//}
$pincode = $_SESSION['PINCODE'];
$latitude = $_SESSION['Latitude'];
$longitude = $_SESSION['Longitude'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Shop by Category</title>
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
               

                var set_deliv_opt = "<?php if (isset($_GET['Deliv_Option']) && $_GET['Deliv_Option'] === 'H') echo 'H'; else echo 'S';?>";
                $('#Deliv_Option').val(set_deliv_opt);
                var Search_Key = "<?php if (isset($_GET['Search_Key']) && $_GET['Search_Key'] !== '') echo $_GET['Search_Key']; else echo ''; ?>";
                $('#Search_Key').val(Search_Key);
                var Distance_Search = "<?php if (isset($_GET['Distance_Search']) && $_GET['Distance_Search'] !== '') echo $_GET['Distance_Search']; else echo '1'; ?>";
                $('#Distance_Search').val(Distance_Search);
                $('#Distance_Search').change(function () 
               
                {
                    var Search_Key = $('#Search_Key').val();
                    var Deliv_Option = $('#Deliv_Option').val();
                    var Distance_Search = $('#Distance_Search').val();
                    self.location.href = "IU_Shop_by_Category.php?Deliv_Option="+Deliv_Option+"&Search_Key="+Search_Key+"&Distance_Search="+Distance_Search;
                });
                $('#Deliv_Option').change(function () 
               
                {
                    var Search_Key = $('#Search_Key').val();
                    var Deliv_Option = $('#Deliv_Option').val();
                    self.location.href = "IU_Shop_by_Category.php?Deliv_Option="+Deliv_Option+"&Search_Key="+Search_Key;
                });
                $('#Search').click(function () 
               {
                   var Search_Key = $('#Search_Key').val();
                   var Deliv_Option = $('#Deliv_Option').val();
                   //alert(Search_Key);
                   if (Search_Key !== '')
                   {
                       self.location.href = "IU_Shop_by_Category.php?Deliv_Option="+Deliv_Option+"&Search_Key="+Search_Key;
                    }
                    else
                    {
                        alert("enter product name");
                        $('#Search_Key').focus();
                    }
                });
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
                
                $('input[id$="Proceed"]').click(function () 
                //            $('#Proceed').click(function () 
                {
                    //alert("Hi");
                    var vartr = $(this).closest('tr');
                    var shop_id = vartr.find('input[id$="shop_id"]').val();
                    //alert("Shop ID: "+shop_id);
                    window.location.href= "View_Shop_Product.php?Shop_ID="+shop_id;
                    //window.location.href= "View_Shop_Product.php";
                });
//       
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
                <h2 style="color:#b5651d;">Shop by Category</h2>
                <table>
                    <tr>
                        <td><input type="text" id="Search_Key" name="Search_Key" placeholder="Enter Product Name" style="width:500px;" class="form-control"></td>
                        <td><input type="button" id="Search" name="Search" class="btn btn-primary" value="Search" style="background:orangered;border:#b5651d;font-weight:bold;"></td>

                        <td>
                            <label style="color: black;font-size:15px;">Filter by Delivery Option:  </label>
                            <select id="Deliv_Option" name="Deliv_Option" >
                                <option value="S" selected="selected">Pick up at Store</option> 
                                <option value="H">Home Delivery</option>
                            </select>
                            
                        </td>
                        <td><label>Search  Shop by Distance: </label><input type="number" id="Distance_Search" name="Distance_Search" style="width:50px;" min="1" max="10" value="1"> <label>Kilometer</label></td>

                    </tr>
                </table>

               
               
            <table class="table">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Category</td>
                    <td>Shop Name</td>
                    <td>Mobile Number</td>
                    <td>Email ID</td>
                    <td>Shop Address</td>
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
                $search_product = isset($_GET['Search_Key']) ? $_GET['Search_Key'] : "";
                $Distance_Search = isset($_GET['Distance_Search']) ? $_GET['Distance_Search'] : "";
                if(isset($_GET['Distance_Search']) && $_GET['Distance_Search'] !== '') 
                {
                    $total_pages_sql = "SELECT count(*) FROM pincode_master p,shop_keeper_registration s where ( 6371 * acos( cos( radians('$latitude') ) * cos( radians( p.Latitude) ) * cos( radians( p.Longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin(radians(p.Latitude)) ) ) < '$Distance_Search' and p.pincode = s.SHOP_PINCODE  order by s.SHOP_CATEGORY,s.shop_name asc";
                }
                else if(isset($_GET['Search_Key']) && $_GET['Search_Key'] !== '' && isset($_GET['Deliv_Option']) && $_GET['Deliv_Option'] === 'H') 
                {
                    $total_pages_sql = "select count(*) from shop_keeper_registration s, shop_product_list p, product_master m where s.SHOP_PINCODE = '$pincode' and s.IS_HD_AVAILABLE = 'Y' and s.SK_UNIQUE_ID = p.SK_UNIQUE_ID and p.PRODUCT_ID = m.PRODUCT_ID and m.PRODUCT_NAME = '$search_product'  order by SHOP_CATEGORY,shop_name asc";
                }
                else if(isset($_GET['Search_Key'])&& $_GET['Search_Key'] !== '') 
                {
                    $total_pages_sql = "select count(*) from shop_keeper_registration s, shop_product_list p, product_master m where s.SHOP_PINCODE = '$pincode' and s.SK_UNIQUE_ID = p.SK_UNIQUE_ID and p.PRODUCT_ID = m.PRODUCT_ID and m.PRODUCT_NAME = '$search_product'  order by SHOP_CATEGORY,shop_name asc";
                }
                else if(isset($_GET['Deliv_Option']) && $_GET['Deliv_Option'] === 'H') 
                {
                    $total_pages_sql = "SELECT count(*) FROM shop_keeper_registration where SHOP_PINCODE = '$pincode' and IS_HD_AVAILABLE = 'Y'";
                }
                else
                {
                    $total_pages_sql = "SELECT count(*) FROM shop_keeper_registration where SHOP_PINCODE = '$pincode'";
                }
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);
                
                if(isset($_GET['Distance_Search']) && $_GET['Distance_Search'] !== '') 
                {
                    $sql = "SELECT s.* FROM pincode_master p,shop_keeper_registration s where ( 6371 * acos( cos( radians('$latitude') ) * cos( radians( p.Latitude) ) * cos( radians( p.Longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin(radians(p.Latitude)) ) ) < '$Distance_Search' and p.pincode = s.SHOP_PINCODE  order by s.SHOP_CATEGORY,s.shop_name asc LIMIT $offset,$no_of_records_per_page";
                }
                else if(isset($_GET['Search_Key']) && $_GET['Search_Key'] !== '' && isset($_GET['Deliv_Option']) && $_GET['Deliv_Option'] === 'H') 
                {
                    $sql = "select s.* from shop_keeper_registration s, shop_product_list p, product_master m where s.SHOP_PINCODE = '$pincode' and s.IS_HD_AVAILABLE = 'Y' and s.SK_UNIQUE_ID = p.SK_UNIQUE_ID and p.PRODUCT_ID = m.PRODUCT_ID and m.PRODUCT_NAME = '$search_product'  order by SHOP_CATEGORY,shop_name asc LIMIT $offset,$no_of_records_per_page";
                }
                else if(isset($_GET['Search_Key']) && $_GET['Search_Key'] !== '') 
                {
                    $sql = "select s.* from shop_keeper_registration s, shop_product_list p, product_master m where s.SHOP_PINCODE = '$pincode' and s.SK_UNIQUE_ID = p.SK_UNIQUE_ID and p.PRODUCT_ID = m.PRODUCT_ID and m.PRODUCT_NAME = '$search_product'  order by SHOP_CATEGORY,shop_name asc LIMIT $offset,$no_of_records_per_page";
                }
                else if(isset($_GET['Deliv_Option']) && $_GET['Deliv_Option'] === 'H') 
                {
                    $sql = "SELECT * FROM shop_keeper_registration where SHOP_PINCODE = '$pincode' and IS_HD_AVAILABLE = 'Y' order by SHOP_CATEGORY,shop_name asc LIMIT $offset,$no_of_records_per_page";
                }
                else
                {
                    $sql = "SELECT * FROM shop_keeper_registration where SHOP_PINCODE = '$pincode' order by SHOP_CATEGORY,shop_name asc LIMIT $offset,$no_of_records_per_page";
                }
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
                    <td><?php echo $row['SHOP_CATEGORY']?>
                    <input type="hidden" id="obj[<?php echo $index?>].shop_id" name="obj[<?php echo $index?>].shop_id" value="<?php echo $row['SK_UNIQUE_ID']?>" >
                    
                    </td>
                    <td><?php echo $row['shop_name']?></td>
                    <td><?php echo $row['SHOP_MOBILE_NUMBER']?></td>
                    <td><?php echo $row['SHOP_EMAIL_ID']?></td>
                    <td><?php echo $row['SHOP_BUILD_NO'].", ".$row['SHOP_STREET'].", \n". $row['SHOP_CITY'].", \n". $row['SHOP_DISTRICT'].", \n". $row['SHOP_STATE']." - \n". $row['SHOP_PINCODE']?></td>
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