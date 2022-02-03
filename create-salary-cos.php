<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Salary COS</title>
    
   
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
<link rel="stylesheet" href="assets/vendors/iconly/bold.css">

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


 if(isset($_POST['grat']) && isset($_POST['employee']) != '') {

 $type = $_POST['type'];
 $payroll_id = "CS".date('YmdHms');

$officecode = $_POST['dept'];

    $query1 = mysqli_query($db, "SELECT * FROM department WHERE officename ='$officecode'");
       if($row = mysqli_fetch_array($query1)) {
        $id = $row['officecode'];
       }
 $officecode = $id;

 $from = $_POST['from'];
  $to = $_POST['to'];
  $days = $_POST['days'];
  $charge = $_POST['charge'];
  $payment = $_POST['payment'];

     
      $tax_db = 0;
      $netpay = 0;
      $tax = 0;

     


 // date_default_timezone_set('Asia/Manila'); 

  $date = date("Y-m-d H:i");

  $array_name_id[] = NULL;
  $dup_name_id = NULL;
  $p_id_dup = NULL;
  $name = NULL;



   
    if(count($_POST['employee'])==count(array_count_values($_POST['employee']))){
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
                      $daily_rate = $salary / 21;
                      $hourly_rate = $daily_rate / 8;
                      $minute_rate = $hourly_rate / 60;
                      $net_half_db = $salary / 2;
                      $monthly_salary = $salary;

                      $taxable_annual_salary = 250000;
                      $annual_rate = $salary * 12;



                      if($annual_rate > $taxable_annual_salary) {
                                                                                
                          $percentage = .04;
                          $netpay = $monthly_salary - ($monthly_salary * $percentage);
                          $tax = $monthly_salary - $netpay;
                          $tax_db = $tax;
                          $net_half_db = $net_half_db - $tax_db;

        
                                                
                      }
                      else {
                          $tax_db = 0;

                     }



            


               // $query_numrow = mysqli_query($db, "SELECT name_id FROM payroll_tbl 
               //                        WHERE name_id='$emp_id[0]' 
               //                        AND payroll_id = '$payroll_id' ");


                $query = mysqli_query($db, "SELECT name_id,payroll_id,date_from,date_to FROM payroll_tbl 
                                      WHERE name_id='$emp_id[0]' AND date_from='$from' AND date_to='$to'
                                       ");

                     if($rowqueryChecking=mysqli_fetch_array($query)) {
                        $dup_name_id = $rowqueryChecking['name_id'];
                        $p_id_dup = $rowqueryChecking['payroll_id'];
                        // $name = $rowqueryChecking['surname']." ".$rowqueryChecking['firstname'];


                     }



                $numrow=mysqli_num_rows($query);




                //check duplicates
                if($numrow == 0) {

                    //CHECK DUPLICATES IN PAYROLL

                    

                      $rowqueryCheckingnumrow=mysqli_num_rows($query);

                    //CONDITION

                    if($rowqueryCheckingnumrow == 0) {

                      $query = mysqli_query($db, "INSERT INTO payroll_tbl(payroll_id,working_days,charge,mode_of_payment,name_id,type,position_code,salary_rate,officecode,date_from,date_to,date_created,net_pay,tax) 
                                            VALUES('$payroll_id','$days','$charge','$payment','$emp_id[0]','$type','$positioncode',
                                            '$salary','$officecode','$from','$to','$date','$net_half_db','$tax_db')");
                        }

                              else{
                     echo '<script>swal("Duplication Detected!", "'.$dup_name_id.' Already in Payroll: '.$p_id_dup.'", "error");</script>';
                     }
                       
              }
               else{
                echo '<script>swal("Duplication Detected!", "'.$dup_name_id.' Already in Payroll: '.$p_id_dup.'", "error");</script>';
        }


            }
           
        
        } //end FORLOOP

           if($dup_name_id != 0) {

              $from = strtr($rowqueryChecking['date_from'], '/', '-');
              $to = strtr($rowqueryChecking['date_to'], '/', '-');
            
              echo '<script>swal("Saving Failed!", "Employeeno: '.$dup_name_id.' was already in Payroll: '.$p_id_dup.' w/ Date Period: '.date("M d-",strtotime($from)).date("d, Y ",strtotime($to)).'", "error");</script>';

           }else {
             echo '<script>swal("Awesome!", "Payroll Successfully Saved!", "success");</script>'; 

           }
             

             
           
       
        
    }


    else{
        echo '<script>swal("Information!", "Duplicate employee name", "info");</script>';
        }

}

