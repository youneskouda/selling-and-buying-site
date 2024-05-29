<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
                integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

                <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@900&display=swap" rel="stylesheet">

                <style>
        /* CSS for button styling */
        .register-button {
            background-color: #4CAF50; /* Green background color */
            border: none; /* Remove border */
            color: white; /* Text color */
            padding: 10px 20px; /* Padding */
            text-align: center; /* Center text */
            text-decoration: none; /* Remove underline */
            display: inline-block; /* Make it inline block */
            font-size: 16px; /* Font size */
            margin: 4px 2px; /* Margin */
            cursor: pointer; /* Cursor style */
            border-radius: 8px; /* Rounded corners */
            transition: background-color 0.3s; /* Transition effect */
            
        }

        /* Hover effect */
        .register-button:hover {
            background-color: #45a049; /* Darker green */
        }
        .h{
            text-align: center;
            
        }
    </style>
            </head>
<body>
    <h1 class="h">Welcome to our Site</h1>


  

      <section class="container">
     <div class="row">
        
  
     
<div class="col-sm-6">
        <div class="category">
            <img src="image/carlogo.jpg" alt=""  width="100%" height="100%">
            <h2>Vehicles</h2>
            <button class="register-button" onclick="window.location.href='register.php'">Take A Look</button>

        </div>
    </div>

      <div class="col-sm-6">
        <div class=" category">
        <img src="image/reales.png" alt=""  width="100%" height="240px">
            <h2>Real Estate</h2>
           
            <button class="register-button" onclick="window.location.href='register.php'">Take A Look</button>

        </div>
    </div>
     </div>
 <hr>
     <div class="row">

     <div class="col-sm-6">
        <div class="category">
            <img src="image/computer.jpg" alt=""   width="100%" height="100%" >
            <h2>Computers</h2>
          
            <button class="register-button" onclick="window.location.href='register.php'">Take A Look</button>

        </div>
    </div>

<div class="col-sm-6">
        <div class="category">
            <img src="image/phone.png" alt=""   width="100%" height="280px">
            <h2>Phones</h2>
           
            <button class="register-button" onclick="window.location.href='register.php'">Take A Look</button>
        </div>
            </div>
    </div>
        </section>
 
</body>
</html>
