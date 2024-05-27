<?php

    session_start();
    include "../DBConnector.php"; 

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['student_email'])) {
        
        $email = $_SESSION['student_email'];
        $getStudentID = "SELECT student_id FROM student WHERE email = '$email'";
        $studentIDResult = $conn->query($getStudentID);

        if ($studentIDResult->num_rows > 0) {
            $studentIDRow = $studentIDResult->fetch_assoc();
            $studentID = $studentIDRow['student_id'];

            
            $permitType = $_POST['permit_type'];

            $insertPermit = "INSERT INTO permit (student_id, permit_type) VALUES ('$studentID', '$permitType')";
            if ($conn->query($insertPermit) === TRUE) {
                echo "<script> alert('Permit filed successfully!'); </script>";
                header("refresh: 0.5;url=../pages/student-dashboard.php");
            } else {
                echo "Error filing permit: " . $conn->error;
            }
        } else {
            echo "Error: Student ID not found.";
        }
    } else {
        echo "Error: Invalid request.";
    }
?>