else if(isset($_POST['grat'])) {
    echo '<script>swal("Information!", "Nothing to be saved!", "info");</script>';
} else {

}

 ?>
<div >

   
    </div>
<br>

<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
        <div class="row match-height" style="margin:30px 30px 30px 30px;">
            <div class="col-12">
                <div class="card" >
                    <div class="card-header">
                        <h4 class="card-title text-center">Create COS Salary Payroll</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body" style="margin:30px 30px 30px 30px; ">
                          
                                <div class="row">
                              
                               
                                
          
            

            <div class="row">

            <div class="col-md-6">

            <form action="create-salary-cos.php" method="post">
                <!-- <label for="dept">Date:</label><br> -->
            
                <!-- <input type="date" id="from" style="width: 174px; height: 39px;" name="from"> 
            
               
                <input type="date" id="to" style="width: 174px; height: 39px;" name="to"> -->
               
             
                    <input type="radio" id="full" name="type" value="full" required="">
                      <label for="full">Full Month</label><br>
                      <input type="radio" id="half" name="type" value="half">
                      <label for="half">Half Month</label><br> <br>

                       <input type="radio" id="atmdownload" name="payment" value="atm" required="">
                      <label for="atmdownload">ATM Downloading</label><br>
                      <input type="radio" id="ca" name="payment" value="ca">
                      <label for="ca">Cash Advance(CA)</label><br>   
                      
            <br>
            <label for="charge">Funding Source/Charge:</label><br>
            
                <input type="charge" id="charge" style="width: 350px; height: 39px;" name="charge" required="">  <br> <br>

               <label for="days">No. of Working Days This Month:</label><br>
            
                <input type="days" id="days" style="width: 350px; height: 39px;" name="days" required="">  <br> <br>

             <label for="dept">Date:</label><br>
            
                <input type="date" id="from" style="width: 174px; height: 39px;" name="from" required=""> 
                <?php //echo "CS".date("YmdHis"); ?>
               
                <input type="date" id="to" style="width: 174px; height: 39px;" name="to" required="">
            <br><br>
           


            <label for="dept">Department:</label><br>
             <input list="depts" onchange="load_employee(event);" name="dept" id="dept"  style="width: 350px; height: 39px;">
            <datalist required  id="depts" style="width: 350px; height: 39px;" >
          
            
            <?php $query = mysqli_query($db, "SELECT * FROM department");
                  while($row = mysqli_fetch_array($query)) 
                  {
            ?>
            <option  value="<?php echo $row['officename']; ?>"><?php echo $row['aliasoffice']; ?>
            <?php } ?>
            </datalist>
            <br>
            <br>
            
            <label for="name">Employee:</label><br>
            <!-- <input  class="" list="employee" type="text" id="name" placeholder="" autocomplete="off" style="width: 350px; height: 39px;"> -->
           


            <select  id="name" style="width: 350px; height: 39px;">
           
                  </select>  
  

            <button id="btnAdd" class="btn btn-primary">+</button>
           
            
            
            </div>

            <div class="col-md-6">
               
            <select id="list" name="employee[]" multiple style="height:500px;width:350px;margin-left:100px"> 
                <ol>
                    <li>
            
                    </li>
                  </ol>
            </select>

<div style="margin-left:100px"> Total: <span  id="totalEmp">0</span></div>


                  
            </div>


            </div>
          
            
      

        
                                    <div class="col-12 d-flex justify-content-center">

                                        
                                        <input type="hidden" name="emp_type" value="CS">
                                        <button type="submit" name="grat" class="btn btn-primary me-1 mb-1 mt-4">Save All Chosen Employee</button>
                                        
                                      <!--   <button type="submit" name="grat_all" class="btn btn-success me-1 mb-1 mt-4">Save All Office Employee</button> -->
                                        <button id="btnRemove" class="btn btn-danger  me-1 mb-1 mt-4">Remove</button>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    
<script src="assets/vendors/apexcharts/apexcharts.js"></script>
<script src="assets/js/pages/dashboard.js"></script>



    <script src="assets/js/mazer.js"></script>
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






xhr.open("POST",`load_employee_per_office.php`, true);

 // xhr.open("POST",`load_employee_per_office_noatm.php`, true);

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
