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

$sql = "SELECT * FROM employment_info
                ";




$query = mysqli_query($db,$sql);
$count_all_rows = mysqli_num_rows($query);

if(isset($_POST['search']['value']))
{
  $search_value = $_POST['search']['value'];
  $sql .= " WHERE employeeno like '%".$search_value."%' ";
  $sql .= " OR surname like '%".$search_value."%' ";
   $sql .= " OR firstname like '%".$search_value."%' ";
  $sql .= " OR effectivitydate like '%".$search_value."%' ";
  $sql .= " OR isactive like '%".$search_value."%' ";
    
}

if(isset($_POST['order']))
{
  $column = $_POST['order'][0]['column'];
  $order = $_POST['order'][0]['dir'];
  $sql .= " ORDER BY '".$column."' ".$order;
}
else
{
  $sql .="ORDER BY id DESC";
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

    $subarray[] = $row['employeeno'];
 if($row['middlename'] == '') {
    $subarray[] = $row['surname'].", ".$row['firstname']." ".$row['extension'];
    }

    else {
          $subarray[] = $row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0].".";
    }



$query = mysqli_query($db,"SELECT employment_info.*, department.officename, position.position
                FROM employment_info
                INNER JOIN department
                ON department.officecode=employment_info.officecode
                INNER JOIN position
                ON position.positioncode=employment_info.positioncode 
                WHERE employeeno = '".$row['employeeno']."'");

if($row2=mysqli_fetch_array($query)) {
  $office = $row2['officename'];
  $pos = $row2['position'];
}
 






$subarray[] = '   <button data-whatever="'.$office.'" type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter">
                                Office
                            </button>

                            <button data-whatever="'.$pos.'" type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter">
                                Position
                            </button>
                            ';
 


  
    $subarray[] = date("M j, Y",strtotime($row['effectivitydate']));

      $subarray[] = date("M j, Y",strtotime($row['fromdate']))."-".date("M j, Y",strtotime($row['todate']));

    if($row['atmno'] == 0) {
      $subarray[] = "<span style='color:red'>no</span>";
    }
    else {
      $subarray[] = "<span style=''>yes</span>";
    }

        if($row['claimed'] == 'no') {
      $subarray[] = "<span style='color:red'>no</span>";
    }

   else if($row['claimed'] == 'yes') {
      $subarray[] = "<span style=''>yes</span>";
    }else {
      $subarray[] = " ";
    }
    


     if($row['isactive'] == 'yes') {
      $subarray[] = "<span class='bg-success p-1 text-white'>active <i class='fa fa-check'></i></span>";
    }
    else {
      $subarray[] = "<span class='bg-danger p-1 text-white'>inactive <b>X</b></span>";
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


