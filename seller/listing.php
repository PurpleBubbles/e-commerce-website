<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/admin/style.css">
    <title>Create Listing</title>
    <link rel="stylesheet" href="/admin/style.css">

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
                <div class="nav-option List" onclick="location.href='/seller/list.php'">
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
        <div class="listing_form">
            <p>Name for new listing</p>
            <input type="text" name="name" id="name" required placeholder="Enter product name">
            <p>Description for new listing</p>
            <input type="text" name="description" id="description" required placeholder="Enter product description"/>
            <p>Price for new listing</p>
            <input type="text" name="price" id="price" required placeholder="Enter product price"/>
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
                    <input type="radio" id="vehicles" name="category" value=1 />
                    <label for="vehicles">Vehicles</label>
                    <input type="radio" id="property" name="category" value=2 />
                    <label for="property">Property</label>
                    <input type="radio" id="clothing" name="category" value=3 />
                    <label for="clothing">Clothing</label>
                    <input type="radio" id="electronics" name="category" value=4 />
                    <label for="electronics">Electronics</label>
                    <input type="radio" id="books" name="category" value=5 />
                    <label for="books">Books</label>
                    <input type="radio" id="furniture" name="category" value=6 />
                    <label for="furniture">Furniture</label>
                    <input type="radio" id="decorations" name="category" value=7 />
                    <label for="decorations">Decorations</label>
                    <input type="radio" id="others" name="category" value=8 />
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
                <input type="radio" id="new" name="condition" value=1 />
                <label for="new">New</label>
                <input type="radio" id="used" name="condition" value=2 />
                <label for="used">Used</label>
                <input type="radio" id="refurbished" name="condition" value=3 />
                <label for="refurbished">Refurbished</label>
                <input type="radio" id="damaged" name="condition" value=4 />
                <label for="damaged">Damaged</label>
                <input type="radio" id="broken" name="condition" value=5 />
                <label for="broken">Broken</label>
            </fieldset>

            <input type="submit" value="Create Listing" name="submit">

        </div>


        <form action="upload.php" method="POST" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>

    </div>

</div>
</body>
</html>
