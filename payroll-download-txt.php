

            <?php 
                     include('db.php');
                    $p_id = $_GET['payroll_id'];
                    $query = mysqli_query($db, "SELECT DISTINCT 
                                            date_from,date_to,date_created,charge,mode_of_payment,working_days FROM payroll_tbl 
                                            WHERE payroll_id = '$p_id' ");
                    
                    if($row = mysqli_fetch_array($query)) {
  
                      $from = strtr($row['date_from'], '/', '-');
                      $to = strtr($row['date_to'], '/', '-');
                      $created = strtr($row['date_created'], '/', '-');
                      $charge = $row['charge'];


                      $mode_of_payment = $row['mode_of_payment'];
                      $working_days = $row['working_days'];

                      // $to = date("Y",strtotime($row['date_to']));
                        
                    }

                      if($mode_of_payment=='atm') {
                        $mode_of_payment='ATM Downloading';
                      }else {
                        $mode_of_payment='Cash Advance(CA)';

                      }
                   

                    ?>
   

       

          <?php 

          

            ?><!-- </p> -->
            
            <!-- </div> -->


  <?php




if(isset($_GET['payroll_id'])) {
 include('db.php');
    $p_id = $_GET['payroll_id'];

$d = date('Y-M-d');
$file = $d."-".$p_id."-landbank.txt";
$txt = fopen($file, "w") or die("Unable to open file!");


    $query = mysqli_query($db, "SELECT payroll_tbl.*, employment_info.*, position.* 
                                  FROM payroll_tbl 
                                  INNER JOIN employment_info
                                  ON payroll_tbl.name_id = employment_info.employeeno
                                  INNER JOIN position
                                  ON payroll_tbl.position_code = position.positioncode WHERE payroll_id = '$p_id' ");
      $num = 0;
      $gross = 0;
      $total_tax = 0;
      $total_net = 0;
      $total_deduction = 0;
      $working_days_in_a_month = 0;




    while($row = mysqli_fetch_array($query)) {

      $daily_rate = $row['salary_rate'] / 21;
      $hourly_rate = $daily_rate / 8;
      $minute_rate = $hourly_rate / 60;
      $salary = $row['salary_rate'] / 2;
      $monthly_salary = $row['salary_rate'];

      $absent_deduction = $daily_rate * $row['absent'];
      $late_deduction = $hourly_rate * $row['late_per_hr'];
      $late_deduction_minute = $minute_rate * $row['late_per_minute'];



      // $n = $late_deduction;
      // $late_deduction_w = floor($n);      
      // $late_deduction_f = $n - $late_deduction_w;
      // $late_deduction = $late_deduction_w + $late_deduction_f;

      // $n = $late_deduction_minute;
      // $late_deduction_minute_w = floor($n);      
      // $late_deduction_minute_f = $n - $late_deduction_minute_w;
      // $late_deduction_minute = $late_deduction_minute_f + $late_deduction_minute_w;



    
      // $f_deduc = $late_deduction_minute_f + $late_deduction_f + $absent_deduction_f;
      $deduction1 = $absent_deduction + $late_deduction + $late_deduction_minute;
      $deduction = number_format(floor($deduction1*100)/100,2, '.', '');


  
      $salary = $salary - $deduction;
      $total_deduction = $total_deduction + $deduction;


      $taxable_annual_salary = 250000;
      $annual_rate = $row['salary_rate'] * 12;

      $second_half = date("d",strtotime($row['date_to'])); 
    

      $num += 1;

      


?>
  <?php

    if($row['middlename'] == '') {
         $num.". ".$row['employeeno']." ".$row['surname'].", ".$row['firstname']." ".$row['extension'];
    }else {
          $num.". ".$row['employeeno']." ".$row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0];
    }

     ?><?php if($row['employmenttype'] == "CS") {  $row['position']."(COS)"; } else {  $row['position']."(JO)"; } ?>


  <?php
    $semi_salary =  $row['salary_rate'] / 2;
    $gross = $gross + $semi_salary;
     number_format((float)$semi_salary, 2, '.', ','); ?>
   

    <?php //TAX//

  if($annual_rate > $taxable_annual_salary && $second_half > 15) {
                                                                    
          $percentage = .04;
          $netpay = $monthly_salary - ($monthly_salary * $percentage);
          $tax = $monthly_salary - $netpay;
          $total_tax = $total_tax + $tax;
           number_format((float)$tax, 2, '.', ',');
                                    
          }
          else {
                             
         } 
?>

   
<?php
   if($row['absent'] > 0) {  
  $row['absent']; 
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
   

    //$total_net = number_format(floor($total_net*100)/100,2, '.', '') + number_format(floor($netpay*100)/100,2, '.', '');
    $total_net =$total_net + $netpay;
    $emp_net = $netpay;
   
    $netpay = number_format((float)$netpay, 2, '.', ',');

    }
    else {

   $total_net = $total_net + $salary;
    $emp_net = $salary;  
    $salary = number_format((float)$salary, 2, '.', ',');
    }

?>
   <?php  $num."."; ?>

<?php
$total_emp +=  $emp_net;

$emp_net = number_format((float)$emp_net, 2, '.', '');



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
  <?php  }//end while


  
  $d = date('Y-M-d');
  $file = $d."-".$p_id."-landbank.csv";
  $fp = fopen($file, "w") or die("Unable to open file!");

  foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

  fclose($fp);


//echo "TOTAL AMOUNT: ".$total_emp;

}//end get method

?>
  
        <?php 
        //deductions
       
        $f = number_format(floor($total_deduction*100)/100,2, '.', ''); 
         number_format((float)$f, 2, '.', ',');
        ?></td>


  

        <?php
           // echo $total_net = number_format(floor($total_net*100)/100,2, '.', ''); 
           
             number_format((float)$total_net, 2, '.', ',');

            // $last_dec = substr($total_net, -1);

            // if($last_dec > 4) {

            //     $total_net += .01;
            //      number_format((float)$total_net, 2, '.', ',');
            // }else {
            //      number_format((float)$total_net, 2, '.', ',');
            // }
  echo "DOWNLOAD SUCCESS FILENAME : ".$file ; 



//   header('Content-Description: File Transfer');
// header('Content-Disposition: attachment; filename='.basename($file));
// header('Expires: 0');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// header('Content-Length: ' . filesize($file));
// header("Content-Type: text/plain");
// readfile($file);
         ?>
    