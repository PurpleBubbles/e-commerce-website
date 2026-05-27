<?php
//start user session
session_start();
class ValidationException extends Exception {}

//include db connection file
include '../database/db_connection.php';

$email = "";
$hashed_password = "";
$error_message_popup = "";
$user_id="";

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
                // Redirect to correct buyer page based on user type
                $sql = "SELECT is_buyer, is_seller, is_admin , user_id FROM USERS WHERE user_email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$email]);
                $row = $stmt->fetch();

                //store user id in session
                $_SESSION['user_id'] = $row['user_id'];

                if ($row['is_admin'] == 1){
                    header('Location: /admin/admin_home.php');
                    exit;
                } else if ($row['is_seller'] == 1){
                    header('Location: /seller/home.php');
                    exit; // Ensure code stops executing after redirect
                } else{
                    header('Location: /buyer/home.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="/stylesheet.css" rel="stylesheet" />
    <title>Login</title>
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

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login to Account</p>

                                <form id="login" action="login.php" method="POST" class="mx-1 mx-md-4">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div>
                                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email;?>">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div>
                                            <input type="password" class="form-control" id="password" name="password" required >
                                            <label for="password">Password</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                                    </div>

                                </form>

                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <a href="/registration/buyer_registration.php" class="footer-links">Register as Buyer</a>

                                </div>

                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <a href="/registration/seller_registration.php" class="footer-links">Register as Seller</a>

                                </div>

                            </div>

                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img src="/media/login_illustration.png"
                                     class="img-fluid" alt="login image">

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