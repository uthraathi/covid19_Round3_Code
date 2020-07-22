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
        <title>RELIEF MATERIAL COLLECTION</title>
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
              $('.PU_Address').hide();
              $('#Delv_Opt').change(function() 
              {
                  var Delv_Opt = $('#Delv_Opt').val();
                  if(Delv_Opt === 'A')
                  {
                      $('.PU_Address').show();
                      $('.ST_Num').hide();
                  }
                  else
                  {
                      $('.PU_Address').hide();
                      $('.ST_Num').show();
                  }
              });
              $('#Register').click(function() 
              {
                var Name = $.trim($('#Vol_Name').val());
                var email = $.trim($('#Vol_Email').val());
                var Mobile = $.trim($('#Vol_Mobile').val());
                var Address = $.trim($('#Vol_Address').val());
                var Vol_Desp = $.trim($('#Vol_Desp').val());
                var Delv_Opt = $.trim($('#Delv_Opt').val());
                var ST_Num = $.trim($('#ST_Num').val());
                var PU_Address = $.trim($('#PU_Address').val());
                var Exp_Date = $.trim($('#Exp_Date').val());
                var Track_Address = "";
                if (Vol_Desp === '')
                {
                     $('#Desp_Err').empty();
                     $('#Desp_Err').append('<span style="color:red;">Product Description with Quantity</span>');
                }
                else
                {
                    $('Desp_Err').empty();
                    if (Delv_Opt === 'A' && PU_Address === '')
                    {
                         $('#PUAddr_Err').empty();
                         $('#PUAddr_Err').append('<span style="color:red;">Enter Pick-up Address</span>');
                         
                    }
                    else if ((Delv_Opt === 'O' || Delv_Opt === 'P')&& ST_Num === '')
                    {
                          $('#ST_Err').empty();
                          $('#ST_Err').append('<span style="color:red;">Enter Shipment Tracking Number</span>');
                          
                    }
                    else
                    {
                         $('#ST_Err').empty();
                         $('#PUAddr_Err').empty();
                         if(Delv_Opt === 'A')Track_Address = PU_Address; else Track_Address = ST_Num;
                         if(Exp_Date === '')
                         {
                             $('#Exp_Date_Err').empty();
                             $('#Exp_Date_Err').append('<span style="color:red;">Enter Expected Date of Delivery</span>');
                         }
                         else
                         {
                           $.ajax
                        ({
                            type: 'POST',
                            url: 'post_IU_Relief_Mtrl_add.php',
                            data: {Name:Name,email:email,Mobile:Mobile,Address:Address,
                                   Vol_Desp:Vol_Desp,Delv_Opt:Delv_Opt, Track_Address:Track_Address,Exp_Date:Exp_Date},
                            success: function(response) {
                                 var result = JSON.parse(response);

                                 if(result.status === "S")
                                 {
                                     alert(result.msg);
                                     window.location.href="IU_Relief_Mtrl_Apply.php";
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
                });
               
            });
            </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">RELIEF MATERIAL COLLECTION</h2>
            
 <p><span class="error">* required field</span></p>

            <table class="table">

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
                            <td><textarea id="Vol_Address" name="Vol_Address" class="form-control" rows="4" cols="50" disabled = "disabled"><?php echo $uaddress; ?></textarea></td>
                            <td id="Addr_Err"></td>
                        </tr>
                        <tr>
                            <td>Product Description with Quantity<span class="error"> * </span></td>
                            <td><textarea id="Vol_Desp" name="Vol_Desp" class="form-control" rows="5" cols="50"></textarea></td>
                            <td id="Desp_Err"></td>
                        </tr>
                        <tr>
                            <td>Delivery Option<span class="error"> * </span></td>
                            <td>
                                <select id = "Delv_Opt" name="Delv_Opt">
                                    <option value="O" selected="selected">Online Delivery</option>
                                    <option value="P">Parcel Delivery</option>
                                    <option value="A">Pick up at address</option>
                                </select>
                            </td>
                            <td id="Deliv_Err"></td>
                        </tr>
                       <tr class="ST_Num">
                            <td>Shipment Tracking Number<span class="error"> * </span></td>
                            <td><input type="text" id="ST_Num" name="ST_Num" class="form-control" ></td>
                            <td id="ST_Err"></td>
                        </tr>
                        <tr class="PU_Address">
                            <td>Pick up Address<span class="error"> * </span></td>
                            <td><textarea id="PU_Address" name="PU_Address" class="form-control" rows="4" cols="50" ></textarea></td>
                            <td id="PUAddr_Err"></td>
                        </tr>
                        <tr>
                            <td>Expected Date of Delivery<span class="error"> * </span></td>
                            <td><input type="Date" id="Exp_Date" name="Exp_Date" class="form-control" ></td>
                            <td id="Exp_Date_Err"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="submit" id="Register" name="Register" class="btn btn-primary" value="Donate" style="background:orangered;border:orangered;font-weight:bold;">
                            </td>
                        </tr>
            </table> 
      

        </div>    
    </body>
</html>
