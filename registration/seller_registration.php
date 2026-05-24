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

            // Redirect to buyer page
            header('Location: /seller/home.php');
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
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


    <title>Seller Registration</title>
</head>
<body>
    <section class="vh-100" style="background-color: #253952;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Seller Account Creation</p>

                                    <form id="seller_registration" action="seller_registration.php" method="POST" class="mx-1 mx-md-4">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="userName"  name="userName" class="form-control" required value="<?php echo $username;?>"/>
                                                <label class="form-label" for="userName">Your Name</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" id="email" name="email" class="form-control" required value="<?php echo $email;?>"/>
                                                <label class="form-label" for="email">Your Email</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" required value="<?php echo $phone;?>"/>
                                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="ID" name="ID" class="form-control" required value="<?php echo $id_number;?>"/>
                                                <label class="form-label" for="ID">ID Number</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="password" name="password" class="form-control" required/>
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required />
                                                <label class="form-label" for="confirmPassword">Repeat your password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="address" name="address" class="form-control" required value="<?php echo $address;?>"/>
                                                <label class="form-label" for="address">House Address</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="bank_name" name="bank_name" class="form-control" required value="<?php echo $bank_name;?>"/>
                                                <label class="form-label" for="bank_name">Bank Name</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="bank_account" name="bank_account" class="form-control" required value="<?php echo $bank_account;?>"/>
                                                <label class="form-label" for="bank_account">Bank Account</label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                        </div>

                                    </form>

                                    <div class="d-flex justify-content-center text-center mt-4">
                                        <a href="/login/login.php" class="footer-links">Login Page</a>
                                    </div>

                                    <div class="d-flex justify-content-center text-center mt-4">
                                        <a href="/registration/buyer_registration.php" class="footer-links">Buyer Registration</a>
                                    </div>

                                </div>

                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="/media/registration_illustration.png"
                                         class="img-fluid" alt="registration image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





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
