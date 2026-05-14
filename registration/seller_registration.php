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
$id_number = "";
$address = "";
$bank_name = "";
$bank_account = "";
$error_message_popup = "";
$user_id="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate and sanitize user input
    $username = htmlspecialchars($_POST['userName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phoneNumber'], FILTER_SANITIZE_NUMBER_INT);
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); //always store only hashed passwords!!!
    $id_number = htmlspecialchars($_POST['ID']);
    $address = htmlspecialchars($_POST['address']);
    $bank_name = htmlspecialchars($_POST['bank_name']);
    $bank_account = htmlspecialchars($_POST['bank_account']);

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
            //save user data to USERS table
            $sql = "INSERT INTO USERS (user_name, password_hashed, user_email, user_phone, is_seller) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $hashed_password, $email, $phone, 1]);

            //get the id of the newly created user
            $sql = "SELECT user_id FROM USERS WHERE user_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $row = $stmt->fetch();

            //save seller info to SELLER_INFO table
            $sql = "INSERT INTO SELLER_INFO (seller_id, house_address, bank_name, bank_account, user_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id_number, $address, $bank_name, $bank_account, $row["user_id"]]);

            $sql = "SELECT user_id FROM USERS WHERE user_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $row = $stmt->fetch();

            //store user id in session
            $_SESSION['user_id'] = $row['user_id'];

            // Redirect to home page
            header('Location: /home/home.php');
            exit; // Ensure code stops executing after redirect
            header("Location: target-file.php");
            exit;
        }
    } catch (ValidationException $e) {
        $error_message_popup = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

	<title>Seller Registration</title>
</head>
<body>
	<h1>Seller Registration</h1>

    <h2>Create an Account</h2>

    <form id="seller_registration" action="seller_registration.php" method="POST">
        <div>

        </div>

        <div class="registration-form">
            <label>Username: </label>
            <input type="text" id="userName" name="userName" required value="<?php echo $username;?>">

            <label>Email: </label>
            <input type="email" id="email" name="email" required value="<?php echo $email;?>">

            <label>Phone Number: </label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required value="<?php echo $phone;?>">

            <label>Password: </label>
            <input type="password" id="password" name="password" required>

            <label>Confirm Password: </label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <label>ID Number: </label>
            <input type="text" id="ID" name="ID" required value="<?php echo $id_number;?>">

            <label>House Address: </label>
            <input type="text" id="address" name="address" required value="<?php echo $address;?>">

            <label>Bank Name: </label>
            <input type="text" id="bank_name" name="bank_name" required value="<?php echo $bank_name;?>">

            <label>Bank Account: </label>
            <input type="text" id="bank_account" name="bank_account" required value="<?php echo $bank_account;?>">

            <button type="submit">Register</button>
        </div>
    </form>
    <a href="/login/login.php" class="footer-links">Login Page</a>
    <a href="/registration/buyer_registration.php" class="footer-links">Buyer Registration</a>

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
</html>
