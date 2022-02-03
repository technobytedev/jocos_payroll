<?php 
include('db.php');

$sql = "
  SELECT payroll_jo_tbl.*, employment_info.*, position.* ,department.officename
  FROM payroll_jo_tbl 
  INNER JOIN employment_info
  ON payroll_jo_tbl.name_id = employment_info.employeeno
    INNER JOIN department
  ON department.officecode = payroll_jo_tbl.officecode
  INNER JOIN position
  ON payroll_jo_tbl.position_code = position.positioncode WHERE payroll_id = 'JO20220203090249'
 
     ";

     $query = mysqli_query($db,$sql);


while($row = mysqli_fetch_assoc($query))     
{

echo $row['surname']."<br>";


}

   ?>