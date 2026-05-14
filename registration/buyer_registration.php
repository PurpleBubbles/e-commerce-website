<?php
//start user session
session_start();

class ValidationException extends Exception {}

//include db connection file
include '../database/db_connection.php';

$username = "";
$email = "";
$phone = "";
$hashed_password = "";
$user_id="";

$error_message_popup = "";

// PHP buyer_registration file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate and sanitize user input
    $username = htmlspecialchars($_POST['userName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phoneNumber'], FILTER_SANITIZE_NUMBER_INT);
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); //always store only hashed passwords!!!

    try {
        if ($_POST['password'] !== $_POST['confirmPassword']) {
            throw new ValidationException("The passwords did not match");
        }

        //check if user email already in use
        $sql = "SELECT COUNT(*) as `counter` FROM USERS WHERE user_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        if ($row['counter'] >= 1){
            throw new ValidationException("User with that email address already exists! Please login instead.");
        }else{

            $sql = "INSERT INTO USERS (user_name, password_hashed, user_email, user_phone) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $hashed_password, $email, $phone]);

            $sql = "SELECT user_id FROM USERS WHERE user_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $row = $stmt->fetch();

            //store user id in session
            $_SESSION['user_id'] = $row['user_id'];

            // Redirect to buyer page
            header('Location: /buyer/buyer.php');
            exit; // Ensure code stops executing after redirect
            header("Location: target-file.php");
            exit;
        }

    } catch (ValidationException $e) {
        $error_message_popup = $e->getMessage();
    }
}

?>

<!--creation of html buyer_registration page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Registration</title>
    <style>
        /* General page styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 10px;
        }

        h1 {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 24px;
        }

        /* Button styling with hover effect */
        btn {
            width: 100%;
            padding: 12px;
            background-color: #04AA6D;
            text-align: center;
            justify-content: center;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        btn:hover {
            background-color: #038d5a;
        }

        label {
            display: block;
            width: 100%;
            text-align: left;
        }
        input, select {
            width: 100%;
            margin-top: 5px;
            margin-bottom: 5px;
            background-color: orange;
            text-align: center;
            justify-content: center;
            color: white;
        }

        /* Footer links */
        .footer-links {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .footer-links a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>

<h1>Buyer Registration</h1>
<h2>Create an Account</h2>
<form id="buyer_registration" action="buyer_registration.php" method="POST">

    <div class="registration-form">
        <label id="userName">Username: </label>
        <input type="text" id="userName" name="userName" required value="<?php echo $username;?>">

        <label>Email: </label>
        <input type="email" id="email" name="email" required value="<?php echo $email;?>">

        <label>Phone Number: </label>
        <input type="tel" id="phoneNumber" name="phoneNumber" required value="<?php echo $phone;?>">

        <label>Password: </label>
        <input type="password" id="password" name="password" required>

        <label>Confirm Password: </label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>

        <button type="submit">Register</button>
    </div>

</form>

<a href="/login/login.php" class="footer-links">Login Page</a>
<a href="/registration/seller_registration.php" class="footer-links">Seller Registration</a>

<?php
if ($error_message_popup != ""){
    ?>

    <script>
        alert("<?php echo $error_message_popup;?>");
    </script>

    <?php
}
?>

</body>
