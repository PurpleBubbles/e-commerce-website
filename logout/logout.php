<?php

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

echo "Logged out successfully.";
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>

<body>
    <button class="view" onclick="location.href='/login/login.php'">Go to login page</button>

</body>

</html>
