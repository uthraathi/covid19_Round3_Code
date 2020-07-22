<?php

require_once 'IU_Menu.php';
require_once "config.php";
$st_code = $_SESSION['STATE_CODE'];
$user_id = $_SESSION['user_id'];
$uname = $uemail = $umobile = $uaddress = "";
$sql_q = "SELECT * FROM user_registration WHERE user_id  = '$user_id'";
$result_q = mysqli_query($MyConnection, $sql_q);

 if (mysqli_num_rows($result_q) > 0) 
 {
    while($row_q = mysqli_fetch_assoc($result_q)) 
    {
        $uname = $row_q['user_name'];
        $uemail = $row_q['email_id'];
        $umobile = $row_q['mobile_number'];
        $uaddress = $row_q['BUILD_NO'] .", ".$row_q['STREET'].", \n". $row_q['CITY'].", \n". $row_q['DISTRICT'].", \n". $row_q['STATE']." - ". $row_q['PINCODE'];
        
    }
 } 
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>VOLUNTEER REGISTRATION</title>
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
               $("#Vol_Mobile").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
                   //display error message
                   $('#Mobile_Err').empty();
                   $("#Mobile_Err").append('<span style="color:red;">enter digit only</span>');
                          return false;
               }
               else
               {$('#Mobile_Err').empty();}
              }); 
              $('#Register').click(function() {
                var District  = $.trim($('#District').val());
                var Category = $.trim($('#CATEGORY').val());
                var Sub_Category = $.trim($('#Sub_Category').val());
                var Sub_Cat_Others = $.trim($('#Sub_Cat_others').val());
                var Name = $.trim($('#Vol_Name').val());
                var email = $.trim($('#Vol_Email').val());
                var Mobile = $.trim($('#Vol_Mobile').val());
                var Gender = $.trim($('#Vol_Gender').val());
                var DOB = $.trim($('#Vol_DOB').val());
                var Address = $.trim($('#Vol_Address').val());
                var Availability = $.trim($('#Vol_Avail').val());
                var Edu_Qual = $.trim($('#Vol_Edu_Qual').val());
                
                
                if(District === 'Select')
                    {
                        $('#District_err').empty();
                        $('#District_err').append('<span style="color:red;">Select District</span>');
                    }
                    else
                    {
                        $('#District_err').empty();
                       
                        if(Category === 'Select')
                        {
                            $('#CATEGORY_err').empty();
                            $('#CATEGORY_err').append('<span style="color:red;">Select Category</span>');
                        }
                        else
                        {
                            $('#CATEGORY_err').empty();
                           
                            if(Sub_Category === 'Select')
                            {
                                $('#Sub_Cat_err').empty();
                                $('#Sub_Cat_err').append('<span style="color:red;">Select Sub-Category</span>');
                            }
                            else if (Sub_Category !== 'Select' && Sub_Category === 'OTHER' && Sub_Cat_Others === '')
                            {
                                $('#Sub_Cat_err').empty();
                                $('#Sub_Cat_err').append('<span style="color:red;">Specify Other</span>');
                            }
                            else
                            {
                                $('#Sub_Cat_err').empty();
                                if(Mobile === '')
                                {
                                    $('#Mobile_Err').empty();
                                    $('#Mobile_Err').append('<span style="color:red;">Enter Mobile Number</span>');
                                }
                                else if (Mobile !== '' && Mobile.length < 10)
                                {
                                    $('#Mobile_Err').empty();
                                    $('#Mobile_Err').append('<span style="color:red;">Invalid Mobile Number</span>');   
                                }
                               else
                                {
                                    $('#Mobile_Err').empty();
                                    if(email === '')
                                    {
                                        $('#Email_Err').empty();
                                        $('#Email_Err').append('<span style="color:red;">Enter Email ID</span>');
                                    }
                                    else if (email !== '' && !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)))
                                
                                    {
                                        $('#Email_Err').empty();
                                        $('#Email_Err').append('<span style="color:red;">Invalid Email ID</span>');
                                    }
                                    else
                                    {
                                        $('#Email_Err').empty();
                                        if(Name === '')
                                        {
                                            $('#Name_Err').empty();
                                            $('#Name_Err').append('<span style="color:red;">Enter Name</span>');
                                        }
                                        else
                                        {
                                            $('#Name_Err').empty();
                                            if(Address === '')
                                            {
                                                $('#Addr_Err').empty();
                                                $('#Addr_Err').append('<span style="color:red;">Enter Address</span>');
                                            }
                                            else
                                            {
                                                $('#Addr_Err').empty();
                                                if(Gender === 'Select')
                                                {
                                                    $('#Gender_Err').empty();
                                                    $('#Gender_Err').append('<span style="color:red;">Select Gender</span>');
                                                }
                                                else
                                                {
                                                    $('#Gender_Err').empty();
                                                    if(DOB === '')
                                                    {
                                                        $('#DOB_Err').empty();
                                                        $('#DOB_Err').append('<span style="color:red;">Enter Date of Birth</span>');
                                                    }
                                                    else
                                                    {
                                                        $('#DOB_Err').empty();
                                                        if(Edu_Qual === '')
                                                        {
                                                            $('#Edu_Qual_Err').empty();
                                                            $('#Edu_Qual_Err').append('<span style="color:red;">Enter Educational Qualification</span>');
                                                        }
                                                        else
                                                        {
                                                            $('#Edu_Qual_Err').empty();
                                                            if(Sub_Category === 'OTHER')
                                                            {
                                                                Sub_Category = Sub_Cat_Others;
                                                            }
                                                            
                                                            $.ajax
                                                            ({
                                                                type: 'POST',
                                                                url: 'post_Volunteer_add.php',
                                                                data: {District:District,Category:Category,Sub_Category:Sub_Category,
                                                                        Name:Name,email:email,Mobile:Mobile,Gender:Gender,DOB:DOB,
                                                                        Address:Address,Availability:Availability,Edu_Qual:Edu_Qual},
                                                                success: function(response) {
                                                                     var result = JSON.parse(response);
                                                                     
                                                                     if(result.status === "S")
                                                                     {
                                                                         alert(result.msg);
                                                                         window.location.href="Volunteer_Registration.php";
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
                });
               $('#Sub_Cat_others').hide();
               //alert("<?php echo $st_code ?>");
               $('#CATEGORY').change(function(){
                   var CATEGORY = $('#CATEGORY').val();
                    if(CATEGORY !== "Select")
                    {   
                        $.ajax
                        ({          
                            type: "GET",
                            url: "get_Volun_Sub_Cat.php",
                            data:'CATEGORY='+CATEGORY,
                            success: function(data)
                            {
                                $("#Sub_Cat_list").empty();
                                $("#Sub_Cat_list").append(data);
                            }
                        });
                    }
                    else
                    {
                        alert("Select Category");
                        $('#CATEGORY').focus();
                        $("#Sub_Cat_list").empty();
                    }
               });
               $(document).on('change', '#Sub_Category', function(){
                   var Sub_Category = $('#Sub_Category').val();
                    if(Sub_Category !== "Select" && Sub_Category === "OTHER")
                    {   
                        $('#Sub_Cat_others').show();
                    } 
                    else if (Sub_Category === "Select")
                    {
                        alert("Select Sub-Category");
                        $('#Sub_Category').focus();
                        $('#Sub_Cat_others').hide();
                        $('#Sub_Cat_others').val("");
                    }
                    else
                    {$('#Sub_Cat_others').hide();
                        $('#Sub_Cat_others').val("");}
               });
               
            });
            </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">VOLUNTEER REGISTRATION</h2>
            
 <p><span class="error">* required field</span></p>

            <table class="table">

                        <tr>
                            <td>District<span class="error"> * </span></td>
                            <td>
                                <select id="District" name="District">
                                    <option value="Select" selected="selected" >--Select District--</option>
                                    <?php
                                    

                                    $sql_d = "SELECT DISTRICT FROM statewise_district_master WHERE STATE_CODE  = '$st_code' order by DISTRICT";
                                    $result_d = mysqli_query($MyConnection, $sql_d);

                                     if (mysqli_num_rows($result_d) > 0) 
                                     {
                                        while($row_d = mysqli_fetch_assoc($result_d)) 
                                        {
                                            echo "<option value='".$row_d['DISTRICT']."'>" . $row_d['DISTRICT'] . "</option>";
                                        }
                                     } 
                                    ?>
                              </select>
                                
                            </td>
                            
                            <td id="District_err"></td>
                        </tr>
                        <tr>
                            <td>Category<span class="error"> * </span></td>
                            <td>
                             <select id="CATEGORY" name="CATEGORY">
                                    <option value="Select" selected="selected" >--Select Category--</option>
                                    <?php
                            

                                    $sql_c = "SELECT DISTINCT(CATEGORY) AS CATEGORY FROM voulteer_category_master ORDER BY CATEGORY";
                                    $result_c = mysqli_query($MyConnection, $sql_c);

                                     if (mysqli_num_rows($result_c) > 0) 
                                     {
                                        while($row_c = mysqli_fetch_assoc($result_c)) 
                                        {
                                            echo "<option value='".$row_c['CATEGORY']."'>" . $row_c['CATEGORY'] . "</option>";
                                        }
                                     } 
                                     
                                     mysqli_close($MyConnection);
                                    ?>
                              </select>
                            </td>
                            <td id="CATEGORY_err"></td>
                        </tr>
                        <tr>
                            <td>Sub-Category<span class="error"> * </span></td>
                            <td id="Sub_Cat_list">
                                
                            </td>
                            
                            <td id="Sub_Cat_err"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="text" id="Sub_Cat_others" name="Sub_Cat_others" class="form-control" placeholder="Type Sub-Category"></td>
                            <td id="others_err"></td>
                        </tr>
                        <tr>
                            <td>Name<span class="error"> * </span></td>
                            <td><input type="text" id="Vol_Name" name="Vol_Name" class="form-control" value="<?php echo $uname; ?>" disabled="disabled"></td>
                            <td id="Name_Err"></td>
                        </tr>
                        <tr>
                            <td>Mobile<span class="error"> * </span></td>
                            <td><input type="text" id="Vol_Mobile" name="Vol_Mobile" class="form-control" value="<?php echo $umobile; ?>" disabled="disabled"></td>
                            <td id="Mobile_Err"></td>
                        </tr>
                        <tr>
                            <td>Email<span class="error"> * </span></td>
                            <td><input type="text" id="Vol_Email" name="Vol_Email" class="form-control" value="<?php echo $uemail; ?>" disabled="disabled"></td>
                            <td id="Email_Err"></td>
                        </tr>
                        <tr>
                            <td>Address<span class="error"> * </span></td>
                            <td><textarea id="Vol_Address" name="Vol_Address" class="form-control" rows="5" cols="50" disabled = "disabled"><?php echo $uaddress; ?></textarea></td>
                            <td id="Addr_Err"></td>
                        </tr>
                        <tr>
                            <td>Availability<span class="error"> * </span></td>
                            <td>
                                <select id = "Vol_Avail" name="Vol_Avail">
                                    <option value="0" selected="selected">Immediate</option>
                                    <option value="3">Within 3 Days</option>
                                    <option value="7">Within 7 Days</option>
                                </select>
                            </td>
                            <td id="Avail_Err"></td>
                        </tr>
                        <tr>
                            <td>Gender<span class="error"> * </span></td>
                            <td>
                                <select id = "Vol_Gender" name="Vol_Avail">
                                    <option value="Select" selected="selected">--Select Gender--</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </td>
                            <td id="Gender_Err"></td>
                        </tr>
                        <tr>
                            <td>Date of Birth<span class="error"> * </span></td>
                            <td>
                                <input type="Date" id="Vol_DOB" name="Vol_DOB" max="01-02-2003">
                            </td>
                            <td id="DOB_Err"></td>
                        </tr>
                        <tr>
                            <td>Educational Qualification<span class="error"> * </span></td>
                            <td>
                                <input type="text" id="Vol_Edu_Qual" name="Vol_Edu_Qual" class="form-control">
                            </td>
                            <td id="Edu_Qual_Err"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="submit" id="Register" name="Register" class="btn btn-primary" value="Register" style="background:orangered;border:orangered;font-weight:bold;">
                            </td>
                        </tr>
            </table> 
      

        </div>    
    </body>
</html>
