<?php 

    session_start();
    include "../DBConnector.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $email = $_POST['email'];
        $password = $_POST['password'];

        $checkStudent = "SELECT * FROM student WHERE email = '$email' ";
        $studentExists = $conn->query($checkStudent);

        if ($studentExists-> num_rows == 1){
            $student = $studentExists -> fetch_assoc();
            if (password_verify($password, $student['student_password'])){
                $_SESSION['student_email'] = $student['email'];
                echo "<script> alert ('Signed-in') </script>";
                header("refresh: 0.5;url=../pages/student-dashboard.php");
            } else {
                echo "<script> alert('Invalid Passoword!'); </script>";
                header("refresh: 0.5;url=../pages/student-login.php");
            }
        } else {
            echo "<script> alert ('Student does not exist!') </script>";
            header("refresh: 0.5;url=../pages/student-login.php");
        }

    }


    



?>