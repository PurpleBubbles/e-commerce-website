<?php
//start user session
session_start();

include '../controllers/admin_controllers/adminreport_ctrl.php';
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
    <title>Reports</title>
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>


<body style="height: 100vh;">

    <header class="p-3 bg-primary text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/admin/admin_home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    Reports
                </a>
            </div>
        </div>
    </header>

    <main class="h-100 d-flex flex">
        <div class="h-100 d-flex flex-column flex-shrink-0 p-3 text-bg-secondary" style="width:fit-content;">
            <a href="/admin/admin_home.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img width="40px" src="/media/logo.png" alt="logo" />
                <span class="fs-4">  Admin Center</span>
            </a>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/admin/admin_home.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/home.png" class="report-img" alt="home"/>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/admin_reports.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/reports.png" class="report-img" alt="home"/>
                        Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/logout/logout.php" class="nav-link active" aria-current="page">
                        <img width="20px" src="/media/logout.png" class="report-img" alt="home"/>
                        Logout
                    </a>
                </li>

            </ul>
        </div>
        <div type="body" class="container-fluid">
            <div class="row align-items-start" style="margin-top: 20px;">
                <div class="report-header">
                    <h1>All Reports</h1>
                </div>

                <table class="table" title="Recent Reports" style="margin-top: 20px;">
                    <thead>
                    <tr>
                        <th scope="col">Report ID</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Report Date</th>
                        <th scope="col">Resolution</th>
                        <th scope="col">Status</th>
                    </tr>
                        <?php
                        foreach($rows as $row){
                            echo ReportCtrl::displayReport($row);
                        }
                        ?>
                    </thead>
                </table>
            </div>
        </div>
    </main>
</body>
</html>

