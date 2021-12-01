<?php

session_start();

session_destroy();

echo "<script>window.open('../customer/index.html','_self')</script>";
