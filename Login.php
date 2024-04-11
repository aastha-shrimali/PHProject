<?php
    include_once "Functions/LoginFunctions.php";
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate form data
        $errors = [];
        $studentId = isset($_POST["userId"]) ? trim($_POST["userId"]) : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
    }
    
     
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error-message {
            color: red;
            font-size: 14px;
        }
        label {
            margin-bottom: 5px;
        }
        .col {
            padding: 5px;
        }
    </style>
    
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h2>Login</h2>

                    <p class="error-message"><?php echo $login_err; ?></p>
                    <div class="form-group row mt-3">
                        <label for="userId" class="col-sm-3 col-form-label">User Id:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="userId" name="userId" value="" autocomplete="off">
                        </div>
                        <div class="col">
                            <?php
                                echo '<label class="error-message" style="color: red; white-space: nowrap; display: ' . ($userId_err ? 'inline-block' : 'none') . '; width: 10px;">' . $userId_err . '</label>';
                            ?>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="password" class="col-sm-3 col-form-label">Password:</label>
                        <div class="col">
                            <input type="password" class="form-control" id="password" name="password" value="" autocomplete="off">
                        </div>
                        <div class="col">
                            <?php
                                echo '<label class="error-message" style="color: red; white-space: nowrap; display: ' . ($password_err ? 'inline-block' : 'none') . '; width: 10px;">' . $password_err . '</label>';
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                        <input class="btn btn-primary" type="reset" value="Clear">
                    </div>                  
                </form>
            </div>
        </div>
    </div>
    <script>
        // Function to clear input fields
    function clearFields() {
        document.getElementById('studentId').value = '';
        document.getElementById('password').value = '';
    }
    
    // Clear fields when the page is loaded
    window.onload = clearFields;
    </script>
</body>
</html>