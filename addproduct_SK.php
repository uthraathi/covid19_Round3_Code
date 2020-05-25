<?php
require_once 'SK_Menu.php';
require_once "config.php";
//session_start();
//if(!isset($_SESSION['user_id']))
//{
//    header('location:index.php');
//}
$user_id = $_SESSION['user_id'];
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Product Add</title>
        <!--<p style="float: right;font-size:20px;color: orchid;"><u>User Name</u>: <?php echo $_SESSION['User_Name']?><br><u>User Category</u>: <?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else echo "Shop Keeper"; ?></p>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 700px; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

            <script type="text/javascript">
            $(function()
            {
               
//               $('#Prod_Cat').change(function(){
//                   var Prod_Cat = $('#Prod_Cat').val();
//                    if(Prod_Cat !== "Select")
//                    {   
//                        $.ajax
//                        ({          
//                            type: "GET",
//                            url: "get_SK_prodname.php",
//                            data:'Prod_Cat='+Prod_Cat,
//                            success: function(data)
//                            {
//                                $("#prod_list").empty();
//                                $("#prod_list").append(data);
//                            }
//                        });
//                    }
//                    else
//                    {
//                        alert("Select Product Category");
//                        $('#Prod_Cat').focus();
//                        $("#prod_list").empty();
//                    }
//               });
                $(document).on('change', '#Prod_Sub_Category', function(){
                   var Prod_Sub_Category = $('#Prod_Sub_Category').val();
                    if(Prod_Sub_Category !== "Select")
                    {   
                        $.ajax
                        ({          
                            type: "GET",
                            url: "get_SK_prodname.php",
                            data:{Prod_SubCat:Prod_Sub_Category},
                            success: function(data)
                            {
                                $("#prod_list").empty();
                                $("#prod_list").append(data);
                            }
                        });
                    }
                    else
                    {
                        alert("Select Product Sub-Category");
                        $('#Prod_Cat').focus();
                        $("#prod_list").empty();
                        $("#Price_List").empty();
                    }
               });
               $(document).on('change', '#Prod_Name', function(){
                   var Prod_ID = $('#Prod_Name').val();
                    if(Prod_ID !== "Select")
                    {   
                        $.ajax
                        ({          
                            type: "GET",
                            url: "get_SK_Prod_Price.php",
                            data:'Prod_ID='+Prod_ID,
                            success: function(data)
                            {
                                $("#Price_List").empty();
                                $("#Price_List").append(data);
                            }
                        });
                    }
                    else
                    {
                        alert("Select Product Name");
                        $('#Prod_Name').focus();
                        $("#Price_List").empty();
                    }
               });
               
                $("#QUANTITY_AVAILABLE").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                   //display error message
                   $('#Qty_err').empty();
                   $("#Qty_err").append('<span style="color:red;">enter digit only</span>');
                          return false;
               }
               else
               {$('#Qty_err').empty();}
              });
              
           
               $('#SK_Product_Add').click(function() {
                var Category  = $.trim($('#Prod_Cat').val());
                var Sub_Category  = $.trim($('#Prod_Sub_Category').val());
                var Name = $.trim($('#Prod_Name').val());
                var Price = $.trim($('#Prod_Price').val());
                var Quantity = $.trim($('#QUANTITY_AVAILABLE').val());
                
                if(Sub_Category === 'Select')
                    {
                        $('#SubCat_err').empty();
                        $('#SubCat_err').append('<span style="color:red;">Select Product Sub-Category</span>');
                    }
                    else
                    {
                        $('#SubCat_err').empty();
                       
                        if(Name === 'Select')
                        {
                            $('#name_err').empty();
                            $('#name_err').append('<span style="color:red;">Seelct Product Name</span>');
                        }
                       
                        else
                        {
                            $('#name_err').empty();
                          
                            if(Price === 'Select')
                            {
                                $('#Price_err').empty();
                                $('#Price_err').append('<span style="color:red;">Select Product Price</span>');
                            }
                            else
                            {
                                $('#Price_err').empty();
                                if(Quantity === '')
                                {
                                    $('#Qty_err').empty();
                                    $('#Qty_err').append('<span style="color:red;">Enter Quantity</span>');
                                }
                               else
                                {
                                    $('#Qty_err').empty();
                                    
                                    $.ajax
                                    ({
                                       type: 'POST',
                                       url: 'post_SK_product_add.php',
                                       data: { Category: Category,Sub_Category:Sub_Category,
                                           ID: Name ,Price: Price,Quantity:Quantity},
                                       success: function(response) {
                                            var result = JSON.parse(response);
                                            //alert(result.status);
                                            if(result.status === "S")
                                            {
                                                alert(result.msg);
                                                window.location.href="addproduct_SK.php";
                                            }
                                            else
                                            {
                                                alert(result.msg);
                                           }
                                       }
                                      });

   
 
                                    }
                                }
                            }
                        }
                    });
               });
            </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
         <h2 style="color:#b5651d;">Product Add</h2>
         
 <p><span class="error">* required field</span></p>
	
            <table class="table">
                        <tr>
                            <td>Product Category<span class="error"> * </span></td>
                            <td style="width:65%;">
                                <select id="Prod_Cat" name="Prod_Cat">
