<?php
require_once "config.php";

$list = "<select id='District' name='District'> <option value='Select'>--Select District--</option>";


if(!empty($_GET['State_code'])) 
{
        $State_code = $_GET["State_code"];           
	$sql ="SELECT DISTRICT FROM statewise_district_master WHERE STATE_CODE  = '$State_code' order by DISTRICT";
	$result = mysqli_query($MyConnection, $sql);
        if (mysqli_num_rows($result) > 0) 
        { 
           while($row = mysqli_fetch_assoc($result)) 
           {
              $list = $list. "<option value='".$row['DISTRICT']."'>" . $row['DISTRICT'] . "</option>";
           }
           $list = $list."</select>";
        } 
         mysqli_close($MyConnection);
}
echo $list;
?>