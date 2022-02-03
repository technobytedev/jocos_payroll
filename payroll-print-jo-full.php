<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title style="font-size: 1px;">File>Salary>JO</title>
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


        <h3 class="heading">SEMIMONTHLY SALARY PAYROLL</h3>
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

            <!-- <div class="col-md-2 col-sm-2">
            <p class="head-left" style=" line-height: 88%;"> --><!-- OFFICE: --> <?php 

            include('db.php');
            
           //  $query = mysqli_query($db, "SELECT DISTINCT officecode FROM payroll_tbl WHERE payroll_id = '$pid' ");
           //  while($row = mysqli_fetch_array($query)) {
           //      $officecodes[] = $row['officecode'];
           //  }

           //  foreach($officecodes as $officecode) {


           //      $query = mysqli_query($db, "SELECT * FROM department WHERE officecode = '$officecode' ");
           //  if($row = mysqli_fetch_array($query)) {
           //      $officenames[] = $row['officename'];
           //  }


           //  }


          
            
           //  //put comma after every office
           // $numItems = count($officenames);
           //  $i = 0;
           //  foreach($officenames as $key=>$value) {
             
              
           //     if(++$i == $numItems) {
           //       echo $value;                
           //    }else {
           //      echo $value.", ";
           //    }
           //  }   


            ?><!-- </p> -->
            
            <!-- </div> -->

            <div class="col-md-3 col-sm-3">
            <p class="head-right">MODE OF PAYMENT: ATM DOWNLOADING</p>
            
            </div>
         
            
            <div class="col-md-3 col-sm-3">
            <p class="head-right">PERIOD: <?php 
                     include('db.php');
                    $p_id = $_GET['payroll_id'];
                    $query = mysqli_query($db, "SELECT DISTINCT 
                                            date_from,date_to,date_created FROM payroll_jo_tbl 
                                            WHERE payroll_id = '$p_id' ");
                    
                    if($row = mysqli_fetch_array($query)) {
  
                      $from = strtr($row['date_from'], '/', '-');
                      $to = strtr($row['date_to'], '/', '-');
                      $created = strtr($row['date_created'], '/', '-');
                     

                      // $to = date("Y",strtotime($row['date_to']));

                        echo date("M d-",strtotime($from)).date("d, Y ",strtotime($to));
                    }

                    ?> </p>
            
            </div>
        </div> 


        <table style="width:100%">
  <tr>
     <th rowspan="2" style="width:28%">Name</th>
    <th rowspan="2" style="width:16%">Designation</th>

     <th  rowspan="2"  style="width:5%">Number of Days Worked</th>
    
    <th  rowspan="2"  style="width:5%">Daily Rate</th>
    <th  rowspan="2">Gross Salary</th>
    <th colspan="4" style="text-align:center;" style="width:18%">Deductions (Absent/Late)</th>

     <th rowspan="2" style="width:7%">Net Pay</th>
    <th rowspan="2" style="width:13%">Signature or Thumbmark</th>
  </tr>

  <tr>
    
   
    <th >Days</th>
    <th >Hours</th>
    <th >Minutes</th>
     <th >Amount</th>
   
  </tr>

  <?php




if(isset($_GET['payroll_id'])) {
 include('db.php');
    $p_id = $_GET['payroll_id'];

    $query = mysqli_query($db, "SELECT payroll_jo_tbl.*, employment_info.*, position.* 
                                  FROM payroll_jo_tbl 
                                  INNER JOIN employment_info
                                  ON payroll_jo_tbl.name_id = employment_info.employeeno
                                  INNER JOIN position
                                  ON payroll_jo_tbl.position_code = position.positioncode WHERE payroll_id = '$p_id' ");
      $num = 0;
      $gross = 0;
      $total_tax = 0;
      $total_net = 0;
      $total_gross = 0;
      $total_deduction = 0;


     



    while($row = mysqli_fetch_array($query)) {

      $daily_rate = $row['salary_rate'];
      $hourly_rate = $daily_rate / 8;
      $minute_rate = $hourly_rate / 60;
      $salary =  $row['salary_rate'] * $row['days'];
      $total_gross += $salary;
      

      $absent_deduction = $daily_rate * $row['absent'];
      $late_deduction = $hourly_rate * $row['late_per_hr'];
      $late_deduction_min = $minute_rate * $row['late_per_minute'];

      $deduction = $late_deduction_min + $late_deduction;
      $salary = $salary - $deduction;
      $total_net += $salary;
      $total_deduction += $deduction; 

      $taxable_annual_salary = 250000;
      $annual_rate = $row['salary_rate'] * 22;
      $annual_rate = $annual_rate * 12;

      $second_half = date("d",strtotime($row['date_to'])); 

      $num += 1;

      


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

    <td>
<?php
   if($row['days'] > 0) {  
 echo $row['days']; 
} 
else {  
} 
?>

    </td>





     
    <td><?php //GROSS
    $semi_salary =  $row['salary_rate'] * $row['days'];
    $gross = $gross + $semi_salary;
    echo number_format((float)$row['salary_rate'], 2, '.', ','); ?>
    </td>

        <td>
<?php
 echo number_format((float)$semi_salary, 2, '.', ',');
?>

    </td>

   
    <td>
<?php
   if($row['absent'] > 0) {  
 echo $row['absent']." (".number_format((float)$absent_deduction, 2, '.', ',').")"; 
} 
else {  
} 
?>

    </td>

<td>
         <?php   
        if($row['late_per_hr'] > 0) {  
         echo $row['late_per_hr']; 
        } else {
          
        } ?>
</td>

   <td>
         <?php   
        if($row['late_per_minute'] > 0) {  
         echo $row['late_per_minute']; 
        } else {
          
        } ?>
</td>

      <td>
         <?php   
      
         echo number_format((float)$deduction, 2, '.', ',');
         ?></td>

    <td>
    
    <?php 


//net pay
   if($annual_rate > $taxable_annual_salary && $second_half > 15) {                             
    $netpay = $salary - $tax;
   

   echo number_format((float)$salary, 2, '.', ',');

    }
    else {

   echo number_format((float)$salary, 2, '.', ',');
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
    <td class="last-td"><?php //echo number_format((float)$monthly, 2, '.', ',');  ?></td>
    <td class="last-td"></td>
    <td class="last-td"><?php  if($total_tax>0){echo number_format((float)$total_tax, 2, '.', ','); }  ?></td>
    <td class="last-td"><?php echo number_format((float)$total_gross, 2, '.', ',');  ?></td>
    <td class="last-td"></td>
     <td class="last-td"></td>
      <td class="last-td"></td>
       <td class="last-td"><?php echo number_format((float)$total_deduction, 2, '.', ',');  ?></td>
    <td class="last-td"><?php

   
    echo number_format((float)$total_net, 2, '.', ','); ?></td>
    <td class="last-td"></td>
  </tr>
  <tr>


    
    <td colspan=11>
         <p class="head-left">  <?php 

            include('db.php');
            
            $query = mysqli_query($db, "SELECT DISTINCT officecode FROM payroll_jo_tbl WHERE payroll_id = '$pid' ");
            while($row = mysqli_fetch_array($query)) {
                $officecodes[] = $row['officecode'];
            }

            foreach($officecodes as $officecode) {


                $query = mysqli_query($db, "SELECT * FROM department WHERE officecode = '$officecode' ");
            if($row = mysqli_fetch_array($query)) {
                $officenames[] = $row['officename'];
            }


            } 

            if(count($officecodes) > 1) {
                echo "<p>OFFICES: ";
            }else {
                 echo "<p>OFFICE: ";
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
            echo "</p>";

            ?> 
    </td>
   
  </tr>

 
  <tr >
 
    <td colspan=1 class="">
    CERTIFIED: <br>
    Each person whose name appears on this roll had rendered services for the time started.
    <br><br><br><br><br><br><br>
    
    <p style="text-align:center;">
    ________________________<br>
    Authorized Approving Officer<br><br><br><p><br><br><br><br><br><br></td>

    <td colspan=6  class="" >
    CERTIFIED:<br>
    a. Allotment obligated for the purpose as per OBR No. ____________<br>
    b. Supporting documents complete
    <br><br>
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
    <br><br> <br><br>
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