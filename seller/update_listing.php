<?php
$image_id = 3;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="/stylesheet.css" rel="stylesheet" />
    <title>Update Listing</title>

</head>
<body>
<section class="vh-100" style="background-color: #2C1E38FF;">
    <header class="header p-3 bg-primary text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/buyer/bought.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    Update Listing
                </a>

            </div>
        </div>
    </header>
    <main class="h-100 d-flex flex-nowrap flex-fill">

        <div class=" h-100 d-flex flex-column flex-shrink-0 p-3 text-bg-secondary" style="width: auto;">
            <a href="/seller/home.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img width="40px" src="/media/logo.png" alt="logo" />
                <span class="fs-4 text-black">Bazaar Inc.</span>
            </a>
            <ul class="nav nav-pills flex-column mb-auto">

                <li class="nav-item my-2">
                    <a href="/seller/home.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/home.png" class="report-img text-black" alt="home"/>
                        Home
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/seller/bought.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/bought.png" class="report-img" alt="Bought items"/>
                        Bought
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/seller/sold.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/sold.png" class="report-img" alt="Sold items"/>
                        Sold
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/seller/user_listings.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/collection.png" class="report-img" alt="My Listings"/>
                        My Listings
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/seller/listing.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/list.png" class="report-img" alt="List Product"/>
                        List
                    </a>
                </li>
                <li class="nav-item my-2">
                    <a href="/seller/profile.php" class="nav-link active" aria-current="page">
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

        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Update Listing</p>

                                    <form id="update_profile" action="profile.php" method="POST" class="mx-1 mx-md-4">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" id="email" name="email" class="form-control" required value="<?php echo $email;?>"/>
                                                <label class="form-label" for="email">Your Email</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="password" name="password" class="form-control" required/>
                                                <label class="form-label" for="password">Current Password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="newPassword" name="newPassword" class="form-control" required/>
                                                <label class="form-label" for="newPassword">New Password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required />
                                                <label class="form-label" for="confirmPassword">Repeat New password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Update</button>
                                        </div>

                                    </form>


                                </div>

                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img style="max-height: 300px;" src="/image.php?image_id=<?php echo $image_id;?>" alt="No Image Present" />

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