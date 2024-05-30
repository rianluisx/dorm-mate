<?php

    session_start();
    include "../DBConnector.php";

    if (!isset($_SESSION['student_email'])) {
        header("Location: student-login.php");
        exit(); 
    }

    $email = $_SESSION['student_email'];
    $getUserInfo = "SELECT * FROM student WHERE email = '$email'";
    $userInfoResult = $conn->query($getUserInfo);

    if ($userInfoResult->num_rows > 0) {
        $userInfo = $userInfoResult->fetch_assoc();
        $studentName = $userInfo['student_name'];
        $studentID = $userInfo['student_id'];
    }

    $getPermits = "SELECT * FROM permit WHERE student_id = '$studentID' ORDER BY date_filed DESC";
    $permitsResult = $conn->query($getPermits);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/student-dashboard.css">
    <link rel="stylesheet" href="../css/media-screen-queries.css">
    <link rel="icon" type="icon" href="../images/🦆 icon _bookmark book_.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>

    <div class="container">

        <div class="header">
            <img src="../images/🦆 icon _bookmark book_.png" alt="">
            <div class="user-name">
                <h3>Hello <?php echo $studentName; ?>!</h3>
            </div>
            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal">Log-out</button>
        </div>

        <div class="modal fade" id="logoutConfirmationModal" tabindex="-1" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutConfirmationModalLabel">Confirm Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to log out?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form id="logoutForm" action="../actions/logout-student.php" method="post">
                            <button type="submit" class="btn btn-primary">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="file-permit">
            <p>Need a permit?</p>
                
            <button type="button" id="file-permit-button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#sign-up-modal">
                File a permit
            </button>

            <p id="permit-timer" class="mt-2" style="font-size: 20px;"></p>

            <div class="modal fade" id="sign-up-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sign-up-modal">File one!</h5>
                        </div>
                        <div class="modal-body">
                            <form action="../actions/permit-filing.php" method="post" class="sign-up">
                                <div class="input-field">
                                    <select name="permit_type" id="permitType">
                                        <option value="late-night-permit">Late Night Permit</option>
                                        <option value="overnight-permit">Overnight Permit</option>
                                        <option value="weekend-permit">Weekend Permit</option>
                                    </select>
                                </div>
                                <div class="input-field">
                                    <input type="text" class="input" id="room-number" placeholder="Room #" name="room_number" required="">
                                </div>
                                <div class="input-field">
                                    <input type="text" class="input" id="time-out" placeholder="Time Out" name="time_out" required="">
                                </div>
                                <div class="input-field">
                                    <input type="date" class="input" id="expected-date" placeholder="Expected Date of Return" name="expected_date" required="">
                                </div>
                                <div class="input-field">
                                    <input type="text" class="input" id="destination" placeholder="Destination" name="destination" required="">
                                </div>
                                <div class="input-field">
                                    <input type="text" class="input" id="purpose" placeholder="Purpose" name="purpose" required="">
                                </div>
                                <div class="input-field">
                                    <input type="text" class="input" id="in-care-of" placeholder="In Care Of" name="in_care_of" required="">
                                </div>
                                <div class="input-field">
                                    <input type="text" class="input" id="emergency-contact" placeholder="Emergency Contact" name="emergency_contact" required="">
                                </div>
                                <button type="submit" class="btn btn-primary">File Permit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>          
        </div>

        <br><br>
        <h2>Your Permits</h2>
        <div id="permitContainer">
            <?php $permitCount = 0; ?>
            <?php if ($permitsResult->num_rows > 0): ?>
                <?php while ($permit = $permitsResult->fetch_assoc()): ?>
                    <?php $permitCount++; ?>
                    <div class="permit-card clickable <?php echo $permitCount > 4 ? 'd-none' : ''; ?>" data-bs-toggle="modal" data-bs-target="#permit-details-modal" data-permit='<?php echo json_encode($permit); ?>'>
                        <h3><?php echo $permit['permit_type']; ?></h3>
                        <span class="badge <?php echo $permit['permit_status'] == 'approved' ? 'bg-success' : ($permit['permit_status'] == 'rejected' ? 'bg-danger' : 'bg-warning'); ?>"><?php echo $permit['permit_status']; ?></span>
                        <p><strong>Date Filed:</strong> <?php echo $permit['date_filed']; ?></p>
                    </div>
                <?php endwhile; ?>
                <?php if ($permitCount > 4): ?>
                    <div class="text-center mt-3">
                        <button id="seeMoreButton" class="btn btn-dark" style="text-align:center;">See More</button>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p>You have not filed any permits yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="permit-details-modal" tabindex="-1" role="dialog" aria-labelledby="permitDetailsModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permitDetailsModalTitle">Permit Details</h5>
                </div>
                <div class="modal-body">
                    <p><strong>Permit Type:</strong> <span id="modal-permit-type"></span></p>
                    <p><strong>Status:</strong> <span id="modal-permit-status"></span></p>
                    <p><strong>Date Filed:</strong> <span id="modal-date-filed"></span></p>
                    <p><strong>Room Number:</strong> <span id="modal-room-number"></span></p>
                    <p><strong>Time Out:</strong> <span id="modal-time-out"></span></p>
                    <p><strong>Expected Date of Return:</strong> <span id="modal-expected-date"></span></p>
                    <p><strong>Destination:</strong> <span id="modal-destination"></span></p>
                    <p><strong>Purpose:</strong> <span id="modal-purpose"></span></p>
                    <p><strong>In Care Of:</strong> <span id="modal-in-care-of"></span></p>
                    <p><strong>Emergency Contact:</strong> <span id="modal-emergency-contact"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="../src/index.js"></script>


</body>
</html>