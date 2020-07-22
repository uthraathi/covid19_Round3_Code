<?php
require_once 'IU_Menu.php';
$state_code = $_SESSION['STATE_CODE'];
$state_name = $_SESSION['STATE_NAME'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>e-Pass</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 700px; padding: 20px; }
        .error{color: #FF0000;}
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

            <script type="text/javascript">
            $(function()
            {
                $('.counterText').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text().replace(/,/g, '')
		}, {
		duration: 2000,
		easing: 'swing',
		step: function (now) {
				$(this).text(Math.ceil(now).toLocaleString());
			}
		});
            });
                
                $('.state_All').hide();
                var State = "<?php echo $state_code ?>";
                $('.'+State).show();
                $("#State").val(State);
                $('#State').prop('disabled', true);
                $("#State").change(function () {
                    var State  = $.trim($('#State').val());
                    if(State !== "Select")
                    {
                           $('.state_All').hide();
                           $('.'+State).show(); 
                        
                    }
                    else
                    {
                        alert("Choose State");
                        $("State").focus();
                        $('.state_All').hide();
                    }
                    
                });
            });
            </script>
    </head>
    <body>
        <div class="wrapper" style="margin:0 auto;" >
            <h2 style="color:#b5651d;">e-Pass</h2>
 <p><span class="error">* required field</span></p>
<!-- <p style="font-weight:bold;">This framework is being used by 17 states of India to provide movement e-Pass services during COVID-19 
     pandemic.</span>-->
 <div>
    
    <ol>
           <li>Any individual/group can apply for the movement pass using this framework.</li> 
           <li>Fill in all the mandatory details carefully and submit.</li>
           <li>Keep the scanned copy of the requisite documents before applying.</li>
           <li>Please use an active mobile number to receive verification OTP.</li>  
           <li>After successful submission of your application, an application reference number will get generated. Please note it to track the application status.</li>
           <li>The movement e-pass will contain your name, address, validity and a QR code.</li>
           <li>Keep a soft/hard copy of the e-pass while traveling and show it to the security personnel if asked.</li>
    </ol>
			
