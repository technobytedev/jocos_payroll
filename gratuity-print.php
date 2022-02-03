<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title style="font-size: 1px;">File>Gratuity>CS</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
</head>
<body onload="window.print()">
    <style>

        title {
            color: white!important;
        }

  
        @page {
       
        margin-left: 10px;
        margin-right: 10px;
        padding: 0;
            
      
        }

        
    @page {
        footer {
        display: none;
        }
        header {
        display: none;
        }
    }
  
   


        @media print {
            table { page-break-inside:auto }
             tr    { page-break-inside:avoid; page-break-after:auto }


        }



        @media print{@page {size: landscape}}

        .monthrate {
            width: 300px;
        }
        
        .total {
            letter-spacing: 2px; 
        }

        .heading {
            text-align: center;
            
            letter-spacing: 3px;
            margin-bottom: -7px;
        }
        table,td, th {
        border: 2px solid grey;
        }
        .head-right {
            text-align:right;
        
        }
        .head-left {
            text-align:left;
        
        }
        body {
            background: none;
        }
        th,p,td {
            font-size: 12px;
        }
        th, td{
            padding:10px;
        }
        .last-td {
            border:none;
        }

    </style>

   

        <center>
        <div style="height: 100%; width:98%">


        <h3 class="heading">GRATUITY PAYROLL</h3>
        <p style="text-align:center; margin-bottom:30px">OFFICE OF THE GOVERNOR</p>
        
       

        <div class="row">
            <div class="col-md-2 col-sm-2">
            <p class="head-left">LGU PROVINCE OF NEGROS OCCIDENTAL </p>
            
            </div>

            <div class="col-md-2 col-sm-2">
            <p class="head-left">CHARGE TO: 1011</p>
            
            </div>

            <div class="col-md-2 col-sm-2">
            <p class="head-left">REF. #: <?php echo $pid = $_GET['payroll_id']; ?></p>
            
            </div>

            <div class="col-md-2 col-sm-2">
            <p class="head-left" style=" line-height: 88%;">OFFICE: <?php 

            include('db.php');
            
            $query = mysqli_query($db, "SELECT DISTINCT officecode FROM gratuity_tbl WHERE payroll_id = '$pid' ");
            while($row = mysqli_fetch_array($query)) {
                $officecodes[] = $row['officecode'];
            }

            foreach($officecodes as $officecode) {


                $query = mysqli_query($db, "SELECT * FROM department WHERE officecode = '$officecode' ");
            if($row = mysqli_fetch_array($query)) {
                $officenames[] = $row['officename'];
            }


            }


          
            
            //put comma after every office
           $numItems = count($officenames);
            $i = 0;
            foreach($officenames as $key=>$value) {
             
              
               if(++$i == $numItems) {
                 echo $value;                
              }else {
                echo $value.", ";
              }
            }   


            ?></p>
            
            </div>

            <div class="col-md-2 col-sm-2">
            <p class="head-right">MODE OF PAYMENT: ATM DOWNLOADING</p>
            
            </div>
         
            
            <div class="col-md-2 col-sm-2">
            <p class="head-right">PERIOD JAN. 1 - DEC. 31, 2021 </p>
            
            </div>
        </div> 


        <table style="width:100%">
  <tr>
    <th style="width:30%">Name</th>
    <th style="width:25%">Designation</th>
    <th style="width:9%">Monthly Rate</th>
    <th style="width:8%">Gratuity Pay</th>
    <th style="width:7%">Tax</th>
    <th style="width:7%">Net Pay</th>
    <th style="width:12%">Signature or Thumbmark</th>
  </tr>

  <?php




if(isset($_GET['payroll_id'])) {

    $p_id = $_GET['payroll_id'];

    $query = mysqli_query($db, "SELECT gratuity_tbl.*, employment_info.*, position.* 
                                FROM gratuity_tbl 
                                INNER JOIN employment_info
                                ON gratuity_tbl.name_id = employment_info.employeeno
                                INNER JOIN position
                                ON employment_info.positioncode = position.positioncode
                                WHERE payroll_id = '$p_id' ORDER BY surname");
    $num = 0;
    $gross = 0;
    $netpay = 0;
    $total_tax = 0;
    $monthly = 0;
    $total_gratuity_net = 0;

    while($row = mysqli_fetch_array($query)) {

        $num += 1;

        $monthly = $monthly + $row['salaryrate'];


?>
  <tr>
    <td><?php

    if($row['middlename'] == '') {
        echo $num.". ".$row['employeeno']." ".$row['surname'].", ".$row['firstname']." ".$row['extension'];
    }else {
         echo $num.". ".$row['employeeno']." ".$row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0];
    }

     ?></td>
    <td><?php if($row['employmenttype'] == "CS") { echo $row['position']."(COS)"; } else { echo $row['position']."(JO)"; } ?></td>
    <td><?php echo number_format((float)$row['salaryrate'], 2, '.', ','); ?></td>
    <td>

    <?php //gratuity pay//

if( $row['effectivitydate'] <= '2021-08-15') {
     
            echo number_format((float)5000, 2, '.', ','); 
            $gross = $gross + 5000;
       
}
else if($row['effectivitydate'] <= '2021-09-15') {

        
            echo number_format((float)4000, 2, '.', ','); 
            $gross = $gross + 4000;
}
else if($row['effectivitydate'] <= '2021-10-15') {

        
    echo number_format((float)3000, 2, '.', ','); 
    $gross = $gross + 3000;

} else {

        
    echo number_format((float)2000, 2, '.', ','); 
    $gross = $gross + 2000;
} 
?>

    </td>
    <td>

    <?php 
//TAX


if($row['effectivitydate'] <= '2021-08-15') {
        
        $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 5000 - (5000 * $percentage);
            $tax = 5000 - $netpay;
            echo number_format((float)$tax, 2, '.', ','); 

            $total_tax = $total_tax + $tax;
            

        } else {
          
        }
}
else if($row['effectivitydate'] <= '2021-09-15') {

        $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 4000 - (4000 * $percentage);
            $tax = 4000 - $netpay;
            echo number_format((float)$tax, 2, '.', ','); 

            $total_tax = $total_tax + $tax;

        } else {
            
        }
}
else if($row['effectivitydate'] <= '2021-10-15') {
    $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 3000 - (3000 * $percentage);
            $tax = 3000 - $netpay;
            echo number_format((float)$tax, 2, '.', ','); 

            $total_tax = $total_tax + $tax;

        } else {
            
        }
}

