
<?php
require_once "config.php";
?>



<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Page</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: auto;border: 2px solid #b5651d;border-radius: 10px 20px 10px 20px;}
        .error{color: #FF0000;}
        
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#Login").click(function () 
                {
                    var usr_category  = $.trim($('#usr_category').val());
                    var username = $.trim($('#username').val());
                    var password = $.trim($('#password').val());
                    //alert(usr_category);   cat_err   name_err     passwd_err
                    if(usr_category === "Select")
                    {
                        $('#cat_err').empty();
                        $('#cat_err').append('<span style="color:red;">Select User Category</span>');
                    }
                    else
                    {
                        $('#cat_err').empty();
                        if(username === '')
                        {
                            $('#name_err').empty();
                            $('#name_err').append('<span style="color:red;">Enter Username</span>');
                        }
                        else
                        {
                            $('#name_err').empty();
                            if(password === '')
                            {
                                $('#passwd_err').empty();
                                $('#passwd_err').append('<span style="color:red;">Enter Password</span>');
                            }
                            else
                            {
                                $('#passwd_err').empty();
                                $.ajax
                                ({
                                type: 'POST',
                                url: 'Check_Login.php',
                                data: { category: usr_category, username: username ,password: password},
                                success: function(response) {
                                     //alert(response);
                                     var result = JSON.parse(response);
                                     //alert(result.status);
                                     if(result.status === "S")
                                     {
                                         //alert(result.msg);
                                         if (usr_category === 'GO')
                                         {
                                         window.location.href="Product_Add.php";
                                         }
                                         else if (usr_category === 'SK')
                                         {
                                         window.location.href="addproduct_SK.php";
                                         }
                                         else if (usr_category === 'RS')
                                         {
                                         window.location.href="addproduct_RS.php";
                                         }
                                         else if (usr_category === 'HA')
                                         {
                                         window.location.href="addDoctors.php";
                                         }
                                         else if (usr_category === 'DR')
                                         {
                                         window.location.href="DR_Service_Time.php";
                                         }
                                         else
                                         {
                                             window.location.href="IU_Shop_by_Category.php";
                                         }
                                        
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
            <h1 style="color: brown;  text-shadow: 1px 2px 2px black, 0 0 25px greenyellow, 0 0 5px grey;text-align: center;height:70px;">Punjab District</h1>
            <table style="border-spacing:20px;border-collapse:separate;">
                <tr>
                    <td style="width:50%;">
                        <img src='/Covid19/27-punjab-home.jpg'  width=100% height='350' alt='' />
                    </td>
                    <td style="width:30%;">
                              <h3 style="color:#b5651d;font-size:30px;text-align:center;">Login</h3>
            <p style="color:red;font-size:10px;">Please fill in your credentials to login.</p>
                
            <table class="table" style="background-image: linear-gradient(to right, white , skyblue);border-spacing:20px;border-collapse:separate;">
                        <tr>
                            <td>User Category<span class="error"> * </span></td>
                            <td style="width:65%;">
                                 <select id="usr_category" name="usr_category" class="form-control">
                                        <option value="Select" selected="selected">Select</option>
                                        <option value="IU">Individual User</option>
                                        <option value="GO">Government Official</option>
                                        <option value="SK">Shop Keeper</option>
                                        <option value="RS">Ration Shop</option>
                                        <option value="HA">Hospital</option>
                                        <option value="DR">Doctor</option>
                                    </select>

                            </td>
                            <td id="cat_err"></td>
                        </tr>
                        <tr>
                            <td>User Unique ID<span class="error"> * </span></td>
                            <td style="width:65%;">
                                 <input type="text" id="username" name="username" class="form-control" >
                            </td>
                            <td id="name_err"></td>
                        </tr>
                        <tr>
                            <td>Password<span class="error"> * </span></td>
                            <td style="width:65%;">
                                 <input type="password" id="password" name="password" class="form-control">
                            </td>
                            <td id="passwd_err"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="submit" id="Login" name="Login" class="btn btn-primary" value="Login" style="background:#b5651d;border:#b5651d;font-weight:bold;float:right;">
                            </td>
                        </tr>
            </table> 
         
            <p>New user click <a href="register.php">Sign up now</a> to register.</p>
                    </td>
                </tr>
               
               
            </table>
            
              

     

        </div>    
    </body>
    <footer style="text-align:center;">
        Copyright © Anna University. All Rights Reserved.
    </footer>
</html>
