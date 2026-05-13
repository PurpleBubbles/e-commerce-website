<?php
class ValidationException extends Exception {}

//include db connection file
include '../database/db_connection.php';

$email = "";
$hashed_password = "";
$error_message_popup = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate and sanitize user input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $hashed_password = password_verify($_POST['password'], PASSWORD_DEFAULT); //always store only hashed passwords!!!

    //check if user with that email exists
    $sql = "SELECT COUNT(*) as `counter` FROM USERS WHERE user_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();

    try {
        if ($row['counter'] < 1){
            throw new ValidationException("User with that email address does not exist! Please create an account instead.");
        }else{
            //check if user with that email has a matching password
            $sql = "SELECT password_hashed FROM USERS WHERE user_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $row = $stmt->fetch();

            if (password_verify($_POST['password'], $row['password_hashed'])){
                // Redirect to home page
                $sql = "SELECT is_buyer, is_seller, is_admin FROM USERS WHERE user_email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$email]);
                $row = $stmt->fetch();
                if ($row['is_admin'] == 1){
                    header('Location: /admin/admin_home.php');
                    exit;
                } else if ($row['is_seller'] == 1){
                    header('Location: /home/home.php');
                    exit; // Ensure code stops executing after redirect
                } else{
                    header('Location: /home/home.php');
                    exit;
                }
            } else{
                throw new ValidationException("Incorrect password! Please try again.");
            }
        }
    }catch (ValidationException $e) {
        $error_message_popup = $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
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
        input {
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
<h1>Login</h1>
<h2>Sign-in to Account</h2>
<form id="login" action="login.php" method="POST">
    <div>
        <label for="email">Email: </label>
        <input type="email" id="email" name="email" required value="<?php echo $email;?>">
    </div>

    <div>
        <label for="password">Password: </label>
        <input type="password" id="password" name="password" required >
    </div>

    <button type="submit">Login</button>
</form>
<a href="/registration/buyer_registration.php" class="footer-links">Register as Buyer</a>
<a href="/registration/seller_registration.php" class="footer-links">Register as Seller</a>

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