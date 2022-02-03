<?php
include('db.php');


$id = $_GET['id'];


$query = mysqli_query($db, "DELETE * FROM gratuity_tbl WHERE employeeno='$id' ");

echo 'delete'.$id;

?>