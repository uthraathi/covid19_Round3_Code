<?php

require_once 'IU_Menu.php';
require_once "config.php";
$st_code = $_SESSION['STATE_CODE'];
$user_id = $_SESSION['user_id'];
$link="";
$sql_q = "SELECT TESTING_CENTERS_LINK FROM state_master WHERE STATE_CODE  = '$st_code'";
$result_q = mysqli_query($MyConnection, $sql_q);

 if (mysqli_num_rows($result_q) > 0) 
 {
    while($row_q = mysqli_fetch_assoc($result_q)) 
    {
        $link = $row_q['TESTING_CENTERS_LINK'];
        
    }
 } 
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TESTING CENTERS</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 100%; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(function(){
                
            });
            </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">TESTING CENTERS</h2>
 
            <div><iframe src="<?php echo $link;?>" width="1000" height="450"></iframe></div>
            <div><p>Source: <a href="/Covid19/Testing_Centers_PDF/COVID_Testing_Labs_29072020.pdf">Private & Government Testing Centers;</a></p></div>
     
        </div>    
    </body>
</html>
