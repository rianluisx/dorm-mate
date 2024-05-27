<?php
    session_start();
    include "../DBConnector.php"; 

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['permit_id']) && isset($_POST['permit_status'])) {
        $permitID = $_POST['permit_id'];
        $permitStatus = $_POST['permit_status'];

    if (isset($_SESSION['admin_email'])) {
        $adminEmail = $_SESSION['admin_email'];
        $getAdminID = "SELECT admin_id FROM admins WHERE email = '$adminEmail'";
        $adminIDResult = $conn->query($getAdminID);

        if ($adminIDResult->num_rows > 0) {
            
            $adminIDRow = $adminIDResult->fetch_assoc();
            $adminID = $adminIDRow['admin_id'];
            
            $updatePermit = "UPDATE permit SET permit_status = '$permitStatus' WHERE permit_id = '$permitID'";
            
            if ($conn->query($updatePermit) === TRUE) {
                
                if ($permitStatus == 'approved' || $permitStatus == 'rejected') {
                    $deletePermit = "DELETE FROM permit WHERE permit_id = '$permitID'";
                    $conn->query($deletePermit);
                    
                }
                echo "<script> alert('Permit updated successfully!'); </script>";
                
            } else {
                echo "Error updating permit: " . $conn->error;
            }
        } else {
            echo "Error: Admin ID not found.";
        }
    } else {
        echo "Error: User not logged in.";
    }
} else {
    echo "Invalid request.";
}

header("refresh: 0.5;url=../pages/admin-dashboard.php");
exit();
?>
