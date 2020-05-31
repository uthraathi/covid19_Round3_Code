<?php
require_once "config.php";
require_once 'GO_Menu.php';
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
        <title>e-Shopping - Ration Product Add</title>
        <!--<p style="float: right;font-size:20px;color: orchid;"><u>User Name</u>: <?php echo $_SESSION['User_Name']?><br><u>User Category</u>: <?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else echo "Shop Keeper"; ?></p>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 60%; padding: 20px; }
        .error{color: #FF0000;}
        
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
              
                
                 $('#RS_Prod_Add').click(function() {
                
                var Prod_Name = $.trim($('#Prod_Name').val());
                var AAP_Qty = $.trim($('#AAP_Qty').val()) !== '' ? parseInt($.trim($('#AAP_Qty').val())): 0;
                var AAP_Price = $.trim($('#AAP_Price').val()) !== '' ? parseFloat($.trim($('#AAP_Price').val())): 0;
                var PHH_Qty = $.trim($('#PHH_Qty').val()) !== '' ? parseInt($.trim($('#PHH_Qty').val())) : 0;
                var PHH_Price = $.trim($('#PHH_Price').val()) !== '' ? parseFloat($.trim($('#PHH_Price').val())) : 0;
                var NPHH_Qty = $.trim($('#NPHH_Qty').val()) !== '' ? parseInt($.trim($('#NPHH_Qty').val())) : 0;
                var NPHH_Price = $.trim($('#NPHH_Price').val()) !== '' ? parseFloat($.trim($('#NPHH_Price').val())) : 0;
                var aap_fm_type = $.trim($('#aap_fm_type').val());
                var phh_fm_type = $.trim($('#phh_fm_type').val());
                var nphh_fm_type = $.trim($('#nphh_fm_type').val());
                if(Prod_Name !== '' )
                    {
                        $.ajax
                        ({
                            type: 'POST',
                            url: 'Post_RS_Prod_Add.php',
                            data: { Prod_Name:Prod_Name,AAP_Qty:AAP_Qty,AAP_Price:AAP_Price,
                                    PHH_Qty:PHH_Qty,PHH_Price:PHH_Price,NPHH_Qty:NPHH_Qty,
                                    NPHH_Price:NPHH_Price,aap_fm_type:aap_fm_type,phh_fm_type:phh_fm_type,nphh_fm_type:nphh_fm_type},
                                success: function(response) {
                                 var result = JSON.parse(response);

                                 if(result.status === "S")
                                 {
                                     alert(result.msg);
                                     window.location.href="Ration_Product_Add.php";
                                 }
                                 else
                                 {
                                     alert(result.msg);
                                }
                            }
                        });
                    }
                    else
                    {
                     alert("Enter Product Name");
                     $('#Prod_Name').focus();
                    }
               });
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Ration Product Add</h2>
            <p><span class="error">* required field</span></p>

            <table class="table">


                <tr>
                    <td><label>Product Name</label><span class="error"> * </span></td>

                    <td>
                        <input type="text" id="Prod_Name" name="Prod_Name" value="" >
                    </td>
                   
                </tr>   
                <tr>
                    <td><label>AAP Card Limit</label><span class="error"> * </span></td>

                    <td>
                        <label>Quantity (Kg/ Litre): </label>
                        <input type="number" id="AAP_Qty" name="AAP_Qty"  value="0" style="width:10%;">
                        <select id="aap_fm_type" name="aap_fm_type">
                            <option value="F" selected="selected">Per Family</option>
                            <option value="M">Per Member</option>
                        </select><br>
                        <label>Price (in Rs.): </label>
                        <input type="number" id="AAP_Price" name="AAP_Price"  value="0"  style="width:10%;" step="any">
                    </td>
                    
                </tr> 
                <tr>
                    <td><label>PHH Card Limit</label><span class="error"> * </span></td>

                    <td>
                        <label>Quantity (Kg/ Litre): </label>
                        <input type="number" id="PHH_Qty" name="PHH_Qty"  value="0"  style="width:10%;">
                        <select id="phh_fm_type" name="phh_fm_type">
                            <option value="F" selected="selected">Per Family</option>
                            <option value="M">Per Member</option>
                        </select><br>
                        <label>Price (in Rs.): </label>
                        <input type="number" id="PHH_Price" name="PHH_Price"  value="0"  style="width:10%;"  step="any">
                    </td>
                    
                </tr>
                <tr>
                    <td><label>NPHH Card Limit</label><span class="error"> * </span></td>

                    <td>
                        <label>Quantity (Kg/ Litre): </label>
                        <input type="number" id="NPHH_Qty" name="NPHH_Qty"  value="0"  style="width:10%;">
                        <select id="nphh_fm_type" name="nphh_fm_type">
                            <option value="F" selected="selected">Per Family</option>
                            <option value="M">Per Member</option>
                        </select><br>
                        <label>Price (in Rs.): </label>
                        <input type="number" id="NPHH_Price" name="NPHH_Price"  value="0"  style="width:10%;" step="any">
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="2"><input type="button" id="RS_Prod_Add" name="RS_Prod_Add" class="btn btn-primary" value="Add Product" style="background:orangered;border:orangered;font-weight:bold;"></td>
                </tr>    
            </table> 
     
        </div>    
    </body>
</html>
