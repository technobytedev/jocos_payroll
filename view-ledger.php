<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Ledger</title>
    
    
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
<!-- <link rel="stylesheet" href="assets/vendors/jquery-datatables/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="assets/vendors/fontawesome/all.min.css">

<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.1.1/b-html5-2.1.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.1.1/b-html5-2.1.1/datatables.min.js"></script> -->

<!--  <link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css"/> -->
<style>
    table.dataTable td{
        padding: 15px 8px;
    }
    .fontawesome-icons .the-icon svg {
        font-size: 24px;
    }
    td {
        font-size: 12px!important;
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

 ?>
<div >

   
    </div>
<br>


                          

<!-- // Basic multiple Column Form section start -->
<section class="section">
        <div class="card">
            <div class="card-header">
                <?php 

               
                    $id = $_GET['emp_id']; 

                    $query = mysqli_query($db, "SELECT surname,firstname,middlename,extension FROM employment_info WHERE employeeno='$id' ");

                    if($row=mysqli_fetch_array($query)) {

                     if($row['middlename'] == '') {
                    $name = $row['surname'].", ".$row['firstname']." ".$row['extension'];
                    }

                    else {
                    $name  = $row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0].".";
                    }
                }
                ?>
                <h5 class="text-center"><?php echo "<small>Employee No: ".$id."</small><br>".$name ?></h5>
               
               
            </div>
            <div class="card-body">
                
                <table class="table table-striped" id="emps">
                    <thead>
                        <tr>
                            <th style="font-size:12px!important;">Date Period</th>
                             <th style="font-size:12px!important;">Monthly Rate</th>
                            
                            <!-- <th style="font-size:12px!important;">Hourly Rate</th> -->
                             <th style="font-size:12px!important;">Gross Semimonthly<br> Pay</th>
                              <th style="font-size:12px!important;">Late & Absent Deduction</th>
                              <th style="font-size:12px!important;">Tax Withholding<br> Rate</th>
                           
                            <th style="font-size:12px!important;">Net Semimonthly<br> Pay</th>

                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if($_GET['emp_type'] == "CS") {

                            $payroll_tbl = 'payroll_tbl';


                        }else if($_GET['emp_type'] == "JO") {

                            $payroll_tbl = 'payroll_jo_tbl';

                        }else {
                            echo 'error employmenttype! either not set or no record!';
                        }

                         $query = mysqli_query($db, "SELECT * FROM $payroll_tbl WHERE name_id='$id' AND isaudited=1 ORDER BY id DESC");

                         $total_amount = 0;
                        while($row=mysqli_fetch_array($query)) {


                            if($_GET['emp_type'] == "CS") {

                            $daily_rate = $row['salary_rate'] / 21;
                            $hourly_rate = $daily_rate / 8;


                        }else if($_GET['emp_type'] == "JO") {

                           $daily_rate = $row['salary_rate'];
                            $hourly_rate = $daily_rate / 8;

                        }else {
                            echo 'error employmenttype! either not set or no record!';
                        }

                           


                         ?>
                        
                        <tr>
                            <td><?php  echo date("M d-",strtotime($row['date_from'])).date("d, Y ",strtotime($row['date_to'])); ?>
                                
                            </td>

                            <td><?php echo number_format((float)$row['salary_rate'], 2, '.', ','); ?></td>
                            <td><?php echo number_format((float)$row['salary_rate']/2, 2, '.', ','); ?></td>
                            <td><?php echo number_format((float)$row['late_absent_deduction'], 2, '.', ','); ?></td>
                            <td><?php echo number_format((float)$row['tax'], 2, '.', ','); ?></td>
                             <td><?php echo number_format((float)$row['net_pay'], 2, '.', ','); ?></td>

                           
                        </tr>


                     <?php  $total_amount += $row['net_pay'];
                      } ?>
                     <tr>
                            <td>
                                
                            </td>

                            <td>Total</td>
                            <td></td>
                            <td></td>
                            <td></td>
                             <td><?php echo number_format((float)$total_amount, 2, '.', ','); ?></td>

                           
                        </tr>
                    </tbody>
              
                </table>
            
            </div>
        </div>

    </section>



    <!-- // Basic multiple Column Form section end -->
  <!-- Vertically Centered modal Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                           
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                             <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Detail:</label>
            <input type="text" value="recipient-name" class="form-control" id="recipient-name">
           
          </div>
         
        </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary"
                                                data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Close</span>
                                            </button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




<!-- DATATABLES INFO: JQUERY SHOULD ALWAYS ABOVE THE DATATABLE FILE FOR IT TO WORK -->
<script src="jquery.min.js"></script>
<script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
<!-- END COMMENT DATATABLES INFO: JQUERY SHOULD ALWAYS ABOVE THE DATATABLE FILE FOR IT TO WORK -->
    
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    


<script src="assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js"></script> 
<script src="assets/vendors/fontawesome/all.min.js"></script>


    <script src="assets/js/mazer.js"></script>



<script>
    // Jquery Datatable

    $('#emps').DataTable({
        
        'processing':true,
        'paging':true,
        'order':[],
        'lengthMenu': [[8, 25, 100, -1], [8, 25, 100, "All"]],
     

      });

    $('#exampleModalCenter').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})



      //   $('#emps').DataTable({
      //   'rowLength': 50,
      //   'serverSide':true,
      //   'processing':true,
      //   'paging':true,
      //   'order':[],
      //   'lengthMenu': [[7, 25, 50, -1], [7, 25, 50, "All"]],
      //   'ajax':{
      //     'url':'load-view-ledger.php',
      //     'type':'post',
      //     "data" : {
      //       "id" : "<?php echo $id; ?>"
      //   }
      //   },
      //   'fnCreatedRow':function(nRow,aData,iDataIndex)
      //   {
      //     $(nRow).attr('DocID',aData[0]);
      //   },
      //   'columnDefs':[{
      //     'target':[0,5],
      //     'orderable':false,
      //   }]

      // });
</script>
    
</body>

</html>
