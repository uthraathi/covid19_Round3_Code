<?php
require_once "config.php";
require_once 'SK_Menu.php';
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
        <title>e-Shopping - Set Service Time</title>
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
                $('.HD_Show').hide();
                var is_HD_there = $('#is_HD_there').val();
                if('Y' === is_HD_there)
                {
                    $('#HD_Yes').prop("checked", true);
                    $('.HD_Show').show();
                }
                else
                {
                    $('#HD_No').prop("checked", true);
                    $('.HD_Show').hide();
                }
                $('input[name=HD_Avail]').click(function() {
                   var HD_Avail =  $("input[name='HD_Avail']:checked").val();
                   //alert(HD_Avail);
                   if('Y' === HD_Avail)
                    {
                        $('.HD_Show').show();
                    }
                    else
                    {
                        $('.HD_Show').hide();
                    }
                });
                
                 $('#Update_Data').click(function() {
                
                var Open_Time = $.trim($('#Open_Time').val());
                var Close_Time = $.trim($('#Close_Time').val());
                var Service_Time = parseInt($.trim($('#Service_Time').val()));
                var No_of_Person = parseInt($.trim($('#No_of_Person').val()));
                var HD_Avail =  $.trim($("input[name='HD_Avail']:checked").val());
                var HD_Service_Time = parseInt($.trim($('#HD_Service_Time').val()));
                var HD_No_of_Person = parseInt($.trim($('#HD_No_of_Person').val()));
                if(Service_Time > 0 )
                    {
                        if(No_of_Person > 0 )
                        {
                            if((HD_Avail === 'Y' && HD_Service_Time > 0) || HD_Avail === 'N' )
                            {
                                if((HD_Avail === 'Y' && HD_No_of_Person > 0) || HD_Avail === 'N' )
                                {
                                    $.ajax
                                    ({
                                        type: 'POST',
                                        url: 'post_Service_Time.php',
                                        data: { Open_Time:Open_Time,Close_Time:Close_Time,Service_Time:Service_Time,
                                                No_of_Person:No_of_Person,HD_Avail:HD_Avail,HD_Service_Time:HD_Service_Time,
                                                HD_No_of_Person:HD_No_of_Person},
                                            success: function(response) {
                                             var result = JSON.parse(response);

                                             if(result.status === "S")
                                             {
                                                 alert(result.msg);
                                                 window.location.href="Service_Time.php";
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
                                    alert("Enter Number of person can service/ Home Delivery Service Time");
                                    $('#HD_No_of_Person').focus();
                                }
                            }
                            else
                            {
                                alert("Enter Home Delivery Service Time");
                                $('#HD_Service_Time').focus();
                            }
                        }
                        else
                        {
                            alert("Enter Number of person can service/ Service Time");
                            $('#No_of_Person').focus();
                        }
                    }
                    else
                    {
                     alert("Enter Service Time");
                     $('#Service_Time').focus();
                    }
               });
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Set Service Time</h2>
 

            <table class="table">
                
                <?php
                $sql = "SELECT s.* from shop_keeper_registration s where s.SK_UNIQUE_ID='$user_id' order by s.SK_UNIQUE_ID asc";
                $result = mysqli_query($MyConnection, $sql);
                 
                 if (mysqli_num_rows($result) > 0) 
                     {
                     ?>
                     <?php 
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                    
                        ?> 
                <tr>
                    <td>Shop Opening Time</td>
               
                    <td>
                    <input type="Time" id="Open_Time" name="Open_Time" value="<?php echo $row['Open_Time']?>" >
                    <input type="hidden" id="is_HD_there" name="is_HD_there" value="<?php echo $row['IS_HD_AVAILABLE']?>" >
                    </td>
                </tr>   
                 <tr>
                    <td>Shop Closing Time</td>
               
                    <td>
                    <input type="Time" id="Close_Time" name="Close_Time" value="<?php echo $row['Close_Time']?>" >
                    
                    </td>
                </tr> 
                 <tr>
                    <td>Shop Service Time</td>
               
                    <td>
                    <input type="number" id="Service_Time" name="Service_Time"  value="<?php echo $row['Service_Time']?>" > Minutes
                    
                    </td>
                </tr> 
                <tr>
                    <td>Number of person can service/ Service Time</td>
               
                    <td>
                        <input type="number" id="No_of_Person" name="No_of_Person" value="<?php echo $row['No_of_Person']?>" >
                    
                    </td>
                </tr>
                <tr>
                    <td>Is Home Delivery Option is there?</td>
               
                    <td>
                        <input type="radio" id="HD_Yes" name="HD_Avail" value="Y" > Yes
                        <input type="radio" id="HD_No" name="HD_Avail" value="N" checked="checked">No
                    </td>
                </tr>
                <tr class="HD_Show">
                    <td>Home Delivery Service Time</td>
               
                    <td>
                    <input type="number" id="HD_Service_Time" name="HD_Service_Time" value="<?php echo $row['HD_Service_Time']?>" > Minutes
                    
                    </td>
                </tr> 
                <tr class="HD_Show">
                    <td>Number of person can deliver/ Home Delivery Service Time</td>
               
                    <td>
                        <input type="number" id="HD_No_of_Person" name="HD_No_of_Person" value="<?php echo $row['HD_No_of_Person']?>" >
                    
                    </td>
                </tr>
                
                <tr>
                     <td colspan="2"><input type="button" id="Update_Data" name="Update_Data" class="btn btn-primary" value="Update Data" style="background:orangered;border:orangered;font-weight:bold;"></td>
                </tr>    
                   
          

                     <?php  
                    }
                       
                }
                 mysqli_close($MyConnection);
                ?>
                                
                        
            </table> 
     
        </div>    
    </body>
</html>
