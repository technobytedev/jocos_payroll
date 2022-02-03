<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payroll JO</title>
    
    
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
<!-- <link rel="stylesheet" href="assets/vendors/jquery-datatables/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="assets/vendors/fontawesome/all.min.css">
<style>
    table.dataTable td{
        padding: 15px 8px;
    }
    .fontawesome-icons .the-icon svg {
        font-size: 24px;
    }
    td {
        font-size: 12px;
    }
</style>

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
        
<script src="sweet-alert.js"></script>
</head>
  
 

    
    


<body>
    <div id="app">


<!-- start sidebar -->
<?php include('sidebar.php'); ?>
<!-- end sidebar -->

   <?php 

if(isset($_POST['add_one_emp']) && $_POST['employee'] != '') {

 
   $officecode = $_POST['officecode'];

        $query1 = mysqli_query($db, "SELECT * FROM department WHERE officename ='$officecode'");
       if($row = mysqli_fetch_array($query1)) {
        $id = $row['officecode'];
       }
 $officecode = $id;


   $payroll_id = $_POST['p_id_add'];
   $from = $_POST['from'];
   $to = $_POST['to'];
   $date_created = $_POST['date_created'];

   $tax_db = 0;
   $netpay = 0;
   $tax = 0;
   $days = 13;


    if(count($_POST['employee'])==count(array_count_values($_POST['employee']))){


           $query = mysqli_query($db, "SELECT DISTINCT type,charge,mode_of_payment FROM payroll_jo_tbl WHERE payroll_id='$payroll_id' ");
                if($row=mysqli_fetch_array($query)){
                   $type = $row['type'];
                   $charge = $row['charge'];
                   $payment = $row['mode_of_payment'];


                }


        for($i = 0; $i < sizeof($_POST['employee']); $i++) {

            $employee = $_POST['employee'][$i];
            
            $emp_id = explode(' ',trim($employee));
            
            
            if($_POST['employee'][$i] != '') {

                $query = mysqli_query($db, "SELECT salaryrate,positioncode FROM employment_info WHERE employeeno='$emp_id[0]'");
                if($row=mysqli_fetch_array($query)){
                   $salary = $row['salaryrate'];
                   $positioncode = $row['positioncode'];
                }




                     //CALCULATION
                      //$daily_rate = $salary / 21;
                      $hourly_rate = $salary / 8;
                      $minute_rate = $hourly_rate / 60;
                      $net_half_db = $salary * $days;
                      $monthly_salary = $salary;
                      $salary_ = $salary * 26;

                      $taxable_annual_salary = 250000;
                      $annual_rate = $salary_ * 12;



                      if($annual_rate > $taxable_annual_salary) {
                                                                                
                          $percentage = .04;
                          $netpay = $monthly_salary - ($monthly_salary * $percentage);
                          $tax = $monthly_salary - $netpay;
                          $tax_db = $tax;

        
                                                
                      }
                      else {
                          $tax_db = 0;

                     }

                if($type=='full') {
                    $days = 22;
                }
                 else if($type=='half') {
                    $days = 13;
                }

                    $query = mysqli_query($db, "SELECT name_id,payroll_id,date_from,date_to FROM payroll_jo_tbl 
                                      WHERE name_id='$emp_id[0]' AND date_from='$from' AND date_to='$to'
                                       ");

                     if($rowqueryChecking=mysqli_fetch_array($query)) {
                        $dup_name_id = $rowqueryChecking['name_id'];
                        $p_id_dup = $rowqueryChecking['payroll_id'];
                        // $name = $rowqueryChecking['surname']." ".$rowqueryChecking['firstname'];


                     }



                $numrow=mysqli_num_rows($query);


  if($numrow == 0) {

                $query = mysqli_query($db, "INSERT INTO payroll_jo_tbl(payroll_id,charge,mode_of_payment,name_id,type,position_code,salary_rate,officecode,days,date_from,date_to,date_created,net_pay) 
                                            VALUES('$payroll_id','$charge','$payment','$emp_id[0]','$type','$positioncode',
                                            '$salary','$officecode','$days','$from','$to','$date_created','$net_half_db')");

              }
              else {

              }
            }
           
        
        }
        echo '<script>swal("Awesome!", "Payroll Successfully Saved!", "success");</script>'; 
       

       echo '<script>document.location = "view-payroll-jo.php?payroll_id='.$payroll_id.'"</script>';
    }else{
        echo '<script>swal("Information!", "Duplicate employee name", "info");</script>';
        }

}


 ?>     

<?php 

if(isset($_GET['name_id'])) {

    $id = $_GET['name_id'];
    $payroll_id = $_GET['payroll_id'];
    echo '<script>swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
document.location="view-payroll-jo?delete='.$id.'&payroll_id='.$payroll_id.'";
  } else {
    swal("Delete Cancelled");
      document.location="view-payroll-jo?payroll_id='.$payroll_id.'";
  }
});</script>';
}else if(isset($_GET['delete'])) {

    $id = $_GET['delete'];
    $payroll_id = $_GET['payroll_id'];
    

   $query = mysqli_query($db, "DELETE FROM payroll_jo_tbl WHERE name_id='$id' AND payroll_id='$payroll_id' ");

    

       echo '<script>
      document.location="view-payroll-jo?payroll_id='.$payroll_id.'";
      </script>';


}else {

}

 ?>           


