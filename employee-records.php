<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Records</title>
    
    
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
                
                <h5 class="text-center">JOCOS Employee Records</h5>
               
               
            </div>
            <div class="card-body">
                
                <table class="table table-striped" id="emps">
                    <thead>
                        <tr>
                            <th style="font-size:12px!important;">Employee NO.</th>
                            <th style="font-size:12px!important;">Name</th>
                             <th style="font-size:12px!important;">Office|Position</th>
                            <th style="font-size:12px!important;">Effectivity</th>
                            <th style="font-size:12px!important;">Contract</th>
                            <th style="font-size:12px!important;">ATM</th>
                             <th style="font-size:12px!important;">First Claimed</th>
                            <th style="font-size:12px!important;">Status</th>
                            
                            
                        </tr>
                    </thead>
              
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

    // $('#table1').DataTable({
        
    //     'processing':true,
    //     'paging':true,
    //     'order':[],
    //     'lengthMenu': [[8, 25, 100, -1], [8, 25, 100, "All"]],
     

    //   });

    $('#exampleModalCenter').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})



        $('#emps').DataTable({
        'rowLength': 50,
        'serverSide':true,
        'processing':true,
        'paging':true,
        'order':[],
        'lengthMenu': [[7, 25, 50, -1], [7, 25, 50, "All"]],
        'ajax':{
          'url':'load-employee-records.php',
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
    
</body>

</html>
