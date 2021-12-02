<?php
session_start();
include("includes/header.php");
include("includes/navbar.php");
include("includes/topbar.php");
include("includes/db.php");
?>

<?php

if (isset($_GET['change'])) {

    $edit_id = $_GET['change'];

    $get_pro = "select * from staff where staffId='$edit_id'";

    $run_pro = mysqli_query($conn, $get_pro);


    $row_pro = mysqli_fetch_array($run_pro);

    $firstname = $row_pro['firstname'];
    $id = $row_pro['staffid'];
}

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Account</h1>

    </div>

    <div class="container px-5 my-5">
        <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
            <div class="mb-3">
                <label class="form-label" for="firstName">First Name</label> <br>
                <label class="form-label" for="firstName" id="firstName"><?php echo $firstname ?></label>

            </div>
            <div class="mb-3">
                <label class="form-label" for="newPassword">New Password</label>
                <input class="form-control" id="newPassword" name="password" type="text" placeholder="New Password" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="confirmPassword">Confirm Password</label>
                <input class="form-control" id="confirmPassword" name="confirmpassword" type="text" placeholder="Confirm Password" />
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="updatepassword">Update Account</button>
            </div>

        </form>
    </div>


    <!-- Content Row -->
    <div class="row">

    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php
include("includes/scripts.php");
include("includes/footer.php");

if (isset($_POST['updatepassword'])) {


    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    if ($password == $confirmpassword) {
        $insertpassword = "update  staff set password='$password' where staffid = '$edit_id'";
        $run_password = mysqli_query($conn, $insertpassword);

        if ($run_password) {
            echo "<script> alert('Password updated successfully ')</script>";
            echo "<script> window.open('index.php ','_self')</script>";
        }
    } else {
        echo "<script> alert('Confirm password did no match ')</script>";
    }
}
?>