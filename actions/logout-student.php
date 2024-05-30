<?php 

    
    unset($_SESSION['student_email']);
    echo "<script> alert('Logged out successfully!') </script>";
    header("refresh: 0.5;url=../pages/student-login.php");
    exit(); 







?>