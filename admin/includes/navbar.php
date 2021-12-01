<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="position: fixed;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user-lock"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span style="font-size: 22px;">Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Facilities
    </div>

    <!-- Nav Item - Pages Collapse Menu -->



    <li class="nav-item" id="navGuest">
        <a class="nav-link" href="guest.php">
            <i class="fas fa-user-friends" style="font-size: 22px;"></i>
            <span style="font-size: 22px;">Guest</span></a>
    </li>

    <li class="nav-item" id="navFood">
        <a class="nav-link" href="food.php">
            <i class="fas fa-utensils" style="font-size: 22px;"></i>
            <span style="font-size: 22px;">Food Details</span></a>
    </li>

    <li class="nav-item" id="navRoom">
        <a class="nav-link" href="rooms.php">
            <i class="fas fa-person-booth" style="font-size: 22px;"></i>
            <span style="font-size: 22px;">Rooms Details</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Office
    </div>






    <li class="nav-item" id="navStaff">
        <a class="nav-link" href="staff.php">
            <i class="fas fa-briefcase" style="font-size: 22px;"></i>
            <span style="font-size: 22px;">Staff</span></a>
        <?php
        if ($_SESSION['role'] == 10) {
            echo "<script>document.getElementById('navStaff').style.display= 'none';</script>";
        }

        ?>
    </li>

    <li class="nav-item" id="navSalary">
        <a class="nav-link" href="salary.php">
            <i class="far fa-money-bill-alt" style="font-size: 22px;"></i>
            <span style="font-size: 22px;">Salary</span></a>
        <?php
        if ($_SESSION['role'] == 10) {
            echo "<script>document.getElementById('navSalary').style.display= 'none';</script>";
        }

        ?>
    </li>

    <li class="nav-item" id="navService">
        <a class="nav-link" href="service.php">
            <i class="fas fa-concierge-bell" style="font-size: 22px;"></i>
            <span style="font-size: 22px;">Services</span></a>
    </li>




    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="logout.php">
            <i class="fas fa-sign-out-alt" style="font-size: 22px;"></i>
            <span style="font-size: 22px;">Logout</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->





<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>





<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>


<?php
include("includes/scripts.php");
?>