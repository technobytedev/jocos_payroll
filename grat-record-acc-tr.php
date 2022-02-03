<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JO Payroll Records</title>
    
    
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
      font-size: 13px;
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
<?php //session_start(); include('db.php'); 
include('sidebar.php'); ?>
<!-- end sidebar -->

           


<?php 


if(isset($_POST['audit_1'])) {

   $id = $_POST['payroll_id'];
  $query = mysqli_query($db, "UPDATE gratuity_tbl SET isaudited=1 WHERE payroll_id='$id' ");

  }

  if(isset($_POST['audit_0'])) {
  
   $id = $_POST['payroll_id'];
  $query = mysqli_query($db, "UPDATE gratuity_tbl SET isaudited=0 WHERE payroll_id='$id' ");

  }

//Release Payroll

if(isset($_POST['release_1'])) {

   $id = $_POST['payroll_id'];
  $query = mysqli_query($db, "UPDATE gratuity_tbl SET isreleased=1 WHERE payroll_id='$id' ");
// echo '<script>alert("'.$id.'")</script>';
  }

  if(isset($_POST['release_0'])) {
  
   $id = $_POST['payroll_id'];
  $query = mysqli_query($db, "UPDATE gratuity_tbl SET isreleased=0 WHERE payroll_id='$id' ");


  }

if(isset($_GET['del_id'])) {

    $id = $_GET['del_id'];
    echo '<script>swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this payroll file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
document.location="payroll-records-jo?delete_payroll='.$id.'";
  } else {
    swal("The payroll '.$id.' is safe!");
      document.location="payroll-records-jo";
  }
});</script>';
}


if(isset($_GET['delete_payroll'])) {

    $id = $_GET['delete_payroll'];
    

   $query = mysqli_query($db, "UPDATE gratuity_tbl SET isdeleted=1 WHERE payroll_id='$id' ");

    echo '<script>swal({
        title: "Deleted!",
        icon: "success",
        button: "ok!",
      });"
      
      </script>';

       echo '<script>
      document.location="payroll-records-jo";
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
                
                <h5 class="text-center">Gratuity Payroll Records</h5>
               
               
            </div>
            <div class="card-body">


                <?php $id = $_SESSION['id'];

                $query = mysqli_query($db, "SELECT officecode FROM users WHERE id='$id' ");
                if($row=mysqli_fetch_array($query)) {
                    $office = $row['officecode'];
                }
                ?>
                <?php  if($office == 'ictd') { ?>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th style="font-size:12px!important;">Payroll ID</th>
                            <th style="font-size:12px!important;">Office</th>
                             <th style="font-size:12px!important;">Date Period</th>
                            <th style="font-size:12px!important;">Date Created</th>
                            <th style="font-size:12px!important;">Released</th>
                            <th style="font-size:12px!important;">Action</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                
                    
                    </tbody>
                </table>

                <?php } else if($office == 'acc') { ?>ACC
                      <table class="table table-striped" id="acc">
                    <thead>
                        <tr>
                            <th style="font-size:12px!important;">Payroll ID</th>
                           
                            
                            <!-- <th style="font-size:12px!important;">Date Created</th> -->
                            <th style="font-size:12px!important;">Status</th>
                            <th style="font-size:12px!important;">Action</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                
                    
                    </tbody>
                </table>
            <?php } else if($office == 'treasurer') { ?>
                <table class="table table-striped" id="treasurer">
                    <thead>
                        <tr>
                            <th style="font-size:12px!important;">Payroll ID</th>
                           
                            
                            <!-- <th style="font-size:12px!important;">Date Created</th> -->
                            <th style="font-size:12px!important;">Status</th>
                            <th style="font-size:12px!important;">Action</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                
                    
                    </tbody>
                </table><?php } ?>
            </div>
        </div>

    </section>

    <!-- // Basic multiple Column Form section end -->





<div class="modal fade" id="modal_release" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Payroll Release Status
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                              X
                                            </button>
                                        </div>
                                        <div class="modal-body " style="height: 190px">

            <form action="payroll-records-jo" method="post">
           <br>
          <input type="text" style="font-size: 18px" id="option_is_released" name="" class="form-control" readonly="">

            <input type="hidden"  class="form-control" name="payroll_id"  id="pid">
           
         

          <br>
            <div style="text-align: right">
             <button type="submit" name="release_1" class="btn btn-success ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Release</span>
                                            </button>
                                               <button type="submit" name="release_0" class="btn btn-primary ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Not Yet</span>
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




<div class="modal fade" id="modal_audit" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Payroll Audit Status
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                              X
                                            </button>
                                        </div>
                                        <div class="modal-body " style="height: 250px">

            <form action="grat-record-acc-tr" method="post">
           <br>
            <input type="text"  class="form-control" name="payroll_id"  id="pid" readonly><br>
          <input type="text" style="font-size: 18px" id="input_is_audited" name="" class="form-control" readonly="">

           
           
         

          <br>
            <div style="text-align: right">
             <button type="submit" name="audit_1" class="btn btn-success ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Mark as Audited</span>
                                            </button>
                                               <button type="submit" name="audit_0" class="btn btn-danger ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Mark as Unaudited</span>
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


    
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    
<script src="assets/vendors/jquery/jquery.min.js"></script>
<script src="assets/vendors/jquery-datatables/jquery.dataTables.min.js"></script>
<script src="assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js"></script>
<script src="assets/vendors/fontawesome/all.min.js"></script>


    <script src="assets/js/mazer.js"></script>
   


<script>




        $('#table1').DataTable({
        'rowLength': 50,
        'serverSide':true,
        'processing':true,
        'paging':true,
        'order':[],
        'lengthMenu': [[7, 25, 50, -1], [7, 25, 50, "All"]],
        'ajax':{
          'url':'load-payroll-records-jo.php',
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

      $('#modal_release').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal

  var pid = button.data('pid')
  var is_r = button.data('is_released') 

   var modal = $(this)
   modal.find('.modal-body #pid').val(pid)
   modal.find('.modal-body #option_is_released').val(is_r)

});

 


           $('#treasurer').DataTable({
        'rowLength': 50,
        'serverSide':true,
        'processing':true,
        'paging':true,
        'order':[],
        'lengthMenu': [[7, 25, 50, -1], [7, 25, 50, "All"]],
        'ajax':{
          'url':'load-treasurer-payroll-records-grat.php',
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






      $('#acc').DataTable({
        'rowLength': 50,
        'serverSide':true,
        'processing':true,
        'paging':true,
        'order':[],
        'lengthMenu': [[7, 25, 50, -1], [7, 25, 50, "All"]],
        'ajax':{
          'url':'load-acc-payroll-records-jo-grat.php',
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


  $('#modal_audit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal

  var pid = button.data('pid')
  var is_r = button.data('is_audited') 

   var modal = $(this)
   modal.find('.modal-body #pid').val(pid)
   modal.find('.modal-body #input_is_audited').val(is_r)



});

</script>
     <script>

  
</script>
</body>

</html>
