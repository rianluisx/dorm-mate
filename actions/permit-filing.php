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
        $roomNumber = $_POST['room_number'];
        $timeOut = $_POST['time_out'];
        $expectedDate = $_POST['expected_date'];
        $destination = $_POST['destination'];
        $purpose = $_POST['purpose'];
        $inCareOf = $_POST['in_care_of'];
        $emergencyContact = $_POST['emergency_contact'];

        $insertPermit = "INSERT INTO permit (student_id, permit_type, room_number, time_out, expected_date, destination, purpose, in_care_of, emergency_contact, permit_status) 
                         VALUES ('$studentID', '$permitType', '$roomNumber', '$timeOut', '$expectedDate', '$destination', '$purpose', '$inCareOf', '$emergencyContact', 'pending')";

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

$conn->close();
?>
