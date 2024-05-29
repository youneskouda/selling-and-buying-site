<?php
// Include the database connection
include 'db.php';

// Start session to handle authentication
session_start();

// Check if the user is logged in
if (!isset($_SESSION['seller_id'])) {
    // Redirect to login page if the seller is not logged in
    header('Location: login.php');
    exit;
}

// Get the seller ID from the session
$seller_id = $_SESSION['seller_id'];

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
    $stmt->bind_param("ii", $delete_id, $seller_id);
    if ($stmt->execute()) {
        echo "Product deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch seller's products to display
$result = $conn->query("SELECT * FROM products WHERE seller_id = $seller_id");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        ul.product-list {
            list-style: none;
            padding: 0;
        }

        ul.product-list li {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 15px;
            display: flex;
            flex-wrap: wrap;
        }

        ul.product-list li strong {
            width: 50%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        ul.product-list li img {
            max-width: 100%;
            border-radius: 8px;
        }

        ul.product-list li:nth-child(even) {
            background-color: #e9e9e9;
        }

        ul.product-list li:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .product-field {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .product-field:nth-child(even) {
            background-color: #fff;
        }

        .product-field:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .h {
            color: #2c3e50; /* Initial text color */
            text-align: center;
            font-size: 2.5em;
            transition: color 0.3s ease;
            margin-bottom: 20px;
        }

        .h:hover {
            color: #3498db; /* Text color on hover */
        }
    </style>
</head>
<body>
    <h1 class="h">Here is our products list</h1>
    <ul class="product-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <div class="product-field">
                    <strong>Category:</strong>
                    <span><?= htmlspecialchars($row['category']) ?></span>
                </div>
                <div class="product-field">
                    <strong>Make:</strong>
                    <span><?= htmlspecialchars($row['make']) ?></span>
                </div>
                <div class="product-field">
                    <strong>Model:</strong>
                    <span><?= htmlspecialchars($row['model']) ?></span>
                </div>
                <div class="product-field">
                    <strong>Price:</strong>
                    <span><?= htmlspecialchars($row['price']) ?></span>
                </div>
                <div class="product-field full-width">
                    <strong>Description:</strong>
                    <span><?= htmlspecialchars($row['description']) ?></span>
                </div>
                <div class="product-field full-width">
                    <strong>Image:</strong>
                    <span><img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['model']) ?>" width="100"></span>
                </div>
                <div class="product-field full-width">
                    <strong>Specifics:</strong>
                    <span><?= htmlspecialchars($row['specifics']) ?></span>
                </div>
                <div>
                    <a href="modify_product.php?id=<?= $row['id'] ?>" class="button">Modify</a>
                    <a href="products.php?delete_id=<?= $row['id'] ?>" class="button delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>

</body>
</html>
