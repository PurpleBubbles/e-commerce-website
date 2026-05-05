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
        }
    }
}

?>

<!--creation of html registration page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h1>Registration</h1>
    <h2>Create an Account</h2>
    <form id="registration" action="registration.php" method="POST">
        <div>
            <label for="userName">Username: </label>
            <input type="text" id="userName" name="userName" required value="<?php echo $username;?>">
        </div>

        <div>
            <label for="email">Email: </label>
            <input type="email" id="email" name="email" required value="<?php echo $email;?>">
        </div>

        <div>
            <label for="phoneNumber">Phone Number: </label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required value="<?php echo $phone;?>">
        </div>

        <div>
            <label for="role">I am registering as a: </label>
            <select id="role" name="role">
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
            </select>
        </div>

        <div>
            <label for="password">Password: </label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="confirmPassword">Confirm Password: </label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
        </div>

        <button type="submit">Submit</button>
    </form>

    <script src="registration-validation.js"></script>

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