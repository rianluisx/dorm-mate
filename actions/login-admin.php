<?php 

    session_start();
    include "../DBConnector.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $email = $_POST['email'];
        $password = $_POST['password'];

        $checkAdmin = "SELECT * FROM admins WHERE email = '$email' ";
        $adminExists = $conn->query($checkAdmin);

        if ($adminExists-> num_rows == 1){
            $admin = $adminExists -> fetch_assoc();
            if (password_verify($password, $admin['admin_password'])){
                $_SESSION['admin_email'] = $admin['email'];
                echo "<script> alert ('Signed-in') </script>";
                header("refresh: 0.5;url=../pages/admin-dashboard.php");
            }   else {
                echo "<script> alert('Invalid Passoword!'); </script>";
                header("refresh: 0.5;url=../pages/admin-login.php");
            }
        } else {
            echo "<script> alert ('Admin does not exist!') </script>";
            header("refresh: 0.5;url=../pages/admin-login.php");
        }

    }






?>