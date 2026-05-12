<?php

//include db connection file
include '../database/db_connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="responsive.css" />
</head>

<body>

<header>
    <div class="searchbar">
        <input type="text" placeholder="Search" />
        <div class="searchbtn">
            <img src="/mock_data/search.png" class="icn" alt="search-button"/>
        </div>
    </div>

    <div class="notifications">
        <div class="circle"></div>
        <img src="/mock_data/notification.png" class="icn" alt="notification alert" />
        <div class="dp">
            <img src="/mock_data/profile.png" class="dpicn" alt="profile emoticon" />
        </div>
    </div>
</header>

<div class="main-container">
    <div class="navcontainer">

        <nav class="navigation_bar">
            <div class="nav-upper-options">

                <div class="nav-option Home">
                    <img src="/mock_data/home.png" class="report-img" alt="home" />
                    <h3>Home</h3>
                </div>

                <div class="nav-option Report">
                    <img src="/mock_data/reports.png" class="report-img" alt="reports" />
                    <h3>Reports</h3>
                </div>

                <div class="nav-option Logout">
                    <img src="/mock_data/logout.png" class="report-img" alt="logout" />
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
                    <h3 class="t-op">Seller ID</h3>
                    <h3 class="t-op">Buyer ID</h3>
                    <h3 class="t-op">Product ID</h3>
                    <h3 class="t-op">Report Date</h3>
                    <h3 class="t-op">Report Reason</h3>
                    <h3 class="t-op">Status</h3>
                </div>

                <div class="reports">
                    <div class="report2">
                        <h3 class="t-op-nextlvl">Article 73</h3>
                        <h3 class="t-op-nextlvl">2.9k</h3>
                        <h3 class="t-op-nextlvl">210</h3>
                        <h3 class="t-op-nextlvl label-tag">Published</h3>
                    </div>

                    <div class="report2">
                        <h3 class="t-op-nextlvl">Article 72</h3>
                        <h3 class="t-op-nextlvl">1.5k</h3>
                        <h3 class="t-op-nextlvl">360</h3>
                        <h3 class="t-op-nextlvl label-tag">Published</h3>
                    </div>

                    <div class="report2">
                        <h3 class="t-op-nextlvl">Article 71</h3>
                        <h3 class="t-op-nextlvl">1.1k</h3>
                        <h3 class="t-op-nextlvl">150</h3>
                        <h3 class="t-op-nextlvl label-tag">Published</h3>
                    </div>

                    <div class="report2">
                        <h3 class="t-op-nextlvl">Article 70</h3>
                        <h3 class="t-op-nextlvl">1.2k</h3>
                        <h3 class="t-op-nextlvl">420</h3>
                        <h3 class="t-op-nextlvl label-tag">Published</h3>
                    </div>

                    <div class="report2">
                        <h3 class="t-op-nextlvl">Article 69</h3>
                        <h3 class="t-op-nextlvl">2.6k</h3>
                        <h3 class="t-op-nextlvl">190</h3>
                        <h3 class="t-op-nextlvl label-tag">Published</h3>
                    </div>

                        <div class="report2">
                            <h3 class="t-op-nextlvl">Article 68</h3>
                            <h3 class="t-op-nextlvl">1.9k</h3>
                            <h3 class="t-op-nextlvl">390</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="report2">
                            <h3 class="t-op-nextlvl">Article 67</h3>
                            <h3 class="t-op-nextlvl">1.2k</h3>
                            <h3 class="t-op-nextlvl">580</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="report2">
                            <h3 class="t-op-nextlvl">Article 66</h3>
                            <h3 class="t-op-nextlvl">3.6k</h3>
                            <h3 class="t-op-nextlvl">160</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="report2">
                            <h3 class="t-op-nextlvl">Article 65</h3>
                            <h3 class="t-op-nextlvl">1.3k</h3>
                            <h3 class="t-op-nextlvl">220</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>