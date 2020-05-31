<?php
session_start();
if(!isset($_SESSION['user_id']))
{
    header('location:index.php');
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 400px; padding: 20px; }
        .error{color: #FF0000;}
         /* Navbar container */
.navbar {
  overflow: hidden;
  background-color: #b5651d;
  font-family: Arial;
}

/* Links inside the navbar */
.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* The dropdown container */
.dropdown {
  float: left;
  overflow: hidden;
}

/* Dropdown button */
.dropdown .dropbtn {
  font-size: 16px;
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit; /* Important for vertical align on mobile phones */
  margin: 0; /* Important for vertical align on mobile phones */
}

/* Add a red background color to navbar links on hover */
.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: whitesmoke;
  color: black;
}

/* Dropdown content (hidden by default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

/* Add a grey background color to dropdown links on hover */
.dropdown-content a:hover {
  background-color: #ddd;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
} 
        </style>
     
    </head>
    <body>
         <div class="navbar">
  <a href="Product_Add.php">Product Add</a>
  <a href="Prod_List.php">Product List</a>
  <a href="Shop_Keepe_Reg.php">Shop Keeper Add</a>
  <a href="Shop_Keepe_List.php">Shop Keeper List</a>
  <a href="RS_Add.php">Ration Shop Add</a>
  <a href="Ration_Shop_List.php">Ration Shop List</a>
  <a href="Ration_Product_Add.php">Ration Product Add</a>
  <a href="Ration_Product_List.php">Ration Product List</a>
  <a href="Logout.php">Logout</a>
  
</div> 
           <table style="float: right;font-size:18px;color: orchid;font-weight:bold;margin-right:20px;">
            <tr>
                <td style="color:black;">User Name: </td>
                <td> <?php echo $_SESSION['User_Name']?></td>
            </tr>
            <tr>
                <td style="color:black;">User Category: </td>
                <td><?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else if($_SESSION['user_category'] === "RS") echo "Ration Shop" ; else echo "Shop Keeper"; ?></td>
            </tr>
        </table>
    </body>
</html>