<?php
//start user session
session_start();

include '../controllers/admin_controllers/adminreport_ctrl.php';
//include db connection file
include '../database/db_connection.php';

//get all reports
$sql = "SELECT * FROM REPORTS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();

//get number of sold products
$sql = "SELECT COUNT(product_id) FROM PRODUCTS WHERE status = 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sold_rows = $stmt->fetch();

//get number of products
$sql = "SELECT COUNT(product_id) FROM PRODUCTS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$product_rows = $stmt->fetch();

//get number of users
$sql = "SELECT COUNT(user_id) FROM USERS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$user_rows = $stmt->fetch();

//get number of reports
$sql = "SELECT COUNT(report_id) FROM REPORTS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$report_rows = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

<header>
    <div class="admin_center">
        <label >
            <h3>Admin Center</h3>
        </label>
    </div>
</header>

<div class="main-container">
    <div class="navcontainer">

        <nav class="navigation_bar">
            <div class="nav-upper-options">

                <div class="nav-option Home" onclick="location.href='/admin/admin_home.php'">
                    <img src="/media/home.png" class="report-img" alt="home" />
                    <h3>Home</h3>
                </div>

                <div class="nav-option Report" onclick="location.href='/admin/admin_reports.php'">
                    <img src="/media/reports.png" class="report-img" alt="reports" />
                    <h3>Reports</h3>
                </div>

                <div class="nav-option Logout" onclick="location.href='/logout/logout.php'">
                    <img src="/media/logout.png" class="report-img" alt="logout" />
                    <h3>Logout</h3>
                </div>

            </div>
        </nav>

    </div>

    <div class="main">
        <div class="box-container">
            <div class="box Sales">
                <div class="text">
                    <h2 class="topic-heading">
                        <?php
                            echo $sold_rows['COUNT(product_id)'];
                        ?>
                    </h2>
                    <h2 class="topic">Product Sold To Date</h2>
                </div>
            </div>

            <div class="box Products">
                <div class="text">
                    <h2 class="topic-heading">
                        <?php
                            echo $product_rows['COUNT(product_id)'];
                        ?>
                    </h2>
                    <h2 class="topic">Products in Database</h2>
                </div>
            </div>

            <div class="box Users">
                <div class="text">
                    <h2 class="topic-heading">
                        <?php
                            echo $user_rows['COUNT(user_id)'];
                        ?>
                    </h2>
                    <h2 class="topic">Number of Users</h2>
                </div>
            </div>

            <div class="box Reports">
                <div class="text">
                    <h2 class="topic-heading">
                        <?php
                            echo $report_rows['COUNT(report_id)'];
                        ?>
                    </h2>
                    <h2 class="topic">Number of Reports</h2>
                </div>
            </div>
        </div>

        <div class="report-container">
            <div class="report-header">
                <h1 class="Recent-Reports">Recent Reports</h1>
                <button class="view" onclick="location.href='/admin/admin_reports.php'">View All</button>
            </div>

            <div class="report-body">
                <div class="report-headings">
                    <h3 class="t-op">Report ID</h3>
                    <h3 class="t-op">Reason</h3>
                    <h3 class="t-op">Report Date</h3>
                    <h3 class="t-op">Resolution</h3>
                    <h3 class="t-op">Status</h3>
                </div>

                <div class="reports">

                    <?php
                    foreach($rows as $row){
                        echo ReportCtrl::displayReport($row);
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</body>

</html>