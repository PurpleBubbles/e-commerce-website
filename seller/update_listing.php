<?php
session_start();

class ValidationException extends Exception {}

//include db connection file
include '../database/db_connection.php';

$listing_name = "";
$listing_description = "";
$listing_price = "";
$listing_category = "";
$listing_condition = "";
$listing_images[] = "";
$seller_user_id = $_SESSION['user_id'];
$product_id = $_GET['product'];
$error_message_popup = "";

$SQL = "SELECT image_id FROM PRODUCT_IMAGES WHERE product_id = ?";
$stmt = $conn->prepare($SQL);
$stmt->execute([$product_id]);
$image_row = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $listing_name = htmlspecialchars($_POST['name']);
    $listing_description = htmlspecialchars($_POST['description']);
    $listing_price = htmlspecialchars($_POST['price']);
    $listing_category = htmlspecialchars($_POST['category']);
    $listing_condition = htmlspecialchars($_POST['condition']);
    $listing_images = $_FILES['image']['tmp_name'];

    try {
        //price validation
        if (is_numeric($listing_price)){
            if ($listing_price >= 0){

                //update product
                $sql = "UPDATE PRODUCTS SET product_name = ?, description = ?, price = ?, category_id = ?, product_condition = ? WHERE product_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$listing_name, $listing_description, $listing_price, $listing_category, $listing_condition, $product_id]);

                //delete old images
                $sql = "DELETE FROM PRODUCT_IMAGES WHERE product_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$product_id]);

                //insert new images
                $counter = 1;
                $sql = "INSERT INTO PRODUCT_IMAGES (product_id, display_order, image_data, image_type) VALUES (?, ?, ?, ?)";
                foreach ($listing_images as $listing_image) {
                    $listing_image_contents = file_get_contents($listing_image);

                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$product_id, $counter, $listing_image_contents, $_FILES['image']['type'][$counter - 1]]);
                    $counter++;
                }

            }else{
                throw new ValidationException("Price must be a positive number");
            }
        } else{
            throw new ValidationException("Price must be a number");
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
    <main class="flex-fill d-flex flex-nowrap flex-fill">

        <div class=" d-flex flex-column flex-shrink-0 p-3 text-bg-secondary" style="width: auto;">
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

        <div class="container">
            <div class="row d-flex justify-content-center align-items-start py-4">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Update Listing</p>

                                    <form id="update_listing" action="update_listing.php?product=<?php echo $product_id?>" method="POST" class="mx-1 mx-md-4" enctype="multipart/form-data">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="name" name="name" class="form-control" required />
                                                <label class="form-label" for="name">New Name</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="description" name="description" class="form-control" required/>
                                                <label class="form-label" for="description">New description</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="price" name="price" class="form-control" required />
                                                <label class="form-label" for="price">New price</label>
                                            </div>
                                        </div>

                                        <fieldset>
                                            <legend>Update Category</legend>
                                            <input style="--bs-primary: " type="radio" id="vehicles" name="category" value=1 required />
                                            <label for="vehicles">Vehicles</label>
                                            <input type="radio" id="property" name="category" value=2 required/>
                                            <label for="property">Property</label>
                                            <input type="radio" id="clothing" name="category" value=3 required/>
                                            <label for="clothing">Clothing</label>
                                            <input type="radio" id="electronics" name="category" value=4 required/>
                                            <label for="electronics">Electronics</label>
                                            <input type="radio" id="books" name="category" value=5 required/>
                                            <label for="books">Books</label>
                                            <input type="radio" id="furniture" name="category" value=6 required/>
                                            <label for="furniture">Furniture</label>
                                            <input type="radio" id="decorations" name="category" value=7 required/>
                                            <label for="decorations">Decorations</label>
                                            <input type="radio" id="others" name="category" value=8 required/>
                                            <label for="others">Others</label>
                                        </fieldset>

                                        <fieldset>
                                            <legend>Update Condition</legend>
                                            <input type="radio" id="new" name="condition" value=1 required/>
                                            <label for="new">New</label>
                                            <input type="radio" id="used" name="condition" value=2 required/>
                                            <label for="used">Used</label>
                                            <input type="radio" id="refurbished" name="condition" value=3 required/>
                                            <label for="refurbished">Refurbished</label>
                                            <input type="radio" id="damaged" name="condition" value=4 required/>
                                            <label for="damaged">Damaged</label>
                                            <input type="radio" id="broken" name="condition" value=5 required/>
                                            <label for="broken">Broken</label>
                                        </fieldset>

                                        <label for="image">Upload New Images: </label>
                                        <input
                                                style="width: fit-content "
                                                class="btn btn-primary btn-lg m-1"
                                                type="file"
                                                name="image[]"
                                                id="image"
                                                accept=".png, .jpeg, .jpg"
                                                multiple
                                                required
                                        >

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Update</button>
                                        </div>

                                    </form>


                                </div>

                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img style="max-height: 300px;" src="/image.php?image_id=<?php echo $image_row['image_id'];?>" alt="No Image Present" />

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