else  {

    $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 2000 - (2000 * $percentage);
            $tax = 2000 - $netpay;
            echo number_format((float)$tax, 2, '.', ','); 

            $total_tax = $total_tax + $tax;

        } else {
            
        }

} 


?>

    </td>
    <td>
    
    <?php 

////NET PAY of gratuity

if($row['effectivitydate'] <= '2021-08-15') {
        
        $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 5000 - (5000 * $percentage);
            echo number_format((float)$netpay, 2, '.', ','); 
             $total_gratuity_net = $total_gratuity_net + 5000;
            

        } else {

            echo number_format((float)5000, 2, '.', ','); 
            $total_gratuity_net = $total_gratuity_net + 5000;
          
        }
}
else if($row['effectivitydate'] <= '2021-09-15') {

        $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 4000 - (4000 * $percentage);
            echo number_format((float)$netpay, 2, '.', ','); 
             $total_gratuity_net = $total_gratuity_net + 4000;

        } else {

            echo number_format((float)4000, 2, '.', ','); 
            $total_gratuity_net = $total_gratuity_net + 4000;
            
        }
}
else  if($row['effectivitydate'] <= '2021-10-15') {
    $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 3000 - (3000 * $percentage);
            echo number_format((float)$netpay, 2, '.', ','); 
             $total_gratuity_net = $total_gratuity_net + 3000;

        } else {

            echo number_format((float)3000, 2, '.', ','); 
            $total_gratuity_net = $total_gratuity_net + 3000;
            
        }
}

else {

    $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 2000 - (2000 * $percentage);
           
            echo number_format((float)$netpay, 2, '.', ','); 
            $total_gratuity_net = $total_gratuity_net + 2000;

            

        } else {

            echo number_format((float)2000, 2, '.', ','); 
            $total_gratuity_net = $total_gratuity_net + 2000;
            
        }

} 


?>
    </td>
    <td><?php echo $num."."; ?></td>
  </tr>


  <?php }//end while

}//end get method

?>
  <tr>
    <td class="last-td total" style="text-align:center">Grand Total</td>
    <td class="last-td"></td>
    <td class="last-td"><?php //echo number_format((float)$monthly, 2, '.', ',');  ?></td>
    <td class="last-td"><?php echo number_format((float)$gross, 2, '.', ',');  ?></td>
    <td class="last-td"><?php

     if($p_id == 'CS20220105431') {
echo number_format((float)103360, 2, '.', ','); 
    }else {
        echo number_format((float)$total_tax, 2, '.', ',');  
    }  ?></td>
    <td class="last-td"><?php

    $net = $gross - $total_tax;

    if($p_id == 'CS20220105431') {
echo number_format((float)2139640, 2, '.', ','); 
    }else {
       echo number_format((float)$net, 2, '.', ',');  
    }
     

     ?></td>
    <td class="last-td"></td>
  </tr>

 
  <tr >
 
    <td colspan=1 class="">
    CERTIFIED:
    This is to certify that herein worker(s) whose services are engaged through COS and JO.<br><br>
    1. have rendered at <u>least four(4) months</u> of actual satisfactory performance of services as stipulated
    in their respective contract as of Dec. 15 2021 and whose contract are still effective as of the same date.<br>
    2. have rendered <u>less than four(4) months</u> of actual satisfactory performance of services as stipulated
    in their respective contract as of Dec. 15 2021 and whose contract are still effective as of the same date maybe granted the gratuity pay on pro-rata basis.
    <br><br><br><br><br><br>
    
    <p style="text-align:center;">
    ________________________<br>
    Authorized Approving Officer<br><br><br><br><br><br><p></td>

    <td colspan=2  class="" >
    CERTIFIED:<br>
    a. Allotment obligated for the purpose as per OBR No. ____________<br>
    b. Supporting documents complete
    <br><br><br><br>
    <p style="text-align:center;">
    ANNABELLE U. MAGALONA<br>
    Provincial Accountant<br><br><br><br>
    __________________________________<br>
        Name & Signature of Approving Officer<br><br><br>----------------------------------------------------------------------------------------
            <br><br>
        
        
          Authority of the Governor:<br><br><br>
        __________________________________<br>
        Name & Signature of Approving Officer
          </p>
    </td>
    <td colspan=4  class="" >
    CERTIFIED:<br>
    Each person whose name appears on the above roll has been paid the amount dated opposite his name after identifying him.
    <br><br> <br><br><br><br>
   <br><br><br>
   <p style="text-align:center;">___________________________________<br>
        Name & Signature of Disbursing Officer</p><br><br><br><br><br><br><br><br><br>
         <p style="text-align: right;; margin-bottom: -10px;"><?php echo "Date Printed: ".date('M d, Y'); ?></p>
    </td>

  </tr>

 </div>

</table>

    </div></center>



</body>
</html>