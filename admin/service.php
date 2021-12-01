<?php
session_start();
include("includes/header.php");
include("includes/navbar.php");
include("includes/topbar.php");
include("includes/db.php");


// service insert here
$servicename = '';
$price = '';

$errorBox = array();
$servicenameErr = $priceErr = "";


if (isset($_POST['addservice'])) {


    $servicename = $_POST['servicename'];
    $price  = $_POST['price'];

    if (empty($_POST['servicename'])) {
        $servicenameErr = 'Service Name is required';
        $errorBox[] = 1;
    }

    if (empty($_POST['price'])) {
        $priceErr = 'Price is required';
        $errorBox[] = 1;
    } else {
        if (!is_numeric($price)) {
            $priceErr = "Only numbers are allowed.";
            $errorBox[] = 1;
        }
    }

    if (empty($errorBox)) {
        $insertservice = "insert into service (servicename,price)"
            . " values ('$servicename','$price')";

        $runservice = mysqli_query($conn, $insertservice);

        if ($runservice) {
            echo "<script> alert('Service added successfully ')</script>";
            echo "<script> window.open('service.php ','_self')</script>";
        }
    } else {
        echo "<script> alert('Service added failed ')</script>";
    }
}



?>




<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Services</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Add New Service
        </button>
    </div>


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
                                <label class="form-label" for="servicename">Service Name</label>
                                <input class="form-control" name="servicename" type="text" placeholder="Service Name" data-sb-validations="required" <?php echo 'value = "' . $servicename . '"'; ?> />
                                <div style="color: red; font-size: 15px"><?php echo $servicenameErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="price">Price</label>
                                <input class="form-control" name="price" type="text" placeholder="Price" data-sb-validations="required" <?php echo 'value = "' . $price . '"'; ?> />
                                <div style="color: red; font-size: 15px"><?php echo $priceErr ?></div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="addservice">Add Service</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ####################################################################################################### -->
    <!-- edit pop up modal -->

    <div class="modal fade" id="editservicemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container px-5 my-5">
                        <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
                            <div class="mb-3">
                                <input class="form-control" name="serviceid" id="serviceid" type="hidden" placeholder="Service ID" data-sb-validations="required" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="servicename">Service Name</label>
                                <input class="form-control" name="servicename" id="servicename" type="text" placeholder="Service Name" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $servicenameErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="price">Price</label>
                                <input class="form-control" name="price" id="price" type="text" placeholder="Price" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $priceErr ?></div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="updateservice">Update Service</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Update here -->
    <?php

    $errorBox = array();
    $servicenameErr = $priceErr = "";

    if (isset($_POST['updateservice'])) {


        $id  = $_POST['serviceid'];
        $servicename = $_POST['servicename'];
        $price = $_POST['price'];

        if (empty($_POST['servicename'])) {
            $servicenameErr = 'Service Name is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['price'])) {
            $priceErr = 'Price is required';
            $errorBox[] = 1;
        } else {
            if (!is_numeric($price)) {
                $priceErr = "Only numbers are allowed.";
                $errorBox[] = 1;
            }
        }

        if (empty($errorBox)) {
            $updateservice = "UPDATE service set servicename='$servicename',price='$price' where serviceid= '$id'";


            $runservice = mysqli_query($conn, $updateservice);

            if ($runservice == TRUE) {
                echo "<script> alert('Service updated successfully ')</script>";
                echo "<script> window.open('service.php ','_self')</script>";
            }
        } else {
            echo "<script> alert('Service update failed ')</script>";
        }
    }
    ?>


    <!-- ################################################################################################# -->


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
                            <th>Service ID</th>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- fetch to table                                  -->
                        <?php



                        $getservice = "select * from service";

                        $runservice = mysqli_query($conn, $getservice);

                        while ($rowservice = mysqli_fetch_array($runservice)) {


                            $serviceid = $rowservice['serviceid'];
                            $servicename = $rowservice['servicename'];
                            $price = $rowservice['price'];




                        ?>

                            <tr>

                                <td><?php echo $serviceid; ?></td>
                                <td><?php echo $servicename; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><a href="#<?php echo $serviceid; ?>"> <button type="submit" name="editservice" class="btn btn-primary editservice">Edit</button></a></td>

                                <td>
                                    <form method="post">
                                        <input type="hidden" name="deleteid" value="<?php echo $rowservice['serviceid']; ?>">
                                        <a href="#<?php echo $pid; ?>"> <button type="submit" name="deleteservice" class="btn btn-danger">Delete</button></a>
                                    </form>
                                </td>

                            </tr>

                            <!-- room delete -->
                            <?php
                            include("includes/db.php");
                            if (isset($_POST['deleteservice'])) {

                                $delete_id = $_POST['deleteid'];

                                $delete_pro = "delete from service where serviceid='$delete_id'";

                                $run_delete = mysqli_query($conn, $delete_pro);

                                if ($run_delete == TRUE) {

                                    echo "<script>alert('Service has been deleted')</script>";

                                    echo "<script>window.open('service.php','_self')</script>";
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
        $('.editservice').on('click', function() {
            $('#editservicemodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#serviceid').val(data[0]);
            $('#servicename').val(data[1]);
            $('#price').val(data[2]);


        });
    });
</script>