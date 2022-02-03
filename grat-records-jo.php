<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JO Gratuity Payroll Records</title>
    
  
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

if(isset($_GET['del_id'])) {

    $id = $_GET['del_id'];
    

    $query = mysqli_query($db, "DELETE FROM gratuity_tbl WHERE payroll_id='$id' ");

    echo '<script>swal({
        title: "Deleted!",
        icon: "success",
        button: "ok!",
      });
      
    document.location="grat-records-jo"
      
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
             <h5 class="text-center">JO Gratuity Payroll Records</h5>
               
               
            </div>
            <div class="card-body">
                
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th style="font-size:12px!important;">Payroll ID</th>
                            <th style="font-size:12px!important;">Office</th>
                            <th style="font-size:12px!important;">Date Created</th>
                            <th style="font-size:12px!important;">Action</th>
                            
                            
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
                                                    ON department.officecode = gratuity_tbl.officecode
                                                    WHERE employmenttype='JO' ORDER BY gratuity_tbl.id DESC
                                                    
                                                    
                                                   
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
                            <td  style="font-size:13px!important;"><?php echo $row['payroll_id']; ?></td>

                            <?php 
                            
                            // $query = mysqli_query($db, "SELECT employment_info.* FROM gratuity_tbl 
                            //                             INNER JOIN employment_info");

                            
                            ?>
                           
                            <td  style="font-size:13px!important;"><?php echo $row['officename'] ?></td>
                            
                            <td  style="font-size:13px!important;"><?php echo date("Y-M-d",strtotime($row['date_created'])); ?></td>
                        
                            <td   style="font-size:13px!important;">
                            <a  class="text-white" href="view-grat-jo?payroll_id=<?php echo $row['payroll_id']; ?>">
                               <span class="btn btn-success">
                              <i class="fa fa-eye"></i>View</span></a>
                              &nbsp;
                             
                               <span class="btn btn-info">
                               <a target="_blank" class="text-white" href="gratuity-print-jo?payroll_id=<?php echo $row['payroll_id']; ?>"><i class="fa fa-print"></i>Payroll</a></span>

                                &nbsp;
                               <a target="" class="text-white" href="grat-records-jo?del_id=<?php echo $row['payroll_id']; ?>"><span class="btn btn-danger">
                               <i class="fa fa-trash"></i>Delete</span></a>
                             
                        
                            </td>
                           
                            
                     
                        </tr>
                    <?php  } //end while ?>
                    
                    </tbody>
                </table>
            
            </div>
        </div>

    </section>

    <!-- // Basic multiple Column Form section end -->









    
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
    // Jquery Datatable

    $('#table1').DataTable({
        
        'processing':true,
        'paging':true,
        'order':[],
        'lengthMenu': [[8, 25, 100, -1], [8, 25, 100, "All"]],
     

      });
</script>
    
</body>

</html>
