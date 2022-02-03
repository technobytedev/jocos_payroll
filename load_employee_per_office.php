<?php


include('db.php');



if(isset($_POST['office_code']))  {

   
     $id2 = $_POST['office_code'];

      $query1 = mysqli_query($db, "SELECT * FROM department WHERE officename ='$id2'");
       if($row = mysqli_fetch_array($query1)) {
        $id = $row['officecode'];
       }
  

     $query = mysqli_query($db, "SELECT * FROM employment_info WHERE isactive='yes' AND employmenttype = 'CS' 
                                AND officecode='$id' ORDER BY SURNAME");

     $numrow = mysqli_num_rows($query);
   

    


           
             if($numrow > 0){

                while($row = mysqli_fetch_array($query)) {
                  
                 if($row['middlename'] == '') {
                  $name = $row['surname'].", ".$row['firstname']." ".$row['extension'].".";
                 }else {
                  $name = $row['surname'].", ".$row['firstname']." ".$row['extension']." ".$row['middlename'][0].".";
                   }
                echo "<option value='".$row['employeeno']." ".$name."' class='option_emp'>".$name."</option>";
                
                }
              }
              else {
                echo "<option value=''>No Employee Available</option>";
              }

      






}




?>