</div>
<!-- <div>
     <table class="table">
         <tr>
             <td>
                 <b>Applications Received</b>
                 <img  alt="icon" src="applied.png" height="50px;"/>
                 <h3 class="counterText">4070231</h3>
             </td>
             <td>
                 <b>E-Passes Issued</b>
                 <img  alt="icon" src="delivered.png" height="50px;"/>
                 <h3 class="counterText">1597233</h3>
             </td>
             <td>
                 <b>Applications Under Process</b>
                 <img  alt="icon" src="underprocess.png" height="50px;"/>
                 <h3 class="counterText">1115550</h3>
             </td>
             <td>
                 <b>E-Passes Rejected</b>
                 <img  alt="icon" src="rejected.png" height="50px;"/>
                 <h3 class="counterText">1357448</h3>
             </td>
         </tr>
     </table>
 </div>-->
     
          <table class="table">
                <tr>
                    <td>Choose State <span class="error"> * </span>
                    </td>
                    <td>
                        <select id="State" name="State">
                                    <option value="Select" selected="selected" >Select State to Apply e-Pass</option>
                                    <?php
                                    require_once "config.php";

                                    $sql = "SELECT * FROM state_master order by STATE_NAME asc ";
                                    $result = mysqli_query($MyConnection, $sql);

                                     if (mysqli_num_rows($result) > 0) 
                                     {
                                        while($row = mysqli_fetch_assoc($result)) 
                                        {
                                            echo "<option value='".$row['STATE_CODE']."'>" . $row['STATE_NAME'] . "</option>";
                                        }
                                     } 
                                     
                                     mysqli_close($MyConnection);
                                    ?>
                              </select>
                    </td>
                    
                </tr>
                <tr>
                    <td class="state_All AD" colspan="2">
                        <a href="https://serviceonline.gov.in/directApply.do?serviceId=1404">Issuance of COVID-19 ePass</a>
                    </td>
                    <td class="state_All AR" colspan="2">
                        <a href="https://eservice.arunachal.gov.in/directApply.do?serviceId=1413">COVID-19 Application for ePermit for stranded PERSON AND MIGRANT LABOURERS</a><br>
                        <a href="https://eservice.arunachal.gov.in/directApply.do?serviceId=612">COVID-19 Vehicle Pass for Essential Service</a><br>
                        <a href="https://eservice.arunachal.gov.in/directApply.do?serviceId=1388">COVID-19 Application for e-Permit for Exempted Activities during Lockdown</a>

                    </td>
                    <td class="state_All AS" colspan="2">
                        <a href="http://eservices.assam.gov.in/directApply.do?serviceId=1533">Issuance of Essential Service Pass</a><br>
                        <a href="http://eservices.assam.gov.in/directApply.do?serviceId=1549">Issuance of e-Pass for delivery of essential commodities</a><br>
                        <a href="http://eservices.assam.gov.in/directApply.do?serviceId=1551">e-Pass for Inter State Stranded Persons</a>
                    </td>
                    <td class="state_All BR" colspan="2">
                        <a href="https://serviceonline.bihar.gov.in/directApply.do?serviceId=1172">Issuance of e-Pass for COVID-19 Disaster</a>
                    </td>
                    <td class="state_All HR" colspan="2">
                        <a href="https://saralharyana.gov.in/directApply.do?serviceId=1505">MOVEMENT PASS FOR COVID-19 CURFEW/LOCKDOWN</a>
                    </td>
                    <td class="state_All HP" colspan="2">
                        <a href="https://serviceonline.gov.in/directApply.do?serviceId=1373">Issuance of COVID-19 Curfew ePass for Vehicle Movement</a><br>
                        <a href="https://serviceonline.gov.in/directApply.do?serviceId=1387">Surveillance of Quarantine Persons-Entered from Outside Himachal Pradesh</a>
                    </td>
                    <td class="state_All JK" colspan="2">
                        <a href="https://serviceonline.gov.in/directApply.do?serviceId=1371">ISSUANCE OF COVID19 MOVEMENT ePASS - Jammu & Kashmir</a>
                    </td>
                    <td class="state_All KA" colspan="2">
                        <a href="https://serviceonline.gov.in/karnataka/directApply.do?serviceId=1085">Covid-19: Apply here to travel to Karnataka from other country</a><br>
                        <a href="https://serviceonline.gov.in/karnataka/directApply.do?serviceId=1082">Covid-19: Apply here to travel to Karnataka from other Indian states</a><br>
                        <a href="https://serviceonline.gov.in/karnataka/directApply.do?serviceId=1084">Covid-19 : Apply here to travel to other Indian states from Karnataka</a>
                    </td>
                    <td class="state_All KL" colspan="2">
                        <a href="https://covid19jagratha.kerala.nic.in/home/addDomestic">Issuance of COVID-19 ePass to travel to Kerala from other states</a><br>
                        <a href="https://covid19jagratha.kerala.nic.in/home/addMedicalEmergencyPass">Issuance of COVID-19 ePass to travel to other states from Kerala and inside Kerala</a><br>
                        <a href="https://services.keralaexcise.gov.in/directApply.do?serviceId=1362">Liquor Issue Pass for Dependent Individuals during COVID-19 emergency</a>
                    </td>
                    <td class="state_All LA" colspan="2">
                        <a href="https://serviceonline.gov.in/directApply.do?serviceId=1374">Issuance of COVID-19 ePass for Vehicle Movement - Ladakh</a>
                    </td>
                    <td class="state_All LD" colspan="2">
                        <a href="https://serviceonline.gov.in/directApply.do?serviceId=1400">Covid19 Movement Pass</a><br>
                        <a href="https://serviceonline.gov.in/directApply.do?serviceId=1401">Covid19 Stranded Person Registration</a>
                    </td>
                    <td class="state_All MH" colspan="2">
                        <a href="https://serviceonline.gov.in/directApply.do?serviceId=1366">ISSUANCE OF PASSES TO GOODS VEHICLE</a>
                    </td>
                    <td class="state_All ML" colspan="2">
                        <a href="https://megedistrict.gov.in/directApply.do?serviceId=1146">ISSUANCE OF e-CURFEW PASS</a><br>
                        <a href="https://megedistrict.gov.in/directApply.do?serviceId=1150">eTransit Pass for citizens of Meghalaya</a>
                    </td>
                    <td class="state_All NL" colspan="2">
                        <a href="https://serviceonline.gov.in/directApply.do?serviceId=1398">Issuance of e-Pass for people movement</a>
                    </td>
                    <td class="state_All OD" colspan="2">
                        <a href="https://edistrict.odisha.gov.in/directApply.do?serviceId=1390">Issuance of COVID-19 ePass For Odisha</a>
                    </td>
                    <td class="state_All PY" colspan="2">
                        <a href="https://epass.py.gov.in/">ePass system for Puducherry</a>
                    </td>
                    <td class="state_All SK" colspan="2">
                        <a href="https://eservices.sikkim.gov.in/directApply.do?serviceId=1364">e-Pass for Covid 19 Curfew</a>
                    </td>
                    <td class="state_All TN" colspan="2">
                        <a href="https://tnepass.tnega.org/">e-Pass Tamil Nadu</a>
                    </td>
                    <td class="state_All TR" colspan="2">
                        <a href="https://edistrict.tripura.gov.in/directApply.do?serviceId=874">ePass for movement amid COVID-19 Pandemic</a>
                    </td>
                    <td class="state_All UP" colspan="2">
                        <a href="http://164.100.68.164/upepass2/">ePass Management System by Uttar Pradesh</a>
                    </td>
                    <td class="state_All PB" colspan="2">
                        <a href="https://epasscovid19.pais.net.in/">ePass Management System by Punjab</a><br>
                        <a href="https://corona.punjab.gov.in/">Punjab Corona Dashboard</a>
                    </td>
                </tr>
          </table>
        </div>  
           
               
    </body>
</html>
