<?php

//include db connection file
include '/Users/monje/PhpstormProjects/ecommerce/database/db_connection.php';

$username = "";
$email = "";
$phone = "";
$role = "";
$hashed_password = "";

$error_message_popup = "";

// PHP registration file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate and sanitize user input
    $username = htmlspecialchars($_POST['userName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phoneNumber'], FILTER_SANITIZE_NUMBER_INT);
    $role = htmlspecialchars($_POST['role']);
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); //always store only hashed passwords!!!

    //check if user email already in use
    $sql = "SELECT COUNT(*) as `counter` FROM USERS WHERE user_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();

    if ($row['counter'] >= 1){
        $error_message_popup = "User already exists!";
    }else{
        //Seller Identification Check
        if ($role === 'seller') {
            // Here you would eventually redirect them to a secondary form

            // to upload their ID or verify their business details.
            echo "Welcome, Seller! Proceeding to identification verification...";
        } else {
            $sql = "INSERT INTO USERS (user_name, password_hashed, user_email, user_phone) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $hashed_password, $email, $phone]);
            echo "Welcome, Buyer! Registration successful.";

            header("Location: target-file.php");
            exit;
        }
    }
}