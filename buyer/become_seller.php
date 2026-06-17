<?php
//start user session
session_start();

class ValidationException extends Exception {}

//include db connection file
include '../database/db_connection.php';

$user_id = $_SESSION['user_id'];

$email = "";
$phone = "";
$hashed_password = "";
$id_number = "";
$address = "";
$bank_name = "";
$bank_account = "";
$error_message_popup = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate and sanitize user input
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

        //check if email is correct
        $sql = "SELECT COUNT(*) as `counter` FROM USERS WHERE user_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        if ($row['counter'] < 1){
            throw new ValidationException("Incorrect email address! Please try again.");
        }else{

            $sql = "SELECT password_hashed FROM USERS WHERE user_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            $row = $stmt->fetch();

            if (password_verify($_POST['password'], $row['password_hashed']) === false){
                throw new ValidationException("Incorrect password! Please try again.");
            }

            //save seller info to SELLER_INFO table
            $sql = "INSERT INTO SELLER_INFO (house_address, bank_name, bank_account, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$address, $bank_name, $bank_account, $user_id]);

            //update user type to seller
            $sql = "UPDATE USERS SET is_seller = 1 WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$user_id]);
            $row = $stmt->fetch();

            // Redirect to seller page
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <script defer src="/navbar_small.js"></script>
    <link href="/stylesheet.css" rel="stylesheet" />
    <title>Become Seller</title>

</head>
<body>
<section class="min-vh-100 d-flex flex-column" style="background-color: #2C1E38FF;">
    <header class="header p-3 bg-primary text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/buyer/bought.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    Become a Seller
                </a>

            </div>
        </div>
    </header>
    <main class="flex-fill d-flex flex-nowrap">

        <div class=" d-flex flex-column flex-shrink-0 p-3 text-bg-secondary" style="width: auto;">
            <a href="/buyer/home.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img width="40px" src="/media/logo.png" alt="logo" />
                <span class="fs-4 text-black">Bazaar Inc.</span>
            </a>
            <ul class="nav nav-pills flex-column mb-auto">

                <li class="nav-item my-2">
                    <a href="/buyer/home.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/home.png" class="report-img text-black" alt="home"/>
                        Home
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/buyer/bought.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/bought.png" class="report-img" alt="Bought items"/>
                        Bought
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/buyer/become_seller.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/seller.png" class="report-img" alt="become seller"/>
                        Become Seller
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/buyer/profile.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/profile.png" class="report-img" alt="edit profile"/>
                        Profile
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/logout/logout.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/logout.png" class="report-img" alt="home"/>
                        Logout
                    </a>
                </li>

            </ul>
        </div>

    <div class="container">
        <div class="row d-flex justify-content-center align-items-start py-4">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Become a Seller</p>

                                <form id="become_seller" action="become_seller.php" method="POST" class="mx-1 mx-md-4">

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
                                        <button type="submit" class="btn btn-primary btn-lg">Become a Seller</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
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
