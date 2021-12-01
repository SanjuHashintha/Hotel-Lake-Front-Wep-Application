<?php
session_start();
include("includes/header.php");
include("includes/navbar.php");
include("includes/topbar.php");
include("includes/db.php");



// dropdown list item fetch from database
$query = "select roomid, roomname from room";
$resultset = mysqli_query($conn, $query);

$room_list = "";
while ($result = mysqli_fetch_assoc($resultset)) {
    $room_list .= "<option value = \"{$result['roomid']}\" >{$result['roomname']}</option>";
}

// dropdown list item fetch from database
$squery = "select serviceid, servicename from service";
$resultsets = mysqli_query($conn, $squery);

$service_list = "";
while ($results = mysqli_fetch_assoc($resultsets)) {
    $service_list .= "<option value = \"{$results['serviceid']}\" >{$results['servicename']}</option>";
}
?>

<?php
// staff insert here

$idtype = '';
$idno = '';
$firstname = '';
$fullname = '';
$gender = '';
$address = '';
$telephone = '';
$email = '';
$roomtype = '';
$arrivaldate = '';
$departuredate = '';
$service = '';


$errorBox = array();
$idtypeErr = $idErr = $fullnameErr = $fristnameErr = $genderErr = $birthdayErr = $addressErr = $telephoneErr  = $roomtypeErr = $arrivaldateErr = $departuredateErr =  "";

if (isset($_POST['addgeust'])) {

    $guestid = $_POST['guestid'];
    $idtype = $_POST['idtype'];
    $idno = $_POST['idno'];
    $fullname = $_POST['fullname'];
    $firstname  = $_POST['firstname'];
    $gender  = $_POST['gender'];
    $address  = $_POST['address'];
    $telephone  = $_POST['telephone'];
    $email  = $_POST['email'];
    $roomtype  = $_POST['roomtype'];
    $arrivaldate  = $_POST['arrivaldate'];
    $departuredate  = $_POST['departuredate'];



    if (empty(trim($_POST['idtype']))) {
        $idtypeErr = 'Id type is required';
        $errorBox[] = 1;
    }

    if (empty(trim($_POST['idno']))) {
        $idErr = 'Id number is required';
        $errorBox[] = 1;
    }

    if (empty(trim($_POST['firstname']))) {
        $fristnameErr = 'First Name is required';
        $errorBox[] = 1;
    }

    if (empty(trim($_POST['fullname']))) {
        $fullnameErr = 'Full Name is required';
        $errorBox[] = 1;
    }

    if (empty($_POST['gender'])) {
        $genderErr = 'Gender is required';
        $errorBox[] = 1;
    }


    if (empty(trim($_POST['address']))) {
        $addressErr = 'Address is required';
        $errorBox[] = 1;
    }

    if (empty(trim($_POST['telephone']))) {
        $telephoneErr = 'Telephone no is required';
        $errorBox[] = 1;
    } else {
        if (!is_numeric($telephone)) {
            $telephoneErr = "Only numbers are allowed.";
            $errorBox[] = 1;
        }
    }

    if (empty($_POST['roomtype'])) {
        $roomtypeErr = 'Room type is required';
        $errorBox[] = 1;
    }



    if (empty($_POST['arrivaldate'])) {
        $arrivaldateErr = 'Arrival date is required';
        $errorBox[] = 1;
    }

    if (empty($_POST['departuredate'])) {
        $departuredateErr = 'Departure date is required';
        $errorBox[] = 1;
    }

    if (empty($errorBox)) {

        $insertguest = "insert into guest (idtype,idno,firstname,fullname,gender,address,telephone,email)"
            . " values ('$idtype','$idno','$firstname','$fullname','$gender','$address','$telephone','$email' )";

        $maxid = "select max(guestid) from guest";
        $maxids = mysqli_query($conn, $maxid);
        $idresult = mysqli_fetch_array($maxids);
        $idmax = $idresult[0] + 1;




        if (isset($_POST['service1'])) {
            $insertbooking = "insert into booking (guestid,roomid,arrivaldate,departuredate,serviceid)"
                . " values ('$idmax','$roomtype','$arrivaldate','$departuredate',1 )";
            $runbook = mysqli_query($conn, $insertbooking);
        }

        if (isset($_POST['service2'])) {
            $insertbooking = "insert into booking (guestid,roomid,arrivaldate,departuredate,serviceid)"
                . " values ('$idmax','$roomtype','$arrivaldate','$departuredate',2 )";
            $runbook = mysqli_query($conn, $insertbooking);
        }
        if (!isset($_POST['service1']) && !isset($_POST['service2'])) {
            $insertbooking = "insert into booking (guestid,roomid,arrivaldate,departuredate)"
                . " values ('$idmax','$roomtype','$arrivaldate','$departuredate' )";
            $runbook = mysqli_query($conn, $insertbooking);
        }



        $runguest = mysqli_query($conn, $insertguest);




        if ($runbook && $runguest) {

            echo "<script> alert('Guest added successfully ')</script>";
            echo "<script> window.open('guest.php ','_self')</script>";
        }
    } else {
        echo "<script> alert('Guest added failed ')</script>";
    }
}
?>




