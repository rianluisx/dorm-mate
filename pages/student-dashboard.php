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

    $getPermits = "SELECT * FROM permit WHERE student_id = '$studentID'";
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
            <h3>Hello <?php echo $studentName; ?>!</h3>
            <form action="../actions/logout-student.php" method="post">
                <button type="submit" class="btn btn-outline-dark">Log-out</button>
            </form>
        </div>

        <div class="file-permit">
            <p>Need a permit?</p>
                
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#sign-up-modal">
                File a permit
            </button>

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
        <br>
        <?php if ($permitsResult->num_rows > 0): ?>
            <?php while ($permit = $permitsResult->fetch_assoc()): ?>
                <div class="permit-card" data-bs-toggle="modal" data-bs-target="#permit-details-modal" data-permit='<?php echo json_encode($permit); ?>'>
                    <h3><?php echo $permit['permit_type']; ?></h3>
                    <!-- Displaying status using Bootstrap badge -->
                    <span class="badge <?php echo $permit['permit_status'] == 'approved' ? 'bg-success' : ($permit['permit_status'] == 'rejected' ? 'bg-danger' : 'bg-warning'); ?>"><?php echo $permit['permit_status']; ?></span>
                    <p><strong>Date Filed:</strong> <?php echo $permit['date_filed']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You have not filed any permits yet.</p>
        <?php endif; ?>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var permitCards = document.querySelectorAll('.permit-card');
            permitCards.forEach(function (card) {
                card.addEventListener('click', function () {
                    var permit = JSON.parse(this.getAttribute('data-permit'));
                    document.getElementById('modal-permit-type').textContent = permit.permit_type;
                    document.getElementById('modal-permit-status').textContent = permit.permit_status;
                    document.getElementById('modal-permit-status').className = 'badge bg-' + (permit.permit_status == 'pending' ? 'warning' : (permit.permit_status == 'approved' ? 'success' : 'danger'));
                    document.getElementById('modal-date-filed').textContent = permit.date_filed;
                    document.getElementById('modal-room-number').textContent = permit.room_number;
                    document.getElementById('modal-time-out').textContent = permit.time_out;
                    document.getElementById('modal-expected-date').textContent = permit.expected_date;
                    document.getElementById('modal-destination').textContent = permit.destination;
                    document.getElementById('modal-purpose').textContent = permit.purpose;
                    document.getElementById('modal-in-care-of').textContent = permit.in_care_of;
                    document.getElementById('modal-emergency-contact').textContent = permit.emergency_contact;
                });
            });
        });
    </script>

</body>
</html>