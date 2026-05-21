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
$listing_location = "";
$listing_images[] = "";
$seller_user_id = $_SESSION['user_id'];
$product_id = "";
$error_message_popup = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $listing_name = htmlspecialchars($_POST['name']);
    $listing_description = htmlspecialchars($_POST['description']);
    $listing_price = htmlspecialchars($_POST['price']);
    $listing_category = htmlspecialchars($_POST['category']);
    $listing_condition = htmlspecialchars($_POST['condition']);
    $listing_location = htmlspecialchars($_POST['location']);
    $listing_images = $_FILES['image']['tmp_name'];

    try {
        //price validation
        if (is_numeric($listing_price)){
            if ($listing_price >= 0){

                $sql = "INSERT INTO PRODUCTS (product_name, description, price, category_id, product_condition, location_id, seller_user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$listing_name, $listing_description, $listing_price, $listing_category, $listing_condition, $listing_location, $seller_user_id]);
                $product_id = $conn->lastInsertId();

                $sql = "SELECT product_id FROM PRODUCTS WHERE product_name = ? AND seller_user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$listing_name, $seller_user_id]);
                $row = $stmt->fetch();

                if ($row === null) {
                    throw new ValidationException("No product id could be found. Please try again later.");
                }

                $product_id = $row['product_id'];
                $sql = "INSERT INTO PRODUCT_IMAGES (product_id, display_order, image) VALUES (?, ?, ?)";

                $counter = 1;
                foreach ($listing_images as $listing_image) {
                    $listing_image_contents = file_get_contents($listing_image);

                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$product_id, $counter, $listing_image_contents]);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title>Create Listing</title>
    <link rel="stylesheet" href="/style.css">

</head>
<body>

<header>
    <div class="listing_page">
        <label >
            <h3>Create Listing</h3>
        </label>
    </div>

</header>

<div class="main-container">
    <div class="navcontainer">

        <nav class="navigation_bar">
            <div class="nav-upper-options">

                <div class="nav-option Home" onclick="location.href='/seller/home.php'">
                    <img src="/media/home.png" class="report-img" alt="home" />
                    <h3>Home</h3>
                </div>
                <div class="nav-option Bought" onclick="location.href='/seller/bought.php'">
                    <img src="/media/bought.png" class="report-img" alt="bought" />
                    <h3>Bought</h3>
                </div>
                <div class="nav-option Sold" onclick="location.href='/seller/sold.php'">
                    <img src="/media/sold.png" class="report-img" alt="sold" />
                    <h3>Sold</h3>
                </div>
                <div class="nav-option List" onclick="location.href='/seller/listing.php'">
                    <img src="/media/list.png" class="report-img" alt="list new product" />
                    <h3>List</h3>
                </div>
                <div class="nav-option Logout" onclick="location.href='/logout/logout.php'">
                    <img src="/media/logout.png" class="report-img" alt="logout" />
                    <h3>Logout</h3>
                </div>

            </div>
        </nav>

    </div>

    <div class="main">
        <form method="post" enctype="multipart/form-data">
            <div class="listing_form">
            <label for="name">New listing name</label>
            <input type="text" name="name" id="name" required placeholder="Enter product name" value="<?php echo $listing_name;?>"/>
            <label for="description">Listing description</label>
            <input type="text" name="description" id="description" required placeholder="Enter product description" value="<?php echo $listing_description;?>"/>
            <label for="price">Listing Price</label>
            <input type="text" name="price" id="price" required placeholder="Enter product price" value="<?php echo $listing_price;?>"/>
            <!--
            Vehicles =1
            Property =2
            Clothing =3
            Electronics=4
            Books =5
            Furniture =6
            Decorations =7
            0ther =8
            -->
            <fieldset>
                <legend>Product Category</legend>
                <input type="radio" id="vehicles" name="category" value=1 required />
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
            <!--
            1= means product is new
            2= means product is used
            3= means product is refurbished
            4= means product is damaged
            5= means product is broken
            -->
            <fieldset>
                <legend>Product Condition</legend>
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

            <fieldset>
                <legend>Location</legend>
                <label for="location">Select your location: </label>
                <select name="location" id="location" required>
                    <option value="1">Johannesburg</option>
                    <option value="2">Cape Town</option>
                    <option value="3">Durban</option>
                    <option value="4">Pretoria</option>
                    <option value="5">Gqeberha (formerly Port Elizabeth)</option>
                    <option value="6">Bloemfontein</option>
                    <option value="7">East London</option>
                    <option value="8">Pietermaritzburg</option>
                    <option value="9">Polokwane</option>
                    <option value="10">Mbombela (formerly Nelspruit)</option>
                    <option value="11">Kimberley</option>
                    <option value="12">Rustenburg</option>
                </select>
            </fieldset>

            <label for="image">Upload Product Images: </label>
            <input
                    type="file"
                    name="image[]"
                    id="image"
                    accept=".png, .jpeg, .jpg"
                    required multiple
            >
            <button type="submit" class="submit-btn">Submit</button>

            </div>
        </form>


    </div>

</div>

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
