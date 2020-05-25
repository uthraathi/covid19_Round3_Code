<?php
require_once "config.php";

if (isset($_GET['searchkey'])) {
     
   $query = "SELECT PRODUCT_ID,PRODUCT_NAME FROM product_master WHERE PRODUCT_NAME like '%" . $_GET['searchkey'] . "%' AND product_type = 'G' order by PRODUCT_NAME";
   $result = mysqli_query($MyConnection, $query);
    $res = array();
    while($resultSet = mysqli_fetch_assoc($result)) {
     $res[$resultSet['PRODUCT_ID']] = $resultSet['PRODUCT_NAME'];
    }
    if(!$res) {
        $res[0] = 'Not found!';
    }
    echo json_encode($res);
    
}
?>