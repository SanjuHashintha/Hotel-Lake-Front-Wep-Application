<?php
session_start();
include("includes/header.php");
include("includes/navbar.php");
include("includes/topbar.php");
include("includes/db.php");

// dropdown list item fetch from database
$query = "select pid, positionname from position";
$resultset = mysqli_query($conn, $query);

$position_list = "";
while ($result = mysqli_fetch_assoc($resultset)) {
    $position_list .= "<option value = \"{$result['pid']}\" >{$result['positionname']}</option>";
}

?>

<?php
// staff insert here

$nic = '';
$fullname = '';
$firstname = '';
$gender = '';
$birthday = '';
$address = '';
$telephone = '';
$email = '';
$joindate = '';
$position = '';
$password = '';

$errorBox = array();
$nicErr = $fullnameErr = $fristnameErr = $genderErr = $birthdayErr = $addressErr = $telephoneErr = $emailErr = $joindateErr = $positionErr = $passwordErr = "";

if (isset($_POST['addemployee'])) {

    $nic = $_POST['nic'];
    $fullname = $_POST['fullname'];
    $firstname  = $_POST['firstname'];
    $gender  = $_POST['gender'];
    $birthday  = $_POST['birthday'];
    $address  = $_POST['address'];
    $telephone  = $_POST['telephone'];
    $email  = $_POST['email'];
    $joindate  = $_POST['joindate'];
    $position  = $_POST['position'];
    $password  = $_POST['password'];

    if (empty(trim($_POST['nic']))) {
        $nicErr = 'NIC is required';
        $errorBox[] = 1;
    }

    if (empty(trim($_POST['fullname']))) {
        $fullnameErr = 'Full Name is required';
        $errorBox[] = 1;
    }

    if (empty(trim($_POST['firstname']))) {
        $fristnameErr = 'First Name is required';
        $errorBox[] = 1;
    }

    if (empty($_POST['gender'])) {
        $genderErr = 'Gender is required';
        $errorBox[] = 1;
    }

    if (empty($_POST['birthday'])) {
        $birthdayErr = 'Birthday is required';
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

    if (empty(trim($_POST['email']))) {
        $emailErr = 'Email is required';
        $errorBox[] = 1;
    } else {
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/", $_POST['email'])) {
            $emailErr = "Email is not valid";
            $errorBox[] = 1;
        }
    }


    if (empty($_POST['joindate'])) {
        $joindateErr = 'Join date is required';
        $errorBox[] = 1;
    }

    if (empty($_POST['position'])) {
        $positionErr = 'Position is required';
        $errorBox[] = 1;
    }

    if (empty(trim($_POST['password']))) {
        $passwordErr = 'Password is required';
        $errorBox[] = 1;
    }

    if (empty($errorBox)) {
        $insertstaff = "insert into staff (nic,fullname,firstname,gender,birthday,address,telephone,email,joindate,position,password)"
            . " values ('$nic','$fullname','$firstname','$gender','$birthday','$address','$telephone','$email','$joindate','$position','$password' )";

        $runstaff = mysqli_query($conn, $insertstaff);

        if ($runstaff) {
            echo "<script> alert('Employee added successfully ')</script>";
            echo "<script> window.open('staff.php ','_self')</script>";
        }
    } else {
        echo "<script> alert('Employee added failed ')</script>";
    }
}
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Staff Details</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add Employee
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container px-5 my-5">
                            <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">

                                <div class="mb-3">
                                    <label class="form-label" for="nationalId">National ID</label>
                                    <input class="form-control" name="nic" id="nationalId" type="text" placeholder="National ID" data-sb-validations="required" <?php echo 'value = "' . $nic . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $nicErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="fullName">Full Name</label>
                                    <input class="form-control" name="fullname" id="fullName" type="text" placeholder="Full Name" data-sb-validations="required" <?php echo 'value = "' . $fullname . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $fullnameErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="firstName">First Name</label>
                                    <input class="form-control" name="firstname" id="firstName" type="text" placeholder="First Name" data-sb-validations="required" <?php echo 'value = "' . $firstname . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $fristnameErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="category">Gender</label>
                                    <select class="form-control" id="gender" aria-label="Gender" name="gender">
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
                                    <label class="form-label" for="birthday">birthday</label>
                                    <input class="form-control" name="birthday" id="birthday" type="date" placeholder="birthday" data-sb-validations="required" <?php echo 'value = "' . $birthday . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $birthdayErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" type="text" placeholder="Address" style="height: 10rem;" data-sb-validations="required" <?php echo 'value = "' . $address . '"'; ?>></textarea>
                                    <div style="color: red; font-size: 15px"><?php echo $addressErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="telephoneNumber">Telephone Number</label>
                                    <input class="form-control" name="telephone" id="telephoneNumber" type="text" placeholder="Telephone Number" data-sb-validations="required" <?php echo 'value = "' . $telephone . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $telephoneErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="emailAddress">Email Address</label>
                                    <input class="form-control" name="email" id="emailAddress" type="email" placeholder="Email Address" <?php echo 'value = "' . $email . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $emailErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="joingDate">Join date</label>
                                    <input class="form-control" name="joindate" id="joingDate" type="date" placeholder="Joing date" data-sb-validations="required" <?php echo 'value = "' . $joindate . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $joindateErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="position">Position</label>
                                    <select class="form-control" name="position" id="position" aria-label="Position">
                                        <?php echo $position_list ?>
                                    </select>
                                    <div style="color: red; font-size: 15px"><?php echo $positionErr ?></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input class="form-control" name="password" id="password" type="text" placeholder="Password" data-sb-validations="required" <?php echo 'value = "' . $password . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $passwordErr ?></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="addemployee" class="btn btn-primary">Add Employee</button>
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
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container px-5 my-5">
                        <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
                            <div class="mb-3">
                                <input class="form-control" name="staffid" id="staffid" type="hidden" placeholder="Staff ID" data-sb-validations="required" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nationalId">National ID</label>
                                <input class="form-control" name="nic" id="nic" type="text" placeholder="National ID" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $nicErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="fullName">Full Name</label>
                                <input class="form-control" name="fullname" id="fullname" type="text" placeholder="Full Name" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $fullnameErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="firstName">First Name</label>
                                <input class="form-control" name="firstname" id="firstname" type="text" placeholder="First Name" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $fristnameErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="category">Gender</label>
                                <select class="form-control" id="gender" aria-label="Gender" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div style="color: red; font-size: 15px"><?php echo $genderErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="birthday">birthday</label>
                                <input class="form-control" name="birthday" id="birthday" type="date" placeholder="birthday" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $birthdayErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" type="text" placeholder="Address" style="height: 10rem;" data-sb-validations="required"></textarea>
                                <div style="color: red; font-size: 15px"><?php echo $addressErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="telephoneNumber">Telephone Number</label>
                                <input class="form-control" name="telephone" id="telephone" type="text" placeholder="Telephone Number" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $telephoneErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="emailAddress">Email Address</label>
                                <input class="form-control" name="email" id="email" type="email" placeholder="Email Address" />
                                <div style="color: red; font-size: 15px"><?php echo $emailErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="joingDate">Join date</label>
                                <input class="form-control" name="joindate" id="joindate" type="date" placeholder="Joing date" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $joindateErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="position">Position</label>
                                <select class="form-control" name="position" id="position" aria-label="Position">
                                    <?php echo $position_list ?>
                                </select>
                                <div style="color: red; font-size: 15px"><?php echo $positionErr ?></div>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="updateemployee" class="btn btn-primary">update Employee</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Update here -->
    <?php

    $errorBox = array();
    $nicErr = $fullnameErr = $fristnameErr = $genderErr = $birthdayErr = $addressErr = $telephoneErr = $emailErr = $joindateErr = $positionErr = $passwordErr = "";

    if (isset($_POST['updateemployee'])) {


        $id  = $_POST['staffid'];

        $nic = $_POST['nic'];
        $fullname = $_POST['fullname'];
        $firstname  = $_POST['firstname'];
        $gender  = $_POST['gender'];
        $birthday  = $_POST['birthday'];
        $address  = $_POST['address'];
        $telephone  = $_POST['telephone'];
        $email  = $_POST['email'];
        $joindate  = $_POST['joindate'];
        $position  = $_POST['position'];

        if (empty(trim($_POST['nic']))) {
            $nicErr = 'NIC is required';
            $errorBox[] = 1;
        }

        if (empty(trim($_POST['fullname']))) {
            $fullnameErr = 'Full Name is required';
            $errorBox[] = 1;
        }

        if (empty(trim($_POST['firstname']))) {
            $fristnameErr = 'First Name is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['gender'])) {
            $genderErr = 'Gender is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['birthday'])) {
            $birthdayErr = 'Birthday is required';
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

        if (empty(trim($_POST['email']))) {
            $emailErr = 'Email is required';
            $errorBox[] = 1;
        } else {
            if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/", $_POST['email'])) {
                $emailErr = "Email is not valid";
                $errorBox[] = 1;
            }
        }


        if (empty($_POST['joindate'])) {
            $joindateErr = 'Join date is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['position'])) {
            $positionErr = 'Position is required';
            $errorBox[] = 1;
        }



        if (empty($errorBox)) {
            $updatestaff = "UPDATE staff set nic='$nic', fullname='$fullname',firstname='$firstname',gender='$gender',birthday='$birthday',address='$address',telephone='$telephone',email='$email',joindate='$joindate',position='$position' where staffid= '$id'";


            $runstaff = mysqli_query($conn, $updatestaff);

            if ($runstaff == TRUE) {
                echo "<script> alert('Employee updated successfully ')</script>";
                echo "<script> window.open('staff.php ','_self')</script>";
            }
        } else {
            echo "<script> alert('Employee update failed ')</script>";
        }
    }
    ?>


    <!-- ########################################################################################### -->

    <!-- Table start here-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Current Staff</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>

                            <th>No</th>
                            <th>NIC</th>
                            <th>Full name</th>
                            <th>Firstname</th>
                            <th>Gender</th>
                            <th>Birthday</th>
                            <th>Address</th>
                            <th>Telephone No</th>
                            <th>Email</th>
                            <th>Join date</th>
                            <th>Position</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- fetch to table                                  -->
                        <?php



                        $getstaff = "SELECT staff.staffid, staff.nic, staff.fullname, staff.firstname, staff.gender, staff.birthday, staff.address, staff.telephone, staff.email, staff.joindate, position.positionname FROM staff INNER JOIN position on staff.position = position.pid order by staffid";

                        $runstaff = mysqli_query($conn, $getstaff);

                        while ($rowstaff = mysqli_fetch_array($runstaff)) {


                            $staffid = $rowstaff['staffid'];
                            $nic = $rowstaff['nic'];
                            $fullname = $rowstaff['fullname'];
                            $firstname = $rowstaff['firstname'];
                            $gender = $rowstaff['gender'];
                            $birthday = $rowstaff['birthday'];
                            $address = $rowstaff['address'];
                            $telephone = $rowstaff['telephone'];
                            $email = $rowstaff['email'];
                            $joindate = $rowstaff['joindate'];
                            $position = $rowstaff['positionname'];



                        ?>

                            <tr>


                                <td><?php echo $staffid; ?></td>
                                <td><?php echo $nic; ?></td>
                                <td><?php echo $fullname; ?></td>
                                <td><?php echo $firstname; ?></td>
                                <td><?php echo $gender; ?></td>
                                <td><?php echo $birthday; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $telephone; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $joindate; ?></td>
                                <td><?php echo $position; ?></td>
                                <td><a href="#<?php echo $staffid; ?>"> <button type="submit" name="editstaff" class="btn btn-primary editstaff">Edit</button></a></td>

                                <td>
                                    <form method="post">
                                        <input type="hidden" name="deleteid" value="<?php echo $rowstaff['staffid']; ?>">
                                        <a href="#<?php echo $id; ?>"> <button type="submit" name="deletestaff" class="btn btn-danger">Delete</button></a>
                                    </form>
                                </td>

                            </tr>

                            <!-- Staff delete -->

                            <?php
                            include("includes/db.php");
                            if (isset($_POST['deletestaff'])) {

                                $delete_id = $_POST['deleteid'];

                                $delete_pro = "delete from staff where staffid='$delete_id'";

                                $run_delete = mysqli_query($conn, $delete_pro);

                                if ($run_delete == TRUE) {

                                    echo "<script>alert('Employee has been deleted')</script>";

                                    echo "<script>window.open('staff.php','_self')</script>";
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

<script>
    $(document).ready(function() {
        $('.editstaff').on('click', function() {
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#staffid').val(data[0]);
            $('#nic').val(data[1]);
            $('#fullname').val(data[2]);
            $('#firstname').val(data[3]);
            $('#gender').val(data[4]);
            $('#birthday').val(data[5]);
            $('#address').val(data[6]);
            $('#telephone').val(data[7]);
            $('#email').val(data[8]);
            $('#joindate').val(data[9]);
            $('#position').val(data[10]);


        });
    });
</script>