<?php 
session_start();
include('db.php');

// $sql = "SELECT employment_info.*, department.officename, position.position
//                 FROM employment_info
//                 INNER JOIN department
//                 ON department.officecode=employment_info.officecode
//                 INNER JOIN position
//                 ON position.positioncode=employment_info.positioncode
//                 ";

$sql = "
   SELECT DISTINCT 
   payroll_tbl.payroll_id,payroll_tbl.type,payroll_tbl.isreleased,payroll_tbl.isaudited,
   payroll_tbl.date_from,payroll_tbl.date_to,payroll_tbl.date_created, payroll_tbl.type 
   FROM payroll_tbl 
   INNER JOIN department 
   ON department.officecode = payroll_tbl.officecode AND isdeleted=0
     ";




$query = mysqli_query($db,$sql);
$count_all_rows = mysqli_num_rows($query);

if(isset($_POST['search']['value']))
{
  $search_value = $_POST['search']['value'];
  $sql .= " WHERE payroll_id like '%".$search_value."%' ";
  //$sql .= " OR officename like '%".$search_value."%' ";
  $sql .= " OR date_from like '%".$search_value."%' ";
  $sql .= " OR date_to like '%".$search_value."%' ";
  $sql .= " OR date_created like '%".$search_value."%' ";
    
}

if(isset($_POST['order']))
{
  $column = $_POST['order'][0]['column'];
  $order = $_POST['order'][0]['dir'];
  $sql .= " ORDER BY '".$column."' ".$order;
}
else
{
  $sql .="ORDER BY payroll_tbl.id DESC";
}


if($_POST['length'] != -1)
{
  $start = $_POST['start'];
  $length = $_POST['length'];
  $sql .=" LIMIT ".$start.", ".$length;
}

$data = array();

$run_query = mysqli_query($db,$sql);
$filtered_rows = mysqli_num_rows($run_query);
while($row = mysqli_fetch_assoc($run_query))     
{
  $subarray = array();

    $payroll_id = $row['payroll_id'];
    $subarray[] = $row['payroll_id'];
   // $subarray[] = $row['officename'];
    $subarray[] = date("M d-",strtotime($row['date_from'])).date("d, Y",strtotime($row['date_to']));
    $subarray[] = date("M j, Y, g:i a",strtotime($row['date_created']));

if($row['type'] == 'full')  {

   if($row['isaudited'] == 1) {

     $subarray[] = '<span> Audited</span>';

        $subarray[] = 
                          '<span  data-pid="'.$payroll_id.'" data-is_audited="Audited"
                             type="button" data-bs-toggle="modal"
                                data-bs-target="#modal_audit" 
                                class="btn btn-sm btn-primary class="">Update</span>
                                 <a data-toggle="tooltip" data-placement="top" title=" PAYROLL - Print Preview" target="_blank" class="text-white" 
                             href="payroll-print-full?payroll_id='.$payroll_id.'">
                               <span class="btn btn-sm btn-info">
                              View</span></a>
                        ';
    }else {
       $subarray[] = '<span >Unaudited</span>';

        $subarray[] = 
                          '<span  data-pid="'.$payroll_id.'" data-is_audited="Unaudited"
                             type="button" data-bs-toggle="modal"
                                data-bs-target="#modal_audit" 
                                class="btn btn-sm btn-primary class="">Update</span>
                                 <a data-toggle="tooltip" data-placement="top" title=" PAYROLL - Print Preview" target="_blank" class="text-white" 
                             href="payroll-print-full?payroll_id='.$payroll_id.'">
                               <span class="btn btn-sm btn-info">
                              View</span></a>
                        ';

    }
}


 else {  

  if($row['isaudited'] == 1) {

     $subarray[] = '<span> Audited</span>';

        $subarray[] = 
                          '<span  data-pid="'.$payroll_id.'" data-is_audited="Audited"
                             type="button" data-bs-toggle="modal"
                                data-bs-target="#modal_audit" 
                                class="btn btn-sm btn-primary class="">Update</span>
                                 <a data-toggle="tooltip" data-placement="top" title=" PAYROLL - Print Preview" target="_blank" class="text-white" 
                             href="payroll-print?payroll_id='.$payroll_id.'">
                               <span class="btn btn-sm btn-info">
                              View</span></a>
                        ';
    }else {
       $subarray[] = '<span >Unaudited</span>';

        $subarray[] = 
                          '<span  data-pid="'.$payroll_id.'" data-is_audited="Unaudited"
                             type="button" data-bs-toggle="modal"
                                data-bs-target="#modal_audit" 
                                class="btn btn-sm btn-primary class="">Update</span>
                                 <a data-toggle="tooltip" data-placement="top" title=" PAYROLL - Print Preview" target="_blank" class="text-white" 
                             href="payroll-print?payroll_id='.$payroll_id.'">
                               <span class="btn btn-sm btn-info">
                              View</span></a>
                        ';

    }
}

      



  $data[]= $subarray;
}

$output = array(
  'data'=>$data,
  'draw'=>intval($_POST['draw']),
  'recordsTotal'=>$count_all_rows,
  'recordsFiltered'=>$count_all_rows,
);

echo json_encode($output);


