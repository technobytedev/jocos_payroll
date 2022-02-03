<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Print COS</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
</head>
<style>
table,td, th {
        border: 2px solid grey;
        }
td {
    margin:0px;
}
.center {
    text-align:center;
}
</style>
<body onload="window.print()">

<?php if(isset($_GET['payroll_id'])) {


?>
    <p class="center">Republic of the Philippines<br>
    PROVINCE OF NEGROS OCCIDENTAL<br>
    Bacolod City</p>
    

    <p  class="center">WITHHOLDING TAX FOR CONTRACT OF SERVICE<br>
    Office of the Governor (Professional)<br>
    For the date January 1 - December 31, 2021</p>

    <p style="margin-bottom: -3px;">COLLECTION LIST NO. <?php echo $_GET['payroll_id']; ?></p>


    <table  style="width:100%">
<tr style="">
    <th  style="width:40%;text-align: left;">Employee No.</th>
    <th  style="width:40%;text-align: left;">Name</th>
    <th  style="width:20%;">Amount</th>
  </tr>


  
  <?php
    $p_id = $_GET['payroll_id'];
    include('db.php');

        $taxable_rate = 20833;
    $query = mysqli_query($db, "SELECT gratuity_tbl.*, employment_info.*
                                FROM gratuity_tbl 
                                INNER JOIN employment_info
                                ON gratuity_tbl.name_id = employment_info.employeeno
                               
                                WHERE payroll_id = '$p_id' 
                                AND employment_info.salaryrate > '$taxable_rate'  ORDER BY surname");


    // AND gratuity_tbl.name_id != '20212296'
    //                              AND gratuity_tbl.name_id != '20212285' AND gratuity_tbl.name_id != '20212951'
    //                              AND gratuity_tbl.name_id != '20212363'

    $num = 0;
    $gross = 0;
    $net = 0;
    $total_tax = 0;
    $monthly = 0;

    while($row = mysqli_fetch_array($query)) {

        $num += 1;
    
    ?>
  
  
  <tr>
    <td><?php echo $num.". ".$row['employeeno']; ?></td>
    <td><?php 

       if($row['middlename'] == '') {
        echo $num.". ".$row['surname'].", ".$row['firstname']." ".$row['extension'];
    }else {
         echo $num.". ".$row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0].".";
    }


     ?></td>
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
  </tr>





  <?php 

} ?>

  <tr>
    <td colspan=2 class="center">Total</td>
  
    <td><?php echo number_format((float)$total_tax, 2, '.', ',');  ?></td>
  </tr>

  
 
</table>
   

<?php } ?>
<br><br>
<p style="text-align:right; margin-right:200px">Submitted by:</p><br>
<p style="text-align:right;"><span style="margin-right: 50px">JESSTHA CHRIS T. ALCALA</span><br>
Authorized signature over printed name</p>


</body>
</html>