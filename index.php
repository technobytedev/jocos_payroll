<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JOCOS</title>
    
    
  
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
<link rel="stylesheet" href="assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <script src="chart.js"></script>

</head>

<body>
    <div id="app">


<!-- start sidebar -->
<?php include('sidebar.php'); ?>
<!-- end sidebar -->

           


  
<div class="page-heading">
    <h3>Statistical Dashboard</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">COS</h6>
                                    <h6 class="font-extrabold mb-0">
                                        <?php $query = mysqli_query($db, 
                                    "SELECT COUNT(employmenttype) AS numberofcs FROM employment_info WHERE employmenttype='CS' AND isactive='yes' ");
                                    
                                    $row = mysqli_fetch_assoc($query);
                                    echo $row['numberofcs']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">JO</h6>
                                    <h6 class="font-extrabold mb-0"><?php $query = mysqli_query($db, 
                                    "SELECT COUNT(employmenttype) AS numberofjo FROM employment_info WHERE employmenttype='JO' AND todate='2021-12-31' AND isactive='yes' ");
                                    
                                    $row = mysqli_fetch_assoc($query);
                                    echo $row['numberofjo']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="stats-icon red">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Gratuity Created</h6>
                                    <h6 class="font-extrabold mb-0"><?php $query = mysqli_query($db, 
                                    "SELECT COUNT(DISTINCT payroll_id) AS grat FROM gratuity_tbl ");
                                    
                                    $row = mysqli_fetch_assoc($query);
                                    echo $row['grat']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            

            <div class="col-6 col-lg-3 col-md-3">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="stats-icon dark">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Payroll Created</h6>
                                    <h6 class="font-extrabold mb-0"><?php $query = mysqli_query($db, 
                                    "SELECT COUNT(DISTINCT payroll_id) AS grat FROM payroll_tbl ");
                                    
                                    $row = mysqli_fetch_assoc($query);
                                    echo $row['grat']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
       
            
            
        </div>
    </section>

     <section class="row" >
      

           

            <div class="col-4 col-lg-4 col-md-4 col-xl-4" >
                    <div class="card" style="height: 253px;"><br>
                       
                            <canvas id="myChart" ></canvas>
                        
                    </div>
                </div>


                <div class="col-4 col-lg-4 col-md-4 col-xl-4" >
                    <div class="card" style="height: 253px;"><br>
                       
                            <canvas id="myChart3" ></canvas>
                        
                    </div>
                </div>
       


            <div class="col-4 col-lg-4 col-md-4 col-xl-4" >
                    <div class="card" style="height: 253px;"><br>
                       
                            <canvas id="myChart2" ></canvas>
                        
                    </div>
                </div>



            
            
    


    </section>

<div class="row">
                
                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Latest Gratuity Created</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Payroll ID</th>
                                            <th>Office</th>
                                            <th>Employment Type</th>
                                            <th>Date Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 

