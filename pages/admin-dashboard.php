<?php
    session_start();
    include "../DBConnector.php"; 

    if (!isset($_SESSION['admin_email'])) {
        header("Location: admin-login.php");
        exit();
    }

    $email = $_SESSION['admin_email'];


    $getPendingPermits = "SELECT permit.*, student.student_name FROM permit JOIN student ON permit.student_id = student.student_id WHERE permit.permit_status = 'pending' ORDER BY permit.date_filed DESC";
    $pendingPermitsResult = $conn->query($getPendingPermits);


    $getActivityLog = "SELECT permit.*, student.student_name FROM permit JOIN student ON permit.student_id = student.student_id ORDER BY permit.date_filed DESC LIMIT 10";
    $activityLogResult = $conn->query($getActivityLog);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>

    <h1>Admin Dashboard</h1>

    <h2>Manage Permits</h2>
    <?php if ($pendingPermitsResult->num_rows > 0): ?>
        <form action="../actions/manage-permit.php" method="post">
            <?php while ($permit = $pendingPermitsResult->fetch_assoc()): ?>
                <div>
                    <p><strong>Student Name:</strong> <?php echo $permit['student_name']; ?></p>
                    <p><strong>Permit Type:</strong> <?php echo $permit['permit_type']; ?></p>
                    <p><strong>Date Filed:</strong> <?php echo $permit['date_filed']; ?></p>
                    <input type="hidden" name="permit_id" value="<?php echo $permit['permit_id']; ?>">
                    <button type="submit" name="permit_status" value="approved">Approve</button>
                    <button type="submit" name="permit_status" value="rejected">Reject</button>
                </div>
                <hr>
            <?php endwhile; ?>
        </form>
    <?php else: ?>
        <p>No pending permits to manage.</p>
    <?php endif; ?>

    <h2>Activity Log</h2>
    <?php if ($activityLogResult->num_rows > 0): ?>
        <ul>
            <?php while ($activity = $activityLogResult->fetch_assoc()): ?>
                <li>
                    <?php echo $activity['date_filed']; ?> - 
                    <?php echo $activity['student_name']; ?> filed a <?php echo $activity['permit_type']; ?> permit.
                    Status: <?php echo $activity['permit_status']; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No recent activities.</p>
    <?php endif; ?>

    <form action="../actions/logout-admin.php" method="post">
        <button type="submit">Log Out</button>
    </form>

</body>
</html>
