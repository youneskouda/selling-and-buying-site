<?php
// Include the database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $user_type = trim($_POST['user_type'] ?? 'buyer'); // Default to 'buyer' if not set

    // Validate required fields
    if (empty($name) || empty($email) || empty($password)) {
        echo "Error: Name, email, and password are required.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (name, surname, address, phone, email, password, user_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $surname, $address, $phone, $email, $hashed_password, $user_type);

        if ($stmt->execute()) {
            // Registration successful, redirect based on user type
            if ($user_type == 'seller') {
                header('Location: seller.php');
            } else {
                header('Location: buyers.php');
            }
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
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
    <style>
        .form-row {
    display: flex;
}

.form-group {
    width: 50%;
    box-sizing: border-box;
    padding-right: 10px; /* Optional: Adjust spacing between elements */
}

/* Optional: Adjust label width */
.form-group label {
    display: inline-block;
    width: 30%;
}
.register-button {
    display: block;
    margin: 0 auto; /* Center the button horizontally */
    background-color: #4CAF50; /* Green background color */
    border: none; /* Remove border */
    color: white; /* Text color */
    padding: 10px 20px; /* Padding */
    text-align: center; /* Center text */
    text-decoration: none; /* Remove underline */
    font-size: 16px; /* Font size */
    cursor: pointer; /* Cursor style */
    border-radius: 8px; /* Rounded corners */
    transition: background-color 0.3s; /* Transition effect */
}

.register-button:hover {
    background-color: #45a049; /* Darker green on hover */
}
.login-button {
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

        .login-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .centered-text {
            text-align: center;
            margin-top: 20px; /* Optional: Add margin-top for spacing */
            color: var(--gray);
font-size: 0.9rem;
color: grey;
text-decoration: none;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

    </style>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" action="register.php" onsubmit="return validateForm()">
    <div class="form-row">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" required>
        </div>
    </div>
    <br>
    <div class="form-row">
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
        </div>
    </div>
    <br>
    <div class="form-row">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
    </div>
    <div class="form-row">
            <div class="form-group ">
                <label for="user_type">Register as:</label>
                <select name="user_type" id="user_type" required>
                    <option value="buyer">Buyer</option>
                    <option value="seller">Seller</option>
                </select>
            </div>
        </div>
    <br>
    <button  type="submit"  class="register-button">Register</button>
    <br>
    <div class="centered-text">
        Already have an account!
    </div>
    <button class="login-button" onclick="window.location.href='login.php'">Go to Login Page</button>
</form>

</body>
</html>
