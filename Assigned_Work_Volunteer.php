<?php
require_once 'GO_Menu.php';

$STATE_CODE = $_SESSION['STATE_CODE'];
$USER_ID = $_SESSION['user_id'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>List of Assigned Work</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
               
                $('input[id$="Download"]').click(function () 
             
                {
                    //alert("Hi");
                    var vartr = $(this).closest('tr');
                    var WORK_ID = vartr.find('input[id$="WORK_ID"]').val();
                    
                    window.location.href= "Download_Wod_Assign.php?WORK_ID="+WORK_ID;

                });
            });
        </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">List of Assigned Work</h2>
 

            <table class="table">
                <tr style="background:yellowgreen;color:black;font-size:16px;font-weight:bold;">
                    <td>S.No</td>
                    <td>Category</td>
                    <td>Sub-Category</td>
                    <td>Work Title</td>
                    <td>Duration</td>
                    <td>Attachment</td>
                    <td>Volunteer ID</td>
                    <td>Volunteer Name</td>
                    <td>Volunteer Mobile</td>
                    <td>Volunteer Email</td>
                </tr>
                <?php
                require_once "config.php";
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 5;
                $offset = ($pageno-1) * $no_of_records_per_page;
                $total_pages_sql = "SELECT count(*) FROM volunteer_work_assign a, volunteer_registration V where a.GOV_ID = '$USER_ID' AND V.Vol_ID = A.VOL_ID ORDER BY A.CATEGORY,A.SUB_CATEGORY,A.START_DT";
                $result_sql = mysqli_query($MyConnection,$total_pages_sql);
                $total_rows = mysqli_fetch_array($result_sql)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $sql = "SELECT A.CATEGORY,A.SUB_CATEGORY,A.WORK_TITLE,A.WORK_PDF,A.START_DT,A.END_DT,A.vol_id,V.name,V.MOBILE,V.EMAIL,WORK_ID FROM volunteer_work_assign a, volunteer_registration V where a.GOV_ID = '$USER_ID' AND V.Vol_ID = A.VOL_ID ORDER BY A.CATEGORY,A.SUB_CATEGORY,A.START_DT LIMIT $offset,$no_of_records_per_page";


                 $result = mysqli_query($MyConnection, $sql);
                 $index = (int)0+(int)$offset;
                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $index++;
                        echo "<tr>";
                        echo "<td>". $index ."</td>";
                        echo "<td>". $row['CATEGORY'] ."</td>";
                        echo "<td>". $row['SUB_CATEGORY'] ."</td>";
                        echo "<td>". $row['WORK_TITLE'] ."</td>";
                        echo "<td>". $row['START_DT']." - ".$row['END_DT'] ."</td>";
                        echo "<td><input type='hidden' id = 'obj[". $index."].WORK_ID' name = 'obj[". $index."].WORK_ID' value=".$row['WORK_ID']."><input type='button' id = 'obj[". $index."].Download' name = 'obj[". $index."].Download' class='btn btn-primary' value='Download' style='background:orangered;border:#b5651d;font-weight:bold;'</td>";
                        echo "<td>". $row['vol_id'] ."</td>";
                        echo "<td>". $row['name'] ."</td>";
                        echo "<td>". $row['MOBILE'] ."</td>";
                        echo "<td>". $row['EMAIL'] ."</td>";
                        echo "</tr>";
                    }
                        
                }
                  

                 mysqli_close($MyConnection);
                ?>
                 <tr style="text-align:center;">
                    <td colspan="10">
                    <ul class="pagination">
                        <li><a href="?pageno=1">First</a></li>
                        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                        </li>
                        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                        </li>
                        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                    </ul>
                </td>
                </tr>                  
                        
            </table> 
     
        </div>    
    </body>
</html>
