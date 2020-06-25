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
        .wrapper{ width: 400px; padding: 10px; }
        .error{color: #FF0000;}
        #Useridentification
	{
            width:18.5%;
            height:90px;
            background-color:#b5651d;
            float:right;
            color:White;
            font-size:18px;
        } 
#navi
{
        border-radius:7px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
	background-color:#b5651d;
	font-size:medium;
	font-family: Arial;
        font-weight: bold;
	height:32px;
	margin: 0 auto;
	width:100%;
	z-index:800;
        padding: 8px 10px;
	-o-transform-origin:center;
}
#navi ul {
	list-style: none;
	margin: 0 auto;
	padding-top:5px;
	height:5px;
     
	
}
#navi li
{
	display:inline;
	list-style: none;
	position:relative;
	z-index : 1000;
	padding:0 auto;
 
	
}
#navi a:link,#navi a:visited {
	padding: 0.4em 1em 0.4em 1em;
	color:GreenYellow;
	background-color:#b5651d;
        text-decoration: none;
	/*border: 1px solid blue;*/
}
#navi a:hover {
	color: #FFFFFF;
	background-color:#b5651d;
}
.hasChildren {
	position: absolute;
	width: 2px; height: 5px;
	background: black;
	right : 0;
	bottom: 0;
}

#navi li ul {
 display: none;
 position: absolute;
 left: 0;
 top: 100%;
 padding-left:0;
 padding-top:5px;
 width:75%;
 
}

#navi li:hover > ul {
 display: block;
}

#navi li ul li, #nav li ul li a {
 float:left;
 padding-left:0;
 padding-top:0px;
 
}

#navi li ul li {
 _display: inline; /* for IE6 */
}

#navi li ul li a {
 width: 150px;
 display: block;
}

/* SUBSUB Menu */

#navi li ul li ul {
 display: none;
}

#navi li ul li:hover ul {
 left: 100%;
 top: 0;
}

        </style>
     
    </head>
    <body>
<div id="navi">
    
    <li>
        <a href=\"#\">e-Shopping <img src="arrow-down.png" style="height:20px;width:20px;"/></a>
        
        <ul>
            <li>
                <a href="IU_Shop_by_Category.php">Purchase Online</a>
            </li>
            <li>
                <a href="IU_Order_Status.php">Order Status</a>
            </li>
            <li>
               <a href="IU_Order_His.php">Order History</a>
            </li>
        </ul>
    </li>
  <li>
        <a href=\"#\">e-Ration Shop <img src="arrow-down.png" style="height:20px;width:20px;"/></a>
        <ul>
            <li>
                <a href="IU_Ration_Shop.php">Purchase Online</a>
            </li>
            <li>
                <a href="IU_RS_Status.php">Order Status</a>
            </li>
            <li>
               <a href="IU_RS_Order_His.php">Order History</a>
            </li>
        </ul>
    </li>
    <li><a href=\"#\">e-Pass <img src="arrow-down.png" style="height:20px;width:20px;"/></a>
        <ul>
            <li>
                <a href="Unified_epass.php">Apply Online</a>
            </li>
        </ul>
    </li>
  <li><a href=\"#\">Personal Info <img src="arrow-down.png" style="height:20px;width:20px;"/></a>
        <ul>
            <li>
                <a href="Add_Family.php">Family Details</a>
            </li>
            <li>
               <a href="About_User.php">About User</a> 
            </li>
        </ul>
    </li>
    <li><a href="Logout.php">Logout</a></li>
</div>
        <table id="Useridentification">
            <tr>
                <td style="color:greenyellow;font-weight:bold;">Name: </td>
                <td> <?php echo $_SESSION['User_Name']?></td>
            </tr>
            <tr>
                <td style="color:greenyellow;font-weight:bold;">Category: </td>
                <td><?php if ($_SESSION['user_category'] === "IU") echo "Individual User"; else if($_SESSION['user_category'] === "GO") echo "Government Official" ; else if($_SESSION['user_category'] === "RS") echo "Ration Shop" ; else echo "Shop Keeper"; ?></td>
            </tr>
        </table>

    </body>
</html>