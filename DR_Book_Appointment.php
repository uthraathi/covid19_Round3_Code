<?php
require_once 'IU_Menu.php';
$state_code = $_SESSION['STATE_CODE'];
$state_name = $_SESSION['STATE_NAME'];
$PINCODE = $_SESSION['PINCODE'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Doctor Appointment - Online Booking</title>
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
              
               $('#SK_Add').click(function() {
                
                
                var doc_id = $.trim($('#doc_id').val());
             
           
                        if(doc_id === 'Select')
                        {
                            $('#doc_err').empty();
                            $('#doc_err').append('<span style="color:red;">Select Doctor Name</span>');
                        }
                        else
                        {
                            $('#doc_err').empty();
                           $.ajax
                            ({
                                type: 'POST',
                                url: 'post_IU_DR_Appointment.php',
                                data: {doc_id:doc_id},
                                success: function(response) {
                                     var result = JSON.parse(response);
                                     //alert(result.status);
                                     if(result.status === "S")
                                     {
                                         alert(result.msg);
                                         window.location.href="DR_Book_Appointment.php";
                                     }
                                     else
                                     {
                                         alert(result.msg);
                                    }
                                }
                            });
                               
                            
                        }
               
                });
            });
            </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Doctor Appointment - Online Booking</h2>
 <p><span class="error">* required field</span></p>

            <table class="table">
 
                        <tr>
                            <td>Doctor Name<span class="error"> * </span></td>
                            <td>
                                 <select id="doc_id" name="doc_id"  class="form-control">
                                    <option value="Select" selected="selected" >-- Select Doctor -- </option>
                                    <?php
                                    require_once "config.php";

                                    $sql_S = "select h.*,d.SPECIALIZATION,d.NAME as doc_name,d.UNIQUE_ID as doc_id from doctor_registration d, hospital_registration h where h.PINCODE = '$PINCODE' and h.UNIQUE_ID = d.HOSPITAL_ID order by h.UNIQUE_ID,d.UNIQUE_ID";
                                    $result_S = mysqli_query($MyConnection, $sql_S);

                                     if (mysqli_num_rows($result_S) > 0) 
                                     {
                                        while($row_S = mysqli_fetch_assoc($result_S)) 
                                        {
                                            echo "<option value='".$row_S['doc_id']."'>Dr. " . $row_S['doc_name'] ." (".$row_S['SPECIALIZATION'].") "." --> ".$row_S['hospital_name']. "</option>";
                                        }
                                     } 
                                     
                                     
                                    ?>
                              </select>
                            </td>
                            <td id="doc_err"></td>
                        </tr>

                        <tr>
                            <td colspan="3">
                                <input type="submit" id="SK_Add" name="SK_Add" class="btn btn-primary" value="BOOK AN APPOINTMENT" style="background:orangered;border:orangered;font-weight:bold;">
                            </td>
                        </tr>
            </table> 
     
        </div>    
    </body>
</html>