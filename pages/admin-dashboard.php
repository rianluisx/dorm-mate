<?php
    session_start();
    include "../DBConnector.php"; 

    if (!isset($_SESSION['admin_email'])) {
        header("Location: admin-login.php");
        exit();
    }

    $email = $_SESSION['admin_email'];

    $getAdmin = "SELECT admin_name from admins WHERE email = '$email'";
    $retrievedAdmin = $conn->query($getAdmin);

    if ($retrievedAdmin->num_rows == 1){
        $admin = $retrievedAdmin->fetch_assoc();
        $adminName = $admin['admin_name'];

    }

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
    <link rel="icon" type="icon" href="../images/🦆 icon _bookmark book_.png">
    <link rel="stylesheet" href="../css/student-dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/media-screen-queries.css">
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="../images/🦆 icon _bookmark book_.png" alt="">
            <div class="admin">
                <h3>Hello <?php echo $adminName; ?>!</h3>
            </div>
            <form action="../actions/logout-admin.php" method="post">
                <button type="submit" class="btn btn-outline-dark">Log-out</button>
            </form>
        </div>

        <br>
        <div class="permit-cont">
            <h2>Manage Permits</h2>
                <?php if ($pendingPermitsResult->num_rows > 0): ?>
                    <?php while ($permit = $pendingPermitsResult->fetch_assoc()): ?>
                        <div class="permit-card clickable" data-bs-toggle="modal" data-bs-target="#permit-details-modal-<?php echo $permit['permit_id']; ?>">
                            <p><strong>Student Name:</strong> <?php echo $permit['student_name']; ?></p>
                            <p><strong>Permit Type:</strong> <?php echo $permit['permit_type']; ?></p>
                            <p><strong>Date Filed:</strong> <?php echo $permit['date_filed']; ?></p>
                        </div>
            

                    <div class="modal fade" id="permit-details-modal-<?php echo $permit['permit_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="permitDetailsModalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="permitDetailsModalTitle">Permit Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <p><strong>Permit Type:</strong> <?php echo $permit['permit_type']; ?> <span id="modal-permit-type"></span></p>
                                        <p><strong>Status:</strong> <?php echo $permit['permit_status']; ?> <span id="modal-permit-status"></span></p>
                                        <p><strong>Date Filed:</strong> <?php echo $permit['permit_type']; ?> <span id="modal-date-filed"></span></p>
                                        <p><strong>Room Number:</strong> <?php echo $permit['room_number']; ?> <span id="modal-room-number"></span></p>
                                        <p><strong>Time Out:</strong> <?php echo $permit['time_out']; ?> <span id="modal-time-out"></span></p>
                                        <p><strong>Expected Date of Return:</strong> <?php echo $permit['expected_date']; ?> <span id="modal-expected-date"></span></p>
                                        <p><strong>Destination:</strong> <?php echo $permit['destination']; ?><span id="modal-destination"></span></p>
                                        <p><strong>Purpose:</strong><?php echo $permit['purpose']; ?> <span id="modal-purpose"></span></p>
                                        <p><strong>In Care Of:</strong> <?php echo $permit['in_care_of']; ?><span id="modal-in-care-of"></span></p>
                                        <p><strong>Emergency Contact:</strong> <?php echo $permit['emergency_contact']; ?> <span id="modal-emergency-contact"></span></p>
                                    <form action="../actions/manage-permit.php" method="post">
                                        <input type="hidden" name="permit_id" value="<?php echo $permit['permit_id']; ?>">
                                        <button type="submit" name="permit_status" value="approved" class="btn btn-success">Approve</button>
                                        <button type="submit" name="permit_status" value="rejected" class="btn btn-danger">Reject</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No pending permits to manage.</p>
            <?php endif; ?>
        </div>

    <br>
    <h2 class="act-log">Activity Log</h2>
        <?php if ($activityLogResult->num_rows > 0): ?>
            <ul>
                <?php while ($activity = $activityLogResult->fetch_assoc()): ?>
                    <div class="permit-card clickable" data-bs-toggle="modal" data-bs-target="#activity-details-modal-<?php echo $activity['permit_id']; ?>">
                        <h3><?php echo $activity['permit_type']; ?></h3>
                        <span class="badge <?php echo $activity['permit_status'] == 'approved' ? 'bg-success' : ($activity['permit_status'] == 'rejected' ? 'bg-danger' : 'bg-warning'); ?>"><?php echo $activity['permit_status']; ?></span>
                        <p><strong>Filed by:</strong> <?php echo $activity['student_name']; ?> 
                        <p><strong>Date Filed:</strong> <?php echo $activity['date_filed']; ?></p>
                    </div>

                    <div class="modal fade" id="activity-details-modal-<?php echo $activity['permit_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="activityDetailsModalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="activityDetailsModalTitle">Activity Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Permit Type:</strong> <?php echo $activity['permit_type']; ?></p>
                                    <p><strong>Status:</strong> <?php echo $activity['permit_status']; ?></p>
                                    <p><strong>Date Filed:</strong> <?php echo $activity['date_filed']; ?></p>
                                    <p><strong>Room Number:</strong> <?php echo $activity['room_number']; ?></p>
                                    <p><strong>Time Out:</strong> <?php echo $activity['time_out']; ?></p>
                                    <p><strong>Expected Date of Return:</strong> <?php echo $activity['expected_date']; ?></p>
                                    <p><strong>Destination:</strong> <?php echo $activity['destination']; ?></p>
                                    <p><strong>Purpose:</strong> <?php echo $activity['purpose']; ?></p>
                                    <p><strong>In Care Of:</strong> <?php echo $activity['in_care_of']; ?></p>
                                    <p><strong>Emergency Contact:</strong> <?php echo $activity['emergency_contact']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No recent activities.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
