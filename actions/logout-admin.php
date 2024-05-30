<?php 

    
    unset($_SESSION['admin_email']);
    echo "<script> alert('Logged out successfully!') </script>";
    header("refresh: 0.5;url=../pages/admin-login.php");
    exit(); 







?>