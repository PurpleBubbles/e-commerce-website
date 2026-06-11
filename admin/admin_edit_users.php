<?php
session_start();

include '../controllers/admin_controllers/adminedit_ctrl.php';
include '../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //get user id from form
    $action = $_POST['action'] ?? '';
    $user_id = (int)($_POST['user_id'] ?? 0);

    if ($action === 'delete_user' && $user_id > 0) {
        $conn->beginTransaction();

        // Get IDs of products this user has listed as a seller
        $stmt = $conn->prepare("SELECT product_id FROM PRODUCTS WHERE seller_user_id = ?");
        $stmt->execute([$user_id]);
        $product_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Delete all related data for the user's listed products in all related tables
        if (!empty($product_ids)) {
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $conn->prepare("DELETE FROM PRODUCT_IMAGES WHERE product_id IN ($placeholders)")->execute($product_ids);
            $conn->prepare("DELETE FROM SAVES WHERE product_id IN ($placeholders)")->execute($product_ids);
            $conn->prepare("DELETE FROM PAYMENTS WHERE product_id IN ($placeholders)")->execute($product_ids);
            $conn->prepare("DELETE FROM REPORTS WHERE product_id IN ($placeholders)")->execute($product_ids);
            $conn->prepare("DELETE FROM BOUGHT WHERE product_id IN ($placeholders)")->execute($product_ids);
        }

        // Delete user's activity in other tables (as buyer, reviewer, reporter, admin)
        $conn->prepare("DELETE FROM SAVES WHERE user_id = ?")->execute([$user_id]);
        $conn->prepare("DELETE FROM PAYMENTS WHERE buyer_user_id = ?")->execute([$user_id]);
        $conn->prepare("DELETE FROM REFUNDS WHERE buyer_user_id = ? OR admin_user_id = ?")->execute([$user_id, $user_id]);
        $conn->prepare("DELETE FROM REVIEWS WHERE buyer_user_id = ?")->execute([$user_id]);
        $conn->prepare("DELETE FROM REPORTS WHERE reporter_user_id = ? OR admin_user_id = ?")->execute([$user_id, $user_id]);
        $conn->prepare("DELETE FROM BOUGHT WHERE buyer_user_id = ?")->execute([$user_id]);
        $conn->prepare("DELETE FROM PRODUCTS WHERE seller_user_id = ?")->execute([$user_id]);
        $conn->prepare("DELETE FROM SELLER_INFO WHERE user_id = ?")->execute([$user_id]);

        $conn->prepare("DELETE FROM USERS WHERE user_id = ?")->execute([$user_id]);

        $conn->commit();
    } elseif ($action === 'update_permissions' && $user_id > 0) {
        // update user permissions if checkbox is checked == 1 else 0
        $is_buyer = isset($_POST['is_buyer']) ? 1 : 0;
        $is_seller = isset($_POST['is_seller']) ? 1 : 0;
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;

        $sql = "UPDATE USERS SET is_buyer = ?, is_seller = ?, is_admin = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$is_buyer, $is_seller, $is_admin, $user_id]);
    }
    //redirect to page again
    header('Location: /admin/admin_edit_users.php');
    exit;
}
//search functionality
$search = trim($_GET['search'] ?? '');
if ($search !== '') {
    $sql = "SELECT user_id, user_name, user_email, is_buyer, is_seller, is_admin FROM USERS WHERE user_name LIKE ? OR user_email LIKE ? ORDER BY user_id"; // Use LIKE for case-insensitive search
    $stmt = $conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->execute([$like, $like]);
} else {
    $sql = "SELECT user_id, user_name, user_email, is_buyer, is_seller, is_admin FROM USERS ORDER BY user_id"; // No search, show all users in order by user_id
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}
$users = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/main.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="/stylesheet.css" rel="stylesheet" />
    <title>Edit Users</title>
</head>

<body style="height: 100vh;">

<header class="header p-3 bg-primary text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/admin/admin_home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                Edit Users
            </a>
        </div>
    </div>
</header>

<main class="h-100 d-flex flex">
    <div class="h-100 d-flex flex-column flex-shrink-0 p-3 text-bg-secondary" style="width: fit-content">
        <a href="/admin/admin_home.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img width="40px" src="/media/logo.png" alt="logo" />
            <span class="fs-4 text-black">Admin Center</span>
        </a>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/admin/admin_home.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/home.png" class="report-img text-black" alt="home"/>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/admin_reports.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/reports.png" class="report-img" alt="reports"/>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/admin_edit_users.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/users.png" class="report-img" alt="edit users"/>
                    Edit Users
                </a>
            </li>
            <li class="nav-item">
                <a href="/logout/logout.php" class="nav-link active" aria-current="page">
                    <img width="20px" src="/media/logout.png" class="report-img" alt="logout"/>
                    Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="container-fluid">
        <div class="row" style="margin-top: 20px;">
            <div class="col">
                <h2>Edit Users</h2>

                <form method="GET" action="/admin/admin_users.php" class="d-flex gap-2 mb-3" style="max-width: 400px;">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <!--show clear btn if search is not empty-->
                    <?php if ($search !== ''): ?>
                        <a href="/admin/admin_users.php" class="btn btn-secondary">Clear</a>
                    <?php endif; ?>
                </form>

                <table class="table table-striped" style="margin-top: 10px;">
                    <thead>
                    <!--table headings-->
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Permissions</th>
                        <th>Remove User</th>
                    </tr>
                    </thead>
                    <!--dynamically display users in table-->
                    <tbody>
                    <!--loop through users-->
                    <?php foreach ($users as $row): ?>
                        <?= AdminEditUsersCtrl::displayUsers($row) ?>
                    <?php endforeach; ?>
                    <!--if no users found-->
                    <?php if (empty($users)): ?>
                        <tr><td colspan="5" class="text-center">No users found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

</body>
</html>
