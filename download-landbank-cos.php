


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
     



    while($row = mysqli_fetch_array($query)) {

      $atm = $row['atmno'];
      $net_pay = $row['net_pay'];


    


$emp_net=str_replace(".", "", $net_pay);



 if($row['middlename'] == '') {
       $name = $row['firstname']." ".$row['middlename'][0]." ".$row['surname'];
    }else {
        $name = $row['firstname']." ".$row['middlename'][0]." ".$row['surname']." ".$row['extension'];
    }

        $name = addslashes($name);



    $list[] = array("atm_new" => $atm, 
                   "name" => $name,
                   "emp_net" => $emp_net);


  
  $d = date('Y-M-d');
  $file = $d."-".$p_id."-landbank.csv";
  $fp = fopen($file, "w") or die("Unable to open file!");






}//end while


  foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

  fclose($fp);

}//end get
         ?>
    