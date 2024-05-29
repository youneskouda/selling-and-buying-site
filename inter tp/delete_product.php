<?php
session_start();
include 'db.php';

if (!isset($_SESSION['seller_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id']) && isset($_GET['category'])) {
    $id = $_GET['id'];
    $category = $_GET['category'];

    $table = '';
    switch ($category) {
        case 'vehicles':
            $table = 'vehicles';
            break;
        case 'real_estate':
            $table = 'real_estate';
            break;
        case 'computers':
            $table = 'computers';
            break;
        case 'phones':
            $table = 'phones';
            break;
    }

    if ($table != '') {
        $stmt = $conn->prepare("DELETE FROM $table WHERE id = ? AND seller_id = ?");
        $stmt->bind_param("ii", $id, $_SESSION['seller_id']);
        $stmt->execute();
        $stmt->close();
    }
}

header('Location: seller.php');
?>
