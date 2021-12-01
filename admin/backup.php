<?php
include ("includes/header.php");
include ("includes/navbar.php");
include ("includes/topbar.php");
include ("includes/db.php");
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
    <form id="contactForm" data-sb-form-api-token="API_TOKEN" method = "post">
        <div class="mb-3">
            <label class="form-label" for="positionId">Position ID</label>
            <input class="form-control" name = "positionid"id="positionId" type="text" placeholder="Position ID" data-sb-validations="required" />
            
        </div>
        <div class="mb-3">
            <label class="form-label" for="position">Position</label>
            <input class="form-control" name = "positionname" id="position" type="text" placeholder="Position" data-sb-validations="required" />
            
        </div>
        <div class="mb-3">
            <label class="form-label" for="salary">Salary</label>
            <input class="form-control" name = "salary" id="salary" type="text" placeholder="Salary" data-sb-validations="required" />
            
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name  = "addposition">Add Position</button>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Add New Position</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    
                                    <div class="container px-5 my-5">
                                    <form id="contactForm" method = "post">
                                    <div class="mb-3">
            <label class="form-label" for="positionId">Position ID</label>
            <input class="form-control" name = "positionid"id="positionid" type="text" placeholder="Position ID" data-sb-validations="required" />
            
        </div>
        <div class="mb-3">
            <label class="form-label" for="position">Position</label>
            <input class="form-control" name = "positionname" id="positionname" type="text" placeholder="Position" data-sb-validations="required" />
            
        </div>
        <div class="mb-3">
            <label class="form-label" for="salary">Salary</label>
            <input class="form-control" name = "salary" id="salary" type="text" placeholder="Salary" data-sb-validations="required" />
            
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name  = "addposition">Add Position</button>
      </div>
                                        
                                    </form>
                                </div>
                                

                                
                            </div>
                            </div>
<!-- Food Update here -->
                            <?php

    if (isset($_POST['updatefood'])) {


        $id  =$_POST['updateid'];

        $foodname = $_POST['foodname'];
        $category = $_POST['category'];
        $price  =$_POST['price'];
        
        

      $updatefood = "UPDATE food set foodname='$foodname', category='$category',price='$price' where foodid= '$id'";
             

        $runfood = mysqli_query($conn, $updatefood);

        if ($runfood == TRUE) {
            echo "<script> alert('Food updated successfully ')</script>";
            echo "<script> window.open('food.php ','_self')</script>";
        }   
    }
    ?>

 
<!-- ############################################################################################################# -->
                    <!-- Table start here-->
     <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Current Position</h6>
                            <form class="form-inline">
                        </form>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            
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

$runposition = mysqli_query($conn,$getposition);

while($rowposition=mysqli_fetch_array($runposition)){

$positionid = $rowposition['positionid'];
$positionname = $rowposition['positionname'];
$salary = $rowposition['salary'];



?>

<tr>

<td><?php echo $positionid; ?></td>
<td><?php echo $positionname; ?></td>
<td><?php echo $salary; ?></td>
<td><a href="#<?php echo $id; ?>"> <button type="submit" name = "editposition" class="btn btn-primary editposition" >Edit</button></a></td>

<td><form  method = "post">
    <input type="hidden" name = "deleteid" value = "<?php echo $rowposition['positionid'];?>">
<a href="#<?php echo $positionid; ?>"> <button type="submit" name = "deletefood"class="btn btn-danger">Delete</button></a>
</form></td>

</tr>

<!-- food delete -->
<!-- 
<?php
include ("includes/db.php");
if(isset($_POST['deletefood'])){
    
    $delete_id = $_POST['deleteid'];
    
    $delete_pro = "delete from food where foodid='$delete_id'";
    
    $run_delete = mysqli_query($conn,$delete_pro);
    
    if($run_delete == TRUE){
    
    echo "<script>alert('Food has been deleted')</script>";
    
    echo "<script>window.open('food.php','_self')</script>";
    
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


if (isset($_POST['addposition'])) {

    $positionid = $_POST['positionid'];
    $positionname = $_POST['positionname'];
    $salary  =$_POST['salary'];
    

       $insertposition = "insert into position (positionid,positionname,salary)"
               . " values ('$positionid','$positionname','$salary')";

       $runposition = mysqli_query($conn, $insertposition);

       if ($runposition) {
           echo "<script> alert('Salary added successfully ')</script>";
           echo "<script> window.open('salary.php ','_self')</script>";
       }
   }
?>

<script>
    $(document).ready(function(){
        $('.editposition').on('click', function(){
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function(){
                return $(this).text();
            }).get();

            console.log(data);
            $('#positionid').val(data[0]);
            $('#positionname').val(data[1]);
            $('#salary').val(data[2]);

            

        });
    });

    $(document).ready(function() {
    $('#dataTable').DataTable();
} );
</script>