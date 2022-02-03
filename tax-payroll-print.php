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

      $p_id = $_GET['payroll_id'];
    include('db.php');

        $taxable_rate = 20833;
    $queryWHILE = mysqli_query($db, "SELECT payroll_tbl.*, employment_info.*
                                FROM payroll_tbl 
                                INNER JOIN employment_info
                                ON payroll_tbl.name_id = employment_info.employeeno
                               
                                WHERE payroll_id = '$p_id' 
                                AND payroll_tbl.salary_rate > '$taxable_rate'  ORDER BY surname");





    $num = 0;
    $gross = 0;
    $net = 0;
    $total_tax = 0;
    $monthly = 0;

    $taxable_rate = 20833;


    $queryIF = mysqli_query($db, "SELECT DISTINCT payroll_tbl.name_id, employment_info.isprc
                                FROM payroll_tbl 
                                INNER JOIN employment_info
                                ON payroll_tbl.name_id = employment_info.employeeno
                               
                                WHERE payroll_id = '$p_id' 
                                ");


if($rownew=mysqli_fetch_array($queryIF)) {
    $prc = $rownew['isprc'];
}




?>
    <p class="center">Republic of the Philippines<br>
    PROVINCE OF NEGROS OCCIDENTAL<br>
    Bacolod City</p>
    

    <p  class="center">WITHHOLDING TAX FOR CONTRACT OF SERVICE<br>
    Office of the Governor <?php if($prc == 'yes'){echo "(Professional)";}else{echo "(Non-Professional)";} ?><br>
    For the Period  <?php 
                     include('db.php');
                    $p_id = $_GET['payroll_id'];
                    $query = mysqli_query($db, "SELECT DISTINCT 
                                            date_from,date_to,date_created FROM payroll_tbl 
                                            WHERE payroll_id = '$p_id' ");
                    
                    if($row = mysqli_fetch_array($query)) {
  
                      $from = strtr($row['date_from'], '/', '-');
                      $to = strtr($row['date_to'], '/', '-');
                      $created = strtr($row['date_created'], '/', '-');
                     

                      // $to = date("Y",strtotime($row['date_to']));

                        echo date("F d-",strtotime($from)).date("d, Y ",strtotime($to));
                    }

                    ?> </p>

    <p style="margin-bottom: -3px;">COLLECTION LIST NO. <?php echo $_GET['payroll_id']; ?></p>


    <table  style="width:100%">
<tr style="">
    <th  style="width:40%;text-align: left;">Employee No.</th>
    <th  style="width:40%;text-align: left;">Name</th>
    <th  style="width:20%;">Amount</th>
  </tr>


  
  <?php
  



    while($row = mysqli_fetch_array($queryWHILE)) {

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



        
        $annual = $row['salaryrate'] * 12;
        $salary = $row['salaryrate'];

        if( $annual > 250000 ) {

            $percentage = '.04';
            $netpay = $salary - ($salary * $percentage);
            $tax = $salary - $netpay;
            echo number_format((float)$tax, 2, '.', ','); 

            $total_tax = $total_tax + $tax;

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