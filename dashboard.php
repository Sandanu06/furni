
<?php
session_start();
require 'db.php';
if (!isset($_SESSION['admin'])) {
        header('Location: login.php');
        exit;
}
$result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />
    <style>
                body { background: #f6f7fb; font-family: 'Inter', sans-serif; }
                .main-content { min-height: 80vh; }
                .card { box-shadow: 0 4px 24px rgba(0,0,0,0.08); border-radius: 16px; }
                .card-title { font-weight: 700; font-size: 1.5rem; margin-bottom: 20px; }
                .table th, .table td { vertical-align: middle; }
                .logout-btn { float: right; margin-bottom: 20px; }
                .dashboard-title { font-weight: 700; font-size: 2rem; margin-bottom: 20px; }
                .navbar { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
                .table-actions a { margin-right: 8px; }
                .table thead th { background: #f0f2f5; }
                .table { font-size: 1.08rem; }
                .card { margin-bottom: 40px; }
                @media (max-width: 1200px) {
                    .card { max-width: 100%; }
                }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
            <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
        </div>
    </nav>
    <div class="container main-content">
        <div class="dashboard-title">Orders Table</div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= htmlspecialchars($order['name']) ?></td>
                                <td><?= htmlspecialchars($order['email']) ?></td>
                                <td><?= htmlspecialchars($order['address']) ?></td>
                                <td><?= htmlspecialchars($order['product']) ?></td>
                                <td><?= $order['quantity'] ?></td>
                                <td><?= $order['price'] ?></td>
                                <td class="table-actions">
                                    <a href="edit_order.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="delete_order.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>