<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Guest</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Reservation
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Guest</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container px-5 my-5">
                            <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
                                <div class="mb-3">

                                    <input class="form-control" name="guestid" type="hidden" placeholder="Guest ID" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="idType">ID Type</label>
                                    <select class="form-control" id="idtype" name="idtype" aria-label="ID Type">
                                        <option value="Natonal ID" <?php if ($idtype == 'Natonal ID') {
                                                                        echo "selected";
                                                                    } ?>>Natonal ID</option>
                                        <option value="Passport" <?php if ($idtype == 'Passport') {
                                                                        echo "selected";
                                                                    } ?>>Passport</option>
                                    </select>
                                    <div style="color: red; font-size: 15px"><?php echo $idtypeErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="idno">ID No</label>
                                    <input class="form-control" name="idno" type="text" placeholder="ID No" data-sb-validations="required" <?php echo 'value = "' . $idno . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $idErr ?></div>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="firstName">First Name</label>
                                    <input class="form-control" id="firstname" name="firstname" type="text" placeholder="First Name" data-sb-validations="required" <?php echo 'value = "' . $firstname . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $fristnameErr ?></div>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="fullName">Full Name</label>
                                    <input class="form-control" name="fullname" type="text" placeholder="Full Name" data-sb-validations="required" <?php echo 'value = "' . $fullname . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $fullnameErr ?></div>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="gender">Gender</label>
                                    <select class="form-control" name="gender" aria-label="Gender">
                                        <option value="Male" <?php if ($gender == 'Male') {
                                                                    echo "selected";
                                                                } ?>>Male</option>
                                        <option value="Female" <?php if ($gender == 'Female') {
                                                                    echo "selected";
                                                                } ?>>Female</option>
                                    </select>
                                    <div style="color: red; font-size: 15px"><?php echo $genderErr ?></div>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea class="form-control" name="address" type="text" placeholder="Address" style="height: 10rem;" data-sb-validations="required" <?php echo 'value = "' . $address . '"'; ?>></textarea>
                                    <div style="color: red; font-size: 15px"><?php echo $addressErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="telephone">Telephone</label>
                                    <input class="form-control" name="telephone" type="text" placeholder="Telephone" data-sb-validations="required" <?php echo 'value = "' . $telephone . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $telephoneErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="emailAddress">Email Address</label>
                                    <input class="form-control" name="email" type="email" placeholder="Email Address" <?php echo 'value = "' . $email . '"'; ?> />

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="roomtype">Room Type</label>
                                    <select class="form-control" name="roomtype" aria-label="rooomtype">
                                        <?php echo $room_list ?>
                                    </select>
                                    <div style="color: red; font-size: 15px"><?php echo $roomtypeErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="arivalDate">Arival date</label>
                                    <input class="form-control" name="arrivaldate" type="date" placeholder="Arival date" data-sb-validations="required" <?php echo 'value = "' . $arrivaldate . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $arrivaldateErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="departureDate">Departure date</label>
                                    <input class="form-control" name="departuredate" type="date" placeholder="Departure date" data-sb-validations="required" <?php echo 'value = "' . $departuredate . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $departuredateErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label d-block">Services</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="service1" />
                                        <label class="form-check-label" for="fullPackage">Full Package</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="service2" />
                                        <label class="form-check-label" for="hotWater">Hot water</label>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="addgeust" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ########################################################################################### -->
    <!-- edit pop up modal -->
    <!-- Modal -->
    <div class="modal fade" id="editGuestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Guest</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container px-5 my-5">
                        <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
                            <div class="mb-3">

                                <input class="form-control" id="guestid" name="guestid" type="hidden" placeholder="Guest ID" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="idType">ID Type</label>
                                <select class="form-control" id="idtype" name="idtype" aria-label="ID Type">
                                    <option value="Natonal ID">Natonal ID</option>
                                    <option value="Passport">Passport</option>
                                </select>
                                <div style="color: red; font-size: 15px"><?php echo $idtypeErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="idno">ID No</label>
                                <input class="form-control" id="idno" name="idno" type="text" placeholder="ID No" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $idErr ?></div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="firstName">First Name</label>
                                <input class="form-control" id="firstname" name="firstname" type="text" placeholder="First Name" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $fristnameErr ?></div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="fullName">Full Name</label>
                                <input class="form-control" name="fullname" id="fullname" type="text" placeholder="Full Name" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $fullnameErr ?></div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" aria-label="Gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div style="color: red; font-size: 15px"><?php echo $genderErr ?></div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" type="text" placeholder="Address" style="height: 10rem;" data-sb-validations="required"></textarea>
                                <div style="color: red; font-size: 15px"><?php echo $addressErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="telephone">Telephone</label>
                                <input class="form-control" id="telephone" name="telephone" type="text" placeholder="Telephone" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $telephoneErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="emailAddress">Email Address</label>
                                <input class="form-control" id="email" name="email" type="email" placeholder="Email Address" />

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="roomtype">Room Type</label>
                                <select class="form-control" id="roomtype" name="roomtype" aria-label="rooomtype">
                                    <?php echo $room_list ?>
                                </select>
                                <div style="color: red; font-size: 15px"><?php echo $roomtypeErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="arivalDate">Arival date</label>
                                <input class="form-control" id="arrivaldate" name="arrivaldate" type="date" placeholder="Arival date" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $arrivaldateErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="departureDate">Departure date</label>
                                <input class="form-control" id="departuredate" name="departuredate" type="date" placeholder="Departure date" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $departuredateErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block">Services</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="service1" type="checkbox" name="service1" />
                                    <label class="form-check-label" for="fullPackage">Full Package</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="service2" type="checkbox" name="service2" />
                                    <label class="form-check-label" for="hotWater">Hot water</label>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="updateguest" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guest Update here -->
    <?php

    $errorBox = array();
    $idtypeErr = $idErr = $fullnameErr = $fristnameErr = $genderErr = $birthdayErr = $addressErr = $telephoneErr  = $roomtypeErr = $arrivaldateErr = $departuredateErr =  "";

    if (isset($_POST['updateguest'])) {


        $guestid = $_POST['guestid'];
        $idtype = $_POST['idtype'];
        $idno = $_POST['idno'];
        $fullname = $_POST['fullname'];
        $firstname  = $_POST['firstname'];
        $gender  = $_POST['gender'];
        $address  = $_POST['address'];
        $telephone  = $_POST['telephone'];
        $email  = $_POST['email'];
        $roomtype  = $_POST['roomtype'];
        $arrivaldate  = $_POST['arrivaldate'];
        $departuredate  = $_POST['departuredate'];


        if (empty(trim($_POST['idtype']))) {
            $idtypeErr = 'Id type is required';
            $errorBox[] = 1;
        }

        if (empty(trim($_POST['idno']))) {
            $idErr = 'Id number is required';
            $errorBox[] = 1;
        }

        if (empty(trim($_POST['firstname']))) {
            $fristnameErr = 'First Name is required';
            $errorBox[] = 1;
        }

        if (empty(trim($_POST['fullname']))) {
            $fullnameErr = 'Full Name is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['gender'])) {
            $genderErr = 'Gender is required';
            $errorBox[] = 1;
        }


        if (empty(trim($_POST['address']))) {
            $addressErr = 'Address is required';
            $errorBox[] = 1;
        }

        if (empty(trim($_POST['telephone']))) {
            $telephoneErr = 'Telephone no is required';
            $errorBox[] = 1;
        } else {
            if (!is_numeric($telephone)) {
                $telephoneErr = "Only numbers are allowed.";
                $errorBox[] = 1;
            }
        }

        if (empty($_POST['roomtype'])) {
            $roomtypeErr = 'Room type is required';
            $errorBox[] = 1;
        }



        if (empty($_POST['arrivaldate'])) {
            $arrivaldateErr = 'Arrival date is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['departuredate'])) {
            $departuredateErr = 'Departure date is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['departuredate'])) {
            $departuredateErr = 'Departure date is required';
            $errorBox[] = 1;
        }

        if (empty($errorBox)) {

            $updateguest = "UPDATE guest set idtype='$idtype',idno='$idno',firstname='$firstname', fullname='$fullname',gender='$gender',address='$address',telephone='$telephone',email='$email' where guestid= '$guestid'";
            $updatebook = "UPDATE booking set roomid='$roomtype',arrivaldate='$arrivaldate',departuredate='$departuredate',departuredate='$departuredate' where guestid= '$guestid'";


            $runguest = mysqli_query($conn, $updateguest);
            $runbook = mysqli_query($conn, $updatebook);

            if ($runguest == TRUE && $runbook == TRUE) {
                echo "<script> alert('Guest updated successfully ')</script>";
                echo "<script> window.open('guest.php ','_self')</script>";
            }
        } else {
            echo "<script> alert('Guest updated failed ')</script>";
        }
    }
    ?>


    <!-- ########################################################################################### -->
    <!-- Content Row -->
    <!-- Guest History Table start here-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Current Guest</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="guestHistoryTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>

                            <th>No</th>
                            <th>NIC</th>
                            <th>Full Name</th>
                            <th>Address</th>
                            <th>Telephone No</th>
                            <th>Email</th>
                            <th>Room Type</th>
                            <th>Arrival date</th>
                            <th>Departure date</th>
                            <th>Payment</th>

                        </tr>
                    </thead>

                    <tbody>
                        <!-- fetch to table                                  -->
                        <?php

                        $date = date('Y-m-d H:i:s');

                        $getguest = "SELECT distinct guest.guestid, guest.idno, guest.firstname, guest.fullname, guest.gender, guest.address, guest.telephone, guest.email, room.roomname, booking.arrivaldate, booking.departuredate FROM booking INNER JOIN guest on guest.guestid = booking.guestid INNER JOIN room on room.roomid = booking.roomid where booking.departuredate >= '$date'";

                        $runguest = mysqli_query($conn, $getguest);

                        while ($rowsguest = mysqli_fetch_array($runguest)) {


                            $guestid = $rowsguest['guestid'];
                            $idno = $rowsguest['idno'];
                            $fullname = $rowsguest['fullname'];
                            $address = $rowsguest['address'];
                            $telephone = $rowsguest['telephone'];
                            $email = $rowsguest['email'];
                            $roomtype = $rowsguest['roomname'];
                            $arrivaldate = $rowsguest['arrivaldate'];
                            $departuredate = $rowsguest['departuredate'];



                        ?>

                            <tr>
                                <?php

                                $bol = "select count(guestid) from payment where guestid = '$guestid'";
                                $run_bol = mysqli_query($conn, $bol);
                                $row_bol = mysqli_fetch_array($run_bol);
                                $rowcount = $row_bol['count(guestid)'];
                                if ($rowcount == 0) {
                                    $payment = 'Payment';
                                } else {
                                    $payment = 'Payment';
                                    $boll = "select tobepaid from payment where guestid = '$guestid' AND paydatetime = (SELECT MAX(paydatetime) FROM payment WHERE guestid = '$guestid')";
                                    $run_boll = mysqli_query($conn, $boll);
                                    $row_boll = mysqli_fetch_array($run_boll);
                                    $tobepaid = $row_boll['tobepaid'];
                                    if ($tobepaid == 0) {
                                        $payment = 'Completed';
                                    }
                                }



                                ?>

                                <td><?php echo $guestid; ?></td>
                                <td><?php echo $idno; ?></td>
                                <td><?php echo $fullname; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $telephone; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $roomtype; ?></td>
                                <td><?php echo $arrivaldate; ?></td>
                                <td><?php echo $departuredate; ?></td>
                                <td><a href="payment.php?payid=<?php echo $guestid; ?>"> <button type="submit" name="payment" id="myBtn" class="btn btn-success" <?php if ($tobepaid == 0) { ?> disabled <?php   } ?>><?php echo $payment; ?></button></a></td>



                            </tr>



                        <?php } ?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ########################################################################################### -->

    <!-- Content Row -->
    <!-- Table start here-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Guest History</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="guestTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>

                            <th>No</th>
                            <th>NIC</th>
                            <th>Firstname</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Telephone No</th>
                            <th>Email</th>
                            <th>Room Type</th>
                            <th>Arrival date</th>
                            <th>Departure date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- fetch to table                                  -->
                        <?php



                        $getguest = "SELECT distinct guest.guestid, guest.idno, guest.firstname, guest.fullname, guest.gender, guest.address, guest.telephone, guest.email, room.roomname, booking.arrivaldate, booking.departuredate FROM booking INNER JOIN guest on guest.guestid = booking.guestid INNER JOIN room on room.roomid = booking.roomid";

                        $runguest = mysqli_query($conn, $getguest);

                        while ($rowsguest = mysqli_fetch_array($runguest)) {


                            $guestid = $rowsguest['guestid'];
                            $idno = $rowsguest['idno'];
                            $firstname = $rowsguest['firstname'];
                            $fullname = $rowsguest['fullname'];
                            $gender = $rowsguest['gender'];
                            $address = $rowsguest['address'];
                            $telephone = $rowsguest['telephone'];
                            $email = $rowsguest['email'];
                            $roomtype = $rowsguest['roomname'];
                            $arrivaldate = $rowsguest['arrivaldate'];
                            $departuredate = $rowsguest['departuredate'];



                        ?>

                            <tr>


                                <td><?php echo $guestid; ?></td>
                                <td><?php echo $idno; ?></td>
                                <td><?php echo $firstname; ?></td>
                                <td><?php echo $fullname; ?></td>
                                <td><?php echo $gender; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $telephone; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $roomtype; ?></td>
                                <td><?php echo $arrivaldate; ?></td>
                                <td><?php echo $departuredate; ?></td>
                                <td><a href="#<?php echo $guestid; ?>"> <button type="submit" name="editguest" class="btn btn-primary editguest">Edit</button></a></td>

                                <td>
                                    <form method="post">
                                        <input type="hidden" name="deleteid" value="<?php echo $rowsguest['guestid']; ?>">
                                        <a href="#<?php echo $guestid; ?>"> <button type="submit" name="deleteguest" class="btn btn-danger">Delete</button></a>
                                    </form>
                                </td>

                            </tr>

                            <!-- guest delete -->

                            <?php
                            include("includes/db.php");
                            if (isset($_POST['deleteguest'])) {

                                $delete_id = $_POST['deleteid'];
                                $delete1 = "delete from guest where guestid='$delete_id'";
                                $delete2 = "delete from booking where guestid='$delete_id'";
                                $run_delete1 = mysqli_query($conn, $delete1);
                                $run_delete2 = mysqli_query($conn, $delete2);

                                if ($run_delete1 == TRUE && $run_delete2 == TRUE) {

                                    echo "<script>alert('Guest has been deleted')</script>";

                                    echo "<script>window.open('guest.php','_self')</script>";
                                }
                            }

                            ?>

                        <?php } ?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php
include("includes/scripts.php");
include("includes/footer.php");
?>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.editguest').on('click', function() {
            $('#editGuestModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#guestid').val(data[0]);
            $('#idtype').val(data[0]);
            $('#idno').val(data[1]);
            $('#firstname').val(data[2]);
            $('#fullname').val(data[3]);
            $('#gender').val(data[4]);
            $('#address').val(data[5]);
            $('#telephone').val(data[6]);
            $('#email').val(data[7]);
            $('#roomtype').val(data[8]);
            $('#arrivaldate').val(data[9]);
            $('#departuredate').val(data[10]);
            $('#service1').val(data[11]);
            $('#service2').val(data[12]);


        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#guestHistoryTable').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        $('#guestTable').DataTable();
    });
</script>