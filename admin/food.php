<?php
session_start();
include("includes/header.php");
include("includes/navbar.php");
include("includes/topbar.php");
include("includes/db.php");

//<!-- Food insert -->
$foodname = '';
$category = '';
$price = '';

$errorBox = array();
$foodnameErr = $categoryErr = $priceErr = "";

if (isset($_POST['addfood'])) {

    $foodname = $_POST['foodname'];
    $category = $_POST['category'];
    $price  = $_POST['price'];

    if (empty(trim($_POST['foodname']))) {
        $foodnameErr = 'Foodname is required';
        $errorBox[] = 1;
    }

    if (empty($_POST['category'])) {
        $categoryErr = 'Category is required';
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

        $insertfood = "insert into food (foodname,category,price)"
            . " values ('$foodname','$category','$price')";

        $runfood = mysqli_query($conn, $insertfood);

        if ($runfood) {
            echo "<script> alert('Food added successfully ')</script>";
            echo "<script> window.open('food.php ','_self')</script>";
        }
    } else {
        echo "<script> alert('Food added failed')</script>";
    }
}

?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Food Details</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add Food
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Food</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container px-5 my-5">
                            <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post">
                                <div class="mb-3">
                                    <label class="form-label" for="foodName">Food Name</label>
                                    <input class="form-control" type="text" placeholder="Food Name" data-sb-validations="required" name="foodname" <?php echo 'value = "' . $foodname . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $foodnameErr ?></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="category">Category</label>
                                    <select class="form-control" aria-label="Category" name="category">
                                        <option value="Breakfast" <?php if ($category == 'Breakfast') {
                                                                        echo "selected";
                                                                    } ?>>Breakfast</option>
                                        <option value="Lunch" <?php if ($category == 'Lunch') {
                                                                    echo "selected";
                                                                } ?>>Lunch</option>
                                        <option value="Dinner" <?php if ($category == 'Dinner') {
                                                                    echo "selected";
                                                                } ?>>Dinner</option>
                                        <option value="Anytime" <?php if ($category == 'Anytime') {
                                                                    echo "selected";
                                                                } ?>>Anytime</option>
                                        <option value="Breakfast-Lunch" <?php if ($category == 'Breakfast-Lunch') {
                                                                            echo "selected";
                                                                        } ?>>Breakfast-Lunch</option>
                                        <option value="Breakfast-Dinner" <?php if ($category == 'Breakfast-Dinner') {
                                                                                echo "selected";
                                                                            } ?>>Breakfast-Dinner</option>
                                        <option value="Lunch-Dinner" <?php if ($category == 'Lunch-Dinner') {
                                                                            echo "selected";
                                                                        } ?>>Lunch-Dinner</option>
                                        <option value="Beverage" <?php if ($category == 'Beverage') {
                                                                        echo "selected";
                                                                    } ?>>Beverage</option>
                                        <option value="Snacks" <?php if ($category == 'Snacks') {
                                                                    echo "selected";
                                                                } ?>>Snacks</option>
                                    </select>
                                    <div style="color: red; font-size: 15px"><?php echo $categoryErr ?></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="price">Price</label>
                                    <input class="form-control" type="text" placeholder="Price" data-sb-validations="required" name="price" <?php echo 'value = "' . $price . '"'; ?> />
                                    <div style="color: red; font-size: 15px"><?php echo $priceErr ?></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="addfood" class="btn btn-primary">Add</button>
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
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Food</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container px-5 my-5">
                        <form id="contactForm" method="post">
                            <div class="mb-3">
                                <label class="form-label" for="updateid"></label>
                                <input class="form-control" id="updateid" type="hidden" placeholder="updateid" name="updateid" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="foodName">Food Name</label>
                                <input class="form-control" id="foodname" type="text" placeholder="Food Name" data-sb-validations="required" name="foodname" />
                                <div style="color: red; font-size: 15px"><?php echo $foodnameErr ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="category">Category</label>
                                <select class="form-control" id="category" aria-label="Category" name="category">
                                    <option value="Breakfast">Breakfast</option>
                                    <option value="Lunch">Lunch</option>
                                    <option value="Dinner">Dinner</option>
                                    <option value="Anytime">Anytime</option>
                                    <option value="Breakfast-Lunch">Breakfast-Lunch</option>
                                    <option value="Breakfast-Dinner">Breakfast-Dinner</option>
                                    <option value="Lunch-Dinner">Lunch-Dinner</option>
                                    <option value="Beverage">Beverage</option>
                                    <option value="Snacks">Snacks</option>
                                </select>
                                <div style="color: red; font-size: 15px"><?php echo $categoryErr ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="price">Price</label>
                                <input class="form-control" id="price" type="text" placeholder="Price" data-sb-validations="required" name="price" />
                                <div style="color: red; font-size: 15px"><?php echo $priceErr ?></div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="updatefood" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Food Update here -->
    <?php

    $errorBox = array();
    $foodnameErr = $categoryErr = $priceErr = "";

    if (isset($_POST['updatefood'])) {


        $id  = $_POST['updateid'];

        $foodname = $_POST['foodname'];
        $category = $_POST['category'];
        $price  = $_POST['price'];

        if (empty(trim($_POST['foodname']))) {
            $foodnameErr = 'Foodname is required';
            $errorBox[] = 1;
        }

        if (empty($_POST['category'])) {
            $categoryErr = 'Category is required';
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

            $updatefood = "UPDATE food set foodname='$foodname', category='$category',price='$price' where foodid= '$id'";


            $runfood = mysqli_query($conn, $updatefood);

            if ($runfood == TRUE) {
                echo "<script> alert('Food updated successfully ')</script>";
                echo "<script> window.open('food.php ','_self')</script>";
            }
        } else {
            echo "<script> alert('Update failed')</script>";
        }
    }
    ?>


    <!-- ############################################################################################################# -->
    <!-- Table start here-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Current Food</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Food ID</th>
                            <th>Food Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- fetch to table                                  -->
                        <?php



                        $getfood = "select * from food";

                        $runfood = mysqli_query($conn, $getfood);

                        while ($rowfood = mysqli_fetch_array($runfood)) {

                            $foodname = $rowfood['foodname'];
                            $category = $rowfood['category'];
                            $price = $rowfood['price'];
                            $id = $rowfood['foodid'];


                        ?>

                            <tr>

                                <td><?php echo $id; ?></td>
                                <td><?php echo $foodname; ?></td>
                                <td><?php echo $category; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><a href="#<?php echo $id; ?>"> <button type="submit" name="editfood" class="btn btn-primary editfood">Edit</button></a></td>

                                <td>
                                    <form method="post">
                                        <input type="hidden" name="deleteid" value="<?php echo $rowfood['foodid']; ?>">
                                        <a href="#<?php echo $id; ?>"> <button type="submit" name="deletefood" class="btn btn-danger">Delete</button></a>
                                    </form>
                                </td>

                            </tr>

                            <!-- food delete -->

                            <?php
                            include("includes/db.php");
                            if (isset($_POST['deletefood'])) {

                                $delete_id = $_POST['deleteid'];

                                $delete_pro = "delete from food where foodid='$delete_id'";

                                $run_delete = mysqli_query($conn, $delete_pro);

                                if ($run_delete == TRUE) {

                                    echo "<script>alert('Food has been deleted')</script>";

                                    echo "<script>window.open('food.php','_self')</script>";
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
        $('.editfood').on('click', function() {
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#updateid').val(data[0]);
            $('#foodname').val(data[1]);
            $('#category').val(data[2]);
            $('#price').val(data[3]);


        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>