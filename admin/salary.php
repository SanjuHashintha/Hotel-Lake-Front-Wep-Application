<?php
session_start();
include("includes/header.php");
include("includes/navbar.php");
include("includes/topbar.php");
include("includes/db.php");

$positionid = "";
$positionname = "";
$salary = "";

$errorBox = array();
$positionidErr = $positionnameErr = $salaryErr = "";

if (isset($_POST['addposition'])) {

    $positionid = $_POST['positionid'];
    $positionname = $_POST['positionname'];
    $salary  = $_POST['salary'];

    if (empty(trim($_POST['positionid']))) {
        $positionidErr = 'Position ID is required';
        $errorBox[] = 1;
    }

    if (empty($_POST['positionname'])) {
        $positionnameErr = 'Position name is required';
        $errorBox[] = 1;
    }

    if (empty($_POST['salary'])) {
        $salaryErr = 'Salary is required';
        $errorBox[] = 1;
    } else {
        if (!is_numeric($salary)) {
            $salaryErr = "Only numbers are allowed.";
            $errorBox[] = 1;
        }
    }

    if (empty($errorBox)) {
        $insertposition = "insert into position (positionid,positionname,salary)"
            . " values ('$positionid','$positionname','$salary')";

        $runposition = mysqli_query($conn, $insertposition);

        if ($runposition) {
            echo "<script> alert('Salary added successfully ')</script>";
            echo "<script> window.open('salary.php ','_self')</script>";
        }
    } else {
        echo "<script> alert('Salary added failed ')</script>";
    }
}

?>




<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Salary</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Add New Position
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Add New Position</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container px-5 my-5">
                            <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
                                <div class="mb-3">
                                    <label class="form-label" for="positionId">Position ID</label>
                                    <input class="form-control" name="positionid" id="positionId" type="text" placeholder="Position ID" data-sb-validations="required" <?php echo 'value = "' . $positionid . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $positionidErr ?></div>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="position">Position</label>
                                    <input class="form-control" name="positionname" id="position" type="text" placeholder="Position" data-sb-validations="required" <?php echo 'value = "' . $positionname . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $positionnameErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="salary">Salary</label>
                                    <input class="form-control" name="salary" id="salary" type="text" placeholder="Salary" data-sb-validations="required" <?php echo 'value = "' . $salary . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $salaryErr ?></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="addposition">Add Position</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ############################################################################################################# -->
    <!-- edit pop up modal -->
    <!-- Modal -->
    <div class="modal fade" id="editpositionmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container px-5 my-5">
                        <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
                            <div class="mb-3">
                                <label class="form-label" for="pid"></label>
                                <input class="form-control" id="pid" type="hidden" placeholder="pid" name="pid" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="positionId">Position ID</label>
                                <input class="form-control" name="positionid" id="positionid" type="text" placeholder="Position ID" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $positionidErr ?></div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="position">Position</label>
                                <input class="form-control" name="positionname" id="positionname" type="text" placeholder="Position" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $positionnameErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="salary">Salary</label>
                                <input class="form-control" name="salary" id="salary" type="text" placeholder="Salary" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $salary ?></div>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="updateposition">Update Position</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Position Update here -->
    <?php

    $errorBox = array();
    $positionidErr = $positionnameErr = $salaryErr = "";

    if (isset($_POST['updateposition'])) {



        $id  = $_POST['pid'];
        $positionid = $_POST['positionid'];
        $positionname = $_POST['positionname'];
        $salary = $_POST['salary'];


        if (empty(trim($_POST['positionid']))) {
            $positionidErr = 'Position ID is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['positionname'])) {
            $positionnameErr = 'Position name is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['salary'])) {
            $salaryErr = 'Salary is required';
            $errorBox[] = 1;
        } else {
            if (!is_numeric($salary)) {
                $salaryErr = "Only numbers are allowed.";
                $errorBox[] = 1;
            }
        }

        if (empty($errorBox)) {
            $updateposition = "UPDATE position set positionid='$positionid', positionname='$positionname',salary='$salary' where pid= '$id'";


            $runposition = mysqli_query($conn, $updateposition);

            if ($runposition == TRUE) {
                echo "<script> alert('Salary updated successfully ')</script>";
                echo "<script> window.open('salary.php ','_self')</script>";
            }
        } else {
            echo "<script> alert('Salary update failed ')</script>";
        }
    }
    ?>


    <!-- ############################################################################################################# -->

    <!-- Table start here-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Current Position</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Position ID</th>
                            <th>Position Name</th>
                            <th>Salary</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- fetch to table                                  -->
                        <?php



                        $getposition = "select * from position";

                        $runposition = mysqli_query($conn, $getposition);

                        while ($rowposition = mysqli_fetch_array($runposition)) {


                            $pid = $rowposition['pid'];
                            $positionid = $rowposition['positionid'];
                            $positionname = $rowposition['positionname'];
                            $salary = $rowposition['salary'];




                        ?>

                            <tr>

                                <td><?php echo $pid; ?></td>
                                <td><?php echo $positionid; ?></td>
                                <td><?php echo $positionname; ?></td>
                                <td><?php echo $salary; ?></td>
                                <td><a href="#<?php echo $pid; ?>"> <button type="submit" name="editposition" class="btn btn-primary editposition">Edit</button></a></td>

                                <td>
                                    <form method="post">
                                        <input type="hidden" name="deleteid" value="<?php echo $rowposition['pid']; ?>">
                                        <a href="#<?php echo $pid; ?>"> <button type="submit" name="deleteposition" class="btn btn-danger">Delete</button></a>
                                    </form>
                                </td>

                            </tr>

                            <!-- food delete -->
                            <?php
                            include("includes/db.php");
                            if (isset($_POST['deleteposition'])) {

                                $delete_id = $_POST['deleteid'];

                                $delete_pro = "delete from position where pid='$delete_id'";

                                $run_delete = mysqli_query($conn, $delete_pro);

                                if ($run_delete == TRUE) {

                                    echo "<script>alert('Position has been deleted')</script>";

                                    echo "<script>window.open('salary.php','_self')</script>";
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
        $('.editposition').on('click', function() {
            $('#editpositionmodel').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#pid').val(data[0]);
            $('#positionid').val(data[1]);
            $('#positionname').val(data[2]);
            $('#salary').val(data[3]);




        });
    });
</script>