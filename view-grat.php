<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Datatable Jquery - Mazer Admin Dashboard</title>
    
   
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
</style>
<script src="sweet-alert.js"></script>
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

if(isset($_POST['add_one_emp'])) {

 
  echo $officecode = $_POST['officecode'];
  echo $payroll_id = $_POST['p_id_add'];
  echo $type = $_POST['emp_type'];

  


   //  $query = mysqli_query($db, "SELECT DISTINCT date_created FROM gratuity_tbl WHERE payroll_id='$pid' ");

   //  if($row=mysqli_fetch_array($query)) {
   //      $date = $row['date_created'];
   //  }



   // $query = mysqli_query($db, "INSERT INTO
   //                           gratuity_tbl(payroll_id,name_id,officecode,employmenttype,date_created) 
   //                           VALUES('$pid','$name','$officecode','$emp_type','$date')
   //                           ");

   



    if(count($_POST['employee'])==count(array_count_values($_POST['employee']))){
        for($i = 0; $i < sizeof($_POST['employee']); $i++) {

            $employee = $_POST['employee'][$i];

            
             $date = date("M. j, Y, g:i a");
            
    
           // $employee = substr($employee, 0, 8);

            
            $emp_id = explode(' ',trim($employee));
            
            
            if($_POST['employee'][$i] != '') {
                $query = mysqli_query($db, "INSERT INTO gratuity_tbl(payroll_id,name_id,officecode,employmenttype,date_created) 
                                            VALUES('$payroll_id','$emp_id[0]','$officecode','$type','$date')");
            }
           
        
        }
        echo '<script>swal("Awesome!", "Payroll Successfully Saved!", "success");</script>'; 
       

       echo '<script>document.location = "view-grat.php?payroll_id='.$payroll_id.'"</script>';
    }else{
        echo '<script>swal("Information!", "Duplicate employee name", "info");</script>';
        }

}


 ?>       


<?php 

include('db.php');
if(isset($_GET['del'])) {

    $id = $_GET['del'];
    $pid = $_GET['payroll_id'];

    $query = mysqli_query($db, "DELETE FROM gratuity_tbl WHERE name_id='$id' ");

    echo '<script>swal({
        title: "Deleted!",
        icon: "success",
        button: "ok!",
      });
      
    document.location="view-grat?payroll_id='.$pid.'"
      
      </script>';

    

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
                    <div class="col-md-4" style=" line-height: 80%;">
                    Payroll No. <code><?php if(isset($_GET['payroll_id'])) {echo $_GET['payroll_id'];}; ?></code> 
                    <br><br>

                        Office:<code style="">

                        <?php 

                        $pid = $_GET['payroll_id'];

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
                    <br>

                     
                    </div>
                    <div class="col-md-8">
                   <div style="text-align: right;"> 
                                <a target="_blank" class="text-white" href="gratuity-print?payroll_id=<?php echo $_GET['payroll_id']; ?>">
                               <span class="btn btn-info">
                              <i class="fa fa-print"></i>Print</span></a>
                              <button type="button" class="ml-1 btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter">
                               + Add
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
                            <th style="font-size:12px!important;">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($_GET['payroll_id'])) {

                        $p_id = $_GET['payroll_id'];

                        $query = mysqli_query($db, "SELECT gratuity_tbl.*, employment_info_old.*, position.* 
                                                    FROM gratuity_tbl 
                                                    INNER JOIN employment_info_old
                                                    ON gratuity_tbl.name_id = employment_info_old.employeeno
                                                    INNER JOIN position
                                                    ON employment_info_old.positioncode = position.positioncode
                                                    WHERE payroll_id = '$p_id' ORDER BY surname");
                        $num = 0;
                        while($row = mysqli_fetch_array($query)) {

                            $num += 1;

                            // $daily_rate = $row['salaryrate'] / 22;
                            // $hourly_rate = $daily_rate / 8;
                            // $salary = $row['salaryrate'] / 2;

                            // $absent_deduction = $daily_rate * $row['absent'];
                            // $late_deduction = $hourly_rate * $row['late_per_hr'];

                            // $deduction = $absent_deduction + $late_deduction;
                            // $salary = $salary - $deduction;
                            


                    ?>
                        <tr>
                            <td  style="font-size:13px!important;"><?php echo $row['employeeno']; ?></td>
                            <td  style="font-size:13px!important;"><?php echo $num.". ".$row['surname'].", ".$row['firstname']; ?></td>
                            <td  style="font-size:13px!important;"><?php echo $row['position']; ?></td>
                            <!-- <td  style="font-size:13px!important;"> -->
                            <?php 

                            // if($row['effectivitydate'] > '2021-09-31') {
                            //         echo number_format((float)2000, 2, '.', ',');  
                            // }
                            // else {

                            //         $annual = $row['salaryrate'] * 12;

                            //         if( $annual > 250000 ) {

                            //             $percentage = '.08';
                            //             $netpay = 5000 - (5000 * $percentage);
                            //             echo number_format((float)$netpay, 2, '.', ','); 

                                        

                            //         } else {
                            //             echo number_format((float)5000, 2, '.', ','); 
                            //         }
                            // }
                            ?>
                            <!-- </td> -->
                            <td   style="font-size:13px!important;">

                            <a class="text-white" href="view-grat?del=<?php echo $row['employeeno']; ?>&payroll_id=<?php echo $row['payroll_id']; ?>">
                               <span class="btn btn-danger">
                              <i class="fa fa-trash"></i> Delete</span></a>
                        
                          
                            </td>
                           
                            
                        
                        </tr>
                    <?php } //end while ?>
                   
                    </tbody>
                </table>
                <?php 
                     } ?>
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



<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
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

            <form action="view-grat" method="post">
  
            <label for="dept">Department:</label><br>
            
            <select required name="officecode" id="dept" style="width: 100%; height: 39px;" onchange="load_employee(event);">
            <option></option>
            
            <?php $query = mysqli_query($db, "SELECT * FROM department");
                  while($row = mysqli_fetch_array($query)) 
                  {
            ?>
            <option  value="<?php echo $row['officecode']; ?>"><?php echo $row['officename']; ?></option>
            <?php } ?>
            </select>

           
            <input type="hidden" value="<?php echo $_GET['payroll_id']; ?>" name="p_id_add">
             <input type="hidden" value="CS" name="emp_type">
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
             <button type="submit" name="add_one_emp" class="btn btn-primary ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                           </div>  
                                            <select id="list" class="mt-1" name="employee[]" multiple style="width: 100%;height:230px;"> 
               
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

    
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    
<script src="assets/vendors/jquery/jquery.min.js"></script>
<script src="assets/vendors/jquery-datatables/jquery.dataTables.min.js"></script>
<script src="assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js"></script>
<script src="assets/vendors/fontawesome/all.min.js"></script>


    <script src="assets/js/mazer.js"></script>
    <script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);

  
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






    // Jquery Datatable

    $('#table1').DataTable({
        
        'processing':true,
        'paging':true,
        'order':[],
        'lengthMenu': [[30, 25, 100, -1], [30, 25, 100, "All"]],
     

      });


        //auto choose office, after the user choose driver
function load_employee(event) {

event.preventDefault();
let xhr = new XMLHttpRequest();
let dept = document.getElementById("dept").value;


// parameter to send using xhr
let param1 = `office_code=${dept}`;






// xhr.open("POST",`load_employee_per_office_add_one.php`, true);

xhr.open("POST",`load_employee_per_office.php`, true);

xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


//sends the parameters to the page
xhr.send(param1);


xhr.onload = function() {


    //console.log(xhr.responseText);

    let sub_office = document.getElementById("name").innerHTML = xhr.responseText;

    console.log(xhr.responseText);




   
    }



}
</script>
    
</body>

</html>
