<?php


include('db.php');



if(isset($_POST['office_code']))  {

   
     $id = $_POST['office_code'];
  

     $query = mysqli_query($db, " SELECT * FROM `employment_info` WHERE grat_release=0 AND employmenttype='JO' AND todate='2021-12-31' AND isactive='yes' ");

     $numrow = mysqli_num_rows($query);
   

    


           
             if($numrow > 0){

                while($row = mysqli_fetch_array($query)) {
               $name = $row['surname'].", ".$row['firstname'];
                echo "<option value='".$row['employeeno']." ".$name."' class='option_emp'>".$name."</option>";
                
                }
              }
              else {
                echo "<option value=''>No Employee Available</option>";
              }

      






}




?>