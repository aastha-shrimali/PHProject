<?php
// Start session
session_start();

// Load database connection settings from DBConnection.ini
$config = parse_ini_file('DBConnection.ini');

$servername = "localhost";
$username = $config['user'];
$password = $config['password'];
$database = "cst8257project";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$userId = $password = "";
$userId_err = $password_err = "";
$login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Student ID
    if (empty(trim($_POST["userId"]))) {
        $userId_err = "User ID cannot be blank.";
    } else {
        $userId = trim($_POST["userId"]);
    }

    // Validate Password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Password cannot be blank.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before checking against database
    if (empty($userId_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT UserId, Password FROM user WHERE UserId = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_userId);
            $param_userId = $userId;

            if ($stmt->execute()) {
                $stmt->store_result();

                // Check if user ID exists, then verify password
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($userId, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            // Store data in session variables
                            $_SESSION["userId"] = $userId;

                            // Redirect user to appropriate page based on registration status
                            if (checkUserRegistrationStatus($_SESSION["userId"])) {
                                header("location: MyAlbums.php");
                            } else {
                                header("location: AddAlbum.php");
                            }
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            $login_err = "Incorrect student ID and/or Password!";
                            // Clear the password field
                            $password = "";
                        }
                    }
                } else {
                    // Display an error message if student ID doesn't exist
                    $login_err = "Incorrect student ID and/or Password!";
                    // Clear the password field
                    $password = "";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
}

// Function to check if the user has registered for any courses
function checkUserRegistrationStatus($studentId) {
    // Load database connection settings from DBConnection.ini
    $config = parse_ini_file('DBConnection.ini');

    $servername = "localhost";
    $username = $config['user'];
    $password = $config['password'];
    $database = "cst8257project";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a select statement
    $sql = "SELECT COUNT(*) AS totalCourses FROM registration WHERE StudentId = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $studentId);

        // Set parameters
        $studentId = $studentId;

        // Execute the statement
        if ($stmt->execute()) {
            // Bind result variables
            $stmt->bind_result($totalCourses);

            // Fetch result
            $stmt->fetch();

            // Close statement
            $stmt->close();

            // Check if the user has registered for any courses
            if ($totalCourses > 0) {
                // User has registered for courses
                return true;
            } else {
                // User has not registered for any courses
                return false;
            }
        } else {
            // Error executing the statement
            echo "Error executing SQL statement: " . $stmt->error;
        }
    } else {
        // Error preparing the statement
        echo "Error preparing SQL statement: " . $conn->error;
    }

    // Close connection
    $conn->close();
}

// Close connection
$conn->close();