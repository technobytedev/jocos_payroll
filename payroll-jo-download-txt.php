

<?php 
                     include('db.php');
                    $p_id = $_GET['payroll_id'];
                    $query = mysqli_query($db, "SELECT DISTINCT 
                                            date_from,date_to,date_created,charge FROM payroll_jo_tbl 
                                            WHERE payroll_id = '$p_id' ");
                    
                    if($row = mysqli_fetch_array($query)) {
  
                      $from = strtr($row['date_from'], '/', '-');
                      $to = strtr($row['date_to'], '/', '-');
                      $created = strtr($row['date_created'], '/', '-');
                      $charge = $row['charge'];

                     }
?>
   

       
    

            <!-- <div class="col-md-2 col-sm-2">
            <p class="head-left" style=" line-height: 88%;"> --><!-- OFFICE: --> <?php 

            include('db.php');
           


            ?><!-- </p> -->
            
            <!-- </div> -->

      
            
         


  <?php




if(isset($_GET['payroll_id'])) {
 include('db.php');
    $p_id = $_GET['payroll_id'];



$d = date('Y-M-d');
$file = $d."-".$p_id."-landbank.txt";
$txt = fopen($file, "w") or die("Unable to open file!");

    $query = mysqli_query($db, "SELECT payroll_jo_tbl.*, employment_info.*, position.* 
                                  FROM payroll_jo_tbl 
                                  INNER JOIN employment_info
                                  ON payroll_jo_tbl.name_id = employment_info.employeeno
                                  INNER JOIN position
                                  ON payroll_jo_tbl.position_code = position.positioncode WHERE payroll_id = '$p_id' ORDER BY surname");
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
 <?php

    if($row['middlename'] == '') {
         $num.". ".$row['employeeno']." ".$row['surname'].", ".$row['firstname']." ".$row['extension'];
    }else {
          $num.". ".$row['employeeno']." ".$row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0];
    }

     ?>

 <?php if($row['employmenttype'] == "CS") {  $row['position']."(COS)"; } else {  $row['position']."(JO)"; } ?>
<?php
   if($row['days'] > 0) {  
  $row['days']; 
} 
else {  
} 
?>


<?php //GROSS
    $semi_salary =  $row['salary_rate'] * $row['days'];
    $gross = $gross + $semi_salary;
     number_format((float)$row['salary_rate'], 2, '.', ','); ?>

<?php
  number_format((float)$semi_salary, 2, '.', ',');
?>

    
<?php
   if($row['absent'] > 0) {  
  $row['absent']." (".number_format((float)$absent_deduction, 2, '.', ',').")"; 
} 
else {  
} 
?>

     <?php   
        if($row['late_per_hr'] > 0) {  
          $row['late_per_hr']; 
        } else {
          
        } ?>

         <?php   
        if($row['late_per_minute'] > 0) {  
          $row['late_per_minute']; 
        } else {
          
        } ?>

         <?php   
      
          number_format((float)$deduction, 2, '.', ',');
         ?>
    
    <?php 


//net pay
   if($annual_rate > $taxable_annual_salary && $second_half > 15) {                             
    $netpay = $salary - $tax;
    $emp_net = $salary;

   

    number_format((float)$salary, 2, '.', ',');

    }
    else {

    number_format((float)$salary, 2, '.', ',');
     $emp_net = $salary;
    }

?>
    <?php  $num."."; 



//DOWNLOAD
$emp_net = number_format((float)$emp_net, 2, '.', '');

$atm=str_replace("-", "", $row['atmno']);

if( strlen($atm) ==9 ) {
  $atm = "0".$atm;
}


$length = 15;
//$emp_net = 222230012;
 $zero = '';



$emp_net=str_replace(".", "", $emp_net);


    if($row['middlename'] == '') {
       $name = $row['firstname']." ".$row['middlename'][0]." ".$row['surname'];
    }else {
        $name = $row['firstname']." ".$row['middlename'][0]." ".$row['surname']." ".$row['extension'];
    }

        $name = addslashes($name);


if( strlen($atm) == 9 ) {
  $atm_new = $atm;

    $list[] = array("atm_new" => $atm_new, 
                   "name" => $name,
                   "emp_net" => $emp_net);
}else{
    $atm_new = $atm;
      $list[] = array("atm_new" => $atm_new, 
                   "name" => $name,
                   "emp_net" => $emp_net);
}









    ?>


  <?php }//end while

  $d = date('Y-M-d');
  $file = $d."-".$p_id."-landbank.csv";
  $fp = fopen($file, "w") or die("Unable to open file!");

  foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

  fclose($fp);

  echo '<script>
    
  document.location="download?file='.$file.'";
</script>';

   




//       header('Content-Description: File Transfer');
// header('Content-Disposition: attachment; filename='.basename($file));
// header('Expires: 0');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// header('Content-Length: ' . filesize($file));
// header("Content-Type: text/plain");
// readfile($file);

}//end get method

?>
 <?php

   
   