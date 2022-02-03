<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>
    

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



 $payroll_id = "CS".date('YmdHis');

 

 if(isset($_POST['sample'])) {


    if(count($_POST['employee'])==count(array_count_values($_POST['employee']))){
        for($i = 0; $i < sizeof($_POST['employee']); $i++) {

            $employee = $_POST['employee'][$i];

            $from = $_POST['from'];
            $to = $_POST['to'];
            $date = date('Y-m-d H:i');
            
    
             $emp_id = explode(' ',trim($employee));
        
            if($_POST['employee'][$i] != '') {
                $query = mysqli_query($db, "INSERT INTO payroll_tbl(payroll_id,name_id,date_from,date_to,date_created) 
                                            VALUES('$payroll_id','$emp_id[0]','$from','$to','$date')");
            }
           
        
        }
        echo '<script>swal("Awesome!", "Payroll Successfully Saved!", "success");</script>'; 
        echo '<script>document.location = "view-payroll.php?payroll_id='.$payroll_id.'"</script>';
    }else{
        echo '<script>swal("Information!", "Duplicate employee name", "info");</script>';
        }






} ?>
<div >

   
    </div>
<br>

<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
        <div class="row match-height" style="margin:30px 30px 30px 30px;">
            <div class="col-12">
                <div class="card" >
                    <div class="card-header">
                        <h4 class="card-title text-center">Create New COS Payroll</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body" style="margin:30px 30px 30px 30px; ">
                          
                                <div class="row">
                              
                               
                                
          
            

            <div class="row">

            <div class="col-md-6">

            <form action="create-payroll.php" method="post">
                <label for="dept">Date:</label><br>
            
                <input type="date" id="from" style="width: 174px; height: 39px;" name="from"> 
            
               
                <input type="date" id="to" style="width: 174px; height: 39px;" name="to">
               
            
            <br><br>
            <label for="dept">Department:</label><br>
            
            <select id="dept" style="width: 350px; height: 39px;" onchange="load_employee(event);">
            
            
            <?php $query = mysqli_query($db, "SELECT * FROM department");
                  while($row = mysqli_fetch_array($query)) 
                  {
            ?>
            <option  value="<?php echo $row['officecode']; ?>"><?php echo $row['officename']; ?></option>
            <?php } ?>
            </select>
            <br>
            <br>
            
            <label for="name">Employee:</label><br>
            <!-- <input  class="" list="employee" type="text" id="name" placeholder="" autocomplete="off" style="width: 350px; height: 39px;"> -->
           


            <select  id="name" style="width: 350px; height: 39px;">
           
                  </select>  
  

            <button id="btnAdd" class="btn btn-primary">+</button>
           
            
            
            </div>

            <div class="col-md-6">
               
            <select id="list" name="employee[]" multiple style="height:400px;width:350px;margin-left:100px"> 
                <ol>
                    <li>
            
                    </li>
                  </ol>
            </select>
                  
            </div>


            </div>
          
            
      

        
                                    <div class="col-12 d-flex justify-content-center">
                                       
                                        <button type="submit" name="sample" class="btn btn-primary me-1 mb-1 mt-4">Submit</button>
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
                alert('Please enter the name.');
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

        console.log(len);
    

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

console.log(len);
        };





//auto choose office, after the user choose driver
function load_employee(event) {

event.preventDefault();
let xhr = new XMLHttpRequest();
let dept = document.getElementById("dept").value;


// parameter to send using xhr
let param1 = `office_code=${dept}`;






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
