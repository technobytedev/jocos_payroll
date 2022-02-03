<?php 
session_start();
include('db.php');

$p_id = $_GET['payroll_id'];

$sql = "
  SELECT payroll_tbl.*, employment_info.*, position.* ,department.officename
  FROM payroll_tbl 
  INNER JOIN employment_info
  ON payroll_tbl.name_id = employment_info.employeeno
  INNER JOIN department
  ON department.officecode = payroll_tbl.officecode
  INNER JOIN position
  ON payroll_tbl.position_code = position.positioncode AND payroll_id = '$p_id'
 
     ";




$query = mysqli_query($db,$sql);
$count_all_rows = mysqli_num_rows($query);

if(isset($_POST['search']['value']))
{
  $search_value = $_POST['search']['value'];
  $sql .= " WHERE employeeno like '%".$search_value."%' ";
   $sql .= " OR  surname like '%".$search_value."%' ";
   $sql .= " OR  officename like '%".$search_value."%' ";

  $sql .= " OR firstname like '%".$search_value."%' ";
 

}

if(isset($_POST['order']))
{
  $column = $_POST['order'][0]['column'];
  $order = $_POST['order'][0]['dir'];
  $sql .= " ORDER BY '".$column."' ".$order;
}
else
{
  $sql .=" ORDER BY surname DESC";
}


if($_POST['length'] != -1)
{
  $start = $_POST['start'];
  $length = $_POST['length'];
  $sql .=" LIMIT ".$start.", ".$length;
}

$data = array();

$run_query = mysqli_query($db,$sql);
$filtered_rows = mysqli_num_rows($run_query);
while($row = mysqli_fetch_assoc($run_query))     
{
  $subarray = array();

  $daily_rate = $row['salary_rate'] / 22;
  $hourly_rate = $daily_rate / 8;
  $minute_rate = $hourly_rate / 60; 
  $salary = $row['salary_rate'];
  $monthly_salary = $row['salary_rate'];

  $absent_deduction = $daily_rate * $row['absent'];
  $late_deduction = $hourly_rate * $row['late_per_hr'];
  $late_deduction_minute = $minute_rate * $row['late_per_minute'];

  $deduction = $absent_deduction + $late_deduction + $late_deduction_minute;
  $salary = $salary - $deduction;

  $taxable_annual_salary = 250000;
  $annual_rate = $row['salary_rate'] * 12;

  $second_half = date("d",strtotime($row['date_to']));    

    
  $subarray[] = $row['employeeno'];

   if($row['middlename'] == '') {
          $subarray[] = $name = $row['surname'].", ".$row['firstname']." ".$row['extension'].".";
          }else {
         $subarray[] = $name = $row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0].".";
        }
    
  $subarray[] = $row['position'];

  $semi_salary =  $row['salary_rate'] / 2;

  $subarray[] = number_format((float)$row['salary_rate'], 2, '.', ',');


  if($annual_rate > $taxable_annual_salary && $second_half > 15) {
                                                                    
          $percentage = .08;
          $netpay = $monthly_salary - ($monthly_salary * $percentage);
          $tax = $monthly_salary - $netpay;
          $subarray[] = number_format((float)$tax, 2, '.', ',');
                                    
          }
          else {
                 $subarray[] = ' ';                   
         }
                                
if($row['absent'] > 0) {  
  $subarray[] =  "<b style='font-size:15px'>".$row['absent']."</b> (".number_format((float)$absent_deduction, 2, '.', ',').")"; 
} 
else {  
 $subarray[] = ' '; 
} 

if($row['late_per_hr'] > 0) {  
  $subarray[] = "<b style='font-size:15px'>".$row['late_per_hr']."</b> (".number_format((float)$late_deduction, 2, '.', ',').")"; 
} else {
   $subarray[] = ' '; 
} 

if($row['late_per_minute'] > 0) {  
  $subarray[] = "<b style='font-size:15px'>".$row['late_per_minute']."</b> (".number_format((float)$late_deduction_minute, 2, '.', ',').")"; 
} else {
   $subarray[] = ' '; 
} 


//net pay
   if($annual_rate > $taxable_annual_salary && $second_half > 15) {                             
    $netpay = $salary - $tax;
    $subarray[] = $netpay = number_format((float)$netpay, 2, '.', ',');
    }
    else {
    $subarray[] = $salary = number_format((float)$salary, 2, '.', ',');
    }


     $subarray[]   ='<button data-nameid="'.$row['name_id'].'" 
                                data-late="'.$row['late_per_hr'].'" 
                                data-absent="'.$row['absent'].'"
                                data-late_minute="'.$row['late_per_minute'].'"
                                data-name="'.$name.'"
                                type="button" data-bs-toggle="modal"
                                data-bs-target="#modal-edit" 
                                class="btn btn-sm btn-primary">Edit</button>
                        <a href="view-payroll?name_id='.$row['name_id'].'&payroll_id='.$row['payroll_id'].'">
                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        </a>';



  $data[]= $subarray;
}

$output = array(
  'data'=>$data,
  'draw'=>intval($_POST['draw']),
  'recordsTotal'=>$count_all_rows,
  'recordsFiltered'=>$count_all_rows,
);

echo json_encode($output);


