<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, product, quantity, price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssii", $name, $email, $address, $product, $quantity, $price);
    $stmt->execute();
    header('Location: thankyou.html');
    exit;
}