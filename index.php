<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome | Algonquin Social Media Website</title>
    <style>
        h2 {
            margin-left: 25px;
        }
        p {
            white-space: pre-line; 
            margin: 25px;
        }
        /* Additional styles can go here */
    </style>
</head>
<body>
    <?php 
    include 'header.php'; 
    ?>
    
    <h1>Welcome to Algonquin Social Media Website</h1>
    <p>If you have never used this before, you have to <a href="NewUser.php">Sign Up</a> first.</p>
    <p>If you have already signed up, you can <a href="Login.php">Log In</a> now.</p>
    
   

    <?php 
    include 'footer.php'; 
    ?>
</body>
</html>
