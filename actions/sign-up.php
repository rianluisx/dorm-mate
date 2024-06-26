<?php 

    include "../DBConnector.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmed_password']) ) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $confirmed_password = $_POST['confirmed_password'];

            $checkStudent = "SELECT * FROM student WHERE email = '$email'";
            $studentExists = $conn->query($checkStudent);

            if ($studentExists->num_rows > 0) {
                echo "<script>alert('User already exists');</script>";
                header("refresh: 0.5;url=../pages/student-login.php");
            } else {

                if ($confirmed_password != $password){
                    echo "<script>alert('Passwords did not match!');</script>";
                    header("refresh: 0.5;url=../pages/student-login.php?signup_error=password_mismatch");
                } else {

                    $signUpStudent = "INSERT INTO student (student_name, email, student_password) 
                            VALUES ('$name', '$email', '$hashedPassword')";
                    $result = $conn->query($signUpStudent);

                    if ($result) {
                        echo "<script>alert('Signed up successfully!');</script>";
                        header("refresh: 0.5;url=../pages/student-login.php");
                    } else {
                        
                        echo "<script>alert('Error in sign up');</script>";
                    }
                }
            }
        } else {

            echo "<script>alert('Error: Missing name, email, or password!');</script>";
        }
    } else {
        
        echo "<script>alert('Error: Invalid request method!');</script>";
    }
?>
