<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Payroll System</title>
   
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
</head>
<?php
session_start();
if(isset($_POST['login'])) {
     $user = $_POST['username'];
     $pass = $_POST['password'];

    include('db.php');

    $query = mysqli_query($db, "SELECT * FROM users WHERE username='$user' AND password='$pass' ");
    $numrows = mysqli_num_rows($query);
    if($numrows > 0) {

          $query = mysqli_query($db, "SELECT * FROM users WHERE username='$user' AND password='$pass' ");
             if($rows = mysqli_fetch_array($query)) {
                 $id = $rows['id'];
                 $_SESSION['id'] = $id;
             } 
       
       if($id == 1) {
       echo '<script>document.location="index"</script>';
      }else {
        echo '<script>document.location="payroll-records"</script>';
      }
    }else{
       echo '<script>document.location="login"</script>';

    }
}

 ?>
<body>
    <div id="auth">
        
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
           
            <h1 class="auth-title" style="font-size: 55px!important;">Payroll System</h1>
           

            <form action="login.php" method="post">
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" class="form-control form-control-xl" name="username" placeholder="Username">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
               
                <button type="submit" name="login" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                
                <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p>
            </div>
        </div>
    </div>
    <div style="background-color: white!important;" class="col-lg-7  d-lg-block">
        <div  style=" filter: hue-rotate(90deg); filter: drop-shadow(8px 8px 10px grey);filter: saturate(90%);" id="">
<img src="123.png" class="mt-3 img-fluid img-responsive">
        </div>
    </div>
</div>

    </div>
</body>

</html>
