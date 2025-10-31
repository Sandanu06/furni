<?php
// checkout.php - Billing and order details
$product = isset($_GET['product']) ? htmlspecialchars($_GET['product']) : '';
$price = isset($_GET['price']) ? htmlspecialchars($_GET['price']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture billing info and order
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $order_product = $_POST['order_product'] ?? '';
    $order_price = $_POST['order_price'] ?? '';

    // Connect to DB
    require 'db.php';
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, phone, product, price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $address, $phone, $order_product, $order_price);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: thankyou.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <h2>Checkout</h2>
    <form method="post" action="checkout.php">
        <div class="row">
            <div class="col-md-6">
                <h4>Billing Details</h4>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
            </div>
            <div class="col-md-6">
                <h4>Your Order</h4>
                <div class="mb-3">
                    <label class="form-label">Product</label>
                    <input type="text" class="form-control" name="order_product" value="<?php echo $product; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="text" class="form-control" name="order_price" value="<?php echo $price; ?>" readonly>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Place Order</button>
    </form>
</div>
</body>
</html>
