<?php
if (!isset($_SESSION)) {
    session_start();
}

// Add item to cart
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['addCart'])) {
    $itemID = $_GET['product_id'] ?? null;
    $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

    if (!$itemID || $qty < 1) {
        header("Location: userViewItem.php");
        exit;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][$itemID] = $qty;

    header("Location: userViewItem.php");
    exit;
}

// Remove item from cart
if (isset($_GET['did'])) {
    $removeID = $_GET['did'];

    if (isset($_SESSION['cart'][$removeID])) {
        unset($_SESSION['cart'][$removeID]);
    }

    header("Location: viewCart.php");
    exit;
}