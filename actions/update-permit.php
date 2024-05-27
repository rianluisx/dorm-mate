<?php
    session_start();
    include "../DBConnector.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['student_email'])) {
        $permitID = $_POST['permit_id'];
        $permitType = $_POST['permit_type'];

        $updatePermit = "UPDATE permit SET permit_type = '$permitType' WHERE permit_id = '$permitID'";
        if ($conn->query($updatePermit) === TRUE) {
            echo "<script> alert('Permit updated successfully!') </script>";
            header("refresh: 0.5;url=../pages/student-dashboard.php");
        } else {
            echo "Error updating permit: " . $conn->error;
        }
    } else {
        echo "Error: Invalid request.";
}
?>