<?php
session_start();
include("includes/db.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="css/admin.min.css" rel="stylesheet" />
</head>

<body class="bg-gradient-primary">
    <div class="container " style="margin-top:190px;">
        <!-- Outer Row -->
        <div class="row justify-content-center ">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block " style="background-image: url('bg.jpg');"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Hotel Lake Front</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" />
                                        </div>

                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
                                        <hr />
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>


<?php

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $get_admin = "select * from staff where email='$email' AND password='$password'";

    $run_admin = mysqli_query($conn, $get_admin);

    $user = mysqli_fetch_assoc($run_admin);



    if (mysqli_num_rows($run_admin) == 1) {
        $_SESSION['role'] = $user['position'];
        if ($run_admin && $_SESSION['role'] == 7) {

            $_SESSION['user_id'] = $user['staffid'];
            $_SESSION['first_name'] = $user['firstname'];

            header('Location: index.php');
        } elseif ($run_admin && $_SESSION['role'] == 10) {

            $_SESSION['user_id'] = $user['staffid'];
            $_SESSION['first_name'] = $user['firstname'];

            header('Location: index.php');
        } else {
            echo "<script>alert('Access denied')</script>";
        }
    } else {
        echo "<script>alert('Username or Password is Wrong')</script>";
    }
}

?>