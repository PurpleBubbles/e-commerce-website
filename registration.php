<?php

// php registration file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate and sanitize user input
    $username = htmlspecialchars($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
    $role = htmlspecialchars($_POST['role']);
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); //always store only hashed passwords!!!

    //4. (Future Step) Connect to MySQL
    // In a modular setup, you would include a separate database connection file here.
    // require_once 'db_connection.php';

    // 5. Seller Identification Check
    if ($role === 'seller') {
        // Here you would eventually redirect them to a secondary form
        // to upload their ID or verify their business details.
        echo "Welcome, Seller! Proceeding to identification verification...";
    } else {
        echo "Welcome, Buyer! Registration successful.";
    }
    /*
    Example of how the MySQL insert will look once your database is ready:
    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $email, $hashed_password, $role]);
    */

} else {
    // If someone tries to access this file directly without submitting the form
    echo "Invalid request method.";
}
