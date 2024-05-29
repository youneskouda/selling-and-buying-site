<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'buyer') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyers Page</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .category {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            display: inline-block;
            width: 200px;
            text-align: center;
            background-color: #f9f9f9;
        }
        .category a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
        }
        .category a:hover {
            text-decoration: underline;
        }
        .h{
            text-align: center;
            
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
    <h1 class="h">Welcome to Our Product Listings</h1>
    <div class="category">
        <a href="vehicles.php">Vehicles</a>
        <img src="image/carlogo.jpg" alt="" width="100%" height="110px">
    </div>
    <div class="category">
        <a href="computers.php">Computers</a>
        <img src="image/computer.jpg" alt="" width="100%" height="100%">

    </div>
    <div class="category">
    <a href="phones.php">Phones</a>
    <img src="image/phone.png" alt="" width="100%" height="100%">

</div>
    <div class="category">
        <a href="realestate.php">Real Estate</a>
        <img src="image/reales.png" alt="" width="100%" height="110px">

    </div>
    <div class="back-button-container">
        <a href="index.php" class="back-button">Back to Home</a>
    </div>
</body>
</html>
