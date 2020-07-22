<?php
require_once 'Go_Menu.php';
$state_code = $_SESSION['STATE_CODE'];
$state_name = $_SESSION['STATE_NAME'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Shopping - Product Add</title>
<!--        <p style="float: right;font-size:20px;color: orchid;"><u>User Name</u>: <?php echo $_SESSION['User_Name']?><br><u>User Category</u>: <?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else echo "Shop Keeper"; ?></p>-->
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
                $('#RS_State').val("<?php echo $state_name ?>");
                $('#RS_State').prop('disabled', true);
                $('#RS_Pincode').val("<?php echo $_SESSION['PINCODE'] ?>");
                $('#RS_Pincode').prop('disabled', true);
                 $("#RS_Pincode").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                   //display error message
                   $('#RS_address_err').empty();
                   $("#RS_address_err").append('<span style="color:red;">enter digit only</span>');
                          return false;
               }
               else
               {$('#RS_address_err').empty();}
              });
              $("#RS_Mobile").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                   //display error message
                   $('#RS_mobile_err').empty();
                   $("#RS_mobile_err").append('<span style="color:red;">enter digit only</span>');
                          return false;
               }
               else
               {$('#RS_mobile_err').empty();}
              });
              $('#RS_register').click(function() {
               
                var RS_Reg_No = $.trim($('#RS_Num').val());
                var Name = $.trim($('#RS_Name').val());
                var Mobile = $.trim($('#RS_Mobile').val());
                var Email = $.trim($('#RS_email').val());
                var Empid = $.trim($('#RS_Empid').val());
                var Build_No = $.trim($('#RS_Build_No').val());
                var Street = $.trim($('#RS_Street').val());
                var City = $.trim($('#RS_City').val());
                var District = $.trim($('#RS_District').val());
                var State = $.trim($('#RS_State').val());
                var Pincode = $.trim($('#RS_Pincode').val());
                var data = {Name:Name,RS_Reg_No:RS_Reg_No,Mobile:Mobile,Email:Email,Empid:Empid,Build_No:Build_No
                    ,Street:Street,City:City,District:District,State:State,Pincode:Pincode};
                    if(Name === '')
                    {
                        $('#RS_Name_err').empty();
                        $('#RS_Name_err').append('<span style="color:red;">Enter Incharge Name</span>');
                    }
                    else
                    {
                        $('#RS_Name_err').empty();
                       
                        if(RS_Reg_No === '')
                        {
                            $('#RS_num_err').empty();
                            $('#RS_num_err').append('<span style="color:red;">Enter Ration Shop Number</span>');
                        }
                        else
                        {
                            $('#RS_num_err').empty();
                             if(Mobile === '')
                                {
                                    $('#RS_mobile_err').empty();
                                    $('#RS_mobile_err').append('<span style="color:red;">Enter Mobile Number</span>');
                                }
                                else if (Mobile !== '' && Mobile.length < 10)
                                {
                                    $('#RS_mobile_err').empty();
                                    $('#RS_mobile_err').append('<span style="color:red;">Invalid Mobile Number</span>');   
                                }
                               else
                                {
                                    $('#RS_mobile_err').empty();
                                    if(Email === '')
                                    {
                                        $('#RS_email_err').empty();
                                        $('#RS_email_err').append('<span style="color:red;">Enter Email ID</span>');
                                    }
                                    else if (Email !== '' && !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(Email)))
                                
                                    {
                                        $('#RS_email_err').empty();
                                        $('#RS_email_err').append('<span style="color:red;">Invalid Email ID</span>');
                                    }
                                    else
                                    {
                                        $('#RS_email_err').empty();
                                        if(Empid === '')
                                        {
                                            $('#RS_empid_err').empty();
                                            $('#RS_empid_err').append('<span style="color:red;">Enter Incharge Employee ID</span>');
                                        }
                                        else
                                        {
                                            $('#RS_empid_err').empty();
                                             if(Build_No === '')
                                                {
                                                    $('#RS_address_err').empty();
                                                    $('#RS_address_err').append('<span style="color:red;">Enter Bulding No/ Apartment No/ Plot No</span>');
                                                }
                                                else
                                                {
                                                    $('#RS_address_err').empty();
                                                    if(Street === '')
                                                    {
                                                        $('#RS_address_err').empty();
                                                        $('#RS_address_err').append('<span style="color:red;">Enter Street</span>');
                                                    }
                                                    else
                                                    {
                                                        $('#RS_address_err').empty();
                                                        if(City === '')
                                                        {
                                                            $('#RS_address_err').empty();
                                                            $('#RS_address_err').append('<span style="color:red;">Enter City/ Village</span>');
                                                        }
                                                        else
                                                        {
                                                            $('#RS_address_err').empty();
                                                            if(District === '')
                                                            {
                                                                $('#RS_address_err').empty();
                                                                $('#RS_address_err').append('<span style="color:red;">Enter District</span>');
                                                            }
                                                            else
                                                            {
                                                                $('#RS_address_err').empty();
                                                                if(State === 'Select')
                                                                {
                                                                    $('#RS_address_err').empty();
                                                                    $('#RS_address_err').append('<span style="color:red;">Select State</span>');
                                                                }
                                                                else
                                                                {
                                                                    $('#RS_address_err').empty();
                                                                    if(Pincode === '')
                                                                    {
                                                                        $('#RS_address_err').empty();
                                                                        $('#RS_address_err').append('<span style="color:red;">Enter Pincode</span>');
                                                                    }
                                                                    else if (Pincode !== '' && Pincode.length < 6)
                                                                    {
                                                                        $('#RS_address_err').empty();
                                                                        $('#RS_address_err').append('<span style="color:red;">Invalid Pincode</span>');   
                                                                    }
                                                                    else
                                                                    {
                                                                        $('#RS_address_err').empty();
                                                                        $.ajax
                                                                        ({
                                                                            type: 'POST',
                                                                            url: 'post_RS_add.php',
                                                                            data: {Name:Name,RS_Reg_No:RS_Reg_No,Mobile:Mobile,Email:Email,Empid:Empid,Build_No:Build_No
                                                                                ,Street:Street,City:City,District:District,State:State,Pincode:Pincode},
                                                                                 success: function(response) {
                                                                                 var result = JSON.parse(response);
                                                                                 //alert(result.status);
                                                                                 if(result.status === "S")
                                                                                 {
                                                                                     alert(result.msg);
                                                                                     window.location.href="RS_Add.php";
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
                                                    }
                                                }
                                            
                                        }
                                        
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
       

                    <h2 style="color:#b5651d;">Ration Shop Registration</h2>
                    <p><span class="error">* required field</span></p>
                    <table class="table">
                        <tr>
                            <td>Ration Shop Number<span class="error"> * </span></td>
                            <td style="width:65%;">
                                 <input type="text" id="RS_Num" name="RS_Num" class="form-control">
                                 
                            </td>
                            <td id="RS_num_err"></td>
                        </tr>
                        <tr>
                            <td>Ration Shop Address<span class="error"> * </span></td>
                            <td>
                                <input type="text" id="RS_Build_No" name="RS_Build_No" placeholder="Building No/ Apartment/ Plat No" class="form-control"> <br>
                               
                                <input type="text" id="RS_Street" name="RS_Street" placeholder="Street" class="form-control" ><br>
                               
                                <input type="text" id="RS_City" name="RS_City" placeholder="Village/ City" class="form-control" ><br>
                              <input type="text" id="RS_District" name="RS_District" placeholder="District" class="form-control" ><br>
                              <label>State: </label> <select id="RS_State" name="RS_State">
                                    <option value="Select" selected="selected" >Select</option>
                                    <?php
                                    require_once "config.php";

                                    $sql = "SELECT * FROM state_master order by STATE_NAME asc ";
                                    $result = mysqli_query($MyConnection, $sql);

                                     if (mysqli_num_rows($result) > 0) 
                                     {
                                        while($row = mysqli_fetch_assoc($result)) 
                                        {
                                            echo "<option value='".$row['STATE_NAME']."'>" . $row['STATE_NAME'] . "</option>";
                                        }
                                     } 
                                     
                                     mysqli_close($MyConnection);
                                    ?>
                                </select>
<!--                              <input type="text" id="RS_State" name="RS_State" placeholder="State" class="form-control" ><br>-->
                              <input type="text" id="RS_Pincode" name="RS_Pincode" placeholder="Pincode" class="form-control" value="<?php echo $_SESSION['PINCODE'] ?>">

                            </td>
                            <td id="RS_address_err"></td>
                        </tr>
                        <tr>
                            <td>Ration Shop Incharge Name<span class="error"> * </span></td>
                            <td style="width:65%;">
                                 <input type="text" id="RS_Name" name="RS_Name" class="form-control">
                                 
                            </td>
                            <td id="RS_Name_err"></td>
                        </tr>
                        <tr>
                            <td>Incharge Employee ID<span class="error"> * </span></td>
                            <td>
                                 <input type="text" id="RS_Empid" name="RS_Empid" class="form-control">
                            </td>
                            <td id="RS_empid_err"></td>
                        </tr>
                        <tr>
                            <td>Incharge Mobile Number<span class="error"> * </span></td>
                            <td>
                                <input type="text" id="RS_Mobile" name="RS_Mobile" maxlength="10" class="form-control">
                            </td>
                            <td id="RS_mobile_err"></td>
                        </tr>
                        <tr>
                            <td>Incharge Email ID<span class="error"> * </span></td>
                            <td>
                                 <input type="text" id="RS_email" name="RS_email" class="form-control">
                            </td>
                            <td id="RS_email_err"></td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <input type="submit" class="btn btn-primary" id="RS_register" name="RS_register" value="Register" style="background:#b5651d;border:#b5651d;">
                                
                            </td>
                        </tr>
                    </table>
           
      

        </div>    
    </body>
</html>
