<?php
require_once "config.php";

$list = "<select id='Sub_Category' name='Sub_Category'> <option value='Select'>--Select Sub-Category--</option>";


if(!empty($_GET['CATEGORY'])) 
{
        $CATEGORY = $_GET["CATEGORY"];           
	$sql ="SELECT SUB_CATEGORY FROM voulteer_category_master WHERE CATEGORY  = '$CATEGORY' order by SC_TYPE,SUB_CATEGORY";
	$result = mysqli_query($MyConnection, $sql);
        if (mysqli_num_rows($result) > 0) 
        { 
           while($row = mysqli_fetch_assoc($result)) 
           {
              $list = $list. "<option value='".$row['SUB_CATEGORY']."'>" . $row['SUB_CATEGORY'] . "</option>";
           }
           $list = $list."</select>";
        } 
         mysqli_close($MyConnection);
}
echo $list;
?>