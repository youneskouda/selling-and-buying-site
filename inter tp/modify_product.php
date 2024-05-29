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

// Fetch product details for modification
$product = null;
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
    $stmt->bind_param("ii", $product_id, $seller_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

// Handle product modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $category = trim($_POST['category'] ?? '');
    $make = trim($_POST['make'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');

    // Validate required fields
    if (empty($category) || empty($price)) {
        echo "Error: Category and price are required.";
    } else {
        // Prepare specifics for JSON storage based on the category
        $specifics = [];
        switch ($category) {
            case 'vehicles':
                $specifics['make'] = $make;
                $specifics['model'] = $model;
                break;
            case 'computers':
                $specifics['make'] = $make;
                $specifics['model'] = $model;
                break;
            case 'phones':
                $specifics['make'] = $make;
                $specifics['model'] = $model;
                break;
            case 'real estate':
                $specifics['location'] = $make; // Assuming 'make' field captures location for real estate
                $specifics['type'] = $model; // Assuming 'model' field captures type of real estate
                break;
        }

        $specifics_json = json_encode($specifics);

        // Prepare and execute the SQL statement to update the product
        $stmt = $conn->prepare("UPDATE products SET category = ?, make = ?, model = ?, price = ?, description = ?, image = ?, specifics = ? WHERE id = ? AND seller_id = ?");
        $stmt->bind_param("sssssssii", $category, $make, $model, $price, $description, $image, $specifics_json, $product_id, $seller_id);

        if ($stmt->execute()) {
            echo "Product updated successfully.";
            // Optionally redirect to products page
            header('Location: products.php');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .form-group {
            width: 48%;
            box-sizing: border-box;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
        }
        .form-group.full-width {
            width: 100%;
        }
        .submit-button {
            display: block;
            margin: 0 auto;
            background-color: #007bff; /* Blue background color */
            color: white; /* Text color */
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .submit-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .button {
            display: inline-block;
            margin: 10px 0;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Modify Product</h1>
    <?php if ($product): ?>
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" required>
                        <option value="vehicles" <?= ($product['category'] == 'vehicles') ? 'selected' : '' ?>>Vehicles</option>
                        <option value="computers" <?= ($product['category'] == 'computers') ? 'selected' : '' ?>>Computers</option>
                        <option value="phones" <?= ($product['category'] == 'phones') ? 'selected' : '' ?>>Phones</option>
                        <option value="real estate" <?= ($product['category'] == 'real estate') ? 'selected' : '' ?>>Real Estate</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="make">Make:</label>
                    <input type="text" name="make" id="make" value="<?= htmlspecialchars($product['make']) ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="model">Model:</label>
                    <input type="text" name="model" id="model" value="<?= htmlspecialchars($product['model']) ?>">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" name="price" id="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="image">Image URL:</label>
                    <input type="text" name="image" id="image" value="<?= htmlspecialchars($product['image']) ?>">
                </div>
            </div>
            <button type="submit" class="submit-button">Save Changes</button>
        </form>
        <a href="products.php" class="button">Back to Products</a>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
</body>
</html>
