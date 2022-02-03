<?php 
include('db.php');
date_default_timezone_set('Asia/Manila'); 
session_start();

if(empty($_SESSION['id'])) {
    echo "<script>document.location='login'</script>";
}
?>
<div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <div class="d-flex">
            
               <span style="font-size: 19px;">JOCOS PAYROLL SYSTEM</span>
            
            <div class="toggler">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>


<?php if($_SESSION['id'] == 1) { ?>

    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>


         
            

            <?php 
           if(basename($_SERVER['PHP_SELF']) == "index.php") 

            {


            ?>
            <li
                class="sidebar-item active ">
                <a href="index" class='sidebar-link'>
                    <i class="bi bi-grid-fill "></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php } else { ?> 

                <li
                class="sidebar-item ">
                <a href="index" class='sidebar-link'>
                    <i class="bi bi-grid-fill "></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <?php } ?>


               <?php 
           if(basename($_SERVER['PHP_SELF']) == "employee-records.php") 

            {


            ?>
            <li
                class="sidebar-item active ">
                <a href="employee-records" class='sidebar-link'>
                    <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Employee Records</span>
                </a>
            </li>
            <?php } else { ?> 

                <li
                class="sidebar-item ">
                <a href="employee-records" class='sidebar-link'>
                    <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Employee Records</span>
                </a>
            </li>

            <?php } ?>


            <?php $id = $_SESSION['id'];
            $query = mysqli_query($db, "SELECT officecode FROM users WHERE id='$id'");
            if($row=mysqli_fetch_array($query)) {
                $office = $row['officecode'];
            }
            if($office == 'acc' OR $office == 'ictd') {

           if(basename($_SERVER['PHP_SELF']) == "employee-ledger.php") 

            {


            ?>
            <li
                class="sidebar-item active ">
                <a href="employee-ledger" class='sidebar-link'>
                    <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Ledger COS</span>
                </a>
            </li>
            <?php } else { ?> 

                <li
                class="sidebar-item ">
                <a href="employee-ledger" class='sidebar-link'>
                    <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Employee Ledger</span>
                </a>
            </li>

            <?php } } ?>

        
            <li
                class="sidebar-item has-sub">
                <a href="create-gratuity.php" class='sidebar-link'>
                <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Create Salary Payroll </span>
                </a>
                <ul class="submenu ">

            <?php 
           if(basename($_SERVER['PHP_SELF']) == "create-salary-cos.php") 

            {


            ?>

                    <li class="submenu-item active">
                        <a href="create-salary-cos">COS</a>
                    </li>
                    <li class="submenu-item">
                        <a href="create-salary-jo">JO</a>
                    </li>
                   
                    </ul>
            </li>
        <?php } else if(basename($_SERVER['PHP_SELF']) == "create-salary-jo.php") { ?>

            



                 <li class="submenu-item">
                        <a href="create-salary-cos">COS</a>
                    </li>

                    <li class="submenu-item active">
                        <a href="create-salary-jo">JO</a>
                    </li>
                    <li class="submenu-item">
                  



                    </ul>
            </li>

              

    

            <?php } else { ?>
                <li class="submenu-item">
                        <a href="create-salary-cos">COS</a>
                    </li>

                    <li class="submenu-item">
                        <a href="create-salary-jo">JO</a>
                    </li>
                 

                    </ul>
            </li>
                <?php } ?>


            

          
 <li
                class="sidebar-item has-sub">
                <a href="create-gratuity.php" class='sidebar-link'>
                <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Payroll Records </span>
                </a>
                <ul class="submenu ">

            <?php 
           if(basename($_SERVER['PHP_SELF']) == "payroll-records.php") 

            {


            ?>

                    <li class="submenu-item active">
                        <a href="payroll-records">COS</a>
                    </li>
                    <li class="submenu-item">
                        <a href="payroll-records-jo">JO</a>
                    </li>
                   
                    </ul>
            </li>
        <?php } else if(basename($_SERVER['PHP_SELF']) == "payroll-records.php") { ?>

            



                 <li class="submenu-item">
                        <a href="payroll-records">COS</a>
                    </li>

                    <li class="submenu-item active">
                        <a href="payroll-records-jo">JO</a>
                    </li>
                    <li class="submenu-item">
                  



                    </ul>
            </li>

              

    

            <?php } else { ?>
                <li class="submenu-item">
                        <a href="payroll-records">COS</a>
                    </li>

                    <li class="submenu-item">
                        <a href="payroll-records-jo">JO</a>
                    </li>
                 

                    </ul>
            </li>
                <?php } ?>



      
         

            <li
                class="sidebar-item has-sub">
                <a href="create-gratuity.php" class='sidebar-link'>
                <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Create Gratuity</span>
                </a>
                <ul class="submenu ">

            <?php 
           if(basename($_SERVER['PHP_SELF']) == "create-gratuity-cos.php") 

            {


            ?>

                    <li class="submenu-item active">
                        <a href="create-gratuity-cos">COS</a>
                    </li>
                    <li class="submenu-item">
                        <a href="create-gratuity-jo">JO</a>
                    </li>
                    <li class="submenu-item">
                        <a href="create-grat-emp-def-rec-cos">COS Def</a>
                    </li>
                    </ul>
            </li>
        <?php } else if(basename($_SERVER['PHP_SELF']) == "create-gratuity-jo.php") { ?>

            



                 <li class="submenu-item">
                        <a href="create-gratuity-cos">COS</a>
                    </li>

                    <li class="submenu-item active">
                        <a href="create-gratuity-jo">JO</a>
                    </li>
                    <li class="submenu-item">
                        <a href="create-grat-emp-def-rec-cos">COS Def</a>
                    </li>



                    </ul>
            </li>

              

    

            <?php } else { ?>
                <li class="submenu-item">
                        <a href="create-gratuity-cos">COS</a>
                    </li>

                    <li class="submenu-item">
                        <a href="create-gratuity-jo">JO</a>
                    </li>
                    <li class="submenu-item">
                        <a href="create-grat-emp-def-rec-cos">COS Def</a>
                    </li>

                    </ul>
            </li>
                <?php } ?>

            
            


         


            <li
                class="sidebar-item has-sub">
                <a href="grat-records-cos.php" class='sidebar-link'>
                <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Gratuity Records</span>
                </a>
                <ul class="submenu ">

            <?php 
           if(basename($_SERVER['PHP_SELF']) == "grat-records-cos.php") 

            {


            ?>

                    <li class="submenu-item active">
                        <a href="grat-records-cos">COS</a>
                    </li>
                    <li class="submenu-item">
                        <a href="grat-records-jo">JO</a>
                    </li>
                    <li class="submenu-item">
                        <a href="grat-def-cos">COS w/ Deficiency</a>
                    </li>
                    <li class="submenu-item">
                        <a href="grat-def-jo">JO w/ Deficiency</a>
                    </li>
                    </ul>
            </li>
        <?php } else if(basename($_SERVER['PHP_SELF']) == "grat-records-jo.php") { ?>

            



                 <li class="submenu-item">
                        <a href="grat-records-cos">COS</a>
                    </li>

                    <li class="submenu-item active">
                        <a href="grat-records-jo">JO</a>
                    </li>

                     <li class="submenu-item">
                        <a href="grat-def-cos">COS w/ Deficiency</a>
                    </li>
                    <li class="submenu-item">
                        <a href="grat-def-jo">JO w/ Deficiency</a>
                    </li>

                    </ul>
            </li>

              

    

            <?php } else { ?>
                <li class="submenu-item">
                        <a href="grat-records-cos">COS</a>
                    </li>

                    <li class="submenu-item">
                        <a href="grat-records-jo">JO</a>
                    </li>

                    <li class="submenu-item">
                        <a href="grat-def-jo">COS w/ Deficiency</a>
                    </li>
                    <li class="submenu-item">
                        <a href="grat-def-jo">JO w/ Deficiency</a>
                    </li>

                    </ul>
            </li>
                <?php } }  else { ?>



                        <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>


         
            

            <?php 
           if(basename($_SERVER['PHP_SELF']) == "index.php") 

            {


            ?>
            <li
                class="sidebar-item active ">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-grid-fill "></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php } else { ?> 

                <li
                class="sidebar-item ">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-grid-fill "></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <?php } ?>


               <?php 
           if(basename($_SERVER['PHP_SELF']) == "employee-records.php") 

            {


            ?>
            <li
                class="sidebar-item active ">
                <a href="#" class='sidebar-link'>
                    <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Employee Records</span>
                </a>
            </li>
            <?php } else { ?> 

                <li
                class="sidebar-item ">
                <a href="#" class='sidebar-link'>
                    <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Employee Records</span>
                </a>
            </li>

            <?php } ?>


             <?php $id = $_SESSION['id'];
            $query = mysqli_query($db, "SELECT officecode FROM users WHERE id='$id'");
            if($row=mysqli_fetch_array($query)) {
                $office = $row['officecode'];
            }
            if($office == 'acc' OR $office == 'ictd') {

           if(basename($_SERVER['PHP_SELF']) == "employee-ledger.php") 

            {


            ?>
            <li
                class="sidebar-item active ">
                <a href="employee-ledger" class='sidebar-link'>
                    <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Employee Ledger</span>
                </a>
            </li>
            <?php } else { ?> 

                <li
                class="sidebar-item ">
                <a href="employee-ledger" class='sidebar-link'>
                    <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Employee Ledger</span>
                </a>
            </li>

            <?php } } ?>

        
            <li
                class="sidebar-item has-sub">
                <a href="#" class='sidebar-link'>
                <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Create Salary Payroll </span>
                </a>
                <ul class="submenu ">

            <?php 
           if(basename($_SERVER['PHP_SELF']) == "create-salary-cos.php") 

            {


            ?>

                    <li class="submenu-item active">
                        <a href="#">COS</a>
                    </li>
                    <li class="submenu-item">
                        <a href="#">JO</a>
                    </li>
                   
                    </ul>
            </li>
        <?php } else if(basename($_SERVER['PHP_SELF']) == "create-salary-jo.php") { ?>

            



                 <li class="submenu-item">
                        <a href="#">COS</a>
                    </li>

                    <li class="submenu-item active">
                        <a href="#">JO</a>
                    </li>
                    <li class="submenu-item">
                  



                    </ul>
            </li>

              

    

            <?php } else { ?>
                <li class="submenu-item">
                        <a href="#">COS</a>
                    </li>

                    <li class="submenu-item">
                        <a href="#">JO</a>
                    </li>
                 

                    </ul>
            </li>
                <?php } ?>


            

          
 <li
                class="sidebar-item has-sub">
                <a href="#" class='sidebar-link'>
                <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Payroll Records </span>
                </a>
                <ul class="submenu ">

            <?php 
           if(basename($_SERVER['PHP_SELF']) == "payroll-records.php") 

            {


            ?>

                    <li class="submenu-item active">
                        <a href="payroll-records">COS</a>
                    </li>
                    <li class="submenu-item">
                        <a href="payroll-records-jo">JO</a>
                    </li>
                   
                    </ul>
            </li>
        <?php } else if(basename($_SERVER['PHP_SELF']) == "payroll-records.php") { ?>

            



                 <li class="submenu-item">
                        <a href="payroll-records">COS</a>
                    </li>

                    <li class="submenu-item active">
                        <a href="payroll-records-jo">JO</a>
                    </li>
                    <li class="submenu-item">
                  



                    </ul>
            </li>

              

    

            <?php } else { ?>
                <li class="submenu-item">
                        <a href="payroll-records">COS</a>
                    </li>

                    <li class="submenu-item">
                        <a href="payroll-records-jo">JO</a>
                    </li>
                 

                    </ul>
            </li>
                <?php } ?>



      
         

            <li
                class="sidebar-item has-sub">
                <a href="#" class='sidebar-link'>
                <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Create Gratuity</span>
                </a>
                <ul class="submenu ">

            <?php 
           if(basename($_SERVER['PHP_SELF']) == "create-gratuity-cos.php") 

            {


            ?>

                    <li class="submenu-item active">
                        <a href="#">COS</a>
                    </li>
                    <li class="submenu-item">
                        <a href="#">JO</a>
                    </li>
                    <li class="submenu-item">
                        <a href="#">COS Def</a>
                    </li>
                    </ul>
            </li>
        <?php } else if(basename($_SERVER['PHP_SELF']) == "create-gratuity-jo.php") { ?>

            



                 <li class="submenu-item">
                        <a href="#">COS</a>
                    </li>

                    <li class="submenu-item active">
                        <a href="#">JO</a>
                    </li>
                    <li class="submenu-item">
                        <a href="#">COS Def</a>
                    </li>



                    </ul>
            </li>

              

    

            <?php } else { ?>
                <li class="submenu-item">
                        <a href="#s">COS</a>
                    </li>

                    <li class="submenu-item">
                        <a href="#">JO</a>
                    </li>
                    <li class="submenu-item">
                        <a href="#">COS Def</a>
                    </li>

                    </ul>
            </li>
                <?php } } ?>

            
            
  <li
                class="sidebar-item ">
                <a href="grat-record-acc-tr" class='sidebar-link'>
                    <svg class="bi" width="1em" height="1em" fill="currentColor">
                    <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-earmark-text-fill"></use>
                </svg>
                    <span>Gratuity Records</span>
                </a>
            </li>


         


            


            <br>
             <br>
              <br>
               <br>
                <br> <br>
            <li
                class="sidebar-item ">
                <a  class='sidebar-link'>
                   
                    <span style="font-size: 11px;">V1.0</span>
                </a>
            </li>
            
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                
                
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <?php $id= $_SESSION['id'];
                         $query = mysqli_query($db,"SELECT username FROM users WHERE id = '$id'");
                         if($row=mysqli_fetch_array($query)) {
                            $user = $row['username'];
                         } ?>
                        <li class="breadcrumb-item"><?php echo $user; ?></li>
                        <!-- <li class="breadcrumb-item " aria-current="page">ICTD</li>  -->
                      
                        <li class="breadcrumb-item " aria-current="page"> <a href="logout.php"> Logout</a></li>
                       
                    </ol>
                </nav>
            </div>
        </div>
    </div>