<?php
// Include the database connection
include 'db.php';

// Start session to handle authentication
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'seller') {
    header('Location: login.php');
    exit;
}

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
    $stmt->bind_param("ii", $delete_id, $_SESSION['seller_id']);
    if ($stmt->execute()) {
        echo "Product deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $category = trim($_POST['category'] ?? '');
    $make = trim($_POST['make'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? ''); // This would typically come from a file upload

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

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("INSERT INTO products (category, make, model, price, description, image, specifics, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssi", $category, $make, $model, $price, $description, $image, $specifics_json, $_SESSION['seller_id']);

        if ($stmt->execute()) {
            echo "Product added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Fetch seller's products to display
$seller_id = $_SESSION['seller_id'];
$result = $conn->query("SELECT * FROM products WHERE seller_id = $seller_id");
$conn->close();
?>
<?php
// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file is uploaded successfully
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Define upload directory and target file
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        
        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // File uploaded successfully
            echo "Image uploaded successfully.";
            // Now you can store the $targetFile path in your database
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller - Manage Products</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
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
.image-preview {
            margin-top: 10px;
        }
        .image-preview img {
            max-width: 100%;
            height: auto;
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
    <h1>Manage Your Products</h1>
    <form method="POST" action="">
    <div class="form-row">
        <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="vehicles">Vehicles</option>
                <option value="computers">Computers</option>
                <option value="phones">Phones</option>
                <option value="real estate">Real Estate</option>
            </select>
        </div>
        <div class="form-group">
            <label for="make">Make:</label>
            <input type="text" name="make" id="make">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" name="model" id="model">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" name="price" id="price" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group full-width">
            <label for="description">Description:</label>
            <textarea name="description" id="description"></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group full-width">
            <label for="image">Image:</label>
            <div class="file-input-container">
                <input type="file" name="image" id="image" class="file-input" accept="image/*" onchange="previewImage(event)">            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group full-width image-preview" id="imagePreview">
            <!-- Image preview will be shown here -->
        </div>
    </div>

        <button type="submit" class="submit-button">Add Product</button>
    </form>
    <div class="back-button-container">
        <a href="products.php" class="back-button">Go to products page</a>
    </div>

    <script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function() {
            var imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = '<img src="' + reader.result + '" alt="Image Preview">';
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>