<!--                                    <option value="Select" selected="selected" >Select</option>-->
                                    <?php
                                    //require_once "config.php";

                                    $sql = "SELECT SHOP_CATEGORY FROM shop_keeper_registration where SK_UNIQUE_ID = '$user_id'";
                                    $result = mysqli_query($MyConnection, $sql);

                                     if (mysqli_num_rows($result) > 0) 
                                     {
                                        while($row = mysqli_fetch_assoc($result)) 
                                        {
                                            echo "<option value='".$row['SHOP_CATEGORY']."'>" . $row['SHOP_CATEGORY'] . "</option>";
                                        }
                                     } 
                                     
                                     //mysqli_close($MyConnection);
                                    ?>
                                </select>

                            </td>
                            <td id="cat_err"></td>
                        </tr>
                        <tr>
                            <td>Product Sub Category<span class="error"> * </span></td>
                            <td>
                             <select id="Prod_Sub_Category" name="Prod_Sub_Category">
                                    <option value="Select" selected="selected" >Select</option>
                                    <?php
                                    //require_once "config.php";
                                    $sql_sub = "SELECT p.Sub_Category FROM shop_keeper_registration s , product_category_master p where p.category_name = s.SHOP_CATEGORY and s.SK_UNIQUE_ID = '$user_id'";
                                    $result_Sub = mysqli_query($MyConnection, $sql_sub);

                                     if (mysqli_num_rows($result_Sub) > 0) 
                                     {
                                        while($row_Sub = mysqli_fetch_assoc($result_Sub)) 
                                        {
                                            echo "<option value='".$row_Sub['Sub_Category']."'>" . $row_Sub['Sub_Category'] . "</option>";
                                        }
                                     } 
                                     
                                     mysqli_close($MyConnection);
                                    ?>
                                </select>
                            </td>
                            
                            <td id="SubCat_err"></td>
                        </tr>
                        <tr>
                            <td>Product Name<span class="error"> * </span></td>
                            <td id="prod_list">
                                
                            </td>
                            
                            <td id="name_err"></td>
                        </tr>
                        <tr>
                            <td>Product Price <span class="error"> * </span></td>
                            <td id="Price_List">
                               
                            </td>
                            
                            <td id="Price_err"></td>
                        </tr>
                       <tr>
                            <td>Stock Available<span class="error"> * </span></td>
                            <td>
                                <input type="text" class="form-control" name="QUANTITY_AVAILABLE" id="QUANTITY_AVAILABLE">
                            </td>
                            
                            <td id="Qty_err"></td>
                        </tr>
                        
                         <tr>
                            <td colspan="3">
                                <input type="submit" id="SK_Product_Add" name="SK_Product_Add" class="btn btn-primary" value="SUBMIT" style="background:orangered;border:orangered;font-weight:bold;">
                            </td>
                        </tr>
            </table>
	
      </div> 
    </body>
</html>