// select distinct a.FirstName, a.LastName, v.District
// from AddTbl a 
//   inner join ValTbl v
//   on a.LastName = v.LastName
// order by a.FirstName;

                        $query = mysqli_query($db, "SELECT DISTINCT gratuity_tbl.payroll_id, gratuity_tbl.employmenttype,gratuity_tbl.officecode,department.officename,
                                                    gratuity_tbl.date_created
                                                    FROM gratuity_tbl 
                                                    INNER JOIN department
                                                    ON department.officecode = gratuity_tbl.officecode ORDER by date_created  DESC LIMIT 5
                                                   
                                                    
                                                   
                                                     ");

                        while($row = mysqli_fetch_array($query)) {

                         
                        
                        

                        // $query = mysqli_query($db, "SELECT DISTINCT gratuity_tbl.officecode
                        // FROM gratuity_tbl 
                        
                        
                       
                        //  ");

                        //     while($row = mysqli_fetch_array($query)) {

                        //     $officecodes[] =  $row['officecode'];

                        //     }

                            


                        

                     

                    ?>
                                        <tr>
                                            <td class="col-3">
                                                <div class="col-auto">
                                                    
                                                    <p class="font-bold mb-0"><?php echo $row['payroll_id']; ?></p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><?php echo $row['officename']; ?></p>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><?php echo $row['employmenttype']; ?></p>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><?php echo $row['date_created']; ?></p>
                                            </td>
                                           
                                        </tr>
                        <?php } ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Monthly Payroll Released Day 1-15</h4>
            </div>
            <div class="card-body">
                <div id="chart-profile-visit"></div>
            </div>
        </div>
    </div>
</div> -->






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

<?php 

$query = mysqli_query($db, "SELECT COUNT(employeeno) AS no_of_emp 
                            FROM employment_info 
                            WHERE 
                            effectivitydate>=2021-01-01 AND 
                            atmno != '0' 
                            AND claimed='yes' AND employmenttype='CS' ");

if($row = mysqli_fetch_array($query)) {

    $total_active_employee = $row['no_of_emp'];
}


$query2 = mysqli_query($db, "SELECT COUNT(name_id) AS no_of_emp_in_tbl 
                            FROM gratuity_tbl WHERE employmenttype='CS' 
                             ");

if($row = mysqli_fetch_array($query2)) {

    $no_of_emp_in_tbl = $row['no_of_emp_in_tbl'];
}

$total_left = $total_active_employee - $no_of_emp_in_tbl;


 ?>

var xValues = ["Released", "Left"];
var yValues = [<?php echo $no_of_emp_in_tbl ?>, <?php echo $total_left ?>];











<?php 

$query = mysqli_query($db, "SELECT COUNT(employeeno) AS has_atm 
                            FROM employment_info 
                            WHERE 
                            isactive='yes' AND 
                            atmno != '0'
                             ");

if($row = mysqli_fetch_array($query)) {

    $has_atm = $row['has_atm'];
}


$query2 = mysqli_query($db, "SELECT COUNT(employeeno) AS no_atm 
                            FROM employment_info 
                            WHERE 
                            isactive='yes' AND 
                            atmno=0
                            
                             ");

if($row = mysqli_fetch_array($query2)) {

    $no_atm = $row['no_atm'];
}



 ?>





var xValues2 = ["With ATM", "Without ATM"];
var yValues2 = [<?php echo $has_atm; ?>, <?php echo $no_atm; ?>];


<?php 

$query = mysqli_query($db, "SELECT COUNT(employeeno) AS no_of_emp 
                            FROM employment_info 
                            WHERE 
                            isactive='yes' AND 
                            atmno != '0' 
                            AND claimed='yes' AND employmenttype='JO' ");

if($row = mysqli_fetch_array($query)) {

    $total_active_employee = $row['no_of_emp'];
}


$query2 = mysqli_query($db, "SELECT COUNT(name_id) AS no_of_emp_in_tbl 
                            FROM gratuity_tbl WHERE employmenttype='JO' 
                             ");

if($row = mysqli_fetch_array($query2)) {

    $no_of_emp_in_tbl = $row['no_of_emp_in_tbl'];
}

$total_left = $total_active_employee - $no_of_emp_in_tbl;


 ?>







var xValues3 = ["Released", "Left"];
var yValues3 = [<?php echo $no_of_emp_in_tbl ?>, <?php echo $total_left ?>];

var barColors = [

  "#57caeb",
  "#9694ff"
];

new Chart("myChart", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "COS Gratuity"
    }
  }
});


new Chart("myChart2", {
  type: "doughnut",
  data: {
    labels: xValues2,
    datasets: [{
      backgroundColor: barColors,
      data: yValues2
    }]
  },
  options: {
    title: {
      display: true,
      text: "Employees ATM"
    }
  }
});


new Chart("myChart3", {
  type: "doughnut",
  data: {
    labels: xValues3,
    datasets: [{
      backgroundColor: barColors,
      data: yValues3
    }]
  },
  options: {
    title: {
      display: true,
      text: "JO Gratuity"
    }
  }
});



</script>
</body>

</html>
