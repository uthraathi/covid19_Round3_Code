<?php  
require_once "config.php";
$order_id = (int)$_GET['order_id'];
 function fetch_data()  
 {  
      $output = ''; 
      $order_id =(int)$_GET['order_id'];
      $index = (int)0;
      $connect = mysqli_connect("localhost", "root", "", "eshopping");  
      $sql = "SELECT u.USER_ID,u.SHOP_ID,p.PRODUCT_ID,m.PRODUCT_NAME,p.QUANTITY, p.sub_total,p.price FROM ration_ordered_product_list p, ration_shop_order u, ration_shop_product_list s,ration_product_master m WHERE u.ORDER_ID = '$order_id' and u.ORDER_STATUS > 1 and u.ORDER_ID = p.ORDER_ID and s.PRODUCT_ID = p.PRODUCT_ID and u.SHOP_ID=s.rs_unique_id  and m.PRODUCT_ID = s.PRODUCT_ID";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {    
          $index++;
      $output .= '<tr>  
                        <td>'.$index.'</td> 
                          <td>'.$row["PRODUCT_NAME"].'</td>  
                          <td>'.$row["price"].'</td>
                          <td>'.$row["QUANTITY"].'</td>  
                          <td>'.$row["sub_total"].'</td>  
                         
                     </tr>  
                          ';  
      }  
      return $output;  
 }  
 function fetch_ShopDetails()  
 {  
      $output = ''; 
      $order_id =(int)$_GET['order_id'];
      $index = (int)0;
      $connect = mysqli_connect("localhost", "root", "", "eshopping");  
      $sql = "SELECT u.*,s.* FROM ration_shop_order u,ration_shop_register s where u.ORDER_ID='$order_id' and u.ORDER_STATUS > 1 and s.RS_INC_ID = u.SHOP_ID order by u.ORDER_DATE desc";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {    
          $index++;
        $delivery_time = date('d-m-Y h:i A',strtotime($row['delivery_time']));
        if ($row['delivery_option'] === 'H')
        {
            $Service_time = (int) $row['HD_Service_Time'] *60;
        }
        else
        {
            $Service_time = (int) $row['Service_Time'] *60;
        }
        $delivery_totime = date('h:i A',strtotime($row['delivery_time'])+ $Service_time) ;   
      $output = "<label><u>Shop Details</u></label><br/>". $row['BUILD_NO'] .", ".$row['STREET'].", <br/>". $row['CITY'].", <br/>". $row['DISTRICT'].", <br/>". $row['STATE']." - ". $row['PINCODE']."<br/>";  
      $output .= "<label><u>Order Id:</u> ".$order_id."<br/>";  
      $output .= "<label><u>Order Date:</u> ".date('d-m-Y',strtotime($row['ORDER_DATE']))."<br/>";
      $output .= "<label><u>Delivery Time Slot:</u> ".$delivery_time." - ".$delivery_totime."<br/>";
      }  
      return $output;  
 } 
 function fetch_total()  
 {  
      $output1 = ''; 
      $order_id1 =(int)$_GET['order_id'];
    
      $connect = mysqli_connect("localhost", "root", "", "eshopping");  
      $sql = "SELECT sum(sub_total) as total from ration_ordered_product_list where ORDER_ID='$order_id1'";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {    
       
      $output1 .= '<tr>  
                            <td></td> 
                          <td></td>  
                          <td></td>  
                          <td><b>Total</b></td>  
                          <td><b>'.$row["total"].'</b></td>  
                         
                     </tr>  
                          ';  
      }  
      return $output1;  
 }  
 if(isset($_POST["create_pdf"]))  
 {  
      require_once('tcpdf_min/tcpdf.php');  
     
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Ration Shop - Order Invoice");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 12);  
      $obj_pdf->AddPage();  
      $content = ''.fetch_ShopDetails();  
      $content .= '  
      <h3 align="center">Ration Shop - Order Invoice</h3><br /><br />  
      <table border="1" cellspacing="0" cellpadding="5">  
           <tr>  
                                <th width="5%">S.No</th>  
                               <th width="45%">Product Name</th>  
                               <th width="15%">Product Price</th>  
                               <th width="15%">Quantity</th>  
                               <th width="20%">Sub-Total</th> 
                 
           </tr>  
      ';  
      $content .= fetch_data().fetch_total();
     
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('Order_Invoice.pdf', 'I');  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Ration Shop - Order Invoice</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />            
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:700px;">  
                <h3 align="center">Ration Shop - Order Invoice</h3><br />  
                <div class="table-responsive"> 
                    <?php  
                    echo fetch_ShopDetails();
                    ?>
                     <table class="table table-bordered">  
                          <tr> 
                               <th width="5%">S.No</th>  
                               <th width="45%">Product Name</th>  
                               <th width="15%">Product Price</th> 
                               <th width="15%">Quantity</th>  
                               <th width="25%">Sub-Total</th>  
                               
                          </tr>  
                     <?php  
                     echo fetch_data();  
                     echo fetch_total();
                     ?>  
                     </table>  
                     <br />  
                     <form method="post">  
                          <input type="submit" name="create_pdf" class="btn btn-danger" value="Download Invoice" style="background:orangered;border:#b5651d;font-weight:bold;"/>  
                     </form>  
                </div>  
           </div>  
      </body>  
 </html>  
