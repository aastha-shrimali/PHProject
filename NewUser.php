<?php
    include_once "./Functions/NewUserFunctions.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New User Registration</title>
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
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="short-input">
                    <h2>Sign up</h2>
                    <p>All fields are required</p>

                    <div class="form-group row mt-3">
                        <label for="userId" class="col-sm-3 col-form-label">User Id:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="userId" name="userId" value="<?php echo isset($_POST["userId"]) ? htmlspecialchars($_POST["userId"]) : ''; ?>">
                        </div>
                        <div class="col">
                            <?php
                                echo '<label class="error-message" style="color: red; white-space: nowrap; display: ' . ($userId_err ? 'inline-block' : 'none') . '; width: 10px;">' . $userId_err . '</label>';
                            ?>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="name" class="col-sm-3 col-form-label">Name:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars(isset($_POST["name"]) ? $_POST["name"] : ''); ?>">
                        </div>
                        <div class="col">
                            <?php
                                echo '<label class="error-message" style="color: red; white-space: nowrap; display: ' . ($name_err ? 'inline-block' : 'none') .  '; width: 10px;">' . $name_err . '</label>';
                            ?>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="phone" class="col-sm-3 col-form-label">Phone Number:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST["phone"]) ? htmlspecialchars($_POST["phone"]) : ''; ?>">
                        </div>
                        <div class="col">
                            <?php
                                echo '<label class="error-message" style="color: red; white-space: nowrap; display: ' . ($phone_err ? 'inline-block' : 'none') . '; width: 10px;">' . $phone_err . '</label>';
                            ?>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="password" class="col-sm-3 col-form-label">Password:</label>
                        <div class="col">
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : ''; ?>">
                        </div>
                        <div class="col">
                            <?php
                                echo '<label class="error-message" style="color: red; white-space: nowrap; display: ' . ($password_err ? 'inline-block' : 'none') . '; width: 10px;">' . $password_err . '</label>';
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group row mt-3">
                        <label for="password" class="col-sm-3 col-form-label">Password Again:</label>
                        <div class="col">
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : ''; ?>">
                        </div>   
                        <div class="col">
                            
                        </div>
                    </div>
                    

                    <br>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                        <input class="btn btn-primary" type="reset" value="Clear">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
