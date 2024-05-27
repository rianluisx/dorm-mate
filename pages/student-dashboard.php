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
</head>
<body>

<h1>Hello <?php echo $studentName; ?></h1>

<h2>Permit Filing</h2>
<form action="../actions/permit-filing.php" method="post">
    <label for="permitType">Permit Type:</label>
    <select name="permit_type" id="permitType">
        <option value="late-night-permit">Late Night Permit</option>
        <option value="overnight-permit">Overnight Permit</option>
        <option value="weekend-permit">Weekend Permit</option>
    </select>
    <br><br>
    <button type="submit">File Permit</button>
</form>

<h2>Your Permits</h2>
<?php if ($permitsResult->num_rows > 0): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Permit Type</th>
                <th>Status</th>
                <th>Date Filed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($permit = $permitsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $permit['permit_type']; ?></td>
                    <td><?php echo $permit['permit_status']; ?></td>
                    <td><?php echo $permit['date_filed']; ?></td>
                    <td>
                        <?php if ($permit['permit_status'] == 'pending'): ?>
                            <form action="edit-permit.php" method="get" style="display:inline;">
                                <input type="hidden" name="permit_id" value="<?php echo $permit['permit_id']; ?>">
                                <button type="submit">Edit</button>
                            </form>
                        <?php else: ?>
                            No actions available
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>You have not filed any permits yet.</p>
<?php endif; ?>

<form action="../actions/logout-student.php" method="post">
    <button type="submit">Log Out</button>
</form>

</body>
</html>