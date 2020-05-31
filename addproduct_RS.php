<?php
require_once 'RS_Menu.php';
require_once "config.php";

$user_id = $_SESSION['user_id'];
$STATE_CODE = $_SESSION['STATE_CODE'];
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Product Add</title>
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
          
                $("#QUANTITY_AVAILABLE").keypress(function (e) 
                {
                
                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
                    {
                       //display error message
                       $('#Qty_err').empty();
                       $("#Qty_err").append('<span style="color:red;">enter digit only</span>');
                              return false;
                    }
                   else
                   {
                       $('#Qty_err').empty();
                   }
              });
              $('#RS_Product_Add').click(function() 
              {
                    var Name  = $.trim($('#Prod_Name').val());
                    var Quantity = $.trim($('#QUANTITY_AVAILABLE').val());
                    if(Name === 'Select')
                    {
                        $('#name_err').empty();
                        $('#name_err').append('<span style="color:red;">Select Product Name</span>');
                    }
                    else
                    {
                        $('#name_err').empty();
                        if(Quantity === '')
                        {
                            $('#Qty_err').empty();
                            $('#Qty_err').append('<span style="color:red;">Enter Stock Availability</span>');
                        }
                       else
                        {
                            $('#Qty_err').empty();
                            $.ajax
                            ({
                               type: 'POST',
                               url: 'post_RS_product_add.php',
                               data: {ID: Name ,Quantity:Quantity},
                               success: function(response) {
                                    var result = JSON.parse(response);
                                    
                                    if(result.status === "S")
                                    {
                                        alert(result.msg);
                                        window.location.href="addproduct_RS.php";
                                    }
                                    else
                                    {
                                        alert(result.msg);
                                   }
                               }
                              });
                            
                        }
                    }
              });
           
               
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
         <h2 style="color:#b5651d;">Ration Shop - Product Add</h2>
         
 <p><span class="error">* required field</span></p>
	
            <table class="table">
                        <tr>
                            <td>Product Name<span class="error"> * </span></td>
                            <td style="width:65%;">
                                <select id="Prod_Name" name="Prod_Name">
                                    <option value="Select" selected="selected" >Select</option>
                                    <?php

                                    $sql = "SELECT * FROM ration_product_master where STATE_CODE = '$STATE_CODE'";
                                    $result = mysqli_query($MyConnection, $sql);

                                     if (mysqli_num_rows($result) > 0) 
                                     {
                                        while($row = mysqli_fetch_assoc($result)) 
                                        {
                                            echo "<option value='".$row['PRODUCT_ID']."'>" . $row['PRODUCT_NAME'] . "</option>";
                                        }
                                     } 
                                     
                                    ?>
                                </select>

                            </td>
                            <td id="name_err"></td>
                        </tr>
                       
                       <tr>
                            <td>Stock Availability<span class="error"> * </span></td>
                            <td>
                                <input type="text" class="form-control" name="QUANTITY_AVAILABLE" id="QUANTITY_AVAILABLE">
                            </td>
                            
                            <td id="Qty_err"></td>
                        </tr>
                        
                         <tr>
                            <td colspan="3">
                                <input type="button" id="RS_Product_Add" name="RS_Product_Add" class="btn btn-primary" value="SUBMIT" style="background:orangered;border:orangered;font-weight:bold;">
                            </td>
                        </tr>
            </table>
	
      </div> 
    </body>
</html>

