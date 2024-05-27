<?php
    session_start();
    include "../DBConnector.php";

    if (!isset($_SESSION['student_email'])) {
        header("Location: student-login.php");
        exit(); // Stop further execution
    }

    $permitID = $_GET['permit_id'];
    $getPermit = "SELECT * FROM permit WHERE permit_id = '$permitID'";
    $permitResult = $conn->query($getPermit);

    if ($permitResult->num_rows > 0) {
        $permit = $permitResult->fetch_assoc();
    } else {
        echo "Permit not found.";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Permit</title>
</head>
<body>

<h1>Edit Permit</h1>

<form action="../actions/update-permit.php" method="post">
    <input type="hidden" name="permit_id" value="<?php echo $permitID; ?>">
    <label for="permitType">Permit Type:</label>
    <select name="permit_type" id="permitType">
        <option value="late-night-permit" <?php echo $permit['permit_type'] == 'late-night-permit' ? 'selected' : ''; ?>>Late Night Permit</option>
        <option value="overnight-permit" <?php echo $permit['permit_type'] == 'overnight-permit' ? 'selected' : ''; ?>>Overnight Permit</option>
        <option value="weekend-permit" <?php echo $permit['permit_type'] == 'weekend-permit' ? 'selected' : ''; ?>>Weekend Permit</option>
    </select>
    <br><br>
    <button type="submit">Update Permit</button>
</form>

</body>
</html>