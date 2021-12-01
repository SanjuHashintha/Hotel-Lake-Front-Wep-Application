<?php

session_start();

session_destroy();

echo "<script>confirm('Do you want to logout?')</script>";
echo "<script>window.open('../customer/index.html','_self')</script>";
