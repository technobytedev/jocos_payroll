<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title style="font-size: 1px;">file>jo>computation</title>
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


        <h3 style="text-align:center; margin-bottom:30px" class="heading">JOB ORDER COMPUTATION <br>January 1 to June 30, 2022</h3>
        <!-- <p style="text-align:center; margin-bottom:30px">OFFICE OF THE GOVERNOR</p> -->
        
       

   
     


        <table style="width:100%">
  <tr>
     <th>Name</th>
    <th>Designation</th> 
    
    <th >Daily Rate</th>
    <th style="font-size:11px" >January 1-31 2022<br>(26 days) </th>
    <th style="font-size:11px" >February 1-28 2022<br>(26 days) </th>
    <th style="font-size:11px" >March 1-31 2022<br>(26 days) </th>
    <th style="font-size:11px" >April 1-30 2022<br>(26 days) </th>
    <th style="font-size:11px" >May 1-31 2022<br>(26 days) </th>
    <th  style="font-size:11px">June 1-30 2022<br>(26 days) </th>
  
    <th >Total</th>
  </tr>



  <?php





 include('db.php');
 

    // $query = mysqli_query($db, "SELECT employment_info.*, position.position ,department.officename
    //                               FROM employment_info 
    //                               INNER JOIN department
    //                               ON employment_info.officecode = department.officecode
    //                               INNER JOIN position
    //                               ON employment_info.positioncode = position.positioncode WHERE employmenttype='JO'
    //                               AND isactive='yes' LIMIT 10 ");

   


       $query = mysqli_query($db, "SELECT DISTINCT Assigned_dept_code FROM employment_info                     
                                    WHERE employmenttype='JO'  AND officecode='1011' AND todate='2022-06-30'
                                  AND isactive='yes' ");
      $num = 0;
      $total = 0;
      $max_days = 26;
      $total_per_emp=0;
      $total_month = 0;
      $grand=0;
      $total_month_final=0;
      $final=0;
       $new = 0;


   while($row = mysqli_fetch_array($query)) {
 // $officecodes[] = $row['Assigned_dept_code']; 
    if($row['Assigned_dept_code'] != '') {
    $officecodes[] = $row['Assigned_dept_code'];
    }else {
       //$officecodes[] = 1011; 
    }
  }



   for($i = 0; $i < sizeof($officecodes); $i++) {

            $officecode = $officecodes[$i];


   $query1 = mysqli_query($db, "SELECT officename FROM department WHERE officecode='$officecode' ");
   if($rowofficce=mysqli_fetch_array($query1)){
    $officename = $rowofficce['officename'];



   }


?>

<tr><td style="font-size: 15px;" colspan="10"><b><?php echo $officename; ?></b></td></tr>

<?php
   $query = mysqli_query($db, "SELECT * FROM employment_info
                                    WHERE employmenttype='JO'
                                     AND isactive='yes' AND Assigned_dept_code='$officecode'  ORDER BY surname ");
    $num = 0;
     $total_per_office = 0;

     $numrowemp = mysqli_num_rows($query);

$new += $numrowemp;
    while($row = mysqli_fetch_array($query)) {

    
      $num += 1;


?>

  <tr>
    
    <td><?php

    if($row['middlename'] == '') {
        echo $num.". ".$row['surname'].", ".$row['firstname']." ".$row['extension'];
    }else {
         echo $num.". ".$row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0];
    }

     ?></td>

        <?php $pos_id = $row['positioncode'];
         $query2 = mysqli_query($db, "SELECT position FROM position WHERE positioncode='$pos_id' ");
                if($row2=mysqli_fetch_array($query2)) {
                    $pos_name = $row2['position'];
                }
          ?>
    <td><?php if($row['employmenttype'] == "CS") { echo $pos_name."(COS)"; } else { echo $pos_name."(JO)"; } ?></td>


    <td>
<?php

    $total_amount = $row['salaryrate']*$max_days; 
    $total_month += $total_amount;
    $total_month_final += $total_amount;
   $total = number_format((float)$total_amount, 2, '.', ',');
  echo number_format((float)$row['salaryrate'], 2, '.', ',');

?>

    </td>
    <td>
<?php

echo "P ".$total;

?>

    </td>
        <td>
<?php

echo "P ".$total;

?>

    </td>
        <td>
<?php

echo "P ".$total;

?>

    </td>
        <td>
<?php

echo "P ".$total;

?>

    </td>
        <td>
<?php

echo "P ".$total;


?>

    </td>

            <td>
<?php

echo "P ".$total;


?>

    </td>
   
    <td>

<?php
   $total_per_emp = $total_amount * 6;
   $grand += $total_per_emp;
  echo "P ".number_format((float)$total_per_emp, 2, '.', ',');
?>

    </td>



     
  



  </tr>



  <?php }//end while 
?> 
 <tr>
    <td class="last-td total" style="text-align:center">Total</td>
      <td class="last-td"></td>
       <td class="last-td"></td>
    <td class="last-td"><?php 

  echo "P ".number_format((float)$total_month, 2, '.', ',');

     ?></td>
    <td class="last-td"><?php 
    
  echo "P ".number_format((float)$total_month, 2, '.', ',');

     ?></td>
    <td class="last-td"><?php 
    
  echo "P ".number_format((float)$total_month, 2, '.', ',');

     ?></td>
    <td class="last-td"><?php 
    
  echo "P ".number_format((float)$total_month, 2, '.', ',');

     ?></td>
    <td class="last-td"><?php 
    
  echo "P ".number_format((float)$total_month, 2, '.', ',');

     ?></td>
     <td class="last-td"><?php 
    
  echo "P ".number_format((float)$total_month, 2, '.', ',');

     ?></td>
    
       <td class="last-td"><?php $final += $grand; echo "P ".number_format((float)$grand, 2, '.', ',');  $grand = 0; ?></td>


  </tr>
<?php
$total_month = 0;
        }//end forloop
?>
  <tr>
    <td class="" style="text-align:center; border-right: none;">Grand Total</td>
      <td class="" style="border-left: none; border-right: none;"></td>
       <td class=""  style="border-left: none; border-right: none;"></td>
    <td class=""  style="border-left: none; border-right: none;"><?php 

  echo "P ".number_format((float)$total_month_final, 2, '.', ',');

     ?></td>
    <td class=""  style="border-left: none; border-right: none;"><?php 
    
  echo "P ".number_format((float)$total_month_final, 2, '.', ',');

     ?></td>
    <td class=""  style="border-left: none; border-right: none;"><?php 
    
  echo "P ".number_format((float)$total_month_final, 2, '.', ',');

     ?></td>
    <td class=""  style="border-left: none; border-right: none;"><?php 
    
  echo "P ".number_format((float)$total_month_final, 2, '.', ',');

     ?></td>
    <td class=""  style="border-left: none; border-right: none;"><?php 
    
  echo "P ".number_format((float)$total_month_final, 2, '.', ',');

     ?></td>
     <td class=""  style="border-left: none; border-right: none;"><?php 
    
  echo "P ".number_format((float)$total_month_final, 2, '.', ',');

     ?></td>
    
       <td class=""  style="border-left: none; border-right: none;"><?php  echo "P ".number_format((float)$final, 2, '.', ',');  ?></td>


  </tr>


 
  <tr >
 
    <td colspan=2 class="">
  
   Recommending Approval
    <br><br><br><br><br><br><br>
    
    <p style="text-align:center;">
    NIMROD C. SARMOY<br>
    Job Order Overall Supervisor<br><br><br><p><br><br><br></td>

    <td colspan=5  class="" >
   
    Certified as to the existence of Appropriation/Obligation
    <br><br><br><br><br><br><br>
    <p style="text-align:center;">
   GEMMA ROSE A. FLORES<br>
   OIC - Provincial Budget Officebr<br><br><br><p><br><br><br>
  
        
        
        
          </p>
    </td>
    <td colspan=3  class="" >
  
    Approved By:
    <br><br> <br><br>
   <br><br><br>
   <p style="text-align:center;">HON. EUGENIO JOSE V. LACSON<br>
        Governor</p><br><br><br><p><br><br>
         <p style="text-align: right;; margin-bottom: -10px;"><?php echo "NUMROWs".$new."Date Printed: ".date('M d, Y'); ?></p>
    </td>

  </tr>

 </div>

</table>

    </div></center>



</body>
</html>