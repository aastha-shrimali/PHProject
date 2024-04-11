<?php
// Start the session to maintain user state
session_start();

// Use placeholders for the database credentials in this script. Replace them with the actual credentials in your secure environment.
$servername = "localhost";
$dbUsername = "root"; // Replace with your actual username
$dbPassword = "Ayesha@1908"; // Replace with your actual password
$dbName = "cst8257project"; // Replace with your actual database name

// Connect to the database with mysqli
$db = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check for a database connection error
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Initialize a message variable to give feedback to the user
$message = '';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape the input to protect against SQL injection
    $friendUserId = $db->real_escape_string($_POST['userId']);
    $currentUser = $_SESSION['user_id']; // The user ID should be stored in session upon login
    
    // Implement the logic based on the project requirements
    // ... (Insert your logic here for handling friend requests)
}

// Include the header for the page
include 'header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Friend</title>
</head>
<body>
    <div class="container">
        <h1>Add Friend</h1>
        <p>Welcome <?php echo htmlspecialchars($currentUserName); ?>! (not you? <a href="logout.php">change user here</a>)</p>
        <form method="post">
            Enter the ID of the user you want to befriend:<br>
            ID: <input type="text" name="userId">
            <input type="submit" value="Send Friend Request">
        </form>
        <?php
        // Display any message to the user
        if (!empty($message)) {
            echo "<p>$message</p>";
        }
        ?>
    </div>

    <?php
    // Include the footer for the page
    include 'footer.php'; 
    ?>
</body>
</html>
