<?php

//include db connection file
include '../database/db_connection.php';

echo "Home Page";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Home</title>

        <style>
            /* Style of sidebar */
            .sidebar {
                height: 100%;
                width: 160px;
                position: fixed;
                top: 0;
                left: 0;
                background-color: orange;
                overflow-x: hidden;
                padding-top: 16px;
            }

            /* sidebar links */
            .sidebar a {
                padding: 6px 8px 6px 16px;
                text-decoration: none;
                font-size: 20px;
                color: black;
                display: block;
            }

            /* Style links on mouse-over */
            .sidebar a:hover {
                color: #f1f1f1;
            }

            container {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 16px;
            }

            .card {
                box-shadow: 0 4px 8px 0 orange;
                max-width: 300px;
                border-radius: 15px;
                padding: 12px;
                margin-left: 170px;
            }

            .price {
    color: grey;
    font-size: 22px;
            }

            img {
                width: 100%;
                height: 300px;
                object-fit: cover;
            }

            .card button {
                border: none;
                outline: 0;
                padding: 12px;
                color: black;
                background-color: orange;
                text-align: center;
                cursor: pointer;
                width: 100%;
                font-size: 18px;
            }

            .card button:hover {
                opacity: 0.7;
            }
        </style>

    </head>
    <body>
    <!-- Load an icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- sidebar -->
    <div class="sidebar">
        <a href="#home"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="#services"><i class="fa fa-fw fa-wrench"></i> Buy</a>
        <a href="#clients"><i class="fa fa-fw fa-user"></i> Sell</a>
        <a href="#contact"><i class="fa fa-fw fa-envelope"></i> Contact</a>
    </div>

    <div class="content">
        <div class="container">
            <div class="card">
                <img src="/media/coffee.jpeg" alt="White coffee mug and saucer on a table ">
                <h2>Coffee Mug</h2>
                <p class="price">R20.00</p>
                <p>A description of the product</p>
                <p>
                    <button>View</button>
                    <button>Buy</button>
                </p>
            </div>
            <div class="card">
                <img src="/media/coffee.jpeg" alt="White coffee mug and saucer on a table ">
                <h2>Coffee Mug</h2>
                <p class="price">R20.00</p>
                <p>A description of the product</p>
                <p>
                    <button>View</button>
                    <button>Buy</button>
                </p>
            </div>
            <div class="card">
                <img src="/media/coffee.jpeg" alt="White coffee mug and saucer on a table ">
                <h2>Coffee Mug</h2>
                <p class="price">R20.00</p>
                <p>A description of the product</p>
                <p>
                    <button>View</button>
                    <button>Buy</button>
                </p>
            </div>
        </div>
    </div>


    </body>
</html>
