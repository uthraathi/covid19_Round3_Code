<?php
require_once 'Go_Menu.php';
$state_code = $_SESSION['STATE_CODE'];
$state_name = $_SESSION['STATE_NAME'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Hospital Registration</title>
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
              $('#State').val("<?php echo $_SESSION['STATE_NAME'] ?>");
              $('#State').prop('disabled', true);
              $('#Pincode').val("<?php echo $_SESSION['PINCODE'] ?>");
              $('#Pincode').prop('disabled', true);
              $("#Pincode").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                   //display error message
                   $('#address_err').empty();
                   $("#address_err").append('<span style="color:red;">enter digit only</span>');
                          return false;
               }
               else
               {$('#address_err').empty();}
              });
              $("#Shop_Mobile").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
                   //display error message
                   $('#mobile_err').empty();
                   $("#mobile_err").append('<span style="color:red;">enter digit only</span>');
                          return false;
               }
               else
               {$('#mobile_err').empty();}
              });
               $('#SK_Add').click(function() {
                
                var Name = $.trim($('#Shop_Name').val());
                var Owner_Name = $.trim($('#Shop_OwnName').val());
                var Mobile = $.trim($('#Shop_Mobile').val());
                var Email = $.trim($('#Shop_Email').val());
            
                var Reg_No = $.trim($('#Shop_Reg').val());
                var Build_No = $.trim($('#Build_No').val());
                var Street = $.trim($('#Street').val());
                var City = $.trim($('#City').val());
                var District = $.trim($('#District').val());
                var State = $.trim($('#State').val());
                var Pincode = $.trim($('#Pincode').val());
            
           
                        if(Name === '')
                        {
                            $('#name_err').empty();
                            $('#name_err').append('<span style="color:red;">Enter Hospital Name</span>');
                        }
                        else
                        {
                            $('#name_err').empty();
                           
                            if(Owner_Name === '')
                            {
                                $('#Own_name_err').empty();
                                $('#Own_name_err').append('<span style="color:red;">Enter In-charge Name</span>');
                            }
                            else
                            {
                                $('#Own_name_err').empty();
                                if(Mobile === '')
                                {
                                    $('#mobile_err').empty();
                                    $('#mobile_err').append('<span style="color:red;">Enter Mobile Number</span>');
                                }
                                else if (Mobile !== '' && Mobile.length < 10)
                                {
                                    $('#mobile_err').empty();
                                    $('#mobile_err').append('<span style="color:red;">Invalid Mobile Number</span>');   
                                }
                               else
                                {
                                    $('#mobile_err').empty();
                                    if(Email === '')
                                    {
                                        $('#email_err').empty();
                                        $('#email_err').append('<span style="color:red;">Enter Email ID</span>');
                                    }
                                    else if (Email !== '' && !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(Email)))
                                
                                    {
                                        $('#email_err').empty();
                                        $('#email_err').append('<span style="color:red;">Invalid Email ID</span>');
                                    }
                                    else
                                    {
                                        $('#email_err').empty();
                                        
                                            if(Reg_No === '')
                                            {
                                                $('#Reg_err').empty();
                                                $('#Reg_err').append('<span style="color:red;">Enter Registration Number</span>');
                                            }
                                            else
                                            {
                                                $('#Reg_err').empty();
                                                if(Build_No === '')
                                                {
                                                    $('#address_err').empty();
                                                    $('#address_err').append('<span style="color:red;">Enter Bulding No/ Apartment No/ Plot No</span>');
                                                }
                                                else
                                                {
                                                    $('#address_err').empty();
                                                    if(Street === '')
                                                    {
                                                        $('#address_err').empty();
                                                        $('#address_err').append('<span style="color:red;">Enter Street</span>');
                                                    }
                                                    else
                                                    {
                                                        $('#address_err').empty();
                                                        if(City === '')
                                                        {
                                                            $('#address_err').empty();
                                                            $('#address_err').append('<span style="color:red;">Enter City/ Village</span>');
                                                        }
                                                        else
                                                        {
                                                            $('#address_err').empty();
                                                            if(District === '')
                                                            {
                                                                $('#address_err').empty();
                                                                $('#address_err').append('<span style="color:red;">Enter District</span>');
                                                            }
                                                            else
                                                            {
                                                                $('#address_err').empty();
                                                                if(State === 'Select')
                                                                {
                                                                    $('#address_err').empty();
                                                                    $('#address_err').append('<span style="color:red;">Select State</span>');
                                                                }
                                                                else
                                                                {
                                                                    $('#address_err').empty();
                                                                    if(Pincode === '')
                                                                    {
                                                                        $('#address_err').empty();
                                                                        $('#address_err').append('<span style="color:red;">Enter Pincode</span>');
                                                                    }
                                                                    else if (Pincode !== '' && Pincode.length < 6)
                                                                    {
                                                                        $('#address_err').empty();
                                                                        $('#address_err').append('<span style="color:red;">Invalid Pincode</span>');   
                                                                    }
                                                                    else
                                                                    {
                                                                        $('#address_err').empty();
                                                                        $.ajax
                                                                        ({
                                                                            type: 'POST',
                                                                            url: 'post_HR_add.php',
                                                                            data: {Name:Name,Owner_Name:Owner_Name,Mobile:Mobile,Email:Email,Reg_No:Reg_No,Build_No:Build_No,Street:Street,City:City,District:District,State:State,Pincode:Pincode},
                                                                            success: function(response) {
                                                                                 var result = JSON.parse(response);
                                                                                 //alert(result.status);
                                                                                 if(result.status === "S")
                                                                                 {
                                                                                     alert(result.msg);
                                                                                     window.location.href="Hospital_Register.php";
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
            <h2 style="color:#b5651d;">Hospital Registration</h2>
 <p><span class="error">* required field</span></p>

            <table class="table">
                       
                        <tr>
                            <td>Hospital Name<span class="error"> * </span></td>
                            <td>
                                 <input type="text" id="Shop_Name" name="Shop_Name" class="form-control">
                            </td>
                            <td id="name_err"></td>
                        </tr>
                        <tr>
                            <td>Hospital In-charge Name<span class="error"> * </span></td>
                            <td>
                                 <input type="text" id="Shop_OwnName" name="Shop_OwnName" class="form-control">
                            </td>
                            <td id="Own_name_err"></td>
                        </tr>
                        <tr>
                            <td>Mobile Number<span class="error"> * </span></td>
                            <td>
                                <input type="text" id="Shop_Mobile" name="Shop_Mobile" class="form-control" maxlength="10">
                            </td>
                            <td id="mobile_err"></td>
                        </tr>
                         <tr>
                            <td>Email<span class="error"> * </span></td>
                            <td>
                                 <input type="text" id="Shop_Email" name="Shop_Email" class="form-control">
                            </td>
                            <td id="email_err"></td>
                        </tr>
                        
                        <tr>
                            <td>Hospital Registration Number<span class="error"> * </span></td>
                            <td>
                                 <input type="text" id="Shop_Reg" name="Shop_Reg" class="form-control">
                            </td>
                            <td id="Reg_err"></td>
                        </tr>
                        <tr>
                            <td>Hospital Address<span class="error"> * </span></td>
                            <td>
                                <input type="text" id="Build_No" name="Build_No" placeholder="Building No/ Apartment/ Plat No" class="form-control"> <br>
                               
                                <input type="text" id="Street" name="Street" placeholder="Street" class="form-control" ><br>
                               
                                <input type="text" id="City" name="City" placeholder="Village/ City" class="form-control" ><br>
                              <input type="text" id="District" name="District" placeholder="District" class="form-control" ><br>
                              <label>State: </label> <select id="State" name="State">
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
                              </select><br>
<!--                              <input type="text" id="State" name="State" placeholder="State" class="form-control" ><br>-->
                              <input type="text" id="Pincode" name="Pincode" placeholder="Pincode" class="form-control"  maxlength="6">

                            </td>
                            <td id="address_err"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="submit" id="SK_Add" name="SK_Add" class="btn btn-primary" value="Register Hospital" style="background:orangered;border:orangered;font-weight:bold;">
                            </td>
                        </tr>
            </table> 
     
        </div>    
    </body>
</html>