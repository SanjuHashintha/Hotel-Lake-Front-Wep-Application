<?php
session_start();
include("includes/header.php");
include("includes/navbar.php");
include("includes/topbar.php");
include("includes/db.php");

//<!-- Room insert -->

$roomname = '';
$price = '';

$errorBox = array();
$roomnameErr = $priceErr = "";

if (isset($_POST['addroom'])) {

    $roomname = $_POST['roomname'];
    $price  = $_POST['price'];



    if (empty(trim($_POST['roomname']))) {
        $roomnameErr = 'Room name is required';
        $errorBox[] = 1;
    }

    if (empty(trim($_POST['price']))) {
        $priceErr = 'Price is required';
        $errorBox[] = 1;
    } else {
        if (!is_numeric($price)) {
            $priceErr = "Only numbers are allowed.";
            $errorBox[] = 1;
        }
    }


    if (empty($errorBox)) {
        $insertroom = "insert into room (roomno,roomname,price)"
            . " values ('$roomno','$roomname','$price')";

        $runroom = mysqli_query($conn, $insertroom);

        if ($runroom) {
            echo "<script> alert('Room added successfully ')</script>";
            echo "<script> window.open('rooms.php ','_self')</script>";
        }
    } else {
        echo "<script> alert('Room added failed ')</script>";
    }
}

?>




<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rooms</h1>
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Add New Room
        </button> -->
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Add New Room</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container px-5 my-5">
                            <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">

                                <div class="mb-3">
                                    <label class="form-label" for="roomname">Room Name</label>
                                    <input class="form-control" name="roomname" type="text" placeholder="Room Name" data-sb-validations="required" <?php echo 'value = "' . $roomname . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $roomnameErr ?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="price">Price</label>
                                    <input class="form-control" name="price" type="text" placeholder="Price" data-sb-validations="required" <?php echo 'value = "' . $price . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $priceErr ?></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="addroom">Add Room</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- ####################################################################################################### -->
    <!-- edit pop up modal -->

    <div class="modal fade" id="editroommodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container px-5 my-5">
                        <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
                            <div class="mb-3">
                                <label class="form-label" for="roomid"></label>
                                <input class="form-control" id="roomid" type="hidden" placeholder="roomid" name="roomid" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="roomname">Room Name</label>
                                <input class="form-control" name="roomname" id="roomname" type="text" placeholder="Room Name" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $roomnameErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="price">Price</label>
                                <input class="form-control" name="price" id="price" type="text" placeholder="Price" data-sb-validations="required" />
                                <div style="color: red; font-size: 15px"><?php echo $priceErr ?></div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="updateroom">Update Room</button>
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
    $roomnoErr = $roomnameErr = $priceErr = "";

    if (isset($_POST['updateroom'])) {


        $id  = $_POST['roomid'];
        $roomname = $_POST['roomname'];
        $price = $_POST['price'];



        if (empty(trim($_POST['roomname']))) {
            $roomnameErr = 'Room name is required';
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
            $updateroom = "UPDATE room set  roomname='$roomname',price='$price' where roomid= '$id'";


            $runroom = mysqli_query($conn, $updateroom);

            if ($runroom == TRUE) {
                echo "<script> alert('Room updated successfully ')</script>";
                echo "<script> window.open('rooms.php ','_self')</script>";
            }
        } else {
            echo "<script> alert('Room updated failed ')</script>";
        }
    }
    ?>


    <!-- ################################################################################################# -->

    <!-- Table start here-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Room Details</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Category ID</th>
                            <th>Category Name</th>
                            <th>Price</th>
                            <th>Edit</th>
                            <!-- <th>Delete</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- fetch to table                                  -->
                        <?php



                        $getroom = "select * from room";

                        $runroom = mysqli_query($conn, $getroom);

                        while ($rowroom = mysqli_fetch_array($runroom)) {


                            $roomid = $rowroom['roomid'];
                            $roomname = $rowroom['roomname'];
                            $price = $rowroom['price'];




                        ?>

                            <tr>

                                <td><?php echo $roomid; ?></td>
                                <td><?php echo $roomname; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><a href="#<?php echo $roomid; ?>"> <button type="submit" name="editroom" class="btn btn-primary editroom">Edit</button></a></td>

                                <!-- <td>
                                    <form method="post">
                                        <input type="hidden" name="deleteid" value="<?php echo $rowroom['roomid']; ?>">
                                        <a href="#<?php echo $pid; ?>"> <button type="submit" name="deleteroom" class="btn btn-danger">Delete</button></a>
                                    </form>
                                </td> -->

                            </tr>

                            <!-- room delete -->
                            <!-- <?php
                                    include("includes/db.php");
                                    if (isset($_POST['deleteroom'])) {

                                        $delete_id = $_POST['deleteid'];

                                        $delete_pro = "delete from room where roomid='$delete_id'";

                                        $run_delete = mysqli_query($conn, $delete_pro);

                                        if ($run_delete == TRUE) {

                                            echo "<script>alert('Room has been deleted')</script>";

                                            echo "<script>window.open('rooms.php','_self')</script>";
                                        }
                                    }

                                    ?> -->

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
        $('.editroom').on('click', function() {
            $('#editroommodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#roomid').val(data[0]);
            $('#roomname').val(data[1]);
            $('#price').val(data[2]);

        });
    });
</script>