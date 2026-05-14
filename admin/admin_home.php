<?php

include '../controllers/adminreport_ctrl.php';
//include db connection file
include '../database/db_connection.php';

$sql = "SELECT * FROM REPORTS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();

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

    <div class="notifications">
        <div class="circle"></div>
        <img src="/media/notification.png" class="icn" alt="notification alert" />
        <div class="dp">
            <img src="/media/profile.png" class="dpicn" alt="profile emoticon" />
        </div>
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

                <div class="nav-option Logout" onclick="location.href='/login/login.php'">
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
                    <h2 class="topic-heading">60.5k</h2>
                    <h2 class="topic">Sales to Date</h2>
                </div>
            </div>

            <div class="box Products">
                <div class="text">
                    <h2 class="topic-heading">150</h2>
                    <h2 class="topic">Products for Sale</h2>
                </div>
            </div>

            <div class="box Users">
                <div class="text">
                    <h2 class="topic-heading">320</h2>
                    <h2 class="topic">Number of Users</h2>
                </div>
            </div>

            <div class="box Reports">
                <div class="text">
                    <h2 class="topic-heading">70</h2>
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