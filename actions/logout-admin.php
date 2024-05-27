<?php 

    
    session_start(); 
    session_destroy(); 
    echo "<script> alert('Logged out successfully!') </script>";
    header("refresh: 0.5;url=../pages/admin-login.php");
    exit(); 







?>