<?php

include '../controllers/report_ctrl.php';
include '../database/db_connection.php';

$sql = "SELECT * FROM REPORTS";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


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

    <div class="report-container">
    <div class="report-header">
        <h1 class="Recent-Reports">Recent Reports</h1>
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

</body>

