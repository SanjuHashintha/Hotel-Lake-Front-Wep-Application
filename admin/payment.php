<?php
session_start();
include("includes/header.php");
include("includes/navbar.php");
include("includes/topbar.php");
include("includes/db.php");

if (isset($_GET['payid'])) {

    $pay = $_GET['payid'];
    $get_pro = "select * from guest where guestid='$pay'";
    $run_pro = mysqli_query($conn, $get_pro);
    $row_pro = mysqli_fetch_array($run_pro);

    $idno = $row_pro['idno'];
    $fullname = $row_pro['fullname'];


    $get_servicecharges = "SELECT sum((DATEDIFF( departuredate, arrivaldate)*service.price)) AS 'Amount' FROM booking inner join service on booking.serviceid = service.serviceid where booking.guestid = '$pay';";
    $run_servicecharge = mysqli_query($conn, $get_servicecharges);
    $row_servicecharge = mysqli_fetch_array($run_servicecharge);
    $serviceAmount = $row_servicecharge['Amount'];


    // $get_payment = "SELECT (DATEDIFF(arrivaldate, departuredate)*room.price) AS 'Amount' FROM room INNER JOIN booking ON room.roomid=booking.roomid INNER JOIN room ON(room.RoomCategoryID=room_catergory.RoomCatergoryID) WHERE room_booking.RoomID=rid AND room_booking.StartDate=sdate and room_booking.EndDate=edate"
    $get_roomcharges = "SELECT (DATEDIFF( departuredate, arrivaldate)*room.price) AS 'RoomCharge' FROM booking inner join room on booking.roomid = room.roomid where booking.guestid = '$pay';";
    $run_roomcharge = mysqli_query($conn, $get_roomcharges);
    $row_roomcharge = mysqli_fetch_array($run_roomcharge);
    $roomAmount = $row_roomcharge['RoomCharge'];

    $totalAmount = $serviceAmount + $roomAmount;


    $bol = "select count(guestid) from payment where guestid = '$pay'";
    $run_bol = mysqli_query($conn, $bol);
    $row_bol = mysqli_fetch_array($run_bol);
    $rowcount = $row_bol['count(guestid)'];
    if ($rowcount == 0) {
        $tobepaid = $totalAmount;
        $paid = 0;
    } else {

        $boll = "select tobepaid from payment where guestid = '$pay' AND paydatetime = (SELECT MAX(paydatetime) FROM payment WHERE guestid = '$pay')";
        $run_boll = mysqli_query($conn, $boll);
        $row_boll = mysqli_fetch_array($run_boll);
        $tobepaid = $row_boll['tobepaid'];
        $paid = $totalAmount - $tobepaid;
    }
}


?>



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Payment</h1>

    </div>

    <div class="container px-5 my-5">
        <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
            <div class="mb-3">

                <input class="form-control" id="guestid" name="guestid" type="hidden" placeholder="Guest ID" />
                <label class="form-label" id="guestid" type="hidden" name="guestid" for="guestid" style="color: white;"><?php echo $pay ?></label>
            </div>

            <div class="mb-3">
                <label class="form-label" for="idno" style="font-size: 30px; color:grey">ID No : </label>
                <label class="form-label" id="idno" name="idno" for="idno" style="font-size: 30px; color:grey"><?php echo $idno ?></label>



            </div>
            <div class="mb-3">
                <label class="form-label" for="fullName" style="font-size: 30px; color:grey">Full Name : </label>
                <label class="form-label" for="fullName" style="font-size: 30px; color:grey"><?php echo $fullname ?></label>



            </div>

            <div class="mb-3">
                <label class="form-label" for="roomcharges" style="font-size: 30px; color:grey">Room charges : </label>
                <label class="form-label" for="roomcharges" style="font-size: 30px; color:blue"><?php echo $roomAmount ?></label>
            </div>

            <div class="mb-3">
                <label class="form-label" for="foodchrages" style="font-size: 30px; color:grey">Charges for services : </label>
                <label class="form-label" for="servicecharge" style="font-size: 30px; color:blue"><?php echo $serviceAmount ?></label>
            </div>
            <div class="mb-3">
                <label class="form-label" for="foodchrages" style="font-size: 30px; color:grey">Total Amount : </label>
                <label class="form-label" id="totalAmount" name="totalAmount" for="roomcharges" style="font-size: 30px; color:black"><?php echo $totalAmount ?></label>
            </div>
            <div class="mb-3">
                <label class="form-label" for="foodchrages" style="font-size: 30px; color:grey">Paid : </label>
                <label class="form-label" for="paid" style="font-size: 30px; color:green"><?php echo $paid ?></label>
            </div>
            <div class="mb-3">
                <label class="form-label" for="foodchrages" style="font-size: 30px; color:grey">To be paid : </label>
                <label class="form-label" id="tobepaid" name="tobepaid" for="tobepaid" style="font-size: 30px; color:red"><?php echo $tobepaid ?></label>
            </div>
            <div class="mb-3">
                <label class="form-label" for="foodchrages" style="font-size: 30px; color:grey">Current payment : </label>
                <input id="currentPayment" name="currentPayment" type="text" placeholder="Current payment" data-sb-validations="required" />
            </div>


            <div class="modal-footer">
                <button type="submit" name="closepayment" class="btn btn-secondary">Close</button>
                <button type="submit" name="updatepayment" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['closepayment'])) {
        echo "<script> window.open('guest.php ','_self')</script>";
    }
    if (isset($_POST['updatepayment'])) {

        $date = date('Y-m-d H:i:s');

        $currentPayment = $_POST['currentPayment'];
        $insertPayment = "insert into payment (guestid, amount, tobepaid, paydatetime)"
            . " values ('$pay','$currentPayment',$tobepaid - $currentPayment, '$date')";
        $runPayment = mysqli_query($conn, $insertPayment);

        if ($runPayment) {
            echo "<script> alert('Payment updated successfully ')</script>";
            echo "<script> window.open('guest.php ','_self')</script>";
        } else {
            echo "<script> alert('Payment updated failed')</script>";
        }
    }




    ?>

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
?>