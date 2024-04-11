<?php
// Establish database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "Ayesha@1908"; // Your MySQL password
$database = "cst8257project"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables
$userName = "";

// Check if the user is logged in
if (isset($_SESSION["userName"])) {
    // Fetch the user's name from the session
    $userName = $_SESSION["userName"];
}

// Fetch possible accessibility options from database
$sql = "SELECT * FROM Accessibility";
$result = $conn->query($sql);

// Store the options in an array
$accessibilityOptions = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $accessibilityOptions[$row['Accessibility_Code']] = $row['Description'];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $accessibility = $_POST['accessibility'];

    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO album (Title, Description, Owner_Id, Accessibility_Code) VALUES (?, ?, 1, ?)");
    $stmt->bind_param("sss", $title, $description, $accessibility);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "New album created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close prepared statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Album</title>
</head>
<body>
    <h2>Create a New Album</h2>
    <?php if (!empty($userName)) : ?>
        <h2>Welcome, <?php echo $userName; ?></h2>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

        <label for="accessibility">Accessibility:</label><br>
        <select id="accessibility" name="accessibility" required>
            <?php
            // Display the options fetched from the database
            foreach ($accessibilityOptions as $code => $description) {
                echo "<option value='$code'>$description</option>";
            }
            ?>
        </select><br><br>

        <input type="submit" value="Create Album">
    </form>
</body>
</html>
