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

        <!-- <canvas id="myChart" style="height:500px;max-width:1700px"></canvas> -->
        <!-- Content Row -->

    </div>
    <!-- End of Main Content -->
    <!-- <?php
            $day = array(10);

            for ($i = 1; $i <= 10; $i++) {

                $date = date('d ');
                $month = date('m ');
                $dt = strtotime($date);
                $revd = date("d ", strtotime("-$i day", $dt));
                $sum = "SELECT sum(amount) FROM payment WHERE MONTH(paydatetime) = '$month' AND DAY(paydatetime) = '$revd'";
                $run_sum = mysqli_query($conn, $sum);
                $tsum = mysqli_fetch_assoc($run_sum);
                $day[$i - 1] = $tsum;
                echo $revd;
            }


            ?> -->

    <!-- Bootstrap core JavaScript-->

    <!-- <script>
        var xValues = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7', 'Day 8', 'Day 9', 'Day 10'];
        var yValues = [<?php echo $day[0] ?>, <?php echo $day[1] ?>, <?php echo $day[2] ?>, <?php echo $day[3] ?>, <?php echo $day[4] ?>, <?php echo $day[5] ?>, <?php echo $day[6] ?>, <?php echo $day[7] ?>, <?php echo $day[8] ?>, <?php echo $day[9] ?>];

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.5)",
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 6,
                            max: 16
                        }
                    }],
                }
            }
        });
    </script> -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
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