<?php 

//days and deductions
if(isset($_POST['update_deduction']) == 'update_deduction') {

    $days = $_POST['days'];
    $late = $_POST['late'];
    $late_minute = $_POST['late_minute'];
    $payroll_id = $_POST['payroll_id'];
    $name_id = $_POST['name_id'];

    $query = mysqli_query($db, "SELECT salary_rate FROM payroll_jo_tbl WHERE name_id='$name_id' AND payroll_id='$payroll_id' ");
                if($row=mysqli_fetch_array($query)){
                   $salary = $row['salary_rate'];
                }

    $deductions = 0;
    $late_amount = 0;
    $absent_amount = 0;
    $net_db = 0;
    $daily_rate = $salary;
    $hourly_rate = $daily_rate / 8;
    $minute_rate = $hourly_rate / 60;
    $salary_half = $salary * $days;


    //ABSENT IN HOURS
    $late_amount = $hourly_rate * $late;
    //$absent_amount = $daily_rate * $absent;

    $deductions = $late_amount + $absent_amount;
    $net_db = $salary_half - $deductions;

    $query = mysqli_query($db, "UPDATE payroll_jo_tbl SET days='$days', late_per_hr='$late', late_per_minute='$late_minute',
                                net_pay='$net_db', late_absent_deduction='$deductions'
                                WHERE name_id='$name_id' AND payroll_id='$payroll_id' ");


    // if($query==TRUE) {
    //    echo '<script>alert("Query true")</script>'; 
    // }
    echo '<script>document.location="view-payroll-jo?payroll_id='.$payroll_id.'"</script>';

} else if(isset($_POST['update_date_period'])) {

    $from = $_POST['edit_date_from'];
    $to = $_POST['edit_date_to'];
    $payroll_id = $_POST['payroll_id'];
   

    $query = mysqli_query($db, "UPDATE payroll_jo_tbl SET date_from='$from', date_to='$to'
                                WHERE payroll_id='$payroll_id' ");

   echo '<script>document.location="view-payroll-jo?payroll_id='.$payroll_id.'"</script>';

}else if(isset($_POST['update_charge'])) {

   $charge = $_POST['edit_charge'];
    $payroll_id = $_POST['payroll_id'];
   

    $query = mysqli_query($db, "UPDATE payroll_jo_tbl SET charge='$charge'
                                WHERE payroll_id='$payroll_id' ");

   echo '<script>document.location="view-payroll-jo?payroll_id='.$payroll_id.'"</script>';
}
else {

}




 ?>
<div >

   
    </div>
<br>

<!-- // Basic multiple Column Form section start -->
<section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3" style="line-height: 13.5px;">
                    Payroll No. <code><?php echo $_GET['payroll_id']; ?></code>
                     <br><br>

                        Office:<code >

                        <?php 

                        $pid = $_GET['payroll_id'];

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

                     ?> </code> <br> 
                    </div>
                    <div class="col-md-3" style="line-height: 13.5px;">
                    Period: <code><?php 

                    $p_id = $_GET['payroll_id'];
                    $query = mysqli_query($db, "SELECT DISTINCT charge,date_from,date_to,date_created FROM payroll_jo_tbl WHERE payroll_id = '$p_id' ");
                    if($row = mysqli_fetch_array($query)) {
                        
                     
                       
  $from = strtr($row['date_from'], '/', '-');
  $to = strtr($row['date_to'], '/', '-');
  $created = strtr($row['date_created'], '/', '-');
  $charge = $row['charge'];

 

                      // $to = date("Y",strtotime($row['date_to']));

                        echo date("M d-",strtotime($from)).date("d, Y ",strtotime($to));
                    }

                    ?></code>
                    </div>
                    <div class="col-md-3" style="line-height: 13.5px;">Date Created: <code><?php echo date("M d, Y h:i a",strtotime($created)); ?></code></div>

                     <div class="col-md-3" style="line-height: 13.5px;">
                   <div style="text-align: right;"> 
                                <a target="_blank" class="text-white" href="payroll-print-jo?payroll_id=<?php echo $_GET['payroll_id']; ?>">
                               <span class="btn btn-info">
                              <i class="fa fa-print"></i>Print</span></a>
                              <button type="button" class="ml-1 btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#add">
                               + Add
                            </button>
                             <button data-datefrom="<?php echo $from; ?>" 
                                    data-dateto="<?php echo $to; ?>"
                                    data-pid="<?php echo $p_id; ?>"
                                    type="button" class="mt-1 btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#modal-edit-date">
                               Edit Date Period
                            </button>
                             <button 
                                    data-charge="<?php echo $charge; ?>"
                                    data-pid="<?php echo $p_id; ?>"
                                    type="button" class="mt-1 btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-edit-charge">
                               Edit Funding Charge
                            </button>
                          </div>

                              
                    </div>
                </div>
               
               
            </div>
            <div class="card-body">
                
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th style="font-size:12px!important;">Employee No.</th>
                            <th style="font-size:12px!important;">Name</th>
                            <th style="font-size:12px!important;">Designation</th>
                            <th style="font-size:12px!important;">Daily Rate</th>
                            <th style="font-size:12px!important;">No. of Days</th>
                            <th style="font-size:12px!important;">Late(<code>Hr./s</code>)</th>
                             <th style="font-size:12px!important;">Late(<code>Min./s</code>)</th>
                            <th style="font-size:12px!important;">Net Pay</th>
                            <th style="font-size:12px!important;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

  <?php  

  $run_query = mysqli_query($db, "SELECT payroll_jo_tbl.name_id,payroll_jo_tbl.payroll_id, payroll_jo_tbl.salary_rate,payroll_jo_tbl.days,payroll_jo_tbl.late_per_hr,payroll_jo_tbl.absent,
  payroll_jo_tbl.late_per_minute,payroll_jo_tbl.date_to, employment_info.employeeno, employment_info.surname,employment_info.firstname,employment_info.middlename,employment_info.extension, position.position ,department.officename
  FROM payroll_jo_tbl 
  INNER JOIN employment_info
  ON payroll_jo_tbl.name_id = employment_info.employeeno
    INNER JOIN department
  ON department.officecode = payroll_jo_tbl.officecode
  INNER JOIN position
  ON payroll_jo_tbl.position_code = position.positioncode 
  WHERE payroll_jo_tbl.payroll_id = '$p_id' ");


     while($row = mysqli_fetch_array($run_query))     
      {

  $daily_rate = $row['salary_rate'];
  $hourly_rate = $daily_rate / 8;
  $minute_rate = $hourly_rate / 60;
  
  $salary = $row['salary_rate'] * $row['days'];

  $absent_deduction = $daily_rate * $row['absent'];
  $late_deduction = $hourly_rate * $row['late_per_hr'];
  $late_deduction_minute = $minute_rate * $row['late_per_minute'];

  $deduction = $late_deduction_minute + $late_deduction;
  $salary = $salary - $deduction;

  $taxable_annual_salary = 250000;
  $annual_rate = $row['salary_rate'] * 22;
  $annual_rate = $annual_rate * 12;


  $second_half = date("d",strtotime($row['date_to'])); 
                  
?>
<tr>

  <td><?php echo $row['employeeno'] ?></td>
 <?php if($row['middlename'] == '') {
          $name = $row['surname'].", ".$row['firstname']." ".$row['extension'].".";
          echo '<td>'.$name.'</td>';
          }else {
          $name = $row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0].".";
          echo '<td>'.$name.'</td>';
  } ?>
 <td><?php echo $row['position'] ?></td>
 <?php $semi_salary =  $row['salary_rate'] * $row['days']; ?>
 <td><?php echo number_format((float)$row['salary_rate'], 2, '.', ','); ?></td>

 <td><b style='font-size:15px'><?php echo $row['days']; ?></b></td>
 <td><?php
  if($row['late_per_hr'] > 0) {  
  echo "<b style='font-size:15px'>".$row['late_per_hr']."</b> (".number_format((float)$late_deduction, 2, '.', ',').")"; 
} else {
   echo ' '; 
} 
?>
</td>
 <td>
<?php
if($row['late_per_minute'] > 0) {  
  $subarray[] = "<b style='font-size:15px'>".$row['late_per_minute']."</b> (".number_format((float)$late_deduction_minute, 2, '.', ',').")"; 
} else {
   $subarray[] = ' '; 
} 

?>
</td>
<td>
<?php $netpay = $salary - $deduction;
   echo $netpay = number_format((float)$netpay, 2, '.', ','); ?>
</td>
<td>
<?php
echo '<button data-nameid="'.$row['name_id'].'" 
                                data-late="'.$row['late_per_hr'].'" 
                                data-late_min="'.$row['late_per_minute'].'" 
                                data-days="'.$row['days'].'"
                                data-name="'.$name.'"
                                type="button" data-bs-toggle="modal"
                                data-bs-target="#modal-edit" 
                                class="btn btn-sm btn-primary">Edit</button>
                        <a href="view-payroll-jo?name_id='.$row['name_id'].'&payroll_id='.$row['payroll_id'].'">
                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        </a>';
 ?>
</td>
</tr>


<?php } //end WHILE?>           
                  
                    
                    </tbody>
                </table>
                
            </div>
        </div>

    </section>

    <!-- // Basic multiple Column Form section end -->





            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2022 &copy; ICTD</p>
                    </div>
                    <div class="float-end">
                        <p>Province of Negros Occidental</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <!-- ----------------------------------------------------------- -->
<div class="modal fade" id="modal-edit-charge" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Update Funding Charge
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                              X
                                            </button>
                                        </div>
                                        <div class="modal-body " style="height: 200px">

            <form action="view-payroll-jo" method="post">
           <label for="edit_charge">Charge To:</label><br>
           <input type="text" name="edit_charge" class="form-control" id="edit_charge"><br>
  
            <input type="hidden" value="<?php echo $_GET['payroll_id'] ?>" class="form-control" name="payroll_id" 
            id="payroll_id">

          <br>
            <div style="text-align: right">
             <button type="submit" name="update_charge" class="btn btn-primary ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Update</span>
                                            </button>
                                             <button class="btn btn-secondary" type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                Cancel
                                            </button>
                                           </div>                          
            
            </div>       
            </div>
                  
                                </div>

                                           
                            </form>
                 
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
<!-- ------------------------------>
<!-- ----------------------------------------------------------- -->
<div class="modal fade" id="modal-edit-date" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Update Date Period
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                              X
                                            </button>
                                        </div>
                                        <div class="modal-body " style="height: 270px">

            <form action="view-payroll-jo" method="post">
           <label for="emp_name">Date From:</label><br>
           <input type="date" name="edit_date_from" class="form-control" id="edit_date_from"><br>
  
            <label for="dept">Date To:</label><br>
            <input type="date" name="edit_date_to" class="form-control" id="edit_date_to">
      
          

            <input type="hidden" value="<?php echo $_GET['payroll_id'] ?>" class="form-control" name="payroll_id" 
            id="payroll_id">
          
         

          <br>
            <div style="text-align: right">
             <button type="submit" name="update_date_period" class="btn btn-primary ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Update</span>
                                            </button>
                                             <button class="btn btn-secondary" type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                Cancel
                                            </button>
                                           </div>                          
            
            </div>       
            </div>
                  
                                </div>

                                           
                            </form>
                 
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
<!-- ------------------------------>
<!-- ----------------------------------------------------- -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Update Days and Deductions
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                              X
                                            </button>
                                        </div>
                                        <div class="modal-body " style="height: 390px">

            <form action="view-payroll-jo" method="post">
           <label for="emp_name">Name:</label><br>
           <input type="text"class="form-control" id="emp_name" readonly=""><br>
  
            <label for="dept">No. of Days:</label><br>
            <input type="text" class="form-control" name="days" id="days">
      
            <label class="mt-1" for="name">Late(hr/s):</label><br>
            <input type="number" min=0 max=200 class="form-control" name="late" id="late">

             <label class="mt-1" for="name">Late(min/s):</label><br>
            <input type="number" min=0 max=200 class="form-control" name="late_minute" id="late_minute">

            <input type="hidden" value="<?php echo $_GET['payroll_id'] ?>" class="form-control" name="payroll_id" 
            id="payroll_id">
             <input type="hidden" id="name_id" value="" class="form-control" name="name_id">
         

          <br>
            <div style="text-align: right">
             <button type="submit" name="update_deduction" class="btn btn-primary ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Update</span>
                                            </button>
                                             <button class="btn btn-secondary" type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                Cancel
                                            </button>
                                           </div>                          
            
            </div>       
            </div>
                  
                                </div>

                                           
                            </form>
                 
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
<!-- ------------------------------------------------------------- -->
<div class="modal fade" id="add" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Add Employee
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body " style="height: 500px">

            <form action="view-payroll-jo" method="post">
  
            <label for="dept">Department:</label><br>
            
            <select required name="officecode" id="dept" style="width: 100%; height: 39px;" onchange="load_employee(event);">
            <option></option>
            
            <?php $query = mysqli_query($db, "SELECT * FROM department ORDER BY officename  ");
                  while($row = mysqli_fetch_array($query)) 
                  {
            ?>
            <option  value="<?php echo $row['officecode']; ?>"><?php echo $row['officename']; ?></option>
            <?php } ?>
            </select>

           
          

            <?php 
            $payroll_id = $_GET['payroll_id'];
            $query = mysqli_query($db, "SELECT DISTINCT date_from,date_to,date_created 
                                        FROM payroll_jo_tbl 
                                        WHERE payroll_id='$payroll_id' ");
            if($row=mysqli_fetch_array($query)) {
                $from = $row['date_from'];
                $to = $row['date_to'];
                $date_created = $row['date_created'];
            }
            ?>
            <input type="hidden" value="<?php echo $_GET['payroll_id']; ?>" name="p_id_add">
            <input type="hidden" value="<?php echo $from; ?>" name="from">
            <input type="hidden" value="<?php echo $to; ?>" name="to">
            <input type="hidden" value="<?php echo $date_created; ?>" name="date_created">
            
            <br>
           
            <label class="mt-1" for="name">Employee:</label><br>
         

            <select name="name"  id="name" style="width: 100%; height: 39px;">
           
                  </select>  
                    <button type="submit"  id="btnAdd"  name="add_one_emp" class="mt-1 btn btn-primary ml-1">
                                           
                                              <i class="fa fa-plus"></i>
                                            </button>
                                            <button type="submit" id="btnRemove" class="mt-1 btn btn-danger ml-1">
                                               
                                                  <i class="fa fa-trash"></i>
                                            </button>
<br>

                   
   

          
            <div style="text-align: right">
                  <button class="btn btn-secondary" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                Cancel
                                            </button>
             <button type="submit" name="add_one_emp" class="btn btn-primary ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                           </div>  
                                            <select required="" id="list" class="mt-1" name="employee[]" multiple style="width: 100%;height:230px;"> 
               
            </select>
 <br>
                    <div> Total: <span  id="totalEmp"></span></div>                      
            
            </div>


            </div>
             
                               
                                </div>

                                           
                            </form>
                 
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
<!-- ------------------------------------------------------------- -->
<script src="jquery.min.js"></script>
<script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
<!-- END COMMENT DATATABLES INFO: JQUERY SHOULD ALWAYS ABOVE THE DATATABLE FILE FOR IT TO WORK -->
    
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    


<script src="assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js"></script> 
<script src="assets/vendors/fontawesome/all.min.js"></script>


    <script src="assets/js/mazer.js"></script>
    <script>
    // Simple Datatable

  
</script>

<script>

  $(document).ready(function() {
    $('#table1').DataTable();
} );

        var payroll_id = "<?php echo $_GET['payroll_id']; ?>";
        console.log(payroll_id);

        $('#table2').DataTable({
        'rowLength': 50,
        'serverSide':true,
        'processing':true,
        'paging':true,
        'order':[],
        'lengthMenu': [[7, 25, 50, -1], [7, 25, 50, "All"]],
        'ajax':{
          'url':'load-view-payroll-jo.php?payroll_id='+payroll_id,
          'type':'post',

        },

        'fnCreatedRow':function(nRow,aData,iDataIndex)
        {
          $(nRow).attr('DocID',aData[0]);
        },
        'columnDefs':[{
          'target':[0,5],
          'orderable':false,
        }]

      });
</script>


<script>


     const btnAdd = document.querySelector('#btnAdd');
        const btnRemove = document.querySelector('#btnRemove');
        const sb = document.querySelector('#list');
        const name = document.querySelector('#name');

        btnAdd.onclick = (e) => {
            e.preventDefault();

            // validate the option
            if (name.value == '') {
                swal("Information!", "Please Choose an Employee/s First", "info");
                return;
            }
            // create a new option
            
            // add it to the list

            // function addoption() {
            //     const sb = document.querySelector('#list');
            //     const name = document.querySelector('#name');
            //     const option = new Option(name.value, name.value);
            //     sb.add(option, undefined);
            // }
           
          

            var li = document.createElement("li");

            const option = new Option(name.value, name.value);
                
                     sb.add(option, undefined);
            


            //select or highlight all options in select
        options = document.getElementById("list");
        for ( i=0; i<options.length; i++)
        {
            options[i].selected = "true";
        }

        var len = document.getElementById("list").length;
       document.getElementById("totalEmp").innerHTML=len;

      

            // reset the value of the input
            name.value = '';
            name.focus();
        };

        // remove selected option
        btnRemove.onclick = (e) => {
            e.preventDefault();

            // save the selected option
            let selected = [];

            for (let i = 0; i < sb.options.length; i++) {
                selected[i] = sb.options[i].selected;
            }

            // remove all selected option
            let index = sb.options.length;
            while (index--) {
                if (selected[index]) {
                    sb.remove(index);
                }
            }


            options = document.getElementById("list");
        for ( i=0; i<options.length; i++)
        {
            options[i].selected = "true";
        }


        var len = document.getElementById("list").length;

        document.getElementById("totalEmp").innerHTML=len;
        };

        //auto choose office, after the user choose driver
function load_employee(event) {

event.preventDefault();
let xhr = new XMLHttpRequest();
let dept = document.getElementById("dept").value;


// parameter to send using xhr
let param1 = `office_code=${dept}`;






// xhr.open("POST",`load_employee_per_office_add_one.php`, true);

xhr.open("POST",`load_employee_per_office_jo.php`, true);

xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


//sends the parameters to the page
xhr.send(param1);


xhr.onload = function() {


    //console.log(xhr.responseText);

    let sub_office = document.getElementById("name").innerHTML = xhr.responseText;

    console.log(xhr.responseText);




   
    }



}


  $('#modal-edit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var nameid = button.data('nameid')
  var days = button.data('days') 
  var late = button.data('late')
  var late_min = button.data('late_min')

  var emp_name = button.data('name')  // Extract info from data-* attributes
    // Extract info from data-* attributes
   // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
   var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
   modal.find('.modal-body #name_id').val(nameid)
   modal.find('.modal-body #days').val(days)
   modal.find('.modal-body #late').val(late)
    modal.find('.modal-body #emp_name').val(emp_name)
     modal.find('.modal-body #late_minute').val(late_min)

});


    $('#modal-edit-date').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var from = button.data('datefrom')
  var to = button.data('dateto') 
 // Extract info from data-* attributes
    // Extract info from data-* attributes
   // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
   var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
   modal.find('.modal-body #edit_date_from').val(from)
   modal.find('.modal-body #edit_date_to').val(to)


});

     $('#modal-edit-charge').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var nameid = button.data('nameid')
  var charge = button.data('charge') 

 // Extract info from data-* attributes
    // Extract info from data-* attributes
   // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
   var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
   modal.find('.modal-body #name_id').val(nameid)
   modal.find('.modal-body #edit_charge').val(charge)
 

});


</script>






    
</body>

</html>
