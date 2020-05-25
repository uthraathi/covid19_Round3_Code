<?php
require_once "config.php";
//define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'eshopping');
$list = "<select id='Prod_Name' name='Prod_Name'> <option value='Select'>Select</option>";
/* Attempt to connect to MySQL database */
//$MyConnection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!empty($_GET['Prod_Cat'])) 
{
        $Prod_Cat = $_GET["Prod_Cat"];     
        $Prod_Sub_Category = $_GET["Prod_Sub_Category"]; 
	$sql ="SELECT PRODUCT_NAME FROM product_master WHERE CATEGORY  = '$Prod_Cat' and Sub_Category = '$Prod_Sub_Category' order by PRODUCT_NAME";
	$result = mysqli_query($MyConnection, $sql);
        if (mysqli_num_rows($result) > 0) 
        { 
           while($row = mysqli_fetch_assoc($result)) 
           {
              $list = $list. "<option value='".$row['PRODUCT_NAME']."'>" . $row['PRODUCT_NAME'] . "</option>";
           }
           $list = $list."</select>";
        } 
         mysqli_close($MyConnection);
}
echo $list;
?>