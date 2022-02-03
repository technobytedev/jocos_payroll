<?php


include('db.php');



if(isset($_POST['office_code']))  {

   
     $id = $_POST['office_code'];
  

     $query = mysqli_query($db, "SELECT * FROM employment_info WHERE isactive='yes' AND employmenttype = 'CS' AND atmno != '0' AND claimed='yes' ORDER BY surname");

     $numrow = mysqli_num_rows($query);
   

    


           
             if($numrow > 0){

                while($row = mysqli_fetch_array($query)) {
               $name = $row['surname'].", ".$row['firstname'];
                echo "<option value='".$row['id']." ".$name."' class='option_emp'>".$name."</option>";
                
                }
              }
              else {
                echo "<option value=''>No Employee Available</option>";
              }

      






}




?>