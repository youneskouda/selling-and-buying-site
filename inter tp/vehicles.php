<?php
include 'db.php';

$category = 'vehicles';
$make = trim($_GET['make'] ?? '');
$model = trim($_GET['model'] ?? '');
$min_price = trim($_GET['min_price'] ?? '');
$max_price = trim($_GET['max_price'] ?? '');

// Build query
$query = "SELECT * FROM products WHERE category = '$category'";
if (!empty($make)) {
    $query .= " AND make LIKE '%$make%'";
}
if (!empty($model)) {
    $query .= " AND model LIKE '%$model%'";
}
if (!empty($min_price)) {
    $query .= " AND price >= $min_price";
}
if (!empty($max_price)) {
    $query .= " AND price <= $max_price";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .product-listing {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
        }
        .product-listing img {
            max-width: 100px;
            height: auto;
        }
    
.form-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.form-group {
    width: 48%; /* Adjust the width as necessary */
    box-sizing: border-box;
}

label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}
button[type="submit"] {
            display: block;
            margin: 0 auto;
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

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-button-container {
            text-align: center;
            margin-top: 20px;
        }

        .back-button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #218838;
        }
</style>

   
</head>
<body>
    <h1>Vehicles</h1>
    <form method="GET" action="vehicles.php">
    <div class="form-row">
        <div class="form-group">
            <label for="make">Make:</label>
            <input type="text" name="make" id="make" value="<?= htmlspecialchars($make) ?>">
        </div>
        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" name="model" id="model" value="<?= htmlspecialchars($model) ?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="min_price">Min Price:</label>
            <input type="number" name="min_price" id="min_price" value="<?= htmlspecialchars($min_price) ?>">
        </div>
        <div class="form-group">
            <label for="max_price">Max Price:</label>
            <input type="number" name="max_price" id="max_price" value="<?= htmlspecialchars($max_price) ?>">
        </div>
    </div>
    <button type="submit">Search</button>
    <div class="back-button-container">
        <a href="buyers.php" class="back-button">Back to buyers page</a>
    </div>
</form>
    <h2>Available Vehicles</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product-listing">
            <strong>Make:</strong> <?= htmlspecialchars($row['make']) ?><br>
            <strong>Model:</strong> <?= htmlspecialchars($row['model']) ?><br>
            <strong>Price:</strong> <?= htmlspecialchars($row['price']) ?><br>
            <strong>Description:</strong> <?= htmlspecialchars($row['description']) ?><br>
            <strong>Image:</strong> <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['model']) ?>"><br>
        </div>
    <?php endwhile; ?>
</body>
</html>

<?php $conn->close(); ?>
