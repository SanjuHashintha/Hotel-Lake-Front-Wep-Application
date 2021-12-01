<?php
session_start();
include("includes/header.php");
include("includes/navbar.php");
include("includes/topbar.php");
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {

    echo "<script>window.open('login.php','_self')</script>";
} else {



?>

    <?php

    $get_staff = "select count(staffid) from staff ";
    $run_staff = mysqli_query($conn, $get_staff);
    $row_staff = mysqli_fetch_array($run_staff);
    $totalstaff = $row_staff['count(staffid)'];
    ?>


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Staff</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalstaff ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $date = date('Y-m-d');

            $get_amount = "select sum(amount) from payment where paydatetime like '$date%' ";
            $run_amount = mysqli_query($conn, $get_amount);
            $row_amount = mysqli_fetch_array($run_amount);
            $dailyamount = $row_amount['sum(amount)'];
            ?>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Earnings (Daily)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rs: <?php echo $dailyamount ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            $date = date('Y-m-d H:i:s');

            $getguestcount = "SELECT distinct count(guest.guestid) FROM booking INNER JOIN guest on guest.guestid = booking.guestid INNER JOIN room on room.roomid = booking.roomid where booking.departuredate >= '$date'";
            $runguestcount = mysqli_query($conn, $getguestcount);
            $row_guestcount = mysqli_fetch_array($runguestcount);
            $currentGuest = $row_guestcount['count(guest.guestid)'];

            ?>


            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Available Room</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo 32 - $currentGuest ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Booked Rooms</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $currentGuest ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <h1>Wellcome to Hotel Lake Front</h1>
        </div>


    </div>
    <!-- /.container-fluid -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Monthly Revenue</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
            <hr>

        </div>

        <!-- Content Row -->

    </div>
    <!-- End of Main Content -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>


    <?php
    include("includes/scripts.php");
    include("includes/footer.php");
    ?>

<?php } ?>