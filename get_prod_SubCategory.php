<?php
require_once "config.php";
//define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'eshopping');
$list = "<select id='Prod_Sub_Category' name='Prod_Sub_Category'> <option value='Select'>Select</option>";
/* Attempt to connect to MySQL database */
//$MyConnection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!empty($_GET['Prod_Cat'])) 
{
        $Prod_Cat = $_GET["Prod_Cat"];           
	$sql ="SELECT Sub_Category FROM product_category_master WHERE category_name  = '$Prod_Cat' order by Sub_Category";
	$result = mysqli_query($MyConnection, $sql);
        if (mysqli_num_rows($result) > 0) 
        { 
           while($row = mysqli_fetch_assoc($result)) 
           {
              $list = $list. "<option value='".$row['Sub_Category']."'>" . $row['Sub_Category'] . "</option>";
           }
           $list = $list."</select>";
        } 
         mysqli_close($MyConnection);
}
echo $list;
?>