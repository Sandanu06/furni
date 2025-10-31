<?php
session_start();
require 'db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit; }
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $stmt = $conn->prepare("UPDATE orders SET name=?, email=?, address=?, product=?, quantity=?, price=? WHERE id=?");
        $stmt->bind_param("ssssidi", $name, $email, $address, $product, $quantity, $price, $id);
        $stmt->execute();
        header('Location: dashboard.php');
        exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { background: #f6f7fb; font-family: 'Inter', sans-serif; }
        .main-content { margin: 60px auto; max-width: 500px; }
        .card { box-shadow: 0 4px 24px rgba(0,0,0,0.08); border-radius: 16px; }
        .card-title { font-weight: 700; font-size: 1.5rem; margin-bottom: 20px; }
        .form-label { font-weight: 500; color: #333; }
        .btn-primary { background: #344767; border: none; }
        .btn-primary:hover { background: #2d3a5a; }
        .back-link { display: block; margin-bottom: 20px; color: #344767; text-decoration: none; font-weight: 500; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="main-content">
        <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Edit Order</h2>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($order['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($order['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($order['address']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <input type="text" class="form-control" name="product" value="<?= htmlspecialchars($order['product']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" value="<?= $order['quantity'] ?>" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" value="<?= $order['price'] ?>" step="0.01" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>