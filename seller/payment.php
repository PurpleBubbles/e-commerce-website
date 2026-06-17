<?php
//start user session
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login/login.php");
    exit;
}

class ValidationException extends Exception {}

include '../controllers/seller_controllers/payment_ctrl.php';
include '../database/db_connection.php';

$product_id = "";
$payment_method="";
$card_name="";
$card_number="";
$card_expiry="";
$card_cvv="";
$shipping = 100;

$error_message_popup = "";

if (isset($_GET['product'])){
    $product_id = filter_var($_GET['product']);
} else {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}

$sql = "SELECT * FROM PRODUCTS WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$product_id]);
$rows = $stmt->fetch();

$total_price = $rows['price'] + $shipping;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $payment_method = htmlspecialchars($_POST['paymentMethod']);
    $card_name = htmlspecialchars($_POST['card_name']);
    $card_number = htmlspecialchars($_POST['card_number']);
    $card_expiry = htmlspecialchars($_POST['card_expiry']);
    $card_cvv = htmlspecialchars($_POST['card_cvv']);

    try {
        if($payment_method == "cash"){
            $card_name="Cash on Delivery";
            $card_number="Cash on Delivery";
            $card_expiry="Cash on Delivery";
            $card_cvv="Cash on Delivery";
        }

        if($card_name == "" || $card_number == "" || $card_expiry == "" || $card_cvv == ""){
            throw new ValidationException("Please fill in all fields");
        }

        $sql = "INSERT INTO PAYMENTS (amount, method, buyer_user_id, product_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$total_price, $payment_method, $_SESSION['user_id'], $product_id]);

        $sql = "INSERT INTO BOUGHT (buyer_user_id, product_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $product_id]);

        $sql = "UPDATE PRODUCTS SET status = 0 WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$product_id]);

        header('Location: /seller/home.php');
        exit;
        header("Location: target-file.php");
        exit;

    } catch (ValidationException $e) {
        $error_message_popup = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<HTML lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="/stylesheet.css" rel="stylesheet" />
    <title>Payment</title>

</head>

<body style="height: 100vh;">
    <header class="header p-3 bg-primary text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/seller/home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    Payment Page
                </a>
            </div>
        </div>
    </header>

    <main class="h-100 d-flex flex-nowrap flex-fill">
        <div class="container-lg my-1">

            <?php

            echo PaymentCtrl::displayPayment($rows, $conn);

            ?>



        <hr class="my-4">

        <form id="payment" action="payment.php?product=<?php echo $product_id ?>" method="POST" class="mx-1 mx-md-4">
            <p class=" h1 fw-bold ">Payment Options</p>

            <div class="my-3">
                <div class="form-check">
                    <input id="credit" name="paymentMethod" type="radio" value="credit" required>
                    <label class="form-check-label" for="credit">Credit card</label>
                </div>
                <div class="form-check">
                    <input id="debit" name="paymentMethod" type="radio" value="debit" required>
                    <label class="form-check-label" for="debit">Debit card</label>
                </div>
                <div class="form-check">
                    <input id="paypal" name="paymentMethod" type="radio" value="paypal" required>
                    <label class="form-check-label" for="paypal">PayPal</label>
                </div>
                <div class="form-check">
                    <input id="cash" name="paymentMethod" type="radio" value="cash" required>
                    <label class="form-check-label" for="cash">Cash</label>
                </div>
            </div>

            <div class="row gy-3">
                <div class="col-md-6">
                    <label for="cc-name" >Name on card</label>
                    <input type="text" name="card_name" id="cc-name" placeholder="Mr/Ms John/Jane Doe" value="<?php echo $card_name?>" >
                    <small class="text-muted">Full name as displayed on card</small>
                </div>

                <div class="col-md-6">
                    <label for="cc-number" class="form-label">Credit card number</label>
                    <input type="text" name="card_number" id="cc-number" placeholder="1234567890"  value="<?php echo $card_number?>">
                </div>

                <div class="col-md-3">
                    <label for="cc-expiration" class="form-label">Expiration</label>
                    <input type="text" name="card_expiry" id="cc-expiration" placeholder="mm/yy"  value="<?php echo $card_expiry?>">
                </div>

                <div class="col-md-3">
                    <label for="cc-cvv" class="form-label">CVV</label>
                    <input type="text" name="card_cvv" id="cc-cvv" placeholder="123"  value="<?php echo $card_cvv?>">
                </div>
            </div>

            <div>
                <button style="width: auto " type="submit" class="btn btn-primary btn-lg m-1">Buy Product</button>

                <button style="width: auto " type="button" class="btn btn-primary btn-lg m-1" onclick="location.href='../../seller/home.php'">Cancel Payment</button>
            </div>
        </form>
        </div>

    </main>

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
</HTML>
