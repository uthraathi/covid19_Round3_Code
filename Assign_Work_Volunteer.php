<?php
require_once 'Go_Menu.php';
require_once 'config.php';
$state_code = $_SESSION['STATE_CODE'];
$state_name = $_SESSION['STATE_NAME'];
$pincode = $_SESSION['PINCODE'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Work Assignment</title>
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
                 $('#NI_Submit').click(function() 
                 {
                    var Category = $.trim($('#CATEGORY').val());
                    var Sub_Category = $.trim($('#Sub_Category').val());
                    var Work_Title = $.trim($('#Work_Title').val());
                    var Start_dt = $.trim($('#Start_dt').val());
                    var End_dt = $.trim($('#End_dt').val());
                    var Req_Volu = $.trim($('#Req_Volu').val());
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
                            else
                            {
                                $('#Sub_Cat_err').empty();
                                if(Work_Title === '')
                                {
                                    $('#Title_Err').empty();
                                    $('#Title_Err').append('<span style="color:red;">Enter Work Title</span>');
                                }
                                else
                                {
                                    $('#Title_Err').empty();   
                                    if(Start_dt === '')
                                    {
                                        $('#Startdt_Err').empty();
                                        $('#Startdt_Err').append('<span style="color:red;">Enter Start Date</span>');
                                    }
                                    else
                                    {
                                        $('#Startdt_Err').empty();
                                        if(End_dt === '')
                                        {
                                            $('#Enddt_Err').empty();
                                            $('#Enddt_Err').append('<span style="color:red;">Enter End Date</span>');
                                        }
                                        else
                                        {
                                            $('#Enddt_Err').empty();
                                            if(Req_Volu === '')
                                            {
                                                $('#Req_Volu_Err').empty();
                                                $('#Req_Volu_Err').append('<span style="color:red;">Enter Number of Volunteers required</span>');
                                            }
                                            else
                                            {
                                                var data = new FormData();
                                                data.append('Category', Category);
                                                data.append('Sub_Category', Sub_Category);
                                                data.append('Start_dt', Start_dt);
                                                data.append('End_dt', End_dt);
                                                data.append('Work_Title', Work_Title);
                                                data.append('Req_Volu', Req_Volu);
                                                data.append('Work_Doc', $('input[type=file]')[0].files[0]);
                                                $.ajax
                                                ({
                                                    url: 'post_Volunteer_Work_Assign.php',
                                                    data: data,
                                                    type: 'POST',
                                                    contentType: false,
                                                    processData: false,
                                                    success: function(response) {
                                                         var result = JSON.parse(response);

                                                         if(result.status === "S")
                                                         {
                                                             alert(result.msg);
                                                             window.location.href="Assign_Work_Volunteer.php";
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
                });
                 $('#CATEGORY').change(function(){
                   var CATEGORY = $('#CATEGORY').val();
                    if(CATEGORY !== "Select")
                    {   
                        $.ajax
                        ({          
                            type: "GET",
                            url: "get_NI_Volun_Sub_Cat.php",
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
            });
            </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">Volunteers - Work Assignment</h2>
                    <p><span class="error">* required field</span></p>
                    <table class="table">
                       
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
                            <td>Work Title<span class="error"> * </span></td>
                            <td><input type="text" id="Work_Title" name="Work_Title" class="form-control" ></td>
                            <td id="Title_Err"></td>
                        </tr>
                        <tr>
                            <td>Work Starts on<span class="error"> * </span></td>
                            <td>
                                <input type="Date" id="Start_dt" name="Start_dt" >
                            </td>
                            <td id="Startdt_Err"></td>
                        </tr>
                        <tr>
                            <td>Work Ends on<span class="error"> * </span></td>
                            <td>
                                <input type="Date" id="End_dt" name="End_dt" >
                            </td>
                            <td id="Enddt_Err"></td>
                        </tr>
                         <tr>
                            <td>Number of volunteer(s) required<span class="error"> * </span></td>
                            <td>
                                <input type="number" id="Req_Volu" name="Req_Volu" value="1">
                            </td>
                            <td id="Req_Volu_Err"></td>
                        </tr>
                        <tr>
                            <td>Work Assignment related document<span class="error"> * </span></td>
                            <td>
                                <input type="file" id="Work_Assigned" name="Work_Assigned" accept=".pdf">
                            </td>
                            <td id="Work_Assign_Err"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="submit" class="btn btn-primary button" id="NI_Submit" name="NI_Submit" value="Check Availability & Assign Work" style="background:orangered;border:orangered;font-weight:bold;float:right;">
                                
                            </td>
                        </tr>
                    </table>
           
      

        </div>    
    </body>
</html>
