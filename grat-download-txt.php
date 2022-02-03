

   <?php  $pid = $_GET['payroll_id']; ?>

        <?php 

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


          
            

           $numItems = count($officenames);
            $i = 0;
            foreach($officenames as $key=>$value) {
             
              
               if(++$i == $numItems) {
                  $value;                
              }else {
                 $value.", ";
              }
            }   





            ?>



  <?php

include('db.php');


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
    $net = 0;
    $total_tax = 0;
    $monthly = 0;

    while($row = mysqli_fetch_array($query)) {

        $num += 1;

        $monthly = $monthly + $row['salaryrate'];


?>


        <?php 

         if($row['middlename'] == '') {
         $num.". ".$row['employeeno']." ".$row['surname'].", ".$row['firstname']." ".$row['extension'];
    }else {
          $num.". ".$row['employeeno']." ".$row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0];
    }


         ?>
        




    
    <?php if($row['employmenttype'] == "CS") {  $row['position']."(COS)"; } else {  $row['position']."(JO)"; } ?>
    <?php  number_format((float)$row['salaryrate'], 2, '.', ','); ?>
    

    <?php //gratuity pay//

if( $row['effectivitydate'] <= '2021-08-15') {
     
             number_format((float)5000, 2, '.', ','); 
            $gross = $gross + 5000;
       
}
else if($row['effectivitydate'] <= '2021-09-15') {

        
             number_format((float)4000, 2, '.', ','); 
            $gross = $gross + 4000;
}
else if($row['effectivitydate'] <= '2021-10-15') {

        
     number_format((float)3000, 2, '.', ','); 
    $gross = $gross + 3000;

} else  {

        
     number_format((float)2000, 2, '.', ','); 
    $gross = $gross + 2000;
} 
?>


  

    <?php 
//TAX


if($row['effectivitydate'] <= '2021-08-15') {
        
        $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 5000 - (5000 * $percentage);
            $tax = 5000 - $netpay;
             number_format((float)$tax, 2, '.', ','); 

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
             number_format((float)$tax, 2, '.', ','); 

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
             number_format((float)$tax, 2, '.', ','); 

            $total_tax = $total_tax + $tax;

        } else {
            
        }
}

else {

    $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 2000 - (2000 * $percentage);
            $tax = 2000 - $netpay;
             number_format((float)$tax, 2, '.', ','); 

            $total_tax = $total_tax + $tax;

        } else {
            
        }

} 


?>

    
    
    <?php 

////NET PAY of gratuity

if($row['effectivitydate'] <= '2021-08-15') {
        
        $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 5000 - (5000 * $percentage);
             number_format((float)$netpay, 2, '.', ','); 
            

        } else {

             number_format((float)5000, 2, '.', ','); 
            $net = $net + 5000;
            $netpay = 5000;
          
        }
}
else if($row['effectivitydate'] <= '2021-09-15') {

        $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 4000 - (4000 * $percentage);
             number_format((float)$netpay, 2, '.', ','); 

        } else {

             number_format((float)4000, 2, '.', ','); 
            $net = $net + 4000;
             $netpay = 4000;
            
        }
}
else  if($row['effectivitydate'] <= '2021-10-15') {
    $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 3000 - (3000 * $percentage);
             number_format((float)$netpay, 2, '.', ','); 

        } else {

             number_format((float)3000, 2, '.', ','); 
            $net = $net + 3000;
            $netpay = 3000;
            
        }
}

else  {

    $annual = $row['salaryrate'] * 12;

        if( $annual > 250000 ) {

            $percentage = '.08';
            $netpay = 2000 - (2000 * $percentage);
           
             number_format((float)$netpay, 2, '.', ','); 

            

        } else {

             number_format((float)2000, 2, '.', ','); 
            $net = $net + 2000;
            $netpay = 2000;
            
        }

} 

?>
    
  <?php

$emp_net = $netpay;
$emp_net = number_format((float)$emp_net, 2, '.', '');

$atm=str_replace("-", "", $row['atmno']);




$emp_net=str_replace(".", "", $emp_net);

//$content = $atm.",""    ".",".$emp_net;


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

  echo $net;

  $d = date('Y-M-d');
  $file = $d."-".$p_id."-landbank.csv";
  $fp = fopen($file, "w") or die("Unable to open file!");

  foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

  fclose($fp);

  echo '<script>
    
  document.location="download?file='.$file.'&total='.$net.'";
</script>';


?>



<?php
//       header('Content-Description: File Transfer');
// header('Content-Disposition: attachment; filename='.basename($file));
// header('Expires: 0');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// header('Content-Length: ' . filesize($file));
// header("Content-Type: text/plain");
// readfile($file);





// $file = $p_id."-landbank.txt";
// $txt = fopen($file, "w") or die("Unable to open file!");


// for($i = 0; $i < sizeof($content); $i++) {

// $cont = $content[$i];        
// fwrite($txt, $cont);
// fwrite($txt, PHP_EOL);
// }


// fclose($txt);
// header('Content-Description: File Transfer');
// header('Content-Disposition: attachment; filename='.basename($file));
// header('Expires: 0');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// header('Content-Length: ' . filesize($file));
// header("Content-Type: text/plain");
// readfile($file);



}//end get method

?>

 
