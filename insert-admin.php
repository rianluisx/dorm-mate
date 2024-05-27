<?php 

include "DBConnector.php";

$adminName = "John Doe";
$email = "john@example.com";
$password = password_hash('123456789', PASSWORD_DEFAULT); 


$insertAdminQuery = "INSERT INTO admins (admin_name, email, admin_password) 
                     VALUES ('$adminName', '$email', '$password')";
$result = $conn->query($insertAdminQuery